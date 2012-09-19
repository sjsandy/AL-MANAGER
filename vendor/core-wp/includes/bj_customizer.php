<?php

/**
 * The file description. *
 * @package BJ
 * @since BJ 1.0
 */


// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class bj_customizer {

    function __construct($header_img = '', $background_image = '') {

        $bj_site_logo = $header_img;
//        if (!file_exists($header_img))
//            $bj_site_logo = '';
        $bj_theme_header = array(
            'default-image' => $bj_site_logo,
            'random-default' => false,
            'width' => 300,
            'height' => 48,
            'flex-height' => true,
            'flex-width' => true,
            'default-text-color' => '',
            'header-text' => true,
            'uploads' => true,
            'wp-head-callback' => '',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
        );
        add_theme_support('custom-header', $bj_theme_header);


        ;
//        if (!file_exists($bj_background))
//            $bj_background = '';
        $bj_theme_background = array(
            'default-color' => 'FFFFFF',
            'default-image' => $background_image,
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => ''
        );
        add_theme_support('custom-background', $bj_theme_background);

        // add_action('customize_register', 'themename_customize_register');
        add_action('admin_menu', array($this, 'bj_theme_custom_admin'));
    }

    /**
     *
     * @param type $header_img
     * @param type $bj_img
     * @return type
     */
    public static function factory($header_img = '', $bj_img = '') {
        return $factory = new bj_customizer($header_img, $bj_img);
    }

    public function default_settings() {

    }

    public function bj_theme_custom_admin() {
        // add the Customize link to the admin menu
        add_theme_page('Customize', 'Theme Customizer', 'edit_theme_options', 'customize.php');
    }

}

class bjc_branding {

    function __construct() {

        add_action('customize_register', array($this, 'customize'));
    }

    public static function factory() {
        return $factory = new bjc_branding();
    }

    public function customize($wp_customize) {
        $wp_customize->add_section('bj_branding_section', array(
            'title' => 'Brand',
            'priority' => 100,
            'description' => __('This section takes care of you Site Logo and online branding, fan-page, twitter url, google plus url etc', 'bj')
        ));


        $wp_customize->add_setting('bjc_logo', array(
            'default' => '',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bjc_logo', array(
                    'label' => 'Site Logo',
                    'section' => 'bj_branding_section',
                    'settings' => 'bjc_logo'
                )));


        $wp_customize->add_setting('bjc_twitter_url', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_twitter_url', array(
            'label' => 'Twitter Url',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));


        $wp_customize->add_setting('bjc_fanpage_url', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_fanpage_url', array(
            'label' => 'Facdbook Fan page',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));


        $wp_customize->add_setting('bjc_gplus_url', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_gplus_url', array(
            'label' => 'Google Plus Url',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));


        $wp_customize->add_setting('bjc_feedburner_url', array(
            'default' => '',
        ));

        $wp_customize->add_control('bjc_feedburner_url', array(
            'label' => 'Feedburner Url',
            'section' => 'bj_branding_section',
            'type' => 'text',
        ));
    }

}

class bjc_contact {

    public function __construct() {
        add_action('customize_register', array($this, 'customize'));
    }

    public static function factory() {
        return $factory = new bjc_contact();
    }

    public function customize($customize) {

        $customize->add_section('bjc_contact', array(
            'title' => 'Site Contact',
            'priority' => 110,
            'description' => __('Default contact info', 'basejump')
        ));




        $customize->add_setting('bjc_contact_message', array(
            'default' => __("Please don't hesitate to contact us for more info!",'basejump'),
        ));

         $customize->add_control(new BJC_Editor_Control($customize, 'bjc_contact_message', array(
                    'label' => 'Contact Message / Copy',
                    'section' => 'bjc_contact',
                    'settings' => 'bjc_contact_message',
                    'type' => 'bjc_wp_editor'
                )));


        $customize->add_setting('bjc_org_name', array(
            'default' => 'Orgnization Name',
        ));



        $customize->add_control('bjc_org_name', array(
            'label' => 'Organization Name',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_name', array(
            'default' => '',
        ));

        $customize->add_control('bjc_contact_name', array(
            'label' => 'Contact Name',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_email', array(
            'default' => 'email@yourdomain.com',
        ));

        $customize->add_control('bjc_contact_email', array(
            'label' => 'Contact Email',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_tel', array(
            'default' => '',
        ));

        $customize->add_control('bjc_contact_tel', array(
            'label' => 'Telephone',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_address', array(
            'default' => 'Address',
        ));

        $customize->add_control('bjc_contact_address', array(
            'label' => 'Street Address',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_city', array(
            'default' => 'City',
        ));

        $customize->add_control('bjc_contact_city', array(
            'label' => 'City',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_state', array(
            'default' => 'XX',
        ));

        $customize->add_control('bjc_contact_state', array(
            'label' => 'State',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));

        $customize->add_setting('bjc_contact_zip', array(
            'default' => '00000',
        ));

        $customize->add_control('bjc_contact_zip', array(
            'label' => 'Zip Code',
            'section' => 'bjc_contact',
            'type' => 'text'
        ));
    }

}

