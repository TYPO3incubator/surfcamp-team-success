<?php
return [
    'BE' => [
        'debug' => false,
        'installToolPassword' => '<set in dotenv>',
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2idPasswordHash',
            'options' => [],
        ],
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8mb4',
                'dbname' => '<set in dotenv>',
                'driver' => '<set in dotenv>',
                'host' => '<set in dotenv>',
                'password' => '<set in dotenv>',
                'port' => '<set in dotenv>',
                'tableoptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci',
                ],
                'user' => '<set in dotenv>',
            ],
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de',
            ],
        ],
    ],
    'EXTENSIONS' => [
        'backend' => [
            'backendFavicon' => 'EXT:success/Resources/Public/Icons/surfcamp2.svg',
            'backendLogo' => 'EXT:success/Resources/Public/Icons/surfcamp2.svg',
            'loginBackgroundImage' => 'EXT:success/Resources/Public/Images/lapared.webp',
            'loginFootnote' => 'Team Success',
            'loginHighlightColor' => '#84b0a5',
            'loginLogo' => 'EXT:success/Resources/Public/Icons/surfcamp1.svg',
            'loginLogoAlt' => '',
        ],
        'extensionmanager' => [
            'automaticInstallation' => '1',
            'offlineMode' => '0',
        ],
        'scheduler' => [
            'maxLifetime' => '1440',
        ],
        'vite_asset_collector' => [
            'defaultManifest' => '_assets/vite/.vite/manifest.json',
            'devServerUri' => 'https://surfcamp-team6.ddev.site:5173',
            'useDevServer' => 'auto',
        ],
    ],
    'FE' => [
        'cacheHash' => [
            'enforceValidation' => true,
        ],
        'debug' => false,
        'disableNoCacheParameter' => true,
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2idPasswordHash',
            'options' => [],
        ],
    ],
    'GFX' => [
        'processor' => 'GraphicsMagick',
        'processor_effects' => false,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
    ],
    'LOG' => [
        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        'notice' => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'MAIL' => [
        'transport' => '<set in dotenv>',
        'transport_sendmail_command' => '<set in dotenv>',
        'transport_smtp_encrypt' => '<set in dotenv>',
        'transport_smtp_password' => '<set in dotenv>',
        'transport_smtp_server' => '<set in dotenv>',
        'transport_smtp_username' => '<set in dotenv>',
    ],
    'SYS' => [
        'UTF8filesystem' => true,
        'caching' => [
            'cacheConfigurations' => [
                'hash' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                ],
                'pages' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'options' => [
                        'compression' => true,
                    ],
                ],
                'rootline' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'options' => [
                        'compression' => true,
                    ],
                ],
            ],
        ],
        'devIPmask' => '',
        'displayErrors' => 1,
        'encryptionKey' => '<set in dotenv>',
        'exceptionalErrors' => 4096,
        'sitename' => 'Surfcamp Template',
        'systemMaintainers' => [
            1,
            2,
        ],
        'trustedHostsPattern' => '.*',
    ],
];
