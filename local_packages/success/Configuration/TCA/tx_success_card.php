<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards.single',
        'label' => 'headline',
        'hideTable' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'typeicon_classes' => [
            'default' => 'content-card',
        ],
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'translationSource' => 'l10n_source',
        'searchFields' => 'headline,bodytext',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => '
        headline, media, bodytext,
        --palette--;;button,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
        --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
        hidden,--palette--;;timeRestriction,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        '],
    ],
    'palettes' => [
        'button' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:button',
            'showitem' => 'button_link, button_label, button_style',
        ],
        'timeRestriction' => ['showitem' => 'starttime, endtime'],
        'language' => ['showitem' => 'sys_language_uid, l10n_parent'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_success_card',
                'foreign_table_where' => 'AND {#tx_success_card}.{#pid}=###CURRENT_PID### AND {#tx_success_card}.{#sys_language_uid} IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => '',
            ],
        ],
        'hidden' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'eval' => 'int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'eval' => 'int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2106),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'headline' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards.headline',
            'config' => [
                'type' => 'input',
                'cols' => 255,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'bodytext' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards.text',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 5,
                'enableRichtext' => true,
                'richtextConfiguration' => 'custom',
            ],
        ],
        'media' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:cards.media',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types'
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
    ],
];