class bjc_copy_editor {

    public function __construct() {
        add_action('customize_register', array($this, 'customize'));
    }

    public static function factory() {
        return $factory = new bjc_copy_editor();
    }

    public function customize($customize) {

        $customize->add_section('bjc_slug', array(
            'title' => 'Theme Copy',
            'priority' => 105,
            'description' => "Customize the theme(s) content/copy/slug"
        ));

        $customize->add_setting('bjc_site_slug', array(
            'default' => 'The super cool SiteSlug or as the guys in marketing call it, elevator pitch',
            'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_site_slug', array(
                    'label' => 'Site Slug',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_site_slug'
                )));

        /************/
        $customize->add_setting('bjc_404_slug', array(
            'default' => 'It looks like nothing was found at this location. Maybe try one of the links below or a search?',
            'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_404_slug', array(
                    'label' => '404 Page Slug',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_404_slug'
                )));

        /************/
        $customize->add_setting('bjc_search_slug', array(
            'default' => 'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
            'type' => 'option'
        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_search_slug', array(
                    'label' => 'Search Not found',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_search_slug'
                )));

        /************/

        $customize->add_setting('bjc_footer_slug', array(
            'default' => 'Here is your footer sulg ',

        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_footer_slug', array(
                    'label' => 'Footer Copy / Slug',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_footer_slug',
                    'type' => 'bjc_wp_editor'
                )));

        $customize->add_setting('bjc_copyright_slug', array(
            'default' => 'Here is your copyright info',

        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_copyright_slug', array(
                    'label' => 'Copyright Info',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_copyright_slug',
                    'type' => 'bjc_wp_editor'
                )));

        $customize->add_setting('bjc_enable_copyinfo',array(
           'default' => '',

        ));

        $customize->add_control('bjc_enable_copyinfo',array(
           'label' => 'Hide Copyright Info' ,
            'section' => 'bjc_slug',
            'type' => 'checkbox'
        ));

        $customize->add_setting('bjc_copyright_slug', array(
            'default' => 'Here is your footer copy',

        ));

        $customize->add_control(new BJC_Editor_Control($customize, 'bjc_copyright_slug', array(
                    'label' => 'Copyright Info',
                    'section' => 'bjc_slug',
                    'settings' => 'bjc_copyright_slug'
                )));
    }

}

if (class_exists('WP_Customize_Control')):

    class Example_Customize_Textarea_Control extends WP_Customize_Control {

        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
        }

    }

    class BJC_Editor_Control extends WP_Customize_Control {

        public $type = 'bjc_wp_editor';

//        var $defaults = array();
//        public $args = array();

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>

            <?php
        }

    }

    /**
     * @source http://ericjuden.com/2012/08/custom-taxonomy-control-for-the-theme-customizer/
     */
    class Taxonomy_Dropdown_Control extends WP_Customize_Control {

        public $type = 'taxonomy_dropdown';
        var $defaults = array();
        public $args = array();

        public function render_content() {
            $this->defaults = array(
                'show_option_none' => __('None'),
                'orderby' => 'name',
                'hide_empty' => 0,
                'id' => $this->id,
                'selected' => $this->value(),
            );

            $r = wp_parse_args($this->args, $this->defaults);
            ?>
            <label><span class="customize-control-title"><?php echo esc_html($this->label); ?></span></label>
            <?php
            wp_dropdown_categories($r);
        }

    }

endif;

