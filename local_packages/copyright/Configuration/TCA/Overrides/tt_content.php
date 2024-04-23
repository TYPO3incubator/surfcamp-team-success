<?php

declare(strict_types=1);

defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Copyright',
    'Images',
    'LLL:EXT:copyright/Resources/Private/Language/locallang_db.xlf:element.label',
    'content-listgroup',
    'special',
    'LLL:EXT:copyright/Resources/Private/Language/locallang_db.xlf:element.description',
);
