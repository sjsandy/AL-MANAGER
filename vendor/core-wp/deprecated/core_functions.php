<?php

/**
 * Description of ss_tools
 *
 * @author Studio365
 */
class core_functions {

    //put your code here


    function __construct() {

    }

    public static function theme_default() {
        self::favicon();
    }

    public static function getPostViews($postID = Null) {
        global $post;
        if (!isset($postID))
            $postID = $post->ID;
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 View";
        }
        return $count;
    }

    public static function setPostViews($postID = Null) {
        global $post;
        if ($postID == null)
            $postID = $post->ID;
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

    public static function breadcrumbs() {
        /**
         * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
         */
        $delimiter = '&raquo;';
        $home = 'Home'; // text for the 'Home' link
        $before = '<span class="current">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb

        if (!is_home() && !is_front_page() || is_paged()) {

            echo '<div id="crumbs">';

            global $post;
            $homeLink = get_bloginfo('url');
            echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

            if (is_category()) {
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0)
                    echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
                echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
            } elseif (is_day()) {
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
                echo $before . get_the_time('d') . $after;
            } elseif (is_month()) {
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                echo $before . get_the_time('F') . $after;
            } elseif (is_year()) {
                echo $before . get_the_time('Y') . $after;
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                    echo $before . get_the_title() . $after;
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                    echo $before . get_the_title() . $after;
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                echo $before . $post_type->labels->singular_name . $after;
            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } elseif (is_page() && !$post->post_parent) {
                echo $before . get_the_title() . $after;
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb)
                    echo $crumb . ' ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } elseif (is_search()) {
                echo $before . 'Search results for "' . get_search_query() . '"' . $after;
            } elseif (is_tag()) {
                echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo $before . 'Articles posted by ' . $userdata->display_name . $after;
            } elseif (is_404()) {
                echo $before . 'Error 404' . $after;
            }

            if (get_query_var('paged')) {
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo ' (';
                echo __('Page') . ' ' . get_query_var('paged');
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo ')';
            }

            echo '</div>';
        }
    }

    /**
     *
     * @global int $paged
     * @global string $wp_query
     * @param <type> $pages
     * @param <type> $range
     * @link http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
     * @link http://design.sparklette.net/teaches/how-to-add-wordpress-pagination-without-a-plugin/
     */
    public static function pagination($pages = '', $range = 4) {
        $showitems = ($range * 2) + 1;

        global $paged;
        if (empty($paged))
            $paged = 1;

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages) {
            echo "<div class=\"pagination\"><span>Page " . $paged . " of " . $pages . "</span>";
            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
                echo "<a href='" . get_pagenum_link(1) . "'>&laquo; First</a>";
            if ($paged > 1 && $showitems < $pages)
                echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; Previous</a>";

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    echo ($paged == $i) ? "<span class=\"current\">" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class=\"inactive\">" . $i . "</a>";
                }
            }

            if ($paged < $pages && $showitems < $pages)
                echo "<a href=\"" . get_pagenum_link($paged + 1) . "\">Next &rsaquo;</a>";
            if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
                echo "<a href='" . get_pagenum_link($pages) . "'>Last &raquo;</a>";
            echo "</div>\n";
        }
    }

    /**
     *
     * @global int $paged
     * @global string $wp_query
     * @param <type> $pages
     * @param <type> $range
     * @link http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
     * @link http://design.sparklette.net/teaches/how-to-add-wordpress-pagination-without-a-plugin/
     */
    public static function pagination_plus($pages = '', $range = 4) {
        $showitems = ($range * 2) + 1;

        global $paged;
        if (empty($paged))
            $paged = 1;

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages) {
            echo "<ul class=\"pagination\"><li>Page " . $paged . " of " . $pages . "</li>";
            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
                echo "<li><a href='" . get_pagenum_link(1) . "'>&laquo; First</a></li>";
            if ($paged > 1 && $showitems < $pages)
                echo "<li><a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; Previous</a></li>";

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    echo ($paged == $i) ? "<li class=\"current\">" . $i . "</li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"unavailable\">" . $i . "</li></a>";
                }
            }

            if ($paged < $pages && $showitems < $pages)
                echo "<li><a href=\"" . get_pagenum_link($paged + 1) . "\">Next &rsaquo;</a></li>";
            if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
                echo "<li><a href='" . get_pagenum_link($pages) . "'>Last &raquo;</a><li>";
            echo "</ul>\n";
        }
    }

    public function add_theme_favicon() {
        //get_stylesheet_directory_uri();
        $file = CWP_URL . '/images/favicon.ico';
        if (file_exists(get_stylesheet_directory() . '/images/favicon.ico')):
            $file = get_stylesheet_directory_uri() . '/images/favicon.ico';
        elseif (file_exists(get_template_directory() . '/images/favicon.ico')) :
            $file = get_template_directory_uri() . '/images/favicon.ico';
        endif;
        echo '<link rel="shortcut icon" href="' . $file . '" >';
    }

    public static function favicon() {
        add_action('wp_head', array('core_functions', 'add_theme_favicon'));
        add_action('admin_head', array('core_functions', 'add_theme_favicon'));
    }

    public static function time_ago($trail_text='ago') {
        $t = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . $trail_text;
        return $t;
    }

    public static function time_ago_comments() {
        return $t = human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ago';
    }

    public static function tweet($data=null, $name="Tweet") {
        ob_start()
        ?>
        <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>" data-count="vertical" data-via="<?php $data; ?>"> <?php echo $name ?></a>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

    /**
     *
     * @global type $post
     * @param type $length
     * @uses print_excerpt(50);
     */
    public static function print_excerpt($length=100) { // Max excerpt length. Length is set in characters
        global $post;
        $text = $post->post_excerpt;
        if ('' == $text) {
            $text = get_the_content('');
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]>', $text);
        }
        $text = strip_shortcodes($text); // optional, recommended
        $text = strip_tags($text); // use ' $text = strip_tags($text,' <p><a>'); ' if you want to keep some tags</p><p>
        $text = substr($text, 0, $length);
        $excerpt = self::reverse_strrchr($text, '.', 1);
        if ($excerpt) {
            echo apply_filters('the_excerpt', $excerpt);
        } else {
            echo apply_filters('the_excerpt', $text);
        }
    }

    public static function reverse_strrchr($haystack, $needle, $trail) {
        return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
    }

    public static function editor() {

        add_editor_style('post_css');
    }

    function fb_move_admin_bar() {
        echo '
    <style type="text/css">
    body {
    margin-top: -28px;
    padding-bottom: 28px;
    }
    body.admin-bar #wphead {
       padding-top: 0;
    }
    body.admin-bar #footer {
       padding-bottom: 28px;
    }
    #wpadminbar {
        top: auto !important;
        bottom: 0;
    }
    #wpadminbar .quicklinks .menupop ul {
        bottom: 28px;
    }
    </style>';
    }

