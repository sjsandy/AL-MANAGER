<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SEO_Conn
 *
 * @author studio
 */


class CONN_FACEBOOK {


    /**
     * Singleton
     */
    private static $instance;
    private static function instance(){
        $class = __CLASS__ ;
        if(!is_object(self::$instance)):
            self::$instance = $class;
            return self::$instance;
        endif;

    }

    private function __construct() {

    }

}


class CONN_TWITTER {


    /**
     * Singleton
     */
    private static $instance;
    private static function instance(){
        $class = __CLASS__ ;
        if(!is_object(self::$instance)):
            self::$instance = $class;
            return self::$instance;
        endif;

    }

    private function __construct() {

    }

}


class CONN_FLICKR {


    /**
     * Singleton
     */
    private static $instance;
    private static function instance(){
        $class = __CLASS__ ;
        if(!is_object(self::$instance)):
            self::$instance = $class;
            return self::$instance;
        endif;

    }

    private function __construct() {

    }

}


class CONN_GA {


    /**
     * Singleton
     */
    private static $instance;
    private static function instance(){
        $class = __CLASS__ ;
        if(!is_object(self::$instance)):
            self::$instance = $class;
            return self::$instance;
        endif;

    }

    private function __construct() {

    }

}


class CONN_GOOGLE {


    /**
     * Singleton
     */
    private static $instance;
    private static function instance(){
        $class = __CLASS__ ;
        if(!is_object(self::$instance)):
            self::$instance = $class;
            return self::$instance;
        endif;

    }

    private function __construct() {

    }

}

?>
