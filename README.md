# TYPO3 Surfcamp Team 6 (Landing Page)

This project demonstrates the power of TYPO3 when building marketing-related one-pagers. This project was kickstarted during the [TYPO3 Surfcamp](https://surfcamp.typo3.com/) in April 2024. Configuration happens via `.env` thanks to the underlying package `helhum/dotenv-connector`.


## What's in the package?

This project can be run via DDEV completely locally, including all of the demonstrated content via a DB and file import.

It showcases:

- A landing page for a product launch
- A landing page for downloading a white paper as PDF after adding basic information (email address) for marketing purposes
- A career / job offer landing page
- A landing page for our landing pages


## Set up and Development

In order to get this project, running you need to have Docker (see https://docs.docker.com/get-docker/) and DDEV (see https://ddev.readthedocs.io/en/stable/#installation) installed.

```sh
cp .env.dist .env
ddev start
ddev composer install
```

To import the existing content use

```sh
# HEADS UP: All files in the local `public/fileadmin/` will be overridden, that means:
# all files that are not present in `data/files/public/fileadmin/` will be deleted from fileadmin
ddev pull assets
```

### Credentials

- Backend: https://surfcamp-team6.ddev.site/typo3
- Username: `admin`
- Password: `John3:16`


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
