<?php


/**
 * Description of cwp_post
 *
 * @author Studio365
 */
class cwp_post {
    //put your code here

    public function __construct() {

    }

    /**
     * Uses WP default query to create a post loop
     * @global type $post
     * @param string / array $query
     * @param string $tpl_slug / default - base
     * @param string $tpl_name / default - general
     * <code><?php cwp_post::loop(array('post_type' => 'cwp_articles')); ?></code>
     */
    public static function loop($query = null, $tpl_slug = null, $tpl_name = null) {
        global $post;
        if (isset($query))
            query_posts($query);
        if (have_posts()):
            while (have_posts()):

                the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'general');

                if ($tpl_slug == 'post_type'):
                    $tpl_slug = $post_type;
                endif;
                if ($tpl_name == 'format')
                    $tpl_name = $post_format;

                $slug = isset($tpl_slug) ? $tpl_slug : 'base';
                $name = isset($tpl_name) ? $tpl_name : 'general';
                cwp_layout::tpl_part($slug, $name);

            endwhile;
        else :
            cwp_layout::tpl_part(null, 'no_post');
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
    public static function query($query='showposts=5', $tpl_slug=null, $tpl_name=null, $def_tpl = 'no_post') {
       global $post;
        $wp = new WP_Query();
        $wp->query($query);
        if ($wp->have_posts()):
            while ($wp->have_posts()):
                $wp->the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'general');

                if ($tpl_slug == 'post_type') $tpl_slug = $post_type;
                if ($tpl_slug == 'format') $tpl_slug = $post_format;

                $slug = isset($tpl_slug) ? $tpl_slug : 'base';
                $name = isset($tpl_name) ? $tpl_name : 'general';

                cwp_layout::tpl_part($slug, $name);

            endwhile;
        else :

            cwp_layout::tpl_part(null, $def_tpl);

        endif;
        wp_reset_postdata();
    }

    public static function get_post($query='showposts=5', $tpl_slug=null, $tpl_name=null) {


    }

}

?>
