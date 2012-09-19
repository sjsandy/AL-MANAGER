<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * include phpbuglost
 */
include_once CWP_PATH.'/includes/phpBugLost.0.2.php';

class cwp_debug {
    //put your code here

    function __construct() {

    }

    public static function factory(){
        return new cwp_debug;
    }

    public function debug(){
         add_action('wp_footer', array($this,'debug_footer'));
    }

    public function debug_footer(){
        return bl_debug(get_defined_vars());
    }


}

?>
