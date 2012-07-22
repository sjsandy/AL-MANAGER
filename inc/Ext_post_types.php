<?php


/**
 * Description of Ext_post_types
 *
 * @author studio
 */


abstract class Ext_post_types {

 /*
     * post vars
     */

    //Class variables
    private $post_type_name;
    private $publicly_queryable = true;
    private $menu_icon = null;
    private $public = true;
    private $show_ui = true;
    private $show_in_menu = true;
    private $query_var = true;
    private $rewrite = true;
    private $capabilities = null;
    private $capability_type = 'post';
    private $has_archive = true;
    private $hierarchical = false;
    private $menu_postion = 5;
    private $supports = array('title', 'editor', 'author', 'thumbnail');
    private $help_tpl;
    private $exclude_from_search = false;
    private $menu_title;
    private $map_meta_cap = null,
            $label = null,
            $post_formats = array(),
            $show_in_nav_menus = true,
            $taxonomies = array('post_tag', 'category');

    public function set_show_in_nav_menus($show_in_nav_menus) {
        $this->show_in_nav_menus = $show_in_nav_menus;
        return $this;
    }

    public function set_taxonomies($taxonomies) {
        $this->taxonomies = $taxonomies;
        return $this;
    }

    /**
     *
     * @param type $post_formats
     * @return cwp_post_type 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'
     */
    public function set_post_formats($post_formats = array('gallery', 'image')) {
        $this->post_formats = $post_formats;
        return $this;
    }

    public function get_label() {
        return $this->label;
    }

    public function set_label($label) {
        $this->label = $label;
        return $this;
    }

    public function get_map_meta_cap() {
        return $this->map_meta_cap;
    }

    public function set_map_meta_cap($map_meta_cap) {
        $this->map_meta_cap = $map_meta_cap;
        return $this;
    }

    public function get_menu_title() {
        return $this->menu_title;
    }

    public function set_menu_title($menu_title) {
        $this->menu_title = $menu_title;
        return $this;
    }

    public function get_exclude_from_search() {
        return $this->exclude_from_search;
    }

    public function set_exclude_from_search($exclude_from_search) {
        $this->exclude_from_search = $exclude_from_search;
        return $this;
    }

    public function get_post_type_name() {
        return $this->post_type_name;
    }

    public function set_post_type_name($post_type_name) {
        $this->post_type_name = $post_type_name;
        return $this;
    }

    public function get_menu_icon() {
        return $this->menu_icon;
    }

    public function set_menu_icon($menu_icon) {
        $this->menu_icon = $menu_icon;
        return $this;
    }

    public function get_public() {
        return $this->public;
    }

    public function set_public($public) {
        $this->public = $public;
        return $this;
    }

    public function get_show_ui() {
        return $this->show_ui;
    }

    public function set_show_ui($show_ui) {
        $this->show_ui = $show_ui;
        return $this;
    }

    public function get_show_in_menu() {
        return $this->show_in_menu;
    }

    public function set_show_in_menu($show_in_menu) {
        $this->show_in_menu = $show_in_menu;
        return $this;
    }

    public function get_query_var() {
        return $this->query_var;
    }

    public function set_query_var($query_var) {
        $this->query_var = $query_var;
        return $this;
    }

    public function get_rewrite() {
        return $this->rewrite;
    }

    public function set_rewrite($rewrite) {
        $this->rewrite = $rewrite;
        return $this;
    }

    public function get_capability_type() {
        return $this->capability_type;
    }

    public function set_capability_type($capability_type) {
        $this->capability_type = $capability_type;
        return $this;
    }

    public function get_has_archive() {
        return $this->has_archive;
    }

    public function set_has_archive($has_archive) {
        $this->has_archive = $has_archive;
        return $this;
    }

    public function get_hierarchical() {
        return $this->hierarchical;
    }

    /**
     * Whether the post type is hierarchical. Allows Parent to be specified.
     * @param type $hieracrchical false
     */
    public function set_hierarchical($hieracrchical) {
        $this->hierarchical = $hieracrchical;
        return $this;
    }

    public function get_menu_postion() {
        return $this->menu_postion;
    }

    public function set_menu_postion($menu_postion) {
        $this->menu_postion = $menu_postion;
        return $this;
    }

    public function get_supports() {
        return $this->supports;
    }

    /**
     * 'title'
     * 'editor' (content)
     * 'author'
     * 'thumbnail' (featured image, current theme must also support post-thumbnails)
     * 'excerpt'
     * 'trackbacks'
     * 'custom-fields'
     * 'comments' (also will see comment count balloon on edit screen)
     * 'revisions' (will store revisions)
     * 'page-attributes' (menu order, hierarchical must be true to show Parent option)
     * 'post-formats' add post formats, see Post Formats
     * @param type $supports array
     */
    public function set_supports($supports = array()) {
        $this->supports = $supports;
        return $this;
    }

    public function get_publicly_queryable() {
        return $this->publicly_queryable;
    }

    public function set_publicly_queryable($publicly_queryable) {
        $this->publicly_queryable = $publicly_queryable;
        return $this;
    }

    public function get_help_tpl() {
        return $this->help_tpl;
    }

