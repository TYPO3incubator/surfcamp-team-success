<?php

declare(strict_types=1);

defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Copyright',
    'Images',
    [
        \Surfcamp\Copyright\Controller\CopyrightController::class => 'images',
    ],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
