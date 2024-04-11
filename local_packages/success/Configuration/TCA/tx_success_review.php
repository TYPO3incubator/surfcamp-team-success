<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title'                    => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:reviews.item',
        'label'                    => 'name',
        'hideTable'                => true,
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'sortby'                   => 'sorting',
        'delete'                   => 'deleted',
        'searchFields'             => '',
        'typeicon_classes'         => [
            'default' => 'install-manage-maintainer',
        ],
        'versioningWS'=> true,
    ],
    'types'     => [
        '1' => ['showitem' => 'name, review'],
    ],
    'columns'   => [
        'name' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:reviews.name',
            'config'  => [
                'type' => 'input',
                'cols' => 255,
                'max'  => 255,
                'eval' => 'trim',
            ],
        ],
        'review' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:reviews.review',
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
