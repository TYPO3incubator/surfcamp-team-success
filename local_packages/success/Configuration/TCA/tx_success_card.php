<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl'      => [
        'title'                    => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.single',
        'label'                    => 'headline',
        'hideTable'                => true,
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'sortby'                   => 'sorting',
        'delete'                   => 'deleted',
        'searchFields'             => '',
        'typeicon_classes'         => [
            'default' => 'content-card',
        ],
        'versioningWS'=> true,
    ],
    'types'     => [
        '1' => ['showitem' => 'headline, media, bodytext, link'],
    ],
    'columns'   => [
        'headline' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.headline',
            'config'  => [
                'type' => 'input',
                'cols' => 256,
                'max'  => 256,
                'eval' => 'trim',
            ],
        ],
        'bodytext' => [
            'exclude' => true,
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.text',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 5,
                'enableRichtext' => true,
            ],
        ],
        'media' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.media',
            'config' => [
                'type' => 'file',
                'maxitems' => 6,
                'allowed' => 'common-image-types'
            ],
        ],
        'link' => [
            'label' => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.link',
            'config' => [
                'type' => 'link',
                'allowedTypes' => ['page', 'url', 'record'],
            ]
        ]
    ],
];
