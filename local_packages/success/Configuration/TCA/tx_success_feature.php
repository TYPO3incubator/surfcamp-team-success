<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title'                    => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features.item',
        'label'                    => 'header',
        'hideTable'                => true,
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'sortby'                   => 'sorting',
        'delete'                   => 'deleted',
        'searchFields'             => '',
        'typeicon_classes'         => [
            'default' => 'install-manage-features',
        ],
        'versioningWS'=> true,
    ],
    'types'     => [
        '1' => ['showitem' => 'header, text, icon'],
    ],
    'columns'   => [
        'icon' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features.icon',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'svg'
            ],
        ],
        'header' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features.header',
            'config'  => [
                'type' => 'input',
                'cols' => 255,
                'max'  => 255,
                'eval' => 'trim',
            ],
        ],
        'text' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:features.text',
            'config'  => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 5,
                'enableRichtext' => true,
                'richtextConfiguration' => 'minimal'
            ],
        ],
    ],
];
