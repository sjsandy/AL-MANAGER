<?php

/*
Plugin Name: AL Manager
Plugin URI: http://craftedandpressed.com
Description: A simple php autoload manager for wordpress, built with PHP-Autoload-Manager http://bashar.alfallouji.com/PHP-Autoload-Manager/. AL-Manager allows you to easily extend the power of WordPress using Object Oriented PHP; classes and libraries.
Author: Shawn Sandy
Author URI: http://shawnsandy.com
Version: 1.0
*/

/*
 * Include al_manager class
 */

include_once WP_PLUGIN_DIR.'/al-manager/al_manager.php' ;

/**
 * instaniate the al_manger class
 */

add_action('init', 'alm_init');

function alm_init(){
    $load_al_manger = al_manager::instance()->autoload();
}