<?php

/**
 * Description of theme_shop
 *
 * @author studio
 */
class custom_theme_shop {

    public function __construct() {

        add_action('admin_menu', array($this, 'admin_init'));
    }

    public static function factory() {
        $factory = new custom_theme_shop();
        return $factory;
    }

    public function admin_init() {
        add_menu_page('CTS_Shop', 'ThemeShop', 'manage_options', 'customshop', array($this, 'shop_menu'), plugins_url('images/suppliers.png', __FILE__), '10.5');

        add_submenu_page('customshop', 'Settings', 'Manage Settings', 'manage_options', 'cts_settings', array($this, 'cts_settings'));

        //create an post_type array(post_type, menu_title);
        $post_types = array('cts_products' => 'Products', 'cts_orders' => "Orders");

        //load and run the class
        $apmmenus = AdminbarPostMenus::add_menus()->set_list_count(10)->set_post_types($post_types)->nodes();
    }

    public function shop_menu() {
        echo 'Shop Menu';
    }

    public function cts_settings() {
        echo "<div class='wrap'><h2>Manage Settings</h2></div>";
    }

}

class cts_products {

    private $post_type;

    function __construct() {
        $this->post_type = new Ext_post_type('products', 'cts');
    }

    public static function factory() {
        $factory = new cts_products();
        return $factory;
    }

    public function add_post_type() {

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('page')
                ->set_menu_postion(11)
                ->set_public(true)
                ->set_menu_title("Products")
                ->set_hierarchical(true)
                ->set_rewrite(array('slug' => 'products'))
                ->set_supports(array('title', 'thumbnail', 'editor', 'comments', 'post-formats', 'page-attributes', 'author'))
                ->set_label("Product")
                ->set_menu_icon(plugins_url('images/product-design.png', __FILE__))
                ->register();


        add_action('load-post.php', array($this, 'formats'));
        add_action('load-post-new.php', array($this, 'formats'));
        $this->categories('products');
        $this->tags('products');
        return $this;
    }

    /**
     * ******************************post formats*******************************
     */
    public function formats($post_formats = array('video', 'image', 'aside')) {
        $this->post_type->set_post_formats($post_formats = array('video', 'image'));
        $this->post_type->post_formats();
    }

    /**
     * ********************************TAXONOMY*********************************
     */
    public function categories($name) {
        $cat = new Ext_taxonomies($name . '_category', ucfirst($name) . ' Categories');
        $cat->set_post_types($this->post_type->get_post_type_name());
        $cat->register();
    }

    public function tags($name) {
        $tags = new Ext_taxonomies($name . '_tag', ucfirst($name) . ' Tags');
        $tags->set_post_types($this->post_type->get_post_type_name());
        $tags->tags();
    }

    /**
     * ********************************METABOXES*********************************
     */
    public function product_details() {


        add_action('admin_init', array($this, '_product_details'));
    }




    public function _product_details() {

        $prefix = '_cts_';


        if (!class_exists('RW_Meta_Box'))
            return;

        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'custom_options',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Product Details',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'normal',
            // Order of meta box: high (default), low; optional
            'piority' => 'high',
            'fields' => array(
                // TEXTAREA
                array(
                    'name' => 'Product Slug/Copy',
                    'desc' => '<strong>A short description of your for the cover/ads/cart and messages</strong>',
                    'id' => "{$prefix}products_detail",
                    'type' => 'textarea',
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Feature List',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'feature_list',
                    // Field description (optional)
                    'desc' => 'Featue List (Format: First Last)',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => 'Anh Tran',
                ),
                array(
                    // Field name - Will be used as label
                    'name' => 'SKU',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'sku',
                    // Field description (optional)
                    'desc' => 'Product SKU',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Product Price',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'product_price',
                    // Field description (optional)
                    'desc' => 'Set your standard product price',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Sale Price',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'sale_price',
                    // Field description (optional)
                    'desc' => 'Set your sale price',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Shipping Weight',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'shipping_weight',
                    // Field description (optional)
                    'desc' => 'Add product shipping weight',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                // RADIO BUTTONS
                array(
                    'name' => 'Stock quantity',
                    'id' => "{$prefix}stock_quantity",
                    'type' => 'radio',
                    // Array of 'key' => 'value' pairs for radio options.
                    // Note: the 'key' is stored in meta field, not the 'value'
                    'options' => array(
                        'available' => 'In Stock',
                        'low' => 'Low',
                        'out' => 'Out of Stock',
                    ),
                    'std' => 'available',
                    'desc' => 'Enter your stock quantity',
                ),
                // PLUPLOAD IMAGE UPLOAD (WP 3.3+)
                array(
                    'name' => 'Product Images',
                    'desc' => 'Add images of your products (10 max)',
                    'id' => "{$prefix}product_images",
                    'type' => 'plupload_image',
                    'max_file_uploads' => 10,
                ),
            )
        );

        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
        return $this;
    }

}

