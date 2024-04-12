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

// Override space before and after
$GLOBALS['TCA']['tt_content']['columns']['space_before_class']['config']['default'] = 'medium';
$GLOBALS['TCA']['tt_content']['columns']['space_before_class']['config']['items']['0'] = [
    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:space.none',
    'value' => 'none',
];
$GLOBALS['TCA']['tt_content']['columns']['space_after_class']['config']['default'] = 'medium';
$GLOBALS['TCA']['tt_content']['columns']['space_after_class']['config']['items']['0'] = [
    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:space.none',
    'value' => 'none',
];

// Palettes
$GLOBALS['TCA']['tt_content']['palettes']['frames']['showitem'] = '
layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:layout_formlabel,
--linebreak--, space_before_class;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_before_class_formlabel, space_after_class;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_after_class_formlabel,';

$GLOBALS['TCA']['tt_content']['palettes']['headers']['showitem'] = '
overline;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:overline,
--linebreak--, header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
--linebreak--, header_layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout_formlabel, header_style;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:header_style,
--linebreak--, subheader;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:subheader_formlabel
';

$GLOBALS['TCA']['tt_content']['palettes']['header']['showitem'] = '
header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
--linebreak--, header_layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout_formlabel, header_style;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:header_style,
';

$GLOBALS['TCA']['tt_content']['palettes']['button'] = [
    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button',
    'showitem' => 'button_link, button_label, button_style,',
];

$GLOBALS['TCA']['tt_content']['columns']['layout']['config']['items'] = [
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:layout.default',
        'value' => 0,
    ],
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:layout.primary',
        'value' => 1,
    ],
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:layout.secondary',
        'value' => 2,
    ],
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:layout.light',
        'value' => 3,
    ],
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:layout.white',
        'value' => 4,
    ],
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:layout.black',
        'value' => 5,
    ],
];

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
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:header_style',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'default' => 'default',
            'items' => [
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:header_style.default',
                    'value' => 'default'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:header_style.heading-xxl',
                    'value' => 'heading-xxl'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:header_style.heading-xl',
                    'value' => 'heading-xl'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:header_style.heading-lg',
                    'value' => 'heading-lg'
                ]
            ]
        ]
    ],
    'overline' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:overline',
        'config' => [
            'type' => 'input',
            'max' => 255,
            'size' => 50,
        ],
    ],
    'button_link' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_link',
        'config' => [
            'type' => 'link',
            'allowedTypes' => ['page', 'url', 'record'],
        ]
    ],
    'button_label' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_label',
        'config' => [
            'type' => 'input',
            'max' => 50,
        ],
    ],
    'button_style' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_style',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'default' => 'primary',
            'items' => [
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_style.primary',
                    'value' => 'primary'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_style.secondary',
                    'value' => 'secondary'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_style.light',
                    'value' => 'light'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_style.black',
                    'value' => 'black'
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button_style.white',
                    'value' => 'white'
                ]
            ]
        ],
    ],
    'tx_success_card' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards.single',
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
    ],
    'tx_success_number_item' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers.counting',
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
    ],
    'tx_success_faq' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:faq.questions',
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
    ],
    'tx_success_review' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:reviews',
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
    ],
    'tx_success_feature' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_success_feature',
            'foreign_field' => 'parentid',
            'foreign_table_field' => 'parenttable',
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 0,
                'useSortable' => 1,
            ],
            'minitems' => 2,
            'maxitems' => 6,
        ],
    ],
    'tx_success_menu_item' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:menuItems',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_success_menu_item',
            'foreign_field' => 'parentid',
            'foreign_table_field' => 'parenttable',
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 0,
                'useSortable' => 1,
            ],
            'minitems' => 0,
            'maxitems' => 7,
        ],
    ],
    'name' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.name',
        'config' => [
            'type' => 'input',
            'cols' => 50,
        ],
    ],
    'color' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.color',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.color.black',
                    'value' => 'black',
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.color.white',
                    'value' => 'white',
                ],
            ],
        ],
    ],
    'navigation' => [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.navigation',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.navigation.below',
                    'value' => 'below',
                ],
                [
                    'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.navigation.beside',
                    'value' => 'beside',
                ],
            ],
        ],
    ],
]);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'header', 'header_style', 'after:header_layout');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'headers', 'header_style', 'after:header_layout');

