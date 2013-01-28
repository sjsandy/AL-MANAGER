<?php

/**
 * Description of wp-autoload
 *
 * @author studio
 */
class wp_autoload {

    private $class;

    public function set_class($class) {
        $this->class = $class;
    }


    public function __construct() {

    }

    /**
     *
     * @return \wp_autoload
     */
    static function factory(){
        $factory = new wp_autoload;
        $factory->load();
        return $factory;
    }



    function load(){
        spl_autoload_register(array('wp_autoload','classes'));
        spl_autoload_register(array('wp_autoload','plugin_classes'));
        spl_autoload_register(array('wp_autoload','theme_classes'));
    }

    public function classes($class){
      $path = WP_PLUGIN_DIR . '/al-manager/classes/'.$class;
      $this->get_path($path);
    }


   public  function plugin_classes($class){
      $path = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $class;
      $this->get_path($path);
    }

   public  function theme_classes($class){
        $path = WP_CONTENT_DIR .'/themes/'.$class;
        $this->get_path($path);
    }

   private function get_path($path){
        $path = str_replace('_', DIRECTORY_SEPARATOR, $path).'.php';

        if(is_readable($path))
            require_once $path;
    }

   public static function hello(){
      echo "hello world";
    }

}

if(!class_exists('wp_autoload'))
wp_autoload::factory();
