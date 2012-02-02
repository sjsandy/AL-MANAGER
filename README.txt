=== AL-Manager ===
Contributors: shawnsandy.com
Donate link:http://autoloadmanger.shawnandy.com
Tags: autoload, OOP,
Requires at least: 3.0
Tested up to: 3.3
Stable tag: trunk

AutoLoad Manager is a simple PHP,  class / interface auto-load manager for WordPress, built with PHP-Autoload-Manager.

== Description ==

A simple PHP classes / interface auto-load manager for wordpress, built with PHP-Autoload-Manager by http://bashar.alfallouji.com/php-autoload-manager/. AL-Manager allows you to easily extend the power of WordPress using Object Oriented PHP, classes and libraries.

=Developer Info =

The AutoLoad Manager is a generic autoloader that can be used with any PHP framework or library. Using the PHP tokenizer mechanism, it will parse folder(s) and discover the different classes and interfaces defined. The big advantage of using this autoloadManager is that it will allow you to implement whatever naming rules you want and may have mutliple classes in one file (if you want to have a such feature).

So basically, you don’t have anymore to implement some complex naming rules between the filename and the classname. You may organize the way you want your API (may have as many subfolders as you want, you may have multiple API folders, etc.).

 (http://bashar.alfallouji.com/php-autoload-manager/)."





== Installation ==

= Quick Start =

1. Install/Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add class files to the plugin includes/library/modules folder

= Add your custom classes / libraries paths =

`<?php
/**
 * --- AL-Manager -----
 */

//check if ALM is loaded and add filter
if(class_exists('almanager')) add_filter('alm_filter', 'al_paths');

//sample fliter adds 'inc' dir to the autoload paths
function al_paths($folders) {
    $p = array(AL_DIR . '/inc/');
    $folders = array_merge($p, $folders);
    return $folders;
}
 ?>`

== Frequently Asked Questions ==


= What about foo bar? =

Answer to foo bar dilemma.

== Changelog ==

= 0.1 Beta =


== Upgrade Notice ==


= 0.1 =
First release

== Arbitrary section ==

While AL_Manager was designed to be flexible it does come with some presets / conventions that you can use (if you choose) out of the box

Directory structure ;

- /includes : All single file classes are placed here
- /library : Add your classes that come packaged in folders here
- /modules : classes designed to work with in wordpress are place here, and follow a simple naming convention e.g. mod_prefix_name.php

= Classes / Libraries =

Included :

PHPFOUR-Payment : PHP Payment Library for Paypal, Authorize.net and 2Checkout : http://phpfour.com/blog/2009/02/php-payment-gateway-library-for-paypal-authorizenet-and-2checkout/

FACEBOOK-SDK : allows you to access Facebook Platform from your PHP app : https://github.com/facebook/php-sdk

More...

For more classes/ libraries please visit http://autoloadmanger.shawnandy.com

= Submit =

Submit you classes / libraries to http://autoloadmanger.shawnandy.com
