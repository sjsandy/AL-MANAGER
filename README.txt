=== AL-Manager ===
Contributors: shawnsandy.com
Donate link:http://ifitiscreative.com
Tags: autoload, OOP,
Requires at least: 3.0
Tested up to: 3.3
Stable tag: trunk

AutoLoad Manager is a simple PHP  class / interface auto-load manager for WordPress, built with PHP-Autoload-Manager

== Description ==

A simple PHP classes / interface auto-load manager for wordpress, built with PHP-Autoload-Manager by http://bashar.alfallouji.com/php-autoload-manager/

AutoLoad Manager is a generic autoloader that can be used with any PHP framework or library. Using the PHP tokenizer mechanism, it will parse folder(s) and discover the different classes and interfaces defined. The big advantage of using this autoloadManager is that it will allow you to implement whatever naming rules you want and may have mutliple classes in one file (if you want to have a such feature).

 

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.
== Frequently Asked Questions ==

Please see http://ifitiscreative.com

== Screenshots ==
1. Screenshot

== Changelog ==
Changes

== Upgrade Notice ==

= 0.1 =
Beta version

== Arbitrary section ==

USAGE
`<php
/**
 * autoload filter
 */
add_filter('alm_filter', 'al_paths');

function al_paths($folders) {
    $p = array(AL_DIR . '/inc/');
    $folders = array_merge($p, $folders);
    return $folders;
}
?>`