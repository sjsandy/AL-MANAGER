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


if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
    $config = array(
        'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
        'proper_folder_name' => 'al-manager', // this is the name of the folder your plugin lives in
        'api_url' => 'https://api.github.com/repos/shawnsandy/AL-MANAGER', // the github API url of your github repo
        'raw_url' => 'https://raw.github.com/shawnsandy/AL-MANAGER', // the github raw url of your github repo
        'github_url' => 'https://github.com/shawnsandy/AL-MANAGER', // the github url of your github repo
        'zip_url' => 'https://github.com/shawnsandy/AL-MANAGER/zipball/master', // the zip url of the github repo
        'sslverify' => true, // wether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
        'requires' => '3.3', // which version of WordPress does your plugin require?
        'tested' => '3.3', // which version of WordPress is your plugin tested up to?
    );
    new wp_github_updater($config);
}