    public function set_help_tpl($help_tpl) {
        $this->help_tpl = $help_tpl;
        return $this;
    }

    /**
     *
     * 'labels' => $labels,
     * 'public' => true,
     * 'publicly_queryable' => true,
     * 'show_ui' => true,
     * 'show_in_menu' => true,
     * 'query_var' => true,
     * 'rewrite' => true,
     * 'capability_type' => 'post',
     * 'has_archive' => true,
     * 'hierarchical' => false,
     * 'menu_position' => null,
     * 'supports' => array('title','editor','author','thumbnail','excerpt','comments')
     * @param type $name post type name
     *
     */
    public function add_post_type($name = 'article') {
        //$this->post_type_name = "cwp_{$name}";
        $this->set_post_type_name($name);
        $this->set_menu_title(ucfirst($name));
        return $this;
    }

    /**
     * register you post type
     */
    public function register() {
        /**
         * custom post type template
         * http://codex.wordpress.org/Function_Reference/register_post_type
         */
        $name = ($this->get_label() ? $this->get_label() : $this->get_menu_title());
        $rewrite = $this->get_rewrite() ? $this->get_rewrite() : $this->get_label();

        $labels = array(
            'name' => _x($name . 's', 'post type general name'),
            'singular_name' => _x($name, 'post type singular name'),
            'add_new' => _x('Add New', $name),
            'add_new_item' => __('Add New ' . $name),
            'edit_item' => __('Edit ' . $name),
            'new_item' => __('New ' . $name),
            'view_item' => __('View ' . $name),
            'search_items' => __('Search ' . $name),
            'not_found' => __('No ' . $name . ' found'),
            'not_found_in_trash' => __('No ' . $name . ' found in Trash'),
            'parent_item_colon' => '',
            'menu_name' => $this->get_menu_title()
        );

        $args = array(
            'labels' => $labels,
            'public' => $this->get_public(),
            'publicly_queryable' => $this->publicly_queryable,
            'show_ui' => $this->get_show_ui(),
            'show_in_menu' => $this->get_show_in_menu(),
            'query_var' => $this->query_var,
            'rewrite' => $this->get_rewrite(),
            'capability_type' => $this->get_capability_type(),
            'has_archive' => $this->get_has_archive(),
            'hierarchical' => $this->get_hierarchical(),
            'menu_position' => $this->get_menu_postion(),
            'show_in_menu' => $this->get_show_in_menu(),
            'menu_icon' => $this->get_menu_icon(),
            'show_in_nave_menus' => $this->show_in_nav_menus,
            'supports' => $this->get_supports(),
            'taxonomies' => $this->taxonomies,
            'meta_cap' => $this->map_meta_cap
                //'title','editor','author','thumbnail','excerpt','comments',trackbacks,custom-fields,post-formats,revisions,page-attributes
        );
        //>>>>> change post type from Article
        register_post_type('cwp_' . $this->get_post_type_name(), $args);

        add_filter('post_updated_messages', array(&$this, 'updated_messages'));
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
        $this->tags();
        $this->categories();
    }

    /**
     * *************************POST FORMATS***********************************
     *
     */

    /**
     * sets custom post type and this post formats
     * @param type $formats - 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'
     */
    public function post_formats() {
        if (!empty($this->post_formats) AND is_array($this->post_formats)):
            $screen = get_current_screen();
            if ($screen->post_type == 'cwp_' . $this->get_post_type_name()):
                //remove_post_type_support( 'post', 'post-formats' );
                add_theme_support('post-formats', $this->post_formats);
            endif;
        endif;
        return $this;
    }

    /**
     * ************************MESSAGE*****************************************
     */

    /**
     * Add postype update message filter
     */
    public function update_message_filter() {
        add_filter('post_updated_messages', array(&$this, 'updated_messages'));
    }

//add filter to ensure the text Article, or Article, is displayed when user updates a Article
//add_filter('post_updated_messages', 'codex_Article_updated_messages');
    public function updated_messages($messages) {
        global $post, $post_ID;

        //************** change name here*********************
        $name = ($this->get_label() ? $this->get_label() : $this->get_menu_title());
        $messages['cwp_' . $this->get_post_type_name()] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf(__($name . ' updated. <a href="%s">View Article</a>'), esc_url(get_permalink($post_ID))),
            2 => __($name . 'updated.'),
            3 => __($name . 'deleted.'),
            4 => __($name . ' updated.'),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf(__($name . ' restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__($name . ' published. <a href="%s">View Article</a>'), esc_url(get_permalink($post_ID))),
            7 => __($name . ' saved.'),
            8 => sprintf(__($name . ' submitted. <a target="_blank" href="%s">Preview Article</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__($name . ' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Article</a>'),
                    // translators: Publish box date format, see http://php.net/date
                    date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__($name . ' draft updated. <a target="_blank" href="%s">Preview Article</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );

        return $messages;
    }

    /**
     * ******************************HELP**************************************
     */
    //display contextual help for Articles
    //remove comments on contextual_hel action (//) to use
    //

    public function help_text_filter() {
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
    }

    public abstract function help_text();
    public abstract function categories();
    public abstract function tags();


}