<?php

declare(strict_types=1);

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title'                    => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:faq.question',
        'label'                    => 'question',
        'hideTable'                => true,
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'sortby'                   => 'sorting',
        'delete'                   => 'deleted',
        'searchFields'             => '',
        'typeicon_classes'         => [
            'default' => 'actions-question',
        ],
        'versioningWS'=> true,
    ],
    'types'     => [
        '1' => ['showitem' => 'question, answer'],
    ],
    'columns'   => [
        'question' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:faq.question',
            'config'  => [
                'type' => 'input',
                'cols' => 255,
                'max'  => 255,
                'eval' => 'trim',
            ],
        ],
        'answer' => [
            'label'   => 'LLL:EXT:success/Resources/Private/Language/locallang_db.xlf:faq.answer',
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