class cts_orders {

    private $post_type;

    function __construct() {

    }

    public static function factory() {
        $factory = new cts_orders();
        return $factory;
    }

    public function add_orders() {

        $this->post_type = new Ext_post_type('orders', 'cts');

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('page')
                ->set_show_in_menu('customshop')
                ->set_public(false)
                ->set_show_ui(true)
                ->set_show_in_nav_menus(false)
                ->set_menu_title("Manage Orders")
                ->set_rewrite(array('slug' => 'order'))
                ->set_supports(array('title', 'comments'))
                ->set_label("Order")
                ->set_menu_icon(plugins_url('images/product-design.png', __FILE__))
                ->register();
        return $this;
    }

    public function order_info() {
         //add_action('add_meta_boxes',array($this,'order_items'));
         add_action('save_post',array($this,'save_post'));
         add_action('admin_init', array($this, '_order_info'));
    }



    public function order_items(){
        add_meta_box('cts_order_items', "Order Items", array($this,'order_items_metabox'), $this->post_type->get_post_type_name(),'normal','high');
    }


    public function order_items_metabox() {

        ob_start();
        wp_nonce_field(plugin_basename(__FILE__), 'cts_orders_nonce');
        ?>
                <h2>Items / Products Ordered</h2>
                <p>Description</p>
                <h2>Add items/products</h2>
                <div>
                    <select name="cts_order_item">
                                <option>Test</option>
                                <option>test 2</option>
                                <option>test 3</option>
                            </select>
                </div>

        <?php
        echo ob_get_clean();
    }



    public function save_post($post_id) {
        if(defined('DOING_AUTOSAVE') AND DOING_AUTOSAVE) return;

    }

    public function _order_info() {


        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = '_cts_orders_';
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box
            'id' => 'cts_orders_meta',
            // Meta box title - Will appear at the drag and drop handle bar
            'title' => 'Orders Info',
            // Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
            'pages' => array($this->post_type->get_post_type_name()),
            // Where the meta box appear: normal (default), advanced, side; optional
            'context' => 'normal',
            // Order of meta box: high (default), low; optional
            'piority' => 'high',
            'fields' => array(
                // TEXTAREA
                array(
                    'name' => 'Order Summary',
                    'desc' => "Orders summary and details",
                    'id' => "{$prefix}summary",
                    'type' => 'textarea',
                    'std' => "",
                    'cols' => '40',
                    'rows' => '20',
                ),
                // SELECT BOX
                array(
                    'name' => 'Order Status',
                    'id' => "{$prefix}status",
                    'type' => 'select',
                    // Array of 'key' => 'value' pairs for select box
                    'options' => array(
                        'processing' => 'In Processing',
                        'deleyed' => 'Delayed',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled'
                    ),
                    // Select multiple values, optional. Default is false.
                    'multiple' => false,
                    // Default value, can be string (single value) or array (for both single and multiple values)
                    'std' => array('processing'),
                    'desc' => 'Select the order status.',
                ),
                // TEXT
                array(
                    // Field name - Will be used as label
                    'name' => 'Customer',
                    // Field ID, i.e. the meta key
                    'id' => $prefix . 'customer',
                    // Field description (optional)
                    'desc' => 'Customer',
                    // CLONES: Add to make the field cloneable (i.e. have multiple value)
                    //'clone' => true,
                    'type' => 'text',
                    // Default value (optional)
                    'std' => '',
                ),
                ));
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
                ));



        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }

}

class cts_shipping {

    function __construct() {

    }

    public static function factory() {
        $factory = new cts_shipping();
        return $factory;
    }

    public function add_shipping() {

        $this->post_type = new Ext_post_type('Shipping', 'cts');

        $this->post_type->set_publicly_queryable(true)
                ->set_capability_type('post')
                ->set_show_in_menu('customshop')
                ->set_public(false)
                ->set_show_ui(true)
                ->set_show_in_nav_menus(false)
                ->set_menu_title("Manage Shipping")
                ->set_rewrite(array('slug' => 'order'))
                ->set_supports(array('title', 'excerpt', 'comments'))
                ->set_label("Shipping")
                ->set_menu_icon(plugins_url('images/shipping.png', __FILE__))
                ->register();

        return $this;
    }

}
