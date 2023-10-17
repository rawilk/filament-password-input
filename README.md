# :package_name

[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor_slug/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/:package_slug)
![Tests](https://github.com/:vendor_slug/:package_slug/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/:vendor_slug/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/:package_slug)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/:vendor_slug/:package_slug?style=flat-square)](https://packagist.org/packages/:vendor_slug/:package_slug)
[![License](https://img.shields.io/github/license/:vendor_slug/:package_slug?style=flat-square)](https://github.com/:vendor_slug/:package_slug/blob/main/LICENSE.md)

## <!--delete-->

This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this skeleton.
2. Run `php ./configure.php` to run the script that will replace all placeholders throughout all the files.
3. Remove this block of text.

---

<!--/delete-->

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require :vendor_slug/:package_slug
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag=":package_slug-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag=":package_slug-config"
```

You can view the default configuration here: https://github.com/:vendor_slug/:package_slug/blob/main/config/:package_slug.php

## Usage

```php
$skeleton = new VendorName\Skeleton;
echo $skeleton->echoPhrase('Hello, VendorName!');
```

## Scripts

### Setup

For convenience, you can run the setup bin script for easy installation for local development.

```bash
./bin/setup.sh
```

### Formatting

Although formatting is done automatically via workflow, you can format php code locally before committing with a composer script:

```bash
composer format
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [my security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

-   [:author_name](https://github.com/:author_username)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
