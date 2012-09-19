<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of core_tpl
 *
 * @author Studio365
 */
class core_tpl {

    public $slug = null;

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function __construct($slug=null) {
        $this->setSlug($slug);
    }

    /**
     * Retrieve path to a template
     *
     * Used to quickly retrieve the path of a template without including the file
     * extension. It will also check the parent theme, if the file exists, with
     * the use of {@link locate_template()}. Allows for more generic template location
     * without the use of the other get_*_template() functions.
     *
     * @since 1.5.0
     *
     * @param string $type Filename without extension.
     * @param array $templates An optional list of template candidates
     * @return string Full path to file.
     */

    /**
     * Retrieve path of index template in current or parent template.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function get_index_template() {
        return $this->get_query_template('index');
    }

    /**
     * Retrieve path of 404 template in current or parent template.
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_404_template() {
        return $this->get_query_template('404');
    }

    /**
     * Retrieve path of archive template in current or parent template.
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_archive_template() {
        $post_type = get_query_var('post_type');

        $templates = array();

        if ($post_type)
            $templates[] = "archive-{$post_type}.php";
        $templates[] = 'archive.php';

        return $this->get_query_template('archive', $templates);
    }

    /**
     * Retrieve path of author template in current or parent template.
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_author_template() {
        $author = get_queried_object();

        $templates = array();

        $templates[] = "author-{$author->user_nicename}.php";
        $templates[] = "author-{$author->ID}.php";
        $templates[] = 'author.php';

        return $this->get_query_template('author', $templates);
    }

    /**
     * Retrieve path of category template in current or parent template.
     *
     * Works by first retrieving the current slug for example 'category-default.php' and then
     * trying category ID, for example 'category-1.php' and will finally fallback to category.php
     * template, if those files don't exist.
     *
     * @since 1.5.0
     * @uses apply_filters() Calls 'category_template' on file path of category template.
     *
     * @return string
     */
    public function get_category_template() {
        $category = get_queried_object();

        $templates = array();

        $templates[] = "category-{$category->slug}.php";
        $templates[] = "category-{$category->term_id}.php";
        $templates[] = 'category.php';

        return $this->get_query_template('category', $templates);
    }

    /**
     * Retrieve path of tag template in current or parent template.
     *
     * Works by first retrieving the current tag name, for example 'tag-wordpress.php' and then
     * trying tag ID, for example 'tag-1.php' and will finally fallback to tag.php
     * template, if those files don't exist.
     *
     * @since 2.3.0
     * @uses apply_filters() Calls 'tag_template' on file path of tag template.
     *
     * @return string
     */
    public function get_tag_template() {
        $tag = self::get_queried_object();

        $templates = array();

        $templates[] = "tag-{$tag->slug}.php";
        $templates[] = "tag-{$tag->term_id}.php";
        $templates[] = 'tag.php';

        return $this->get_query_template('tag', $templates);
    }

    /**
     * Retrieve path of taxonomy template in current or parent template.
     *
     * Retrieves the taxonomy and term, if term is available. The template is
     * prepended with 'taxonomy-' and followed by both the taxonomy string and
     * the taxonomy string followed by a dash and then followed by the term.
     *
     * The taxonomy and term template is checked and used first, if it exists.
     * Second, just the taxonomy template is checked, and then finally, taxonomy.php
     * template is used. If none of the files exist, then it will fall back on to
     * index.php.
     *
     * @since 2.5.0
     * @uses apply_filters() Calls 'taxonomy_template' filter on found path.
     *
     * @return string
     */
    public function get_taxonomy_template() {
        $term = get_queried_object();
        $taxonomy = $term->taxonomy;

        $templates = array();

        $templates[] = "taxonomy-$taxonomy-{$term->slug}.php";
        $templates[] = "taxonomy-$taxonomy.php";
        $templates[] = 'taxonomy.php';

        return $this->get_query_template('taxonomy', $templates);
    }

    /**
     * Retrieve path of date template in current or parent template.
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_date_template() {
        return $this->get_query_template('date');
    }

    /**
     * Retrieve path of home template in current or parent template.
     *
     * This is the template used for the page containing the blog posts
     *
     * Attempts to locate 'home.php' first before falling back to 'index.php'.
     *
     * @since 1.5.0
     * @uses apply_filters() Calls 'home_template' on file path of home template.
     *
     * @return string
     */
    public function get_home_template() {
        $templates = array('home.php', 'index.php');

        return $this->get_query_template('home', $templates);
    }

