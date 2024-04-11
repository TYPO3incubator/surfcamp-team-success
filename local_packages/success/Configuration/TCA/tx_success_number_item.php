<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl'      => [
        'title'                    => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers.single',
        'label'                    => 'number',
        'hideTable'                => true,
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'sortby'                   => 'sorting',
        'delete'                   => 'deleted',
        'searchFields'             => '',
        'typeicon_classes'         => [
            'default' => 'number',
        ],
        'versioningWS'=> true,
    ],
    'types'     => [
        '1' => ['showitem' => 'number, suffix, label'],
    ],
    'columns'   => [
        'number' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers.number',
            'config'  => [
                'type' => 'input',
                'cols' => 3,
                'max'  => 6,
                'eval' => 'int',
            ],
        ],
        'suffix' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers.suffix',
            'config'  => [
                'type' => 'input',
                'cols' => 10,
                'max'  => 10,
                'eval' => 'trim',
            ],
        ],
        'label' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:numbers.label',
            'config'  => [
                'type' => 'input',
                'cols' => 255,
                'max'  => 255,
                'eval' => 'trim',
            ],
        ],
    ],
];
