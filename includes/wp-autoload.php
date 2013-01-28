<?php

/**
 * Description of wp-autoload
 *
 * @author studio
 */
class wp_autoload {

    protected $class,
            $paths,
            $lowercase = false;

    public function set_paths($paths) {
        $this->paths = $paths;
        return $this;
    }

    public function set_lowercase($lowercase) {
        $this->lowercase = $lowercase;
        return $this;
    }



    public function set_class($class) {
        $this->class = $class;
        return $this;
    }

    public function __construct() {

    }

    /**
     *
     * @return \wp_autoload
     */
    static function factory() {

        $factory = new wp_autoload();
        //$factory->load();
        return $factory;

    }

    function load() {
        $paths[] = WP_PLUGIN_DIR . '/al-manager/classes/';
        $paths[] = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR ;
        $paths[] = WP_CONTENT_DIR . '/themes/';
        $this->paths = $paths;
        $this->register();
//
//        spl_autoload_register(array($this, 'classes'));
//        spl_autoload_register(array($this, 'classes_lowercase'));
//        spl_autoload_register(array($this, 'plugin_classes'));
//        spl_autoload_register(array($this, 'theme_classes'));
    }

    public function register(){
        spl_autoload_register(array($this,'autoload'));
    }

    public function autoload($class) {
        $classname = $class.'.php';
        foreach ($this->paths as $path) {
            $_class = $path . $classname;
            $this->get_path($_class, $this->lowercase);
        }

    }

    public function classes($class) {
        $path = WP_PLUGIN_DIR . '/al-manager/classes/' . $class;
        $this->get_path($path);
    }

    public function classes_lowercase($class) {
        $path = WP_PLUGIN_DIR . '/al-manager/classes/' . $class;
        $this->get_path($path, TRUE);
    }

    public function plugin_classes($class) {
        $path = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $class;
        $this->get_path($path);
    }

    public function theme_classes($class) {
        $path = WP_CONTENT_DIR . '/themes/' . $class;
        $this->get_path($path);
    }

    private function get_path($path, $lowercase = false) {
        $path = str_replace('_', DIRECTORY_SEPARATOR, $path);

        if ($lowercase === TRUE)
            $path = strtolower($path);
        if (is_readable($path))
            require_once $path;
    }

    public static function hello() {
        echo "hello world";
    }

}


    wp_autoload::factory()->load();
