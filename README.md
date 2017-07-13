<p align="center"><img src="http://dbrasil.tk/media/db_96.png"></p>

# Website Core 
Core for PHP website.

[![Build Status](https://travis-ci.org/devbr/website.svg)](https://travis-ci.org/devbr/website)
[![Latest Stable Version](https://poser.pugx.org/devbr/website/v/stable)](https://packagist.org/packages/devbr/website)
[![Latest Unstable Version](https://poser.pugx.org/devbr/website/v/unstable)](https://packagist.org/packages/devbr/website)
[![License](https://poser.pugx.org/devbr/website/license)](https://packagist.org/packages/devbr/website)
[![Total Downloads](https://poser.pugx.org/devbr/website/downloads)](https://packagist.org/packages/devbr/website)
[![Monthly Downloads](https://poser.pugx.org/devbr/website/d/monthly)](https://packagist.org/packages/devbr/website)


# Install
Open a terminal in root directory of your website and type:

```shell
Composer create-project devbr/website ./ 
```

Require [PHP 7](http://www.php.net/) & [Composer](https://getcomposer.org/download/).


# Commands
Access <b>devbr</b> system commands using "Composer run":

```shell
Composer run -h
```
Displays a list of available commands

## Create a Controller
In a terminal, type:

```shell
Composer run make:controller Blog\Front\Page
```
A new file in the <code>.php/Blog/Front/Page.php</code> path will be created containing the minimum code (based on template).

---

<b>Attention: </b>

To use minification and obfuscation of files with the command "optimize" it is necessary to <a href="https://www.java.com/en/download/">install JAVA</a>.

You need to enable Apache mod_rewrite.

At the terminal, type:

```shell
$ sudo a2enmod rewrite
```
You may also need to add these (minimum) rows in VirtualHost settings:

```shell
<VirtualHost *:80>
  DocumentRoot /var/www/website
  
  <Directory /var/www/website>
    AllowOverride All
  </Directory>
<VirtualHost/>
```



<p align="center"><img src="http://dbrasil.tk/media/db64.png"></p>
