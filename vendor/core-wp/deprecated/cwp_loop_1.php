<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cwp_loop
 *
 * @author Studio365
 */
class cwp_loop {
    //put your code here

    public function __construct() {

    }

     /**
     * get loop for post-formats
      * //post-format-aside post-format-audio post-format-chat post-format-gallery post-format-image post-format-link post-format-status post-format-quote post-format-video
     * @global type $post
     * @param string $tpl tpl name
     * @param string $_formats default aside
     * @param String $operator (IN, NOT_IN)
      * @param boolean $reset 
     */
    public static function formats($tpl="general", $_formats = array('post-format-aside'), $operator="IN",$reset=true) {
        //http://wordpress.mfields.org/2011/post-format-queries/

        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => $formats,
                    'operator' => "{$operator}"
                )
            )
        );

        $query = new WP_Query($args);
        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                cwp_layout::tpl_part(NULL, $tpl);
            endwhile;
        endif;
        if($reset)
        wp_reset_postdata();
    }

}

//post-format-aside post-format-audio post-format-chat post-format-gallery post-format-image post-format-link post-format-status post-format-quote post-format-video
