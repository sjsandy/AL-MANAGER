<?php

/**
 * @package WordPress
 * @subpackage Toolbox
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */






class bj_layout {

    public function __construct() {

    }

    static $main_tpl;
    static $base_tpl;

    public static function base_tpl() {
        return self::$base_tpl;
    }

    /**
     *
     * @param type $name
     * @param type $slug
     */
    public static function get_tpl($name = NULL,$dir = 'themes') {
        $use = "index";
        if (isset($name))
            $use = "tpl/{$dir}/tpl-{$name}";
        get_template_part($use);
    }

    /**
     * Deprecated do not use replaced with content ( include_once bj_layout::the_content(); )
     * Main Tpl Loads layout code (loop)
     * @param boolean $load use default wordpress loadtemplate
     * @param string $slug - location of directory in theme folder
     */
    public static function main_tpl($slug = null, $load = false) {
        
        global $post;
        $tpl = self::$main_tpl;
        if (isset($slug))
            $tpl = $slug . '-' . self::$main_tpl;
        if ($load):
            load_template($tpl);
            return;
        endif;
        include $tpl;

    }


    public static function content(){
        return self::$main_tpl;
    }

    public static function tpl_include($template) {

        //checks to see if mobile theme is available
        $mobile_themes = false;
        if (file_exists(get_stylesheet_directory() . '/mobile.php') or file_exists(get_template_directory() . '/mobile.php')):
            $mobile_themes = true;
        endif;
        //checks to see if mobile-phone theme is available
        $mobile_phone_themes = false;
        if (file_exists(get_stylesheet_directory() . '/mobile-phone.php') or file_exists(get_template_directory() . '/mobile-phone.php')):
            $mobile_phone_themes = true;
        endif;

        if (cwp::theme_settings('offline') == 1 and !current_user_can('manage_options'))
            self::$main_tpl = get_stylesheet_directory() . '/offline.php';
        else
            self::$main_tpl = $template;

        self::$base_tpl = substr(basename(self::$main_tpl), 0, -4);

        if ('index' == self::$base_tpl)
            self::$base_tpl = false;


        /**
         *  check to seee if a mobile templaate exists in stylesheet dir and load
         *  to disable mobile themes create a child theme without a mobile template
         */
        if ($mobile_themes AND mod_mobile::detect()->isTablet()) {
            /*
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array('tpl/mobile/mobile.php',);
            if (self::$base_tpl) {
                //twitter bootstrap themes
                array_unshift($templates, sprintf('tpl/mobile/tpl-mobile-%s.php', self::$base_tpl));
            }
        } elseif ($mobile_phone_themes AND mod_mobile::detect()->isPhone()) {
            /*
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array('tpl/mobile/phone.php',);
            if (self::$base_tpl) {
                //twitter bootstrap themes
                array_unshift($templates, sprintf('tpl/mobile/tpl-phone-%s.php', self::$base_tpl));
            }
        } else {
            /*
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array('tpl/themes/tpl-index.php', 'tpl/layout/tpl-index.php', 'tpl/layout/index.php',);
            if (self::$base_tpl) {

                //foundation themes  - may remove foundation entirely
                //array_unshift($templates, sprintf('tpl/sample/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/layout/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/themes/tpl-%s.php', self::$base_tpl));
            }
        }

        //return locate_template($templates,true);

        self::locate_tpl($templates, null, true);
        // return self::locate_tpl($templates);
    }

    /**
     *
     * @param string $template_names
     * @param string $slug null
     * @param bool $load false
     * @param bool $require_once true
     * @return string
     */
    public static function locate_tpl($template_names, $slug = null, $load = false, $require_once = true) {
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
            } else if (file_exists(CWP_PATH . "/{$path}" . $template_name)) {
                $located = CWP_PATH . "/{$path}" . $template_name;
                break;
            }
        }


        if ($load && '' != $located)
            load_template($located, $require_once);
        return $located;

    }


    /**
     * Uses wordpress get_template part to retrieve template flies in the tpl directory
     * with slight template names variation $prefixes to the $name
     * $prefix = hierachy : ($slug-single-$name)
     * $prefix = post_type : ($slug-$post_type-$name)
     * @global type $post
     * @param type $slug
     * @param type $name
     * @param type $prefix
     * @param type $base_dir
     */
    public static function get_template_part($slug='content', $name=null,$base_dir = 'views') {
        global $post;
//        if($name == 'hierachy'):
//        if(is_page()) $name = 'page'. isset($name) ? '-' .$name : '' .$slug ;
//        if(is_single()) $name = 'single'. isset($name) ? '-' .$name : '' .$slug ;
//        if(is_archive()) $name = 'archive'. isset($name) ? '-' .$name : '' .$slug ;
//        endif;
//        if($prefix == 'post_type'):
//            $type = $post->post_type;
//        if(!empty($type))
//        $name = $type . isset($name) ? '-' .$name : '' .$slug ;
//        endif;
        get_template_part('tpl/'.$base_dir.'/'.$slug, $name);
    }

    public static function get_header($name=null,$base_dir='layout'){
        $slug = 'tpl-header';
        bj_layout::get_template_part($slug,$name,$base_dir);
    }

    public static function get_footer($name=null,$base_dir='layout'){
        $slug = 'tpl-footer';
        bj_layout::get_template_part($slug,$name,$base_dir);
    }


    public static function get_content($name=null,$base_dir='views'){
        $slug = 'content';
        bj_layout::get_template_part($slug,$name,$base_dir);
    }

}