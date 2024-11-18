# TYPO3 Surfcamp Team 6 (Landing Page)

This Git repository is intended for use by our dedicated teams at the [TYPO3 Surfcamp](https://surfcamp.typo3.com/). The configuration happens via `.env` thanks to the underlying package `vlucas/phpdotenv`.


## Requirements

* having Docker installed locally (see https://docs.docker.com/get-docker/)
* having DDEV installed locally (see https://ddev.readthedocs.io/en/stable/#installation)


## Initialization

```sh
cp .env.dist .env
ddev start
ddev composer install
```

## Credentials

- Backend: https://surfcamp-team3.ddev.site/typo3
- Username: `admin`
- Password: `John3:16`

### Downloading database and files

```sh
# HEADS UP: All files in the local `public/fileadmin/` will be overridden, that means:
# all files that are not present in `data/files/public/fileadmin/` will be deleted from fileadmin
ddev pull assets
```

### Update local database and files

```sh
# HEADS UP: All files in the local `data/files/public/fileadmin/` will be overridden, that means:
# all files that are not present in `public/fileadmin/` will be deleted from fileadmin
ddev push assets
```

## Use Vite.js [dev server for ddev](https://github.com/torenware/ddev-viteserve#getting-started)

```
ddev get torenware/ddev-viteserve
ddev restart
ddev vite-serve start
```

## Npm Scripts / Vite.js

The frontend toolchain uses NPM and Vite.js with a few loaders to ...
  * Compile scss to css (`assets/Scss`)
  * Bundle javascript (`assets`)

Watch for changes in js/scss files:

```
ddev npm run watch
```

Build JS, CSS for development use (not compressed/optimized):

```
ddev npm run build:development
```

Build JS, CSS for production use:

```
ddev npm run build:production
```
