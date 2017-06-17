# ECG Magento Code Sniffer Coding Standard

[![SensioLabsInsight Medal](https://insight.sensiolabs.com/projects/a06c37c6-0d79-4476-aff5-12d8ce1d8c53/big.png "SensioLabsInsight Medal")](https://insight.sensiolabs.com/projects/a06c37c6-0d79-4476-aff5-12d8ce1d8c53)

ECG Magento Code Sniffer Coding Standard is a set of rules and sniffs for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) tool.

It allows automatically check your code against some of the common Magento and PHP coding issues, like:
- raw SQL queries;
- SQL queries inside a loop;
- direct instantiation of Mage and Enterprise classes;
- unnecessary collection loading;
- excessive code complexity;
- use of dangerous functions;
- use of PHP Superglobals;

and many others.

Both Magento and Magento 2 are supported.

# Installation & Usage

Before starting using our coding standard install [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer).

Clone or download this repo somewhere on your computer or install it with [Composer](http://getcomposer.org/):

```sh
composer require magento-ecg/coding-standard
```

Note: PHP_CodeSniffer 3.x is now requred to run our coding standard. To install PHP_CodeSniffer 2.x compatible version:

```sh
composer require magento-ecg/coding-standard:2.*
```

Select a standard to run with CodeSniffer:

* Ecg for Magento
* EcgM2 for Magento 2

Run CodeSniffer:

```sh
$ phpcs --standard=./vendor/magento-ecg/coding-standard/Ecg /path/to/code
```
```sh
$ phpcs --standard=./vendor/magento-ecg/coding-standard/EcgM2 /path/to/code
```

As a one time thing, you can add the ECG standards directory to PHP_CodeSniffer's installed paths:
```sh
$ phpcs --config-set installed_paths /path/to/your/folder/vendor/magento-ecg/coding-standard
```

After that specifying the path to a standard is optional:
```sh
$ phpcs --standard=Ecg /path/to/code
```
```sh
$ phpcs --standard=EcgM2 /path/to/code
```

PHP CodeSniffer will automatically scan Magento PHP files. To check design templates, you must specify `phtml` in the `--extensions` argument: `--extensions=php,phtml`.

# Requirements

PHP 5.4 and up.

Checkout the `php-5.3-compatible` branch to get the PHP 5.3 version.

# Contribution

Please feel free to contribute new sniffs or any fixes or improvements for the existing ones.
