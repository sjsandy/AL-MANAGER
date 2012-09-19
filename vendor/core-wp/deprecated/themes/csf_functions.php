<?php
/**
 * @package WordPress
 * @subpackage BaseJump5
 * @author shawnsandy
 */
/**
 * Theme menus
 */

/**
 * default base menu
 */
function base_default_menu() {
    ?>
    <ul>
        <li>
            <a href="<?php echo home_url() ?>" >Home</a>
            <?php //wp_list_categories('title_li=&depth=1');   ?>
        </li>

    </ul>
    <?php
}

function install_guide($templates) {
    $tpl = get_template_directory() . '/install-guide.php';
    load_template($tpl);
}

if (!class_exists('cwp')):
    add_filter('template_include', 'install_guide');
    return;
endif;

/*
 * add layout tpl
 */
add_filter('template_include', array('cwp_layout', 'tpl_include'));


/**
 * adds all post functions
 */
core_functions::all_post_formats();

/**
 * setup some script variables
 */
$css_path = get_template_directory_uri() . '/library/css';

$cycle_style = $css_path . '/home-cycle.css';
$tiptip_style = $css_path . '/tipTip.css';

/*
 * register styles
 */

wp_register_style('cycle', $cycle_style);
wp_register_style('cycle', $tiptip_style);

wp_register_style('flex-slider', get_stylesheet_directory_uri() . '/library/css/flexslider.css');
/*
 * register scripts
 */
$js_h5f = get_template_directory_uri() . '/library/js/h5f.min.js';
$js_backstretch = get_template_directory_uri() . '/library/js/jquery.backstretch.min.js';
$js_cycle = get_template_directory_uri() . '/library/js/jquery.cycle.all.js';
$js_masonry = get_template_directory_uri() . '/library/js/jquery.masonry.min.js';
$js_tiptip = get_template_directory_uri() . '/library/js/jquery.tipTip.minified.js';



wp_register_script('h5f', $js_h5f);
wp_register_script('backstretch', $js_backstretch, array('jquery'));
wp_register_script('cycle', $js_cycle, array('jquery'));
wp_register_script('masonry', $js_masonry, array('jquery'));
wp_register_script('tiptip', $js_tiptip, array('jquery'));
wp_register_script('flex-slider', get_stylesheet_directory_uri() . '/library/js/jquery.flexslider-min.js', array('jquery'));


/**
 * Main theme js scripts
 */
if (!is_admin()) {
    cwp::jquery();
    wp_enqueue_script('modernizer', get_template_directory_uri() . '/library/js/modernizr.custom.48627.js', array('jquery'));
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/library/js/scripts.js');
    wp_enqueue_script('media-queries', get_template_directory_uri() . '/library/js/css3-mediaqueries.js');
    wp_enqueue_script('fitvids', get_template_directory_uri() . '/library/js/jquery.fitvids.js', array('jquery'));
    //wp_enqueue_script('less', 'http://lesscss.googlecode.com/files/less-1.0.21.min.js', array('jquery'));
    wp_enqueue_script('hf5', $js_h5f);
}



core_functions::favicon();
add_theme_support('post-thumbnails');
add_theme_support('automatic-feed-links');
//add_editor_style();
//cwp::theme_images(); //adds  image sizes slideshow-[720,960,1200,1560], icon-[40,60,100]
add_image_size('icon-60', 60, 60, true);
add_image_size('icon-100', 100, 100, true);
add_image_size('icon-40', 40, 40, true);


/*
 * footer widgets
 */
cwp::add_widget('info 1', 'info-1', 'Display widgets in the first footer box');
cwp::add_widget('info 2', 'info-2', 'Display widgets in the second footer box');
cwp::add_widget('info 3', 'info-3', 'Display widgets in the third footer box');
cwp::add_widget('info 4', 'info-4', 'Display widgets in the fourth footer box');
cwp::add_widget('info 5', 'info-5', 'Display widgets in the fifth footer box');
cwp::add_widget('Widget Page', 'widget-page', 'Display widgets on the widget-page tpl');
cwp::add_widget('404 Page', '404-page', 'Display widgets on the 404-page tpl');

/**
 * footer
 */
add_action('wp_footer', 'theme_footer');

function theme_footer() {

}

/*
 * add thumbnails to editior list
 */
core_admin::post_list_thumbs();


/*
 * add post style to TinyMCS editor
 */
core_admin::editor_style();


/**
 * custom post types
 */
//$order = new cwp_orders();

/**
 * Adapt.js/960 grid
 */

/**
 * Tinymce Style Buttons
 *
 */
function theme_formatTinyMCE($init) {
    $init['theme_advanced_buttons2_add'] = 'styleselect';
    $init['theme_advanced_styles'] = 'PDF=pdf;Notes=notes;DiscussIt=discuss;Warning=warning;Share=share';
    return $init;
}

add_filter('tiny_mce_before_init', 'theme_formatTinyMCE');


remove_post_type_support('post', 'revisions');

/**
 * stop self pingbacks
 */


