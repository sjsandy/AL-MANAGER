<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cts_carts
 *
 * @author studio
 */

class cts_carts {

    private $post_type;

    function __construct($post_name='cart',$prefix = 'cts') {

        $this->post_type = new Ext_post_type($post_name, $prefix);


        cts_meta_box::factory()
                ->set_include_page(plugin_dir_path(__FILE__) . 'includes/add-to-cart.php')
                ->set_id('cts_add_to_cart')
                ->set_piority('high')
                ->set_screen('cts_cart')
                ->set_title('Add To Cart')
                ->metabox();
    }

    public static function factory($post_name='cart',$prefix = 'cts') {
        $factory = new cts_carts($post_name,$prefix);
        return $factory;
    }

    public function add_cart() {

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('page')
                ->set_show_in_menu('customshop')
                ->set_public(false)
                ->set_show_ui(true)
                ->set_show_in_nav_menus(false)
                ->set_menu_title("Manage Carts")
                ->set_rewrite(array('slug' => 'carts'))
                ->set_supports(array('title', 'excerpt', 'comments', 'author'))
                ->set_label("Cart")
                ->set_menu_icon(plugins_url('images/shipping.png', __FILE__))
                ->register();
        add_action('admin_init', array($this, 'meta_boxes'));
        return $this;
    }

    public function meta_boxes() {
        $prefix = 'cts';
        if (!class_exists('RW_Meta_Box'))
            return;
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_cart',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Ship To',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'side',
            // Order of meta box: high (default), low; optional
            'piority' => 'high',
            'fields' => array(
                // SELECT BOX
                array(
                    'name' => 'Where do you live?',
                    'id' => "{$prefix}place",
                    'type' => 'select',
                    // Array of 'key' => 'value' pairs for select box
                    'options' => array(
                        'usa' => 'USA',
                        'vn' => 'Vietnam',
                    ),
                    // Select multiple values, optional. Default is false.
                    'multiple' => true,
                    // Default value, can be string (single value) or array (for both single and multiple values)
                    'std' => array('vn'),
                    'desc' => 'Select the current place, not in the past',
                ),
                ));

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }

}
