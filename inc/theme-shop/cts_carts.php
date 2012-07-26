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

    function __construct($post_name = 'cart', $prefix = 'cts') {

        $this->post_type = new Ext_post_type($post_name, $prefix);


        cts_meta_boxes::factory()
                ->set_include_page(plugin_dir_path(__FILE__) . 'includes/add-to-cart.php')
                ->set_id('cts_add_to_cart')
                ->set_piority('high')
                ->set_screen('cts_cart')
                ->set_title('Add To Cart')
                ->metabox();
        add_action('save_post', array($this,'cts_save_cart_items'), 10, 2);
    }

    public static function factory($post_name = 'cart', $prefix = 'cts') {

        $factory = new cts_carts($post_name, $prefix);
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
                ->set_supports(array('title', 'excerpt', 'comments', 'author', 'custom-fields'))
                ->set_label("Cart")
                ->set_menu_icon(plugins_url('images/shipping.png', __FILE__))
                ->register();
        add_action('admin_init', array($this, 'meta_boxes'));
        add_action('add_meta_boxes', array($this, 'change_defaults'), 10);
        return $this;
    }

    public function change_defaults() {
        global $wp_meta_boxes;
        ////        remove_meta_box('authordiv', 'cts_cart', 'normal');
        unset($wp_meta_boxes['cts_cart']['normal']['core']['postexcerpt']);

        add_meta_box('postexcerpt', 'Order Excerpt', 'post_excerpt_meta_box', 'cts_cart', 'normal', 'high');
    }

    public function meta_boxes() {
        $prefix = '_cts_cart_';
        if (!class_exists('RW_Meta_Box'))
            return;
        /**
         * Customer address
         */
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_orders_billing',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Bill To',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'side',
            // Order of meta box: high (default), low; optional
            'piority' => 'high',
            'fields' => array(
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'First Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'first_name',
                    // Field description (optional)
                    'desc' => 'Customer Full Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Last Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'flast_name',
                    // Field description (optional)
                    'desc' => 'Customer Last Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address',
                    // Field description (optional)
                    'desc' => 'Address',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address 2',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address_2',
                    // Field description (optional)
                    'desc' => 'Address 2',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'City',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'city',
                    // Field description (optional)
                    'desc' => 'City',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Postal Code',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'postal_code',
                    // Field description (optional)
                    'desc' => 'Postal Code',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Country',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'country',
                    // Field description (optional)
                    'desc' => 'Country',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // CHECKBOX
                array(
                    'name' => 'Same for Shipping', // File type: checkbox
                    'id' => "{$prefix}same_shipto",
                    'type' => 'checkbox',
                    'desc' => 'Yes use this address for shipping',
                    // Value can be 0 or 1
                    'std' => 0,
                ),
                ));
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_orders_shipto',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Ship To',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'side',
            // Order of meta box: high (default), low; optional
            'piority' => 'low',
            'fields' => array(
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'First Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'first_name',
                    // Field description (optional)
                    'desc' => 'Customer Full Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Last Name',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'flast_name',
                    // Field description (optional)
                    'desc' => 'Customer Last Name',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address',
                    // Field description (optional)
                    'desc' => 'Address',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Address 2',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'address_2',
                    // Field description (optional)
                    'desc' => 'Address 2',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'City',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'city',
                    // Field description (optional)
                    'desc' => 'City',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Postal Code',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'postal_code',
                    // Field description (optional)
                    'desc' => 'Postal Code',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'Country',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'country',
                    // Field description (optional)
                    'desc' => 'Country',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                ));



        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }

    public function cts_save_cart_items($post_id) {



        if (!wp_verify_nonce($_POST['items_nonce_name'], 'items_nonce_action')) :
            update_post_meta($post_id, 'nonce-test', 'not saved', 1);

            return;
        endif;

        update_post_meta($post_id, 'nonce-test', $_POST['name'] , 0);

    }

}