// Text Media
$GLOBALS['TCA']['tt_content']['types']['textmedia'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers, bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
    --palette--;;button,
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
    ',
    'columnsOverrides' => [
        'bodytext' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero.text',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 5,
                'enableRichtext' => true,
                'richtextConfiguration' => 'custom'
            ],
        ],
    ],
];

// Text Media
$GLOBALS['TCA']['tt_content']['types']['text'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers, bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
    --palette--;;button,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
    'columnsOverrides' => [
        'bodytext' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero.text',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 5,
                'enableRichtext' => true,
                'richtextConfiguration' => 'custom'
            ],
        ],
    ],
];

// Cards Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards',
        'value' => 'success_cards',
        'icon' => 'content-card-group',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_cards'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,
    --div--;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards, tx_success_card,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_cards'] = 'content-card-group';

// Big Numbers Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers',
        'value' => 'success_numbers',
        'icon' => 'content-widget-number',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_numbers'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,
    --div--;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers, tx_success_number_item,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_numbers'] = 'content-widget-number';

// Gallery Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:gallery',
        'value' => 'success_gallery',
        'icon' => 'content-image',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:gallery.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_gallery'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media, assets,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_gallery'] = 'content-image';

// Partner Logo Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:partner',
        'value' => 'success_partner',
        'icon' => 'install-manage-maintainer',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:partner.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_partner'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media, assets,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_partner'] = 'install-manage-maintainer';

// FAQ element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:faq',
        'value' => 'success_faq',
        'icon' => 'actions-question-circle-alt',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:faq.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_faq'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,
    --div--;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:faq, tx_success_faq,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_faq'] = 'actions-question-circle-alt';

// Hero Banner Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero',
        'value' => 'success_hero',
        'icon' => 'install-test-image',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_hero'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;header, bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
    --palette--;;button,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media, assets,
    --linebreak--, imageorient;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient_formlabel,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,',
    'columnsOverrides' => [
        'bodytext' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero.text',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 5,
                'enableRichtext' => true,
                'richtextConfiguration' => 'minimal'
            ],
        ],
        'assets' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero.media',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'maxitems' => 1,
            ],
        ],
        'imageorient' => [
            'config' => [
                'items' => [
                    [
                        'icon' => 'content-beside-text-img-centered-right',
                        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero.imageorient.background.text_left',
                        'value' => 0,
                    ],
                    [
                        'icon' => 'content-beside-text-img-centered-left',
                        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:hero.imageorient.background.text_right',
                        'value' => 1,
                    ],
                    [
                        'icon' => 'content-beside-text-img-right',
                        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient.I.9',
                        'value' => 2,
                    ],
                    [
                        'icon' => 'content-beside-text-img-left',
                        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient.I.10',
                        'value' => 3,
                    ],
                ],
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
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:reviews',
        'value' => 'success_review',
        'icon' => 'content-certificate',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:reviews.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_review'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,
    --div--;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:reviews, tx_success_review,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_review'] = 'content-certificate';

// Features Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features',
        'value' => 'success_features',
        'icon' => 'install-manage-features',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_features'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;headers,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media, assets,
    --div--;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features, tx_success_feature,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_features'] = 'install-manage-features';

// Top Bar Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar',
        'value' => 'success_topbar',
        'icon' => 'content-header',
        'group' => 'default',
        'description' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.description',
    ]
);

$GLOBALS['TCA']['tt_content']['types']['success_topbar'] = [
    'showitem' => '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,name,color,navigation,
    --div--;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:topbar.logo, assets,
    --div--;LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:menuItems, tx_success_menu_item,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
    --palette--;;frames,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['success_topbar'] = 'content-header';
