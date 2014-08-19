<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

if (PHP_VERSION < 5.3) {
	die('Sorry WP.Symfony.AutoLoader requires PHP 5.3 or greater');
}

include_once dirname(__FILE__).'/symfony/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$wp_symfony_loader = new UniversalClassLoader;

$wp_symfony_loader->registerNamespace('Symfony', __DIR__ .'/src');

//$wp_symfony_loader->registerNamespace('Plugins', PLUGINDIR );
//$wp_symfony_loader->registerNamespaces(array(
//  'Themes', __DIR__ .'/../../themes',
//  'Plugins', __DIR__.'/../src',
//));

//$wp_symfony_loader->register();

class SymphonyAutoLoader {

	private static $instance = null;

	function __construct() {

	}

	public static function instance() {

		if (self::$instance == NULL) {
			self::$instance = new UniversalClassLoader;
		}

		return self::$instance;

	}

}
