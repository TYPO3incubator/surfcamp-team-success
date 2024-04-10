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

namespace Surfcamp\Success\Domain\Finishers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Finishers\Exception\FinisherException;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;
use TYPO3\CMS\Form\ViewHelpers\RenderRenderableViewHelper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * A finisher that outputs a given text
 *
 * Options:
 *
 * - message: A hard-coded message to be rendered
 * - contentElementUid: A content element uid to be rendered
 *
 * Usage:
 * //...
 * $confirmationFinisher = GeneralUtility::makeInstance(ConfirmationFinisher::class);
 * $confirmationFinisher->setOptions(
 *   [
 *     'message' => 'foo',
 *   ]
 * );
 * $formDefinition->addFinisher($confirmationFinisher);
 * // ...
 *
 * Scope: frontend
 */
class NotificationFinisher extends AbstractFinisher
{
    /**
     * @var array
     */
    protected $defaultOptions = [
        'message' => 'The form has been submitted.',
    ];

    protected array $typoScriptSetup = [];

    protected ConfigurationManagerInterface $configurationManager;

    protected ContentObjectRenderer $contentObjectRenderer;

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
        $this->typoScriptSetup = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
    }

    public function injectContentObjectRenderer(ContentObjectRenderer $contentObjectRenderer)
    {
        $this->contentObjectRenderer = $contentObjectRenderer;
    }

    /**
     * Executes this finisher
     *
     * @see AbstractFinisher::execute()
     * @return string
     *
     * @throws FinisherException
     */
    protected function executeInternal()
    {

        $message = $this->parseOption('message');

        $standaloneView = $this->initializeStandaloneView(
            $this->finisherContext->getFormRuntime()
        );

        $standaloneView->assignMultiple([
            'message' => $message,
        ]);

        return $standaloneView->render();
    }

    /**
     * @throws FinisherException
     */
    protected function initializeStandaloneView(FormRuntime $formRuntime): StandaloneView
    {
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setRequest($this->finisherContext->getRequest());

        if (!isset($this->options['templateName'])) {
            throw new FinisherException(
                'The option "templateName" must be set for the ConfirmationFinisher.',
                1521573955
            );
        }

        $standaloneView->setTemplate($this->options['templateName']);
        $standaloneView->getTemplatePaths()->fillFromConfigurationArray($this->options);

        if (isset($this->options['variables']) && is_array($this->options['variables'])) {
            $standaloneView->assignMultiple($this->options['variables']);
        }

        $standaloneView->assign('form', $formRuntime);
        $standaloneView->assign('finisherVariableProvider', $this->finisherContext->getFinisherVariableProvider());

        $standaloneView->getRenderingContext()
            ->getViewHelperVariableContainer()
            ->addOrUpdate(RenderRenderableViewHelper::class, 'formRuntime', $formRuntime);

        return $standaloneView;
    }
}
