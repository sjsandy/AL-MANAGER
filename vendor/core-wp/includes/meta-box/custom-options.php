<?php


/**
 * *****************************************************************************
 * Add Metaboxes
 * *****************************************************************************
 */



add_action('admin_menu','cwpt_remove_metaboxes');

function cwpt_remove_metaboxes(){

}

//add_filter( 'cmb_meta_boxes', 'cwp_optional_metaboxes' );
add_action( 'add_meta_boxes', 'cwpt_custom_metaboxes' );
add_action( 'add_meta_boxes', 'cwpt_theme_screenshot' );

function cwpt_custom_metaboxes(){

 remove_meta_box('postimagediv', 'cwp_custom_options', 'side');
 //add_meta_box('cwpt_preview', 'Site Preview', 'cwpt_preview_box', 'cwp_custom_options', 'normal', 'low');

}


function cwpt_theme_screenshot(){
    $title = get_current_theme();
    //add_meta_box('cwpt_theme_screen', $title. ' - Custom Theme Options', 'add_cwpt_screenshot', 'cwp_custom_options', 'side', 'high');
}

$theme_logo = new MultiPostThumbnails(array(
            'label' => 'Site Logo / Image',
            'id' => 'theme-logo',
            'post_type' => 'cwp_custom_options',
            'context' => 'side',
            'priority' => 'low',
                )
);

function add_cwpt_screenshot(){
    ?>

<p style="display: block; clear: both; font-size:16px; line-height: 1.5em ">

<!--      <img src="<?php echo get_template_directory_uri() ?>/screenshot.png" style="float: left;padding: 10px;  " >-->

 <?php _e('
        Custom Theme Options allow you to create, modify, save and reuse theme (UI) options, theme logo, 404 / search page,copy etc. Set defualt custom options from the theme settings page, directly on post and pages or directly in theme files. Save mutiple options if you like (do not abuse, with great power...). All the options are conviently placed on one page for ease of use please see theme documentation for multiple custom theme options','corewp') ?>
    </p>
    <br style="clear:both" />
    <?php
}

function cwp_optional_metaboxes( $meta_boxes ) {

    $meta_boxes[] = array(
        'id' => 'optional_metabox',
        'title' => 'Show Hide Options',
        'pages' => array('cwp_custom_options'), // post type
        'context' => 'side',
        'priority' => 'default',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Hide UI Options',
                'desc' => 'Hide UI options if they get in yout way ot your simple need you use the content',
                'type' => 'title',
                'id' => '_cwpt_copy_title',
            ),
            array(
                'name' => 'Hide Options',
                'desc' => 'Hides UI Options',
                'id' => '_cwpt_show_home',
                'type' => 'checkbox'
            )

        ),
    );

	return $meta_boxes;
}




$cwpt_prefix = '_cwpt_'; // Prefix for all fields

