# PHPIrkit

IRKit Device HTTP API Commander.

[![Latest Stable Version](https://img.shields.io/packagist/v/dimgraycat/phpirkit.svg?style=flat-square)](https://packagist.org/packages/dimgraycat/phpirkit)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)

## Installation

We distribute a [PHP Archive (PHAR)](https://php.net/phar) that has all required (as well as some optional) dependencies of PHPIrkit bundled in a single file:

```bash
$ wget https://raw.github.com/dimgraycat/php-irkit/master/build/phpirkit.phar
$ wget https://raw.github.com/dimgraycat/php-irkit/master/config.json
$ wget https://raw.github.com/dimgraycat/php-irkit/master/messages.json

$ chmod +x phpirkit.phar

$ mv phpirkit.phar /usr/local/bin/phpirkit

$ mkdir /var/phpirkit
$ mv config.json /var/phpirkit/
$ mv messages.json /var/phpirkit/

$ php phpirkit --help
$ php phpirkit keys -d /var/phpirkit/
$ php phpirkit messages -d /var/phpirkit/ --help
```

You can also immediately use the PHAR after you have downloaded it, of course:

```bash
$ wget https://raw.github.com/dimgraycat/php-irkit/master/build/phpirkit.phar
$ wget https://raw.github.com/dimgraycat/php-irkit/master/config.json
$ wget https://raw.github.com/dimgraycat/php-irkit/master/messages.json

$ php phpirkit.phar --help
```
