<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JavascriptLoader
 *
 * @author studio
 */


abstract class Basejump_Scripts_Loader{

    private $config = '';
    private $scripts = array();
    private $styles = array();


 private $js_settings = array(),
            $container_name;

    public function set_container_name($class_name) {
        $this->container_name = $class_name;
    }

    public function get_container_name() {
        return $this->container_name;
    }



    public function get_js_settings() {
        return $this->js_settings;
        return $this;
    }




    public function set_js_settings($js_settings = array()) {
        $this->js_settings = $js_settings;
    }



    public function run() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'footer_scripts'));
        add_action('wp_head', array($this, 'head_scripts'));
    }

    public abstract function enqueue_scripts();

    public abstract function footer_scripts();

    public abstract function head_scripts();

}


