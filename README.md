# PHPIrkit

IRKit Device HTTP API Commander.

[![License](https://img.shields.io/badge/license-mit-blue.svg?style=flat-square)](https://github.com/dimgraycat/php-irkit/blob/master/LICENSE)
[![Latest Stable Version](https://img.shields.io/packagist/v/dimgraycat/phpirkit.svg?style=flat-square)](https://packagist.org/packages/dimgraycat/phpirkit)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)
[![Travis](https://img.shields.io/travis/rust-lang/rust.svg?style=flat-square)](https://travis-ci.org/dimgraycat/php-irkit)

## Installation

We distribute a [PHP Archive (PHAR)](https://php.net/phar) that has all required (as well as some optional) dependencies of PHPIrkit bundled in a single file:

```bash
$ wget https://raw.github.com/dimgraycat/php-irkit/master/build/phpirkit.phar

$ chmod +x phpirkit.phar

$ mv phpirkit.phar /usr/local/bin/phpirkit
$ phpirkit config --help
$ mkdir /var/phpirkit
$ mv config.json /var/phpirkit/
$ mv messages.json /var/phpirkit/

$ phpirkit --help
$ phpirkit keys -d /var/phpirkit/
$ phpirkit messages -d /var/phpirkit/ --help
```
See: [Sample Settings](https://github.com/dimgraycat/php-irkit/tree/master/sample)

You can also immediately use the PHAR after you have downloaded it, of course:

```bash
$ wget https://raw.github.com/dimgraycat/php-irkit/master/build/phpirkit.phar

$ php phpirkit.phar config --help
$ php phpirkit.phar --help
