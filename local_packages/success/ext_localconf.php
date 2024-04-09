<?php

/***************
 * Add custom RTE configurations
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['custom'] = 'EXT:success/Configuration/RTE/Custom.yaml';

// Include vite generated manifest file (global)
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['vite_asset_collector']['defaultManifest'] = 'EXT:success/Resources/Public/Vite/.vite/manifest.json';

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend'] = [
    'backendFavicon' => 'EXT:success/Resources/Public/Icons/surfcamp2.svg',
    'backendLogo' => 'EXT:success/Resources/Public/Icons/surfcamp2.svg',
    'loginBackgroundImage' => 'EXT:success/Resources/Public/Images/lapared.webp',
    'loginLogo' => 'EXT:success/Resources/Public/Icons/surfcamp1.svg',
    'loginHighlightColor' => '#84b0a5',
    'loginFootnote' => 'Team Success',
];