// on backend area
//add_action( 'admin_head', 'fb_move_admin_bar' );
// on frontend area
    public static function admin_bar_footer() {
        add_action('wp_head', array('core_functions', 'fb_move_admin_bar'));
    }

    public static function hide_bar_admin() {
        add_filter('show_admin_bar', '__return_false');
    }

    /**
     * Add all post format support
     * @param array $array -default : 'aside', 'gallery', 'video', 'link', 'image', 'quote', 'status'
     */
    public static function all_post_formats($array = array('aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat')) {
        add_theme_support('post-formats', $array);
    }

    /**
     *
     * @param string $theme_name
     * @param string $option_value
     */
    public function theme_activation($theme_name=null, $option_value='yes') {
        $theme = $theme_name . '_activated';
        if (get_option($theme) != $option_value) {
            update_option($theme, $option_value);
        }
    }

    /**
     *
     * @param type $theme_name
     */
    public function theme_deactivation($theme_name=null) {
        $theme = $theme_name . '_activated';
        delete_option($theme);
    }

    public static function no_smiley_face() {
        add_action('wp_head', array('core_functions', '_smiley_face'));
    }

    public function _smiley_face() {
        echo '
        <script type="text/css">
            img#wpstats {
                 display: none;
            }
        </script>';
    }

    public static function jquery($url='https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js', $version='1.6.1') {
        if (!is_admin()) {
            // comment out the next two lines to load the local copy of jQuery
            wp_deregister_script('jquery');
            wp_register_script('jquery', $url, false, $version);
            wp_enqueue_script('jquery');
        }
    }

    public static function inuit_css($style='inuit') {
        $path = CM_URL . '/inuit/css/';
        $css = $path . 'inuit.css';
        wp_enqueue_style('inuit', $css);
        $grid = $path . 'grid.inuit.css';
        wp_enqueue_style('grid-inuit', $grid, array('inuit'));
        $dropdown = $path . 'dropdown.inuit.css';
        wp_enqueue_style('dropdown-inuit', $dropdown, array('inuit'));
    }

    public static function extra_contact_info($contactmethods) {
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['facebook'] = 'Facebook';
        $contactmethods['twitter'] = 'Twitter';
        $contactmethods['linkedin'] = 'LinkedIn';
        $contactmethods['flickr'] = 'Flickr';

        return $contactmethods;
    }

    public static function add_contact_info() {
        //http://www.wprecipes.com/how-to-easily-modify-user-contact-info
        //http://thomasgriffinmedia.com/blog/2010/09/how-to-add-custom-user-contact-info-in-wordpress/
        //the_author_meta('facebook', $current_author->ID);
        add_filter('user_contactmethods', array('core_functions', 'extra_contact_info'));
    }



}