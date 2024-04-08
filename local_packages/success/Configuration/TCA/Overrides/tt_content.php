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

// Cards Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards',
        'value' => 'success_cards',
        'icon' => 'content-card-group',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.description',
    ]
);

$tx_success_card = [
    'tx_success_card' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.single',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_success_card',
            'foreign_field' => 'parentid',
            'foreign_table_field' => 'parenttable',
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 0,
                'useSortable' => 1,
            ],
            'minitems' => 1,
            'maxitems' => 99,
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tx_success_card);

$GLOBALS['TCA']['tt_content']['types']['success_cards'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,tx_success_card'
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_cards'] = 'content-card-group';
$GLOBALS['TCA']['tx_success_card']['ctrl']['security']['ignorePageTypeRestriction'] = true;

// Big Numbers Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:numbers',
        'value' => 'success_numbers',
        'icon' => 'number',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:numbers.description',
    ]
);

$tx_success_number_item = [
    'tx_success_number_item' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:numbers.counting',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_success_number_item',
            'foreign_field' => 'parentid',
            'foreign_table_field' => 'parenttable',
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 0,
                'useSortable' => 1,
            ],
            'minitems' => 3,
            'maxitems' => 5,
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tx_success_number_item);

$GLOBALS['TCA']['tt_content']['types']['success_numbers'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,tx_success_number_item'
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_numbers'] = 'number';
$GLOBALS['TCA']['tx_success_number_item']['ctrl']['security']['ignorePageTypeRestriction'] = true;

// Gallery Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:gallery',
        'value' => 'success_gallery',
        'icon' => 'content-image',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:gallery.description',
    ]
);

$tx_success_gallery_item = [
    'tx_success_gallery_item' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:gallery.item',
        'config' => [
            'type' => 'file',
            'allowed' => 'common-image-types'
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tx_success_gallery_item);

$GLOBALS['TCA']['tt_content']['types']['success_gallery'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,tx_success_gallery_item'
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_gallery'] = 'content-image';

// Partner Logo Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:partner',
        'value' => 'success_partner',
        'icon' => 'actions-briefcase',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:partner.description',
    ]
);

$tx_success_partner = [
    'tx_success_partner' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:partner.item',
        'config' => [
            'type' => 'file',
            'allowed' => 'common-image-types',
            'maxitems' => 2,
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tx_success_partner);

$GLOBALS['TCA']['tt_content']['types']['success_partner'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,tx_success_partner'
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_partner'] = 'actions-briefcase';

// FAQ element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:faq',
        'value' => 'success_faq',
        'icon' => 'actions-question',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:faq.description',
    ]
);

$tx_success_faq = [
    'tx_success_faq' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:faq.questions',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_success_faq',
            'foreign_field' => 'parentid',
            'foreign_table_field' => 'parenttable',
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 0,
                'useSortable' => 1,
            ],
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tx_success_faq);

$GLOBALS['TCA']['tt_content']['types']['success_faq'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,tx_success_faq'
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_faq'] = 'actions-question';
$GLOBALS['TCA']['tx_success_faq']['ctrl']['security']['ignorePageTypeRestriction'] = true;

// Hero Banner Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:hero',
        'value' => 'success_hero',
        'icon' => 'install-test-image',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:hero.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_hero'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,bodytext,media,',
    'columnsOverrides' => [
        'bodytext' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:hero.text',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 5,
                'enableRichtext' => true,
                'richtextConfiguration' => 'custom'
            ],
        ],
        'media' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:hero.media',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'maxitems' => 1,
            ],
        ],
    ],
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_hero'] = 'install-test-image';

// Reviews Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:reviews',
        'value' => 'success_review',
        'icon' => 'install-manage-maintainer',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:reviews.description',
    ]
);

$tx_success_review = [
    'tx_success_review' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:reviews',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_success_review',
            'foreign_field' => 'parentid',
            'foreign_table_field' => 'parenttable',
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 0,
                'useSortable' => 1,
            ],
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tx_success_review);

$GLOBALS['TCA']['tt_content']['types']['success_review'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,tx_success_review'
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_review'] = 'install-manage-maintainer';
$GLOBALS['TCA']['tx_success_review']['ctrl']['security']['ignorePageTypeRestriction'] = true;
