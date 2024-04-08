<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl'      => [
        'title'                    => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:numbers.single',
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
            'exclude' => 0,
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:numbers.number',
            'config'  => [
                'type' => 'input',
                'cols' => 3,
                'max'  => 6,
                'eval' => 'int',
            ],
        ],
        'suffix' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:numbers.suffix',
            'config'  => [
                'type' => 'input',
                'cols' => 10,
                'max'  => 10,
                'eval' => 'trim',
            ],
        ],
        'label' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:numbers.label',
            'config'  => [
                'type' => 'input',
                'cols' => 255,
                'max'  => 255,
                'eval' => 'trim',
            ],
        ],
    ],
];
