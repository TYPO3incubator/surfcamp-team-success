<?php

use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!empty($_ENV['TYPO3_BE_INSTALLTOOLPASSWORD'])) {
    $hashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance('BE');
    $hashedPassword = $hashInstance->getHashedPassword($_ENV['TYPO3_BE_INSTALLTOOLPASSWORD']);
}

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], [
    'BE' => [
        'debug' => $_ENV['TYPO3_BE_DEBUG'] ?? 0,
        'installToolPassword' => $hashedPassword ?? '',
    ],
    'FE' => [
        'debug' => $_ENV['TYPO3_FE_DEBUG'] ?? 0,
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'host' => $_ENV['TYPO3_DB_CONNECTIONS_DEFAULT_HOST'],
                'port' => (int)($_ENV['TYPO3_DB_CONNECTIONS_DEFAULT_PORT'] ?? 3306),
                'user' => $_ENV['TYPO3_DB_CONNECTIONS_DEFAULT_USER'],
                'password' => $_ENV['TYPO3_DB_CONNECTIONS_DEFAULT_PASSWORD'],
                'dbname' => $_ENV['TYPO3_DB_CONNECTIONS_DEFAULT_DBNAME'],
                'driver' => $_ENV['TYPO3_DB_CONNECTIONS_DEFAULT_DRIVER'] ?? 'mysqli',
            ],
        ],
    ],
    'MAIL' => [
        'defaultMailFromAddress' => $_ENV['TYPO3_MAIL_DEFAULTMAILFROMADDRESS'] ?? '',
        'defaultMailFromName' => $_ENV['TYPO3_MAIL_DEFAULTMAILFROMNAME'] ?? '',
        'transport' => $_ENV['TYPO3_MAIL_TRANSPORT'] ?? 'sendmail',
        'transport_mbox_file' => $_ENV['TYPO3_MAIL_TRANSPORT_MBOX_FILE'] ?? '',
        'transport_sendmail_command' => $_ENV['TYPO3_MAIL_TRANSPORT_SENDMAIL_COMMAND'] ?? '/usr/local/bin/mailpit sendmail -t --smtp-addr 127.0.0.1:1025',
        'transport_smtp_encrypt' => $_ENV['TYPO3_MAIL_TRANSPORT_SMTP_ENCRYPT'] ?? '',
        'transport_smtp_password' => $_ENV['TYPO3_MAIL_TRANSPORT_SMTP_PASSWORD'] ?? '',
        'transport_smtp_server' => $_ENV['TYPO3_MAIL_TRANSPORT_SMTP_SERVER'] ?? '',
        'transport_smtp_username' => $_ENV['TYPO3_MAIL_TRANSPORT_SMTP_USERNAME'] ?? '',
    ],
    'SYS' => [
        'devIPmask' => $_ENV['TYPO3_SYS_DEVIPMASK'] ?? '',
        'displayErrors' => $_ENV['TYPO3_SYS_DISPLAYERRORS'] ?? 0,
        'encryptionKey' => $_ENV['TYPO3_SYS_ENCRYPTIONKEY'],
        'exceptionalErrors' => $_ENV['TYPO3_SYS_EXCEPTIONALERRORS'] ?? 4096,
        'reverseProxyIP' => $_ENV['TYPO3_SYS_REVERSEPROXYIP'] ?? '',
        'reverseProxySSL' => $_ENV['TYPO3_SYS_REVERSEPROXYSSL'] ?? '',
        'systemLocale' => $_ENV['TYPO3_SYS_SYSTEMLOCALE'] ?? '',
    ],
]);

if (\TYPO3\CMS\Core\Core\Environment::getContext()->isDevelopment()) {
    // Use dev server only if it's running ( ddev vite-serve start )
    $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['vite_asset_collector']['useDevServer'] = (bool)exec('tmux ls 2>/dev/null | grep vite-sess');
    $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['vite_asset_collector']['devServerUri'] = getenv('DDEV_PRIMARY_URL') . ':' . getenv('VITE_PRIMARY_PORT');

    // Disable caching locally
    $doNotDisableCache = [
        'fluid_template',
        'runtime',
    ];
    foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
        if (in_array($cacheName, $doNotDisableCache, true)) {
            continue;
        }
        if (isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['frontend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['frontend'] = \TYPO3\CMS\Core\Cache\Frontend\NullFrontend::class;
        }
        if (isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
        }
    }

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fluid_template']['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
}