function cwp_options_metaboxes($meta_boxes) {
    global $cwpt_prefix;
    $meta_boxes[] = array(
        'id' => 'custom_options',
        'title' => 'Custom Theme Options',
        'pages' => array('cwp_custom_options'), // post type
        'context' => 'normal',
        'priority' => 'core',
        'show_names' => true, // Show field names on the left
        'fields' => array(

            array(
                'name' => 'Custom Theme Options',
                'desc' => 'Custom Theme Options allow you to create, modify, save and reuse theme (UI) options, theme logo, 404 / search page,copy etc. Set defualt custom options from the theme settings page, directly on post and pages or directly in theme files. Save mutiple options if you like (do not abuse, with great power...). All the options are conviently placed on one page for ease of use please see theme documentation for help',
                'type' => 'title',
                'id' => '_cwpt_copy_title',
            ),
            array(
                'name' => 'Theme Home Page Custom Options',
                'desc' => 'Copy / text / content / elements, used on the theme Home page',
                'type' => 'title',
                'id' => '_cwpt_copy_title',
            ),
            array(
                'name' => 'Theme Headline Copy / Slug',
                'desc' => 'Enter copy for theme cover (home page) headline or slug',
                'id' => '_cwpt_headline_copy',
                'type' => 'textarea_small'
            ),
            array(
                'name' => 'Home Page Content / Copy',
                'desc' => 'Appears as the theme main content',
                'id' => '_cwpt_main_copy',
                'type' => 'wysiwyg',
                'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => true, // show insert/upload button(s)
                    //'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
                    'textarea_rows' => get_option('default_post_edit_rows', 4), // rows="..."
                    'tabindex' => '',
                    'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
                    'editor_class' => '', // add extra class(es) to the editor textarea
                    'teeny' => false, // output the minimal editor config used in Press This
                    'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
                    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                    'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                ),
            ),
            array(
                'name' => 'General Theme Custom Options',
                'desc' => 'Copy / text / content used on the theme Home page',
                'type' => 'title',
                'id' => '_cwpt_copy_title',
            ),
              array(
                'name' => 'Header Copy / Text',
                'desc' => 'Enter copy for theme header',
                'id' => '_cwpt_header_copy',
                'type' => 'textarea_small'
            ),
            array(
                'name' => 'Footer Copy / Text',
                'desc' => 'Copy / Text for the theme footer',
                'id' => '_cwpt_footer_copy',
                'type' => 'textarea_small'
            ),
             array(
                'name' => 'Subscribe Copy / Text',
                'desc' => 'Copy / Text for the theme footer',
                'id' => '_cwpt_subscribe_copy',
                'type' => 'textarea_small'
            ),
            array(
                'name' => 'Copyright Slug',
                'desc' => 'This text is append to your copyrights',
                'id' => '_cwpt_copyright_copy',
                'type' => 'text'
            ),
            array(
                'name' => 'Contact Slug',
                'desc' => 'This is used for the contact us text',
                'id' => '_cwpt_contact_copy',
                'type' => 'text'
            ),
            //******************* offline ***************************************
            array(
                'name' => 'Offline Custom Options',
                'desc' => 'Copy / text / content / elements, used when the site is offline',
                'type' => 'title',
                'id' => '_cwpt_copy_title',
            ),
            array(
                'name' => 'Offline Copy / Slug',
                'desc' => 'Enter copy for theme cover (home page) headline or slug',
                'id' => '_cwpt_offline_slug',
                'type' => 'text'
            ),
            array(
                'name' => 'Offline Copy / Text',
                'desc' => 'Appears as the theme offline',
                'id' => '_cwpt_offline_copy',
                'type' => 'wysiwyg',
                'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => true, // show insert/upload button(s)
                    //'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
                    'textarea_rows' => get_option('default_post_edit_rows', 5), // rows="..."
                    'tabindex' => '',
                    'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
                    'editor_class' => '', // add extra class(es) to the editor textarea
                    'teeny' => true, // output the minimal editor config used in Press This
                    'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
                    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                    'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                ),
            ),
            //**********************404****************************************
            array(
                'name' => '404 Custom Options',
                'desc' => 'Copy / text / content / elements, used in the theme 404 page',
                'type' => 'title',
                'id' => '_cwpt_copy_title',
            ),
            array(
                'name' => '404 page Copy / Slug',
                'desc' => 'Enter copy for theme cover (home page) headline or slug',
                'id' => '_cwpt_404_slug',
                'type' => 'text'
            ),
            array(
                'name' => '404 Page Copy / Text',
                'desc' => 'Appears as the theme 404 page',
                'id' => '_cwpt_404_copy',
                'type' => 'wysiwyg',
                'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => true, // show insert/upload button(s)
                    //'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
                    'textarea_rows' => get_option('default_post_edit_rows', 5), // rows="..."
                    'tabindex' => '',
                    'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
                    'editor_class' => '', // add extra class(es) to the editor textarea
                    'teeny' => true, // output the minimal editor config used in Press This
                    'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
                    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                    'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                ),
            ),
            array(
                'name' => '404 page elements',
                'desc' => 'Select the items you do not want to appear on you 404 page (optional)',
                'id' => '_cwpt_404_elements',
                'type' => 'multicheck',
                'options' => array(
                    'search' => 'Site Search',
                    'recent_post' => 'Recent Post',
                    'archives' => 'Archives',
                    'pages' => 'Pages',
                )
            ),
        ),
    );

    return $meta_boxes;
}

add_filter('cmb_meta_boxes', 'cwp_options_metaboxes');


$theme_404 = new MultiPostThumbnails(array(
            'label' => '404 Logo / Image',
            'id' => '404-image',
            'post_type' => 'cwp_custom_options',
            'context' => 'side',
            'priority' => 'low',
                )
);

$theme_offline = new MultiPostThumbnails(array(
            'label' => 'Offline image',
            'id' => 'offline-image',
            'post_type' => 'cwp_custom_options',
            'context' => 'side',
            'priority' => 'low',
                )
);




function cwpt_preview_box(){
    echo 'hello world';
    media_upload_form() ;
    //echo '<p><iframe src="' .site_url(). '" width="100%" height="500"></iframe></p>';
}

class cwpt {




    function __construct() {

    }

    public static function default_id(){
        $def = null;
        // get the last published custom_optinos and use as id
        $args = array('showposts'=>1,'post_type'=>'cwp_custom_options','orderby'=>'menu_order');
        $def_opt = get_posts($args);
        if(isset($def_opt) AND !empty($def_opt))
        $def = $def_opt[0]->ID;
        return $def;
    }

    public static function images(){

    }

}