    /**
     * Retrieve path of front-page template in current or parent template.
     *
     * Looks for 'front-page.php'.
     *
     * @since 3.0.0
     * @uses apply_filters() Calls 'front_page_template' on file path of template.
     *
     * @return string
     */
    public function get_front_page_template() {
        $templates = array('front-page.php');

        return $this->get_query_template('front_page', $templates);
    }

    /**
     * Retrieve path of page template in current or parent template.
     *
     * Will first look for the specifically assigned page template
     * The will search for 'page-{slug}.php' followed by 'page-id.php'
     * and finally 'page.php'
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_page_template() {
        $id = get_queried_object_id();
        $template = get_post_meta($id, '_wp_page_template', true);
        $pagename = get_query_var('pagename');

        if (!$pagename && $id > 0) {
            // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object
            $post = get_queried_object();
            $pagename = $post->post_name;
        }

        if ('default' == $template)
            $template = '';

        $templates = array();
        if (!empty($template) && !validate_file($template))
            $templates[] = $template;
        if ($pagename)
            $templates[] = "page-$pagename.php";
        if ($id)
            $templates[] = "page-$id.php";
        $templates[] = 'page.php';

        return $this->get_query_template('page', $templates);

    }

    /**
     * Retrieve path of paged template in current or parent template.
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_paged_template() {
        return $this->get_query_template('paged');
    }

    /**
     * Retrieve path of search template in current or parent template.
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_search_template() {
        return $this->get_query_template('search');
    }

    /**
     * Retrieve path of single template in current or parent template.
     *
     * @since 1.5.0
     *
     * @return string
     */
    public function get_single_template() {
        $object = get_queried_object();

        $templates = array();

        $templates[] = "single-{$object->post_type}.php";
        $templates[] = "single.php";

        return $this->get_query_template('single', $templates);
    }

    /**
     * Retrieve path of attachment template in current or parent template.
     *
     * The attachment path first checks if the first part of the mime type exists.
     * The second check is for the second part of the mime type. The last check is
     * for both types separated by an underscore. If neither are found then the file
     * 'attachment.php' is checked and returned.
     *
     * Some examples for the 'text/plain' mime type are 'text.php', 'plain.php', and
     * finally 'text_plain.php'.
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function get_attachment_template() {
        global $posts;
        $type = explode('/', $posts[0]->post_mime_type);
        if ($template = $this->get_query_template($type[0]))
            return $template;
        elseif ($template = $this->get_query_template($type[1]))
            return $template;
        elseif ($template = $this->get_query_template("$type[0]_$type[1]"))
            return $template;
        else
            return $this->get_query_template('attachment');
    }

    /**
     * Retrieve path of comment popup template in current or parent template.
     *
     * Checks for comment popup template in current template, if it exists or in the
     * parent template.
     *
     * @since 1.5.0
     * @uses apply_filters() Calls 'comments_popup_template' filter on path.
     *
     * @return string
     */
    public function get_comments_popup_template() {
        $template = $this->get_query_template('comments_popup', array('comments-popup.php'));

        // Backward compat code will be removed in a future release
        if ('' == $template)
            $template = ABSPATH . WPINC . '/theme-compat/comments-popup.php';

        return $template;
    }

    public function tpl($slug=null) {
        //$tpl = new core_tpl();
        $template = false;
        if (is_404() && $template = $this->get_404_template()) :
        elseif (is_search() && $template = $this->get_search_template()) :
        elseif (is_tax() && $template = $this->get_taxonomy_template()) :
        elseif (is_front_page() && $template = $this->get_front_page_template()) :
        elseif (is_home() && $template = $this->get_home_template()) :
        elseif (is_attachment() && $template = $this->get_attachment_template()) :
            remove_filter('the_content', 'prepend_attachment');
        elseif (is_single() && $template = $this->get_single_template()) :
        elseif (is_page() && $template = $this->get_page_template()) :
        elseif (is_category() && $template = $this->get_category_template()) :
        elseif (is_tag() && $template = $this->get_tag_template()) :
        elseif (is_author() && $template = $this->get_author_template()) :
        elseif (is_date() && $template = $this->get_date_template()) :
        elseif (is_archive() && $template = $this->get_archive_template()) :
        elseif (is_comments_popup() && $template = $this->get_comments_popup_template()) :
        elseif (is_paged() && $template = $this->get_paged_template()) :
        else :
            $template = $this->get_index_template();
        endif;
        if ($template = apply_filters('template_include', $template))
            return( $template );
        return;
    }

