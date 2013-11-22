#ECG Magento Code Sniffer Coding Standard

ECG Magento Code Sniffer Coding Standard is a set of rules and sniffs for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) tool.

It allows automatically check your code against some of the common Magento and PHP coding issues, like:
- raw SQL queries;
- SQL queries inside a loop;
- direct instantiation of Mage and Enterpise classes;
- unnecessary collection loading;
- excessive code complexity;
- use of dangerous functions;
- use of PHP superglobals;

and many others.


#Installation & Usage

Before starting using our coding standard install [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer).

Clone or download this repo somewhere on your computer or install it with [Composer](http://getcomposer.org/).
To do so, add the dependency to your `composer.json` file and run the `php composer.phar install` command:

```json
{
  "require": {
    "magento-ecg/coding-standard": "dev-master"
  }
}
```

Run CodeSniffer:

```sh
phpcs --standard=/path/to/Ecg/standard /path/to/code
```



#Requirements


PHP 5.4 and up.

Checkout the `php-5.3-compatible` branch to get the PHP 5.3 version.

#Contribution

Please feel free to contribute new sniffs or any fixes or improvements for the existing ones.
