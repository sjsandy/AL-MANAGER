<?php

/**
 * Description of Ext_Admin_Menus
 *
 * @author studio
 */

/**
 * Quickly add post edits links to the Adminbar
 * <code>
 * /** Display most recent Post (all Post Types)
  Post_Menus::add()->set_node_id('recent')->set_node_title('Recent Post')->set_post_types(TRUE)->published();
  //** Display published Post
  Post_Menus::add()->set_node_id('menu-published')->set_node_title('Post')->published();
  //** Display published pages
  Post_Menus::add()->set_node_id('menu-pages')->set_node_title('Pages')->published('page');
  //** Display Custom Options pages
  Post_Menus::add()->set_node_id('custom_options')->set_node_title('UI.Options')->published('cwp_custom_options');
 * </code>
 */
class Post_Menus {

    private $items = 10,
            $node_parent,
            $post_status = 'publish',
            $post_type = 'post',
            $post_types = false,
            $node_id = 'menu-node',
            $node_title = 'Menu Title';

    /**
     * Menu ID
     * @param type $node_id
     * @return \Post_Menus
     */
    public function set_node_id($node_id) {
        $this->node_id = $node_id;
        return $this;
    }

    /**
     * Menu Title
     * @param type $node_title
     * @return \Post_Menus
     */
    public function set_node_title($node_title) {
        $this->node_title = $node_title;
        return $this;
    }

    /**
     * Number of items to list
     * @param type $items
     * @return \Post_Menus
     */
    public function set_items($items) {
        $this->items = $items;
        return $this;
    }

    /**
     * Set post status
     * @param type $post_status
     * @return \Post_Menus
     */
    public function set_post_status($post_status) {
        $this->post_status = $post_status;
        return $this;
    }

    /**
     * Set Post Type
     * @param type $post_type
     * @return \Post_Menus
     */
    public function set_post_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    /**
     * Set post
     * @param type $post_types
     * @return \Post_Menus
     */
    public function set_post_types($post_types) {
        $this->post_types = $post_types;
        return $this;
    }

    private static $instance;

    /**
     * Singleton pattern
     * @return type
     */
    public static function instance() {
        if (!is_object(self::$instance)):
            $class = new Post_Menus();
            self::$instance = $class;
        endif;
        return self::$instance;
    }

    /**
     * Factory Pattern
     * @return Post_Menus method (chainable);
     */
    public static function add() {
        $factory = new Post_Menus();
        return $factory;
    }

    private function __construct() {

    }

    /**
     * Display published post
     * @param type $post_type
     * @param type $items
     */
    public function published($post_type = 'post', $items = 10) {

        $this->post_type = $post_type;
        $this->items = $items;
        $this->post_status = 'publish';
        $this->add_nodes($this->node_id, $this->node_title);
    }

    /**
     * Display drafts
     * @param type $post_type
     * @param type $items
     */
    public function drafts($post_type = 'post', $items = 10) {
        $this->post_type = $post_type;
        $this->items = $items;
        $this->post_status = 'drafts';
        $this->add_nodes($this->node_id, $this->node_title);
    }

    /**
     * Display schelude post
     * @param type $post_type
     * @param type $items
     */
    public function scheduled($post_type = 'post', $items = 10) {
        $this->post_type = $post_type;
        $this->items = $items;
        $this->post_status = 'future';
        $this->add_nodes($this->node_id, $this->node_title);
    }

    /**
     * Display pending post
     * @param type $post_type
     * @param type $items
     */
    public function pending($post_type = 'post', $items = 10) {
        $this->post_type = $post_type;
        $this->items = $items;
        $this->post_status = 'pending';
        $this->add_nodes($this->node_id, $this->node_title);
    }

    /**
     *
     * @global type $wpdb
     * @param array $where
     * @return type
     */
    private function data() {

        global $wpdb, $post;
        $qry = "
	SELECT $wpdb->posts.ID, $wpdb->posts.post_title
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = '$this->post_status'
                AND
                $wpdb->posts.post_type = '$this->post_type'
                ORDER BY $wpdb->posts.ID DESC LIMIT $this->items";
        $query = $wpdb->get_results($qry,OBJECT);
        return $query;
    }

    /**
     * get all post
     * @global type $wpdb
     * @param array $where
     * @return type
     */
    private function data_all() {

        global $wpdb, $post;
        $qry = "
	SELECT $wpdb->posts.ID, $wpdb->posts.post_title
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = '$this->post_status'
        ORDER BY $wpdb->posts.ID DESC LIMIT $this->items
                ";
        $query = $wpdb->get_results($qry, OBJECT);
        return $query;
    }

    /**
     *
     * @param type $node_id
     * @param type $node_title
     */
    public function add_nodes($node_id = 'menu-id', $node_title = 'node_title') {
        $this->node_id = $node_id;
        $this->node_title = $node_title;
        add_action('admin_bar_menu', array($this, 'nodes'), 999);
    }

    /**
     * Add the nodes to your menubar
     * //http://codex.wordpress.org/Function_Reference/add_menu
     * @global type $wp_admin_bar
     * @param type $wp_admin_bar
     */
    public function nodes($wp_admin_bar) {

        /*         * * parent node ** */
        $args = array(
            'id' => $this->node_id,
            'title' => $this->node_title,
            'href' => '#',
            'class' => 'ext-menubars-' . $this->node_id,
            'meta' => array(
                'class' => $this->node_id,
                'title' => $this->node_title . ' Menu')
        );
        $wp_admin_bar->add_node($args);


        //** get the post data **//
        if ($this->post_types)
            $data = $this->data_all();
        else
            $data = $this->data();

        /** Check the data and proceed * */
        //if (!$data OR !is_array($data))return false;
        //** loop thorugh the data and create the nodes **//
        foreach ($data as $item):
            if (current_user_can('edit_posts')):
                $args = array(
                    'id' => $this->node_id . '-' . $item->ID,
                    'title' => esc_attr($item->post_title),
                    'href' => esc_url(get_edit_post_link($item->ID)),
                    'parent' => $this->node_id,
                    'meta' => array(
                        'class' => $this->node_id . '-class',
                        'title' => 'Edit ' . esc_attr($item->post_title),
                    )
                );

                $wp_admin_bar->add_node($args);
            endif;
        endforeach;
    }

}
