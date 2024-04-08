<?php

declare(strict_types=1);

defined('TYPO3') || die();

/**
 * Remove default TYPO3 content elements
 */
$removeCE = [
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

// Palettes
$GLOBALS['TCA']['tt_content']['palettes']['frames']['showitem'] = '
layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:layout_formlabel,
--linebreak--, space_before_class;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_before_class_formlabel, space_after_class;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_after_class_formlabel,';

$GLOBALS['TCA']['tt_content']['palettes']['headers']['showitem'] = '
overline;LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:overline,
--linebreak--, header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
--linebreak--, header_layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout_formlabel, header_style;LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:header_style,
--linebreak--, subheader;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:subheader_formlabel
';

// Text Media
$GLOBALS['TCA']['tt_content']['types']['textmedia']['showitem'] ='
--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
--palette--;;general,
--palette--;;headers, bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media, assets,
--linebreak--, imageorient;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient_formlabel,
--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
--palette--;;frames,
--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
--palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
--palette--;;hidden,
--palette--;;access,
--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
';

// Image orient options
$GLOBALS['TCA']['tt_content']['columns']['imageorient']['config']['items'] = [
    [
        'icon' => 'content-beside-text-img-right',
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient.I.9',
        'value' => 0,
    ],
    [
        'icon' => 'content-beside-text-img-left',
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient.I.10',
        'value' => 1,
    ],
];


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', [
    'header_style' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:tt_content.header_style',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'default' => 'default',
            'items' => [
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:header_style.default',
                    'value' => 'default'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:header_style.lovely',
                    'value' => 'lovely'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:header_style.fancy',
                    'value' => 'fancy'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:header_style.rainbow',
                    'value' => 'rainbow'
                ]
            ]
        ]
    ],
    'overline' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ttc.xlf:tt_content.overline',
        'config' => [
            'type' => 'input',
            'max' => 255,
            'size' => 50,
        ],
    ],
]);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'header', 'header_style', 'after:header_layout');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'headers', 'header_style', 'after:header_layout');