    /**
     * Retrieve path to a template
     *
     * Used to quickly retrieve the path of a template without including the file
     * extension. It will also check the parent theme, if the file exists, with
     * the use of {@link locate_template()}. Allows for more generic template location
     * without the use of the other get_*_template() functions.
     *
     * @since 1.5.0
     *
     * @param string $type Filename without extension.
     * @param array $templates An optional list of template candidates
     * @return string Full path to file.
     */
    public function get_query_template($type, $templates = array()) {
        $type = preg_replace('|[^a-z0-9-]+|', '', $type);
        $slug = $this->getSlug();

        if (empty($templates))
            $templates = array("{$type}.php");

        return apply_filters("tpl_{$type}_template", core_tpl::locate_tpl($templates,$slug));
    }

    /**
     * Retrieve the name of the highest priority template file that exists.
     *
     * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
     * inherit from a parent theme can just overload one file.
     *
     * @since 2.7.0
     *
     * @param string|array $template_names Template file(s) to search for, in order.
     * @param bool $load If true the template file will be loaded if it is found.
     * @param bool $require_once Whether to require_once or require. Default true. Has no effect if $load is false.
     * @return string The template filename if one is located.
     */
    public static function locate_template($slug=null, $template_names, $load = false, $require_once = true) {
        $located = '';
        foreach ((array) $template_names as $template_name) {
            if (!$template_name)
                continue;
            if (file_exists(STYLESHEETPATH . '/' . $template_name)) {
                $located = STYLESHEETPATH . '/' . $template_name;
                break;
            } else if (file_exists(TEMPLATEPATH . '/' . $template_name)) {
                $located = TEMPLATEPATH . '/' . $template_name;
                break;
            }
        }

        if ($load && '' != $located)
            self::load_template($located, $require_once);
        return $located;
    }

    /**
     *
     * @param type $template_names
     * @param type $slug
     * @param type $load
     * @param type $require_once
     * @return string
     */
    public static function locate_tpl($template_names, $slug=null, $load = false, $require_once = true) {
        $located = '';
        $path = 'tpl/';
        if (isset($slug))
            $path = "tpl/{$slug}/";
        foreach ((array) $template_names as $template_name) {
            if (!$template_name)
                continue;
            if (file_exists(STYLESHEETPATH . "/{$path}" . $template_name)) {
                $located = STYLESHEETPATH . "/{$path}" . $template_name;
                break;
            } else if (file_exists(TEMPLATEPATH . "/{$path}" . $template_name)) {
                $located = TEMPLATEPATH . "/{$path}" . $template_name;
                break;
            } else if (file_exists(STYLESHEETPATH . '/' . $template_name)) {
                $located = STYLESHEETPATH . '/' . $template_name;
                break;
            } else if (file_exists(TEMPLATEPATH . '/' . $template_name)) {
                $located = TEMPLATEPATH . '/' . $template_name;
                break;
            } else if (file_exists(CWP_PATH . "{$path}" . $template_name)) {
                $located = CWP_PATH . "{$path}" . $template_name;
                break;
            }
        }

        if ($load && '' != $located)
            self::load_template($located, $require_once);
        return $located;
    }

    public function templates($_templates=array()) {
        $templates = array();
        $path = 'tpl/';
        if (isset($slug))
            $path = $slug . '/tpl/';
        foreach ($_templates as $tpl):
            $templates[] = $path . $tpl;
        endforeach;
        $templates[] = "tpl/{$slug}.php";
        $templates[] = "{$slug}.php";

        self::locate_template($templates, null, true, false);
    }

