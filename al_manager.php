<?php

/**
 * Description of al_manager
 *
 * @author Studio365
 */
define('AL_DIR', WP_PLUGIN_DIR . '/al-manager');

include_once AL_DIR . '/autoloadManager.php';

class al_manager {

    private static $instance;

    /**
     *
     */
    private function __construct() {
        //$this->autoload();
    }


    /**
     *
     * @return type
     */
    public static function  instance(){
         if (!isset(self::$instance)) {
            self::$instance = new al_manager();
        }
        return self::$instance;

    }

    /**
     * class factory
     * @return \al_manager
     */
    public static function load() {
        return new al_manager;
    }

    /**
     * Sigleton pattern
     */

    /**
     *
     */
    public function autoload() {

        //autoload class
        $autoloadManager = new AutoloadManager();
        $autoloadManager->setSaveFile(AL_DIR . '/autoload.php');

        //folder array
//        $folders = array(
//            AL_DIR.'/library/',
//            AL_DIR.'/includes/',
//            AL_DIR.'/modules/',
//        );

        $folders = array();
        //$folders[] = AL_DIR . '/library/';
        $folders[] = AL_DIR . '/includes/';
        //$folders[] = AL_DIR . '/modules/';



        //add the filter
        if (has_filter('alm_filter')):
            $folders = apply_filters('alm_filter', $folders);
        endif;

        foreach ($folders as $path):
            $autoloadManager->addFolder($path);
        endforeach;
        $autoloadManager->register();
    }

    /**
     * use to add your custom classes please create the custom
     */
    public static function custom_path() {
        add_filter('alm_filter', array('al_manager', 'custom'));
    }


    public function custom($folders) {
        $dir = array(AL_DIR . '/custom/');
                 $folders = array_merge($dir, $folders);
        return $folders;
    }

    public static function add_libraries(){
        add_filter('alm_filter', array('al_manager', 'libraries'));
    }

    public function libraries($folders){
        $dir = array(AL_DIR . '/library/');
        $folders = array_merge($dir, $folders);
        return $folders;
    }

}

