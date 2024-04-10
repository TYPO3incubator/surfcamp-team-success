<?php

/***************
 * Add custom RTE configurations
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['minimal'] = 'EXT:success/Configuration/RTE/Minimal.yaml';
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


#TODO This is a workaround only because currently it is not possible to add it through a set
call_user_func(static function () {

    // Add module configuration
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        'module.tx_form {
            settings {
                yamlConfigurations {
                    110 = EXT:success/Configuration/Sets/LandingPage/Yaml/FormSetup.yaml
                }
            }
        }'
    );
});
