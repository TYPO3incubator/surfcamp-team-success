<?php

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../../', '.env.dist');
$dotenv->load();

if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], [
    'BE' => [
        'debug' => getenv('TYPO3_BE_DEBUG') ?: 0,
        'installToolPassword' => getenv('TYPO3_BE_INSTALLTOOLPASSWORD') ?: '',
    ],
    'FE' => [
        'debug' => getenv('TYPO3_FE_DEBUG') ?: 0,
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'host' => getenv('TYPO3_DB_CONNECTIONS_DEFAULT_HOST'),
                'port' => (int)(getenv('TYPO3_DB_CONNECTIONS_DEFAULT_PORT') ?: 3306),
                'user' => getenv('TYPO3_DB_CONNECTIONS_DEFAULT_USER'),
                'password' => getenv('TYPO3_DB_CONNECTIONS_DEFAULT_PASSWORD'),
                'dbname' => getenv('TYPO3_DB_CONNECTIONS_DEFAULT_DBNAME'),
            ],
        ],
    ],
    'MAIL' => [
        'defaultMailFromAddress' => getenv('TYPO3_MAIL_DEFAULTMAILFROMADDRESS') ?: '',
        'defaultMailFromName' => getenv('TYPO3_MAIL_DEFAULTMAILFROMNAME') ?: '',
        'transport' => getenv('TYPO3_MAIL_TRANSPORT'),
        'transport_mbox_file' => getenv('TYPO3_MAIL_TRANSPORT_MBOX_FILE'),
        'transport_sendmail_command' => getenv('TYPO3_MAIL_TRANSPORT_SENDMAIL_COMMAND'),
        'transport_smtp_encrypt' => getenv('TYPO3_MAIL_TRANSPORT_SMTP_ENCRYPT'),
        'transport_smtp_password' => getenv('TYPO3_MAIL_TRANSPORT_SMTP_PASSWORD'),
        'transport_smtp_server' => getenv('TYPO3_MAIL_TRANSPORT_SMTP_SERVER'),
        'transport_smtp_username' => getenv('TYPO3_MAIL_TRANSPORT_SMTP_USERNAME'),
    ],
    'SYS' => [
        'devIPmask' => getenv('TYPO3_SYS_DEVIPMASK') ?: '',
        'displayErrors' => getenv('TYPO3_SYS_DISPLAYERRORS') ?: 0,
        'encryptionKey' => getenv('TYPO3_SYS_ENCRYPTIONKEY'),
        'exceptionalErrors' => getenv('TYPO3_SYS_EXCEPTIONALERRORS') ?: 4096,
    ],
]);