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

namespace Surfcamp\Success\ViewHelpers;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Domain\RecordInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\CMS\Fluid\View\FluidViewAdapter;
use TYPO3\CMS\Fluid\ViewHelpers\CObjectViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * ViewHelper to render a block from a record
 */
final class RenderBlockViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    public function __construct(private readonly RenderingContextFactory $renderingContextFactory) {}

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('record', RecordInterface::class, 'Record object');
        $this->registerArgument('template', 'string', 'Alternative template name for this record');
        $this->registerArgument('context', 'array', 'Context information', false, []);
    }

    public function render(): string
    {
        /** @var RecordInterface $record */
        $record = $this->arguments['record'];
        /** @var string|null $templateFileName */
        $templateFileName = $this->arguments['template'] ?? null;
        $outerRenderingContext = $this->renderingContext;
        $request = $outerRenderingContext->getAttribute(ServerRequestInterface::class);

        // Create new rendering context
        $innerRenderingContext = $this->renderingContextFactory->create([], $request);
        $innerRenderingContext->setTemplatePaths(clone $outerRenderingContext->getTemplatePaths());

        // Selectively pass variables from the parent to the sub view:
        // * settings (inherited in getScopeCopy())
        // * data, which contains the provided record object
        // * site, page and language, which are also present in templates initiated with PageViewContentObject
        // * additional variables, provided to the ViewHelpers in the "arguments" argument
        $innerVariableProvider = $outerRenderingContext->getVariableProvider()->getScopeCopy([
            'data' => $record,
            'site' => $request->getAttribute('site'),
            'language' => $request->getAttribute('language'),
            'page' => $request->getAttribute('frontend.page.information'),
            ...(array)$this->arguments['arguments'],
        ]);
        $innerRenderingContext->setVariableProvider($innerVariableProvider);

        // Create the actual view object based on the rendering context. FluidViewAdapter is used here as
        // preparation for a potential use of different view implementations in the future
        $innerView = new FluidViewAdapter(new TemplateView($innerRenderingContext));

        $typeCamelCase = GeneralUtility::underscoredToUpperCamelCase(str_replace('tt_content', 'content', $record->getFullType()));
        $typeCamelCase = str_replace(' ','/',ucwords(str_replace('.', ' ', $typeCamelCase)));
        $templateFileName = $templateFileName ?? $typeCamelCase;
        debug($templateFileName);
        try {
            return $innerView->render($templateFileName);
        } catch (InvalidTemplateResourceException $e) {
            // Fallback to TypoScript rendering for:
            // * content elements without matching template file
            // * more complex content elements, like ExtBase plugins
            try {
                $blockType = $record->getFullType();
                $content = $outerRenderingContext->getViewHelperInvoker()->invoke(
                    CObjectViewHelper::class,
                    [
                        'typoscriptObjectPath' => $blockType,
                        'data' => $record->getRawRecord()?->toArray(),
                        'table' => $record->getMainType(),
                    ],
                    $outerRenderingContext,
                );
                if ($content === '') {
                    $content = $outerRenderingContext->getViewHelperInvoker()->invoke(
                        CObjectViewHelper::class,
                        [
                            'typoscriptObjectPath' => $blockType . '.20',
                            'data' => $record->getRawRecord()?->toArray(),
                            'table' => $record->getMainType(),
                        ],
                        $outerRenderingContext,
                    );
                }
                return is_string($content) ? $content : '';
            } catch (Exception) {
                throw new InvalidTemplateResourceException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }
}
