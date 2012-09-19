<?php

/**
 * Description of cwp_menu
 * TODO Add doc
 * @author Studio365
 *
 */


/*
 * @todo deprecate to use cwp_navs instead
 */
class cwp_menu {

    //put your code here

            private $theme_location = 'primary',
            $item = "",
            $menu_name = "";

    public function set_theme_location($theme_location) {
        $this->theme_location = $theme_location;
        return $this;
    }

    public function set_item($item) {
        $this->item = $item;
        return $this;
    }

    public function set_menu_name($menu_name) {
        $this->menu_name = $menu_name;
        return $this;
    }


    public function __construct() {

    }

    public static function factory($object) {
        $object = new cwp_menu();
        return $object;
    }

    public function add_item($item = "Menu Item", $location = 'primary') {
        $this->theme_location = $location;
        $this->item = $item;
        add_filter('wp_nav_menu_items', array($this, 'item'), 10, 2);
    }

    public function item($items, $args) {
        if ($args->theme_location == $this->theme_location):
            $items .= '<li>' . $this->item . '</li>';
        endif;
        return $items;
    }

    public function add_drop_down($location = 'primary',$item = "Some random stuff goes here", $menu_name = 'Drop-Down' ) {
        $this->theme_location = $location;
        $this->item = $item;
        $this->menu_name = $menu_name;
        add_filter('wp_nav_menu_items', array($this, 'drop_down'), 10, 2);
    }

    public function drop_down($items, $args) {
        if ($args->theme_location == $this->theme_location):
            $items .="<li><a href=\"#\">{$this->menu_name}</a>";
            $items .="<ul><li>{$this->item}</li></ul>";
            $items .="</li>";
            return $items;
        endif;
    }

    public function add_login($location = 'primary') {
        $this->theme_location = $location;
        add_filter('wp_nav_menu_items', array($this, 'add_loginout'), 10, 2);
    }

    //
    public function add_loginout($items, $args) {
        if (is_user_logged_in() && $args->theme_location == $this->theme_location) {
            $items .= '<li><a href="' . wp_logout_url() . '">' . __('Log Out', 'corewp') . '</a></li>';
        } elseif (!is_user_logged_in() && $args->theme_location == $this->theme_location) {
            $items .= '<li><a href="' . site_url('wp-login.php') . '">' . __('Log In', 'corewp') . '</a></li>';
        }
        return $items;
    }

    public function add_search($location = 'primary') {
        $this->theme_location = $location;
        add_filter('wp_nav_menu_items', array($this, 'search_box'), 10, 2);
    }

    public function search_box($items, $args) {
        if ($args->theme_location == $this->theme_location)
            return $items . "<li class='menu-header-search'><form action='http://example.com/' id='searchform' method='get'><input type='text' name='s' id='s' placeholder='" . __('Search', 'corewp') . "></form></li>";
        return $items;
    }

}

?>
