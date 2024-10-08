<?php

declare(strict_types=1);

namespace Surfcamp\Success\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ThemeVariablesProviderViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('selector', 'string', 'Theme variables', false, ':root');
        $this->registerArgument('variables', 'array', 'Theme variables', true);
        $this->registerArgument('prefix', 'string', 'Theme variables', false, '');
    }

    public function render(): string
    {
        if (empty($this->arguments['variables']) || empty($this->arguments['selector'])) {
            return '';
        }

        $content = $this->arguments['selector'] . ' {' . LF;
        $content .= $this->buildVariables($this->arguments['variables'], $this->arguments['prefix'] ?? '');
        $content .= '}';

        return $content;
    }

    private function buildVariables(array $variables, string $prefix = ''): string
    {
        $content = '';

        foreach ($variables as $name => $value) {
            if (is_array($value)) {
                $content .= self::buildVariables($value, $prefix . $name . '-');
            } else {
                $content .= '--' . $prefix . $name . ': ' . $value . ';' . LF;
            }
        }
        return $content;
    }
}
