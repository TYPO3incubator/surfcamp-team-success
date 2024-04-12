<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Surfcamp\Success\Hooks;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Error\Exception;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Form\Mvc\Configuration\Exception\NoSuchFileException;
use TYPO3\CMS\Form\Mvc\Configuration\Exception\ParseErrorException;
use TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface;
use TYPO3\CMS\Form\Mvc\Persistence\Exception\PersistenceManagerException;

/**
 * Contains a preview rendering for the page module of CType="form_formframework"
 * @internal
 */
class FormPagePreviewRenderer extends StandardContentPreviewRenderer
{
    private const L10N_PREFIX = 'LLL:EXT:form/Resources/Private/Language/Database.xlf:';

    public function renderPageModulePreviewContent(GridColumnItem $item): string
    {
        $row = $item->getRecord();
        $itemContent = $this->linkEditContent('<strong>' . htmlspecialchars($item->getContext()->getContentTypeLabels()['form_formframework']) . '</strong>', $row) . '<br />';

        $flexFormData = GeneralUtility::makeInstance(FlexFormService::class)
            ->convertFlexFormContentToArray($row['pi_flexform']);

        $persistenceIdentifier = $flexFormData['settings']['persistenceIdentifier'] ?? '';
        if (!empty($persistenceIdentifier)) {
            try {
                $formPersistenceManager = GeneralUtility::makeInstance(FormPersistenceManagerInterface::class);

                try {
                    if (
                        $formPersistenceManager->hasValidFileExtension($persistenceIdentifier)
                        || PathUtility::isExtensionPath($persistenceIdentifier)
                    ) {
                        $formDefinition = $formPersistenceManager->load($persistenceIdentifier);
                        $formLabel = $formDefinition['label'];
                        return $this->renderFormFromDefinition($formDefinition);
                    } else {
                        $formLabel = sprintf(
                            $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.inaccessiblePersistenceIdentifier'),
                            $persistenceIdentifier
                        );
                    }
                } catch (ParseErrorException $e) {
                    $formLabel = sprintf(
                        $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.invalidPersistenceIdentifier'),
                        $persistenceIdentifier
                    );
                } catch (PersistenceManagerException $e) {
                    $formLabel = sprintf(
                        $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.inaccessiblePersistenceIdentifier'),
                        $persistenceIdentifier
                    );
                } catch (Exception $e) {
                    $formLabel = sprintf(
                        $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.notExistingdPersistenceIdentifier'),
                        $persistenceIdentifier
                    );
                }
            } catch (NoSuchFileException $e) {
                $this->addInvalidFrameworkConfigurationFlashMessage($persistenceIdentifier, $e);
                $formLabel = sprintf(
                    $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.notExistingdPersistenceIdentifier'),
                    $persistenceIdentifier
                );
            } catch (ParseErrorException $e) {
                $this->addInvalidFrameworkConfigurationFlashMessage($persistenceIdentifier, $e);
                $formLabel = sprintf(
                    $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.invalidFrameworkConfiguration'),
                    $persistenceIdentifier
                );
            } catch (\Exception $e) {
                // Top level catch - FAL throws top level exceptions on missing files, eg. in getFileInfoByIdentifier() of LocalDriver
                $this->addInvalidFrameworkConfigurationFlashMessage($persistenceIdentifier, $e);
                $formLabel = sprintf(
                    $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.invalidFrameworkConfiguration.text'),
                    $persistenceIdentifier,
                    $e->getMessage()
                );
            }
        } else {
            $formLabel = $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.noPersistenceIdentifier');
        }

        $itemContent .= $this->linkEditContent(
            htmlspecialchars($formLabel),
            $row
        ) . '<br />';

        return $itemContent;
    }

    protected function addInvalidFrameworkConfigurationFlashMessage(string $persistenceIdentifier, \Exception $e): void
    {
        $messageText = sprintf(
            $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.invalidFrameworkConfiguration.text'),
            $persistenceIdentifier,
            $e->getMessage()
        );

        GeneralUtility::makeInstance(FlashMessageService::class)
            ->getMessageQueueByIdentifier('core.template.flashMessages')
            ->enqueue(
                GeneralUtility::makeInstance(
                    FlashMessage::class,
                    $messageText,
                    $this->getLanguageService()->sL(self::L10N_PREFIX . 'tt_content.preview.invalidFrameworkConfiguration.title'),
                    ContextualFeedbackSeverity::ERROR,
                    true
                )
            );
    }

    protected function renderFormFromDefinition(array $formDefinition): string
    {
        $finishers = isset($formDefinition['finishers']) ? $formDefinition['finishers'] : [];
        $pages = isset($formDefinition['renderables']) ? $formDefinition['renderables'] : [];
        $html = '<style>.form-container{display:flex;flex-direction:column;background:rgb(255,249,232);padding:20px;border-radius:20px;}.content{display:flex;flex-direction:column;align-items:center;width:100%;}.headline{font-size:24px;}.subline{font-size:18px;}.form{display:flex;gap:15px;}.form-page{display:flex;flex-direction:column;gap:10px;overflow:hidden;padding:15px;border-radius:15px;border:2px solid wheat;box-shadow:none;width:100%;}.form-page-label{font-size:16px;font-weight:bold;}</style><div class="form-container"><div class="content"><span class="overline">Overline</span><span class="headline">Header</span><p class="subline">Subheader</p></div>';

        if (is_array($pages) && count($pages) > 0) {
            $html .= '<div class="form">';

            foreach ($pages as $page) {
                $html .= '<div class="form-page"><span class="form-page-label">Page</span>';
                foreach ($page['renderables'] as $item) {
                    $html .= '<div class="form-field">' . $item['label'] . ': ' . $item['type'] . '</div>';
                }
                $html .= '</div>';
            }

            $html .= '</div>';
        }

        if (is_array($finishers) && count($finishers) > 0) {
            $html .= '<div class="form-field"><span class="form-page-label">Finishers:</span>&nbsp;';

            foreach ($finishers as $finisher) {
                $html .= '<div class="form-field">' . $finisher['identifier'] . '</div>&nbsp;';
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    function setLogger(LoggerInterface $logger): void
    {

    }
}
