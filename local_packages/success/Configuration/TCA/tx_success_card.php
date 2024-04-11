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
                'cols' => 255,
                'max'  => 255,
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
                'richtextConfiguration' => 'custom',
            ],
        ],
        'media' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_ctypes.xlf:cards.media',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types'
            ],
        ],
    ],
];
