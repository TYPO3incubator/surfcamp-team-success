<?php

declare(strict_types=1);

namespace Surfcamp\Success\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FontMappingViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    /**
     * Take care of the order to not override the same value again!
     * The variable names can be overridden if they are matched.
     *
     * @var string[]
     */
    private static array $fonts = [
        'comic-neue' => '"Comic Neue", cursive',
        'lato' => 'Lato, sans-serif',
        'merriweather' => 'Merriweather, serif',
        'noto-serif' => '"Noto Serif", serif',
        'open-sans' => '"Open Sans", sans-serif',
        'oswald' => 'Oswald, sans-serif',
        'playpen-sans' => '"Playpen Sans", cursive',
        'roboto-slab' => '"Roboto Slab", serif',
        'roboto-mono' => '"Roboto Mono", monospace',
        'roboto' => 'Roboto, sans-serif',
    ];

    public function render(): mixed
    {
        return str_replace(array_keys(self::$fonts), self::$fonts, $this->renderChildren());
    }
}
