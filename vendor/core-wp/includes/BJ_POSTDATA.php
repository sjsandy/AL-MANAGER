<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BJ_POSTDATA
 *
 * @author studio
 */
class BJ_POSTDATA {

    private $query = null,
            $wp_query = array('showposts' => 5),
            $template_name = '',
            $template_slug = 'content',
            $base_directory = 'views',
            $post_per_page = 4;

    public function set_post_per_page($post_per_page) {
        $this->post_per_page = $post_per_page;
        return $this;
    }

    public function set_base_directory($base_directory) {
        $this->base_directory = $base_directory;
        return $this;
    }

    public function set_query($query) {
        $this->query = $query;
        return $this;
    }

    public function set_template_name($template_name) {
        $this->template_name = $template_name;
        return $this;
    }

    public function set_template_slug($template_slug) {
        $this->template_slug = $template_slug;
        return $this;
    }

    public function set_wp_query($wp_query) {
        $this->wp_query = $wp_query;
    }

    public function get_query() {
        return $this->query;
    }

    public function get_wp_query() {
        return $this->wp_query;
    }

    public function get_template_name() {
        return $this->template_name;
    }

    public function get_template_slug() {
        return $this->template_slug;
    }

    public function get_base_directory() {
        return $this->base_directory;
    }

    public function get_post_per_page() {
        return $this->post_per_page;
    }

    public function __construct() {

    }

   /**
    *
    * @global type $post
    */
    public function loop() {
        global $post;
        if (isset($this->query))
            query_posts($this->query);
        if (have_posts()):
            while (have_posts()):
                the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'content');

                //if the slug is post_type use the post type name for slug instead of default content
                if ($this->template_slug == 'post_type')
                    $this->template_slug = $post_type;

                //if the name is format will use the post format for the template name
                if ($this->template_name == 'format')
                    $this->template_name = $post_format;

                //cwp_layout::tpl_part($slug, $name);
                bj_layout::get_template_part($this->template_slug, $this->template_name, $this->base_directory);
            endwhile;
        else :
            //cwp_layout::tpl_part(null, 'no_post');
            $this->template_name = 'no-post';
            $this->base_directory = 'views';
            bj_layout::get_template_part($this->template_slug, $this->template_name, $this->base_directory);
        endif;
        wp_reset_query();
    }

    /**
     *
     * Uses WP_Query to create post loops
     * @param string / array $query
     * @param string $tpl_slug // default - base
     * @param string $tpl_name // default - general
     * @param string $def_tpl
     * <code></code>
     */
    public function query() {
        global $post;
        $wp = new WP_Query();
        $wp->query($this->wp_query);
        if ($wp->have_posts()):
            while ($wp->have_posts()):
                $wp->the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'general');


                //if the slug is post_type use the post type name for slug instead of default content
                if ($this->template_slug == 'post_type')
                    $this->template_slug = $post_type;

                //if the name is format will use the post format for the template name
                if ($this->template_name == 'format')
                    $this->template_name = $post_format;

                bj_layout::get_template_part($this->template_slug, $this->template_name, $this->base_directory);

            endwhile;
        else :

            $this->template_name = 'no-post';
            $this->base_directory = 'views';
            bj_layout::get_template_part($this->template_slug, $this->template_name, $this->base_directory);
        endif;
        wp_reset_postdata();
    }

}
