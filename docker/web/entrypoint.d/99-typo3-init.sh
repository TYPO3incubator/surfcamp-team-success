#!/bin/sh
echo "👋 Hello, setting up TYPO3!"
/var/www/html/bin/typo3 cache:flush
/var/www/html/bin/typo3 language:update
