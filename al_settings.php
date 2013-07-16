<?php


/*
  Plugin Name: WP.Autoload Settings
  Plugin URI: http://autoloadmanager.shawnsandy.com
  Description: Manage WP.Autoload settings, components and modules.
  Author URI: http://shawnsandy.com
  Version: 2.0 Beta
 */


add_action('init', 'settings_admin_init');


function settings_admin_init(){

    include_once dirname(__FILE__).'/autoload_settings.php';

}