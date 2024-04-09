<?php

declare(strict_types=1);

namespace Surfcamp\Success\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ThemeVariablesProviderViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('selector', 'string', 'Theme variables', false,':root');
        $this->registerArgument('variables', 'array', 'Theme variables', true);
        $this->registerArgument('prefix', 'string', 'Theme variables', false, '');
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        if (empty($arguments['variables']) || empty($arguments['selector'])) {
            return '';
        }

        $content = $arguments['selector'] . ' {' . LF;
        $content .= self::buildVariables($arguments['variables'], $arguments['prefix'] ?? '');
        $content .= '}';

        return $content;
    }

    private static function buildVariables(array $variables, string $prefix = ''): string
    {
        $content = '';

        foreach ($variables as $name => $value) {
            if (is_array($value)) {
                $content .= self::buildVariables($value, $prefix . $name . '-');
            } else {
                $content .= '--'. $prefix. $name . ': ' .$value . ';' . LF;
            }
        }
        return $content;
    }
}