    /**
     * Require the template file with WordPress environment.
     *
     * The globals are set up for the template file to ensure that the WordPress
     * environment is available from within the function. The query variables are
     * also available.
     *
     * @since 1.5.0
     *
     * @param string $_template_file Path to template file.
     * @param bool $require_once Whether to require_once or require. Default true.
     */
    public static function load_template($_template_file, $require_once = true) {
        global $posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        if (is_array($wp_query->query_vars))
            extract($wp_query->query_vars, EXTR_SKIP);

        if ($require_once)
            require_once( $_template_file );
        else
            require( $_template_file );
    }

    public static function template() {
        $tpl = new core_tpl;
        $template = false;
        if (is_404() && $template = self::get_404_template()) :
        elseif (is_search() && $template = self::get_search_template()) :
        elseif (is_tax() && $template = self::get_taxonomy_template()) :
        elseif (is_front_page() && $template = self::get_front_page_template()) :
        elseif (is_home() && $template = self::get_home_template()) :
        elseif (is_attachment() && $template = self::get_attachment_template()) :
            remove_filter('the_content', 'prepend_attachment');
        elseif (is_single() && $template = self::get_single_template()) :
        elseif (is_page() && $template = self::get_page_template()) :
        elseif (is_category() && $template = self::get_category_template()) :
        elseif (is_tag() && $template = self::get_tag_template()) :
        elseif (is_author() && $template = self::get_author_template()) :
        elseif (is_date() && $template = self::get_date_template()) :
        elseif (is_archive() && $template = self::get_archive_template()) :
        elseif (is_comments_popup() && $template = self::get_comments_popup_template()) :
        elseif (is_paged() && $template = self::get_paged_template()) :
        else :
            $template = $tpl->get_index_template();
        endif;
        if ($template = apply_filters('template_include', $template))
            return( $template );
        return;
    }

   /**
     * Load independant themes templates (modules), push custom data array, load from child/parents thene or plugin dir
     * Based on the wp template system
     * @global type $posts
     * @global type $post
     * @global type $wp_did_header
     * @global type $wp_did_template_redirect
     * @global type $wp_query
     * @global type $wp_rewrite
     * @global type $wpdb
     * @global type $wp_version
     * @global type $wp
     * @global type $id
     * @global type $comment
     * @global type $user_ID
     * @param string $template
     * @param array $data
     * @param bool $require_once
     * @param string $module
     */
    public function modules($template='index', $module='default',  $data=array(), $require_once=false) {


        $template = $template . '.php';

        //$file = PLUGINDIR . '/core-wp/modules/' . $module . '/tpl/' . $template ;
         $file = CM_PATH . '/' . $module . '/tpl/' . $template;

        if (file_exists(STYLESHEETPATH . '/tpl/' . $template)) {
            $file = STYLESHEETPATH . '/tpl/' . $template;
        } elseif (file_exists(STYLESHEETPATH . '/' . $template)) {
            $file = STYLESHEETPATH . '/' . $template;
        } elseif (file_exists(TEMPLATEPATH . '/tpl/' . $template)) {
            $file = TEMPLATEPATH . '/tpl/' . $template;
        } elseif (file_exists(TEMPLATEPATH . '/' . $template)) {
            $file = TEMPLATEPATH . '/' . $template;
        }

        if (file_exists($file))
            self::load_template ($file, $require_once);
        else
            echo "TPL NOT FOUND";
    }


    /**
     * locates and load templates
     * @param type $slug tpl directory - default content
     * @param type $name tpl name
     */
    public static function get_tpl_part($slug=null, $name = null) {
        //do_action("get_template_part_{$slug}", $slug, $name);
        $templates = array();
        if (isset($name)):
            $templates[] = "content/{$name}.php";//**tpl/content/name.php
            $templates[] = "default/{$name}.php";//**tpl/default/name.php
            $templates[] = "{$name}.php";//**tpl/name.php
        endif;
        //$templates[] = "{$slug}.php";
        if (isset($slug)):
            $templates[] = "{$name}.php";//** tpl/slug/name.php
            $templates[] = "{$slug}.php";//** tpl/slug/slug.php
            $templates[] = "index.php";//** tpl/slug/index.php
            //$templates[] = "{$name}.php";
            return $tpl = self::locate_tpl($templates, $slug, true, false);
        else :
            return $tpl = self::locate_tpl($templates, null, true, false);
        endif;
    }


}
