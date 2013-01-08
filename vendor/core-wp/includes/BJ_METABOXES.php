<?php

/**
 * Description of BJ_METABOXES
 *
 * @author studio
 */
class BJ_METABOXES {

    private $meta_box = array();

    public function set_meta_box($meta_box) {
        $this->meta_box = $meta_box;
        return $this;
    }

    public function __construct() {

    }

    public static function factory($meta_boxes) {

        $factory = new BJ_METABOXES();
        $factory->set_meta_box($meta_boxes);
        return $factory;
    }


    public function metaboxes(){
        add_action('admin_init', array($this,'register_metaboxes'));
    }

    public function register_metaboxes() {

        //Make sure there's no errors when the plugin is deactivated or during upgrade
        if (!class_exists('RW_Meta_Box') && !is_array($this->meta_box))
            return;


        foreach ($this->meta_box as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }

}
