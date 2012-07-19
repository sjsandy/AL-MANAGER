<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FN_js_sctipts
 *
 * @author studio
 */
abstract class FN_js {

    /**
     * Locates a resource in the library file
     * <code> <?php echo cwp::locate_in_libary('myfile.css','css') ?> </code>
     * @param string $filename
     * @param string $dir default- css
     * @return string
     */
    public function locate_in_library($filename = null, $dir = 'css') {
        if (isset($filename)):
            $filepath = 'library/' . $dir . '/' . $filename;
            if (file_exists(get_stylesheet_directory() . '/' . $filepath)):
                $file = get_stylesheet_directory_uri() . '/' . $filepath;
            elseif (file_exists(get_template_directory_uri() . '/' . $filepath)):
                $file = get_stylesheet_directory() . '/' . $filepath;
            elseif (CWP_PATH . '/' . $filepath):
                $file = CWP_URL . '/' . $filepath;
            endif;
            return $file;
        endif;
    }

    public function run() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'footer_scripts'));
        add_action('wp_head', array($this, 'head_scripts'));
    }

    public abstract function enqueue_scripts();

    public abstract function footer_scripts();

    public abstract function head_scripts();
}


/**
 * Masonry class.
 */
class FN_masonry extends FN_js {

    private $container_id = 'masonry',
            $item_selector = 'span4';

    public function set_container_id($container_id) {
        $this->container_id = $container_id;
        return $this;
    }

    public function set_item_selector($item_selctor) {
        $this->item_selector = $item_selctor;
        return $this;
    }

    public function get_container_id() {
        return $this->container_id;
    }


    public function get_item_selector() {
        return $this->item_selector;
    }

    public static function factory(){
        $factory = new FN_masonry();
        return $factory;
    }

    public function run_masonry($container_id = 'masonry', $item_selector = 'span4'){
        $this->container_id = $container_id;
        $this->item_selector = $item_selector;
        $this->run();
        return $this;

    }

    public function enqueue_scripts() {
        wp_register_script('masonry', cwp::locate_in_library('jquery.wookmark.min.js', 'masonry'), array('jquery'));
        if (!is_admin()) wp_enqueue_script('masonry');
    }

    public function footer_scripts() {
        ?>
 <!-- Once the page is loaded, initalize the plug-in. -->
  <script type="text/javascript">
   jQuery.noConflict();
     (function($) {
     $(window).load(function(){
		$('#<?php echo $this->container_id  ?>').masonry({
			//columnWidth: 350,
			animate: true,
			itemSelector: '.<?php echo $this->item_selector  ?>'
		},
		function() { $(this).css({
			margin: '0 0 80px 0'
			});
		});
	});
        })(jQuery);

  </script>
        <?php

    }

    public function head_scripts() {
        return false;
    }

}


class FN_curtains extends FN_js {


    public function __construct() {

    }

    public static function factory(){
        $factory = new FN_curtains();
        return $factory;
    }

    public function enqueue_scripts() {

        wp_register_script('curtains_js', $this->locate_in_library('curtain.js', 'curtains'), array('jquery'));
        if (!is_admin())
            wp_enqueue_script('curtains_js');
        wp_register_style('curtains-css', $this->locate_in_library('curtain.css', 'curtains'));
        wp_enqueue_style('curtains-css');

    }

    public function footer_scripts() {
        ?>
             <!-- Once the page is loaded, initalize the plug-in. -->
             <script type="text/javascript">
                 jQuery.noConflict();

                 jQuery(function(){
                     jQuery('.curtains').curtain({
                         scrollSpeed: 450,
                         controls: '.menu',
                         curtainLinks: '.curtain-links'
                     });
                 });
             </script>
        <?php
    }

    public function head_scripts() {
        return false;

    }

}

