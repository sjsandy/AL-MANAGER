<?php


/**
 * Description of core_media
 *
 * @author Studio365
 */



class core_media {

    //put your code here
    public function __construct() {

    }

    /**
     * Locates a file url e.g. images/video/stylesheets
     * Searches core-wp/modules plugin directory in plugin,
     * - core-WP in the stylesheet / template directory
     * - modules in the stylesheet / template directory
     * - stylesheet / template directory
     * @param string $file filename
     * @param string $dir path to file - dirname/ (w/trailing slash)
     * @return string
     */
    public static function locate($file, $dir=NULL) {
        $located = false;
        $fname = $dir . $file;
        $file = CM_URL . '/' . $fname;
        if (file_exists(get_stylesheet_directory() . '/core-wp/modules/' . $fname)):
            $file = get_stylesheet_directory_uri() . '/core-wp/modules/' . $fname;
        elseif (file_exists(get_template_directory() . '/core-wp/modules/' . $fname)):
            $file = get_template_directory_uri() . '/core-wp/modules/' . $fname;
        elseif (file_exists(get_stylesheet_directory() . '/modules/' . $fname)):
            $file = get_stylesheet_directory_uri() . '/modules/' . $fname;
        elseif (file_exists(get_template_directory() . '/modules/' . $fname)):
            $file = get_template_directory_uri() . '/modules/' . $fname;
        elseif (file_exists(get_stylesheet_directory() . $fname)):
            $file = get_stylesheet_directory_uri() . $fname;
        elseif (file_exists(get_template_directory() . $fname)):
            $file = get_template_directory_uri() . $fname;
        endif;
        if (file_exists($file)):
            return $file;
        else :
            return false;
        endif;
    }

   /**
    * Locates your modules css files
    * @param string $filename The file name
    * @param String $module_dir The name ot the module directory
    * @return String URL of the css file
    */
    public static function locate_css($filename='style', $module_dir='default'){
        $file = $filename . '.css';
        $css = self::locate($file, $module_dir . '/css/');
        return $css;
    }

}

