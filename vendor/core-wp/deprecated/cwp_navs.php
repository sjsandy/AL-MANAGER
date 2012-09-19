<?php

/**
 *
 *
 * 'container' =>false,
  'menu_class' => 'nav',
  'echo' => true,
  'before' => '',
  'after' => '',
  'fallbck_cb => '',
  'link_before' => '',
  'link_after' => '',
  'depth' => 0,
  'walker' => new description_walker());
 * give access to all the theme walker classes
 */
class cwp_navs {

    private $menu,
            $theme_location = 'primary',
            $fallback_cb = array('cwp_navs','default_menu'),
            $depth = 0,
            $link_before = '',
            $link_after = '',
            $before = '',
            $after = '',
            $echo = true,
            $container = false,
            $container_class = '',
            $menu_class = '',
            $walker,
            $items = "",
            $menu_name = "",
            $menu_array = array();

    public function set_menu($menu) {
        $this->menu = $menu;
        return $this;
    }

    public function set_theme_location($theme_location) {
        $this->theme_location = $theme_location;
        return $this;
    }

    public function set_fallback_cb($fallback_cb) {
        $this->fallback_cb = array($this, 'default_menu');
        return $this;
    }

    public function set_depth($depth) {
        $this->depth = $depth;
        return $this;
    }

    public function set_link_before($link_before) {
        $this->link_before = $link_before;
        return $this;
    }

    public function set_link_after($link_after) {
        $this->link_after = $link_after;
        return $this;
    }

    public function set_before($before) {
        $this->before = $before;
        return $this;
    }

    public function set_after($after) {
        $this->after = $after;
        return $this;
    }

    public function set_echo($echo) {
        $this->echo = $echo;
        return $this;
    }

    public function set_container($container) {
        $this->container = $container;
        return $this;
    }

    public function set_menu_class($menu_class) {
        $this->menu_class = $menu_class;
        return $this;
    }

    public function set_menu_array($menu_array) {
        $this->menu_array = $menu_array;
        return $this;
    }

    function __construct() {

    }

    /**
     * Add the wp_navs to themes
     * <code>
     * //set menu depth and the menu location to primary
     * <?php $p_nav = cwp_navs::factory()->set_depth(1)->menu('primary'); ?>
     * <?php cwp_navs::factory()->menu('browse'); ?>
     * </code>
     */
    public static function factory() {
        return new cwp_navs();
    }

    /**
     * <code>
     * cwp_navs::factory()->set_depth(0)->tbs_menu('primary');
     * </code>
     * @param type $theme_location
     * @return \cwp_navs
     */
    public function menu($theme_location = 'primary') {
        $this->theme_location = $theme_location;

        wp_nav_menu(array(
            'theme_location' => $this->theme_location,
            'fallback_cb' => $this->fallback_cb,
            'container' => $this->container,
            'container_class' => $this->container_class,
            'menu_class' => $this->menu_class,
            'echo' => $this->echo,
            'before' => $this->before,
            'after' => $this->after,
            'link_before' => $this->link_before,
            'link_after' => $this->link_after,
            'depth' => $this->depth,
            'walker' => $this->walker
        ));
        return $this;
    }


    /**
     * <code>
     * cwp_navs::factory()->set_depth(0)->tbs_menu('primary');
     * </code>
     * @param type $theme_location
     * @return \cwp_navs
     */
    public function tbs_menu($theme_location = 'primary') {
        $this->theme_location = $theme_location;
        $this->menu_class = 'nav';

        wp_nav_menu(array(
            'theme_location' => $this->theme_location,
            'fallback_cb' => $this->fallback_cb,
            'container' => $this->container,
            'container_class' => $this->container_class,
            'menu_class' => 'nav',
            'echo' => $this->echo,
            'before' => $this->before,
            'after' => $this->after,
            'link_before' => $this->link_before,
            'link_after' => $this->link_after,
            'depth' => $this->depth,
            'walker' => $this->walker
        ));
        return $this;
    }



    public function menu_description($location) {

        //$this->theme_location = $location;
        //$this->theme_location = $location;
        $this->walker = new nav_descriptions();
        return $this->menu($location);
    }

