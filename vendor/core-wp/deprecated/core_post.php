<?php


/**
 * Description of core_loop
 *
 * @author Studio365
 */
class core_post {
    //put your code here

    public function __construct() {

    }

    public static function loop($query=Null,$page='loop',$data=null){
       if($query != null) query_posts($query);
        if(have_posts()):
            while(have_posts()):
                the_post();
                //core_tpl::modules($template, $module, $data)
                cwp::modules($page, 'default', $data);
            endwhile;
        endif;
    }


    public static function content($query=null,$data=null,$page='content'){

        if($query != null) query_posts($query);
        if(have_posts()):
            while(have_posts()):
            $_page = "content-".get_post_format();
                the_post();
                //core_tpl::modules($template, $module, $data)
                cwp::modules($page, 'default', $data);
            endwhile;
        endif;

    }

    public static function listing($query,$data,$tpl='list-default'){
        //$page = 'list';
        self::loop($query, $tpl, $data);
    }

    public static function grid($query,$data,$tpl='grid-default'){
        //$page = 'list';
        self::loop($query, $tpl, $data);
    }

    public static function single($query,$data,$tpl='single-default'){
        //$page = 'list';
        self::loop($query, $tpl, $data);
    }


    /**
     *
     * @param WP_Query $query
     * @param type $tpl
     * @param type $module
     * @param type $data
     */
    public static function custom($query='showposts=10', $tpl='post', $module='default', $data=null) {
        $query = new WP_Query($query);
        if ($query->have_posts()):
            while ($query->have_posts()):
                cwp::modules($tpl, $module, $data, true);
            endwhile;
        endif;
        // Reset Post Data
        wp_reset_postdata();
    }

    public static function format(){

    }


}


