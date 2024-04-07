<?php

declare(strict_types=1);

defined('TYPO3') || die();

/**
 * Remove default TYPO3 content elements
 */
$removeCE = [
    '1',
    'div',
    'bullets',
    'header',
    'html',
    'image',
    'list',
    'menu_abstract',
    'menu_categorized_content',
    'menu_categorized_pages',
    'menu_pages',
    'menu_recently_updated',
    'menu_related_pages',
    'menu_section',
    'menu_section_pages',
    'menu_sitemap',
    'menu_sitemap_pages',
    'menu_subpages',
    'shortcut',
    'table',
    'text',
    'textmedia',
    'textpic',
    'uploads',
];

foreach ($removeCE as $CType) {
    unset(
        $GLOBALS['TCA']['tt_content']['types'][$CType],
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$CType]
    );
}

foreach ($GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'] as $cTypeId => $item) {
    if (in_array($item['value'], $removeCE, true)) {
        unset($GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][$cTypeId]);
    }
}