    public function default_menu() {
        ?>

        <ul class="nav">
            <li>
                <a href="<?php echo home_url() ?>" >Home</a>
            </li>
            <?php wp_list_categories('title_li=&depth=1number=5'); ?>
        </ul>
        <?php
    }

    /**
     * ************custom menu items ********************************************
     */
    public function add_item($items, $args, $location = 'primary', $content = "Items") {
        if ($args->theme_location == $location):
            $items .= '<li>' . $content . '</li>';
        endif;
    }

    /**
     * <code>
     * add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );
      function your_custom_menu_item ( $items, $args ) {
      $items = cwp_navs::factory()->add_drop_down($items, $args,'browse',"Another Dropwdown");
      return $items;
      }
     * </code>
     * @param type $items
     * @param type $args
     * @param type $location
     * @param type $name
     * @param type $content
     * @param type $class
     * @return string
     */
    public function add_drop_down($items, $args, $location, $name = "Drop Down", $content = 'Some Content', $class = 'ui box medium') {
        if ($args->theme_location == $location):
            $items .="<li><a href=\"#\">{$name}</a>";
            $items .="<ul><li><div class=\"{$class}\">{$content}</div></li></ul>";
            $items .="</li>";
        endif;
        return $items;
    }

    /**
     * <code>
     * add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
      function add_loginout_link( $items, $args ) {
      $items = cwp_navs::factory()->add_loginout($items,$args,'primary');
      return $items;
      }
     * </code>
     * @param type $items
     * @param type $args
     * @param type $location
     * @return string
     */
    public function add_loginout($items, $args, $location) {
        if (is_user_logged_in() && $args->theme_location == $location) {
            $items .= '<li><a href="' . wp_logout_url() . '">' . __('Log Out', 'corewp') . '</a></li>';
        } elseif (!is_user_logged_in() && $args->theme_location == $this->theme_location) {
            $items .= '<li><a href="' . site_url('wp-login.php') . '">' . __('Log In', 'corewp') . '</a></li>';
        }
        return $items;
    }

    /**
     *
     * @param type $items
     * @param type $args
     * @param type $location
     * @return type
     */
    public function add_search_box($items, $args, $location) {
        if ($args->theme_location == $location)
            return $items . "<li class='menu-header-search'><form action='http://example.com/' id='searchform' method='get'><input type='text' name='s' id='s' placeholder='" . __('Search', 'corewp') . "></form></li>";
        return $items;
    }

}

/**
 * Adds a category desctiption below level 1 category titles
 *
 * @author Studio365
 */
class nav_descriptions extends Walker_Nav_Menu {
    // http://wordpress.stackexchange.com/questions/14037/menu-items-description/14039#14039

    /**
     * Start the element output.
     *
     * @param  string $output Passed by reference. Used to append additional content.
     * @param  object $item   Menu item data object.
     * @param  int $depth     Depth of menu item. May be used for padding.
     * @param  array $args    Additional strings.
     * @return void
     */
    function start_el(&$output, $item, $depth, $args) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $class_names = join(
                ' '
                , apply_filters(
                        'nav_menu_css_class'
                        , array_filter($classes), $item
                )
        );

        !empty($class_names)
                and $class_names = ' class="' . esc_attr($class_names) . '"';

        $output .= "<li id='menu-item-$item->ID' $class_names>";

        $attributes = '';

        !empty($item->attr_title)
                and $attributes .= ' title="' . esc_attr($item->attr_title) . '"';
        !empty($item->target)
                and $attributes .= ' target="' . esc_attr($item->target) . '"';
        !empty($item->xfn)
                and $attributes .= ' rel="' . esc_attr($item->xfn) . '"';
        !empty($item->url)
                and $attributes .= ' href="' . esc_attr($item->url) . '"';

        // insert description for top level elements only
        // you may change this
        $description = (!empty($item->description) and 0 == $depth ) ? '<small class="nav_desc">' . esc_attr($item->description) . '</small>' : '';

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output = $args->before
                . "<a $attributes>"
                . $args->link_before
                . $title
                . '</a> '
                . $args->link_after
                . $description
                . $args->after;

        // Since $output is called by reference we don't need to return anything.
        $output .= apply_filters(
                'walker_nav_menu_start_el'
                , $item_output
                , $item
                , $depth
                , $args
        );
    }

}
