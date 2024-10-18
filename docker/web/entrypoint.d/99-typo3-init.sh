#!/bin/sh
echo "👋 Hello, setting up TYPO3!"
/var/www/html/bin/typo3 extension:setup -n
/var/www/html/bin/typo3 cache:flush -n
if [ -z "$TYPO3_BE_USER_NAME" ] || [ -z "$TYPO3_BE_USER_PASSWORD" ]; then
    echo "🙅 Skip TYPO3 be user creation"
else
    echo "🧑‍💻 Create TYPO3 be user"
    /var/www/html/bin/typo3 backend:user:create -a -m -n || exit 0
fi
/var/www/html/bin/typo3 language:update -n
