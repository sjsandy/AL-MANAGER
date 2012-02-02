<?php

/**
 * Description of al_manager
 *
 * @author Studio365
 */


define('AL_DIR', WP_PLUGIN_DIR . '/al-manager');

include_once AL_DIR . '/autoloadManager.php';

class al_manager {

    /**
     *
     */
    public function __construct() {
        $this->autoload();
    }

    /**
     * class factory
     * @return \al_manager
     */
    public static function load(){
        return new al_manager;
    }

    /**
     *
     */
    public function autoload(){

        //autoload class
        $autoloadManager = new AutoloadManager();
	$autoloadManager->setSaveFile(AL_DIR . '/autoload.php');

        //folder array
        $folders = array(
            AL_DIR.'/library/',
            AL_DIR.'/includes/',
            AL_DIR.'/modules/',
        );

        //add the filter
        if(has_filter('alm_filter')):
           $folders = apply_filters('alm_filter', $folders);
        endif;

        foreach($folders as $path):
            $autoloadManager->addFolder($path);
        endforeach;
        $autoloadManager->register();
    }

}


