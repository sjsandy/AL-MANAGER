<?php

/**
 * @package WordPress
 * @subpackage al-manager
 * @author shawnsandy
 * @link http://shawnsandy.com
 */


/**
 * Theme setup functions
 */
class FN_Theme_Setup {

    function __construct() {

    }

    /**
     *
     */
    public static function factory() {
        $factory = new FN_Theme_Setup();
        return $factory;
    }

    private $post_titles = array('Home', 'About', 'Contact Us'),
            $post_type = 'page',
            $post_status = 'publish',
            $home_page = null,
            $post_content = '<p><strong>Please go to your admin and edit / modify this page.</strong></p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat, orci ac laoreet cursus, dolor sem luctus lorem, eget consequat magna felis a magna. Aliquam scelerisque condimentum ante, eget facilisis tortor lobortis in. In interdum venenatis justo eget consequat. Morbi commodo rhoncus mi nec pharetra. Aliquam erat volutpat. Mauris non lorem eu dolor hendrerit dapibus. Mauris mollis nisl quis sapien posuere consectetur. Nullam in sapien at nisi ornare bibendum at ut lectus. Pellentesque ut magna mauris. Nam viverra suscipit ligula, sed accumsan enim placerat nec. Cras vitae metus vel dolor ultrices sagittis. Duis venenatis augue sed risus laoreet congue ac ac leo. Donec fermentum accumsan libero sit amet iaculis. Duis tristique dictum enim, ac fringilla risus bibendum in. Nunc ornare, quam sit amet ultricies gravida, tortor mi malesuada urna, quis commodo dui nibh in lacus. Nunc vel tortor mi. Pellentesque vel urna a arcu adipiscing imperdiet vitae sit amet neque. Integer eu lectus et nunc dictum sagittis. Curabitur commodo vulputate fringilla. Sed eleifend, arcu convallis adipiscing congue, dui turpis commodo magna, et vehicula sapien turpis sit amet nisi.';

    public function get_post_content() {
        return $this->post_content;
    }

    public function set_post_content($post_content) {
        $this->post_content = $post_content;
        return $this;
    }

    public function set_post_title($post_titles) {
        $this->post_titles = $post_titles;
        return $this;
    }

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    public function set_post_status($post_status) {
        $this->post_status = $post_status;
        return $this;
    }

    public function set_home_page($home_page) {
        $this->home_page = $home_page;
        return $this;
    }

    public function get_post_titles() {
        return $this->post_titles;
    }

    public function get_post_type() {
        return $this->post_type;
    }

    public function get_post_status() {
        return $this->post_status;
    }

    public function get_home_page() {
        return $this->home_page;
    }

}

/**
 * Description of FN_Post
 *
 * @author studio
 */

/**
 * Setup theme default pages
 * <code>
 * FN_Pages_Setup::add()->set_home_page('Home Page')->set_post_status('publish')->setup();
 * </code>
 */
class FN_Pages_Setup extends FN_Theme_Setup {

    public function __construct() {
        parent::__construct();
        $this->set_post_type('page');
    }

    public function add() {
        return $factory = new FN_Pages_Setup();
    }

    /**
     * Create default pages for your theme uses post titles
     * Add page templates to theme directory to find the template dir and custom page template will be set automatically follow naming convetions
     * Page name convetions (all lowercase / spaces converted to ' - ' ) @example Contact Us (Page Title) > contact-us.php (template name)
     * @param aray $title_array - array('Home Page', 'About', 'Contact')
     */
    public function setup($title_array = array('Home Page', 'About', 'Contact','Offline')) {

        //$theme_page = $this->theme_page();
        // @source roots theme framework (modified)
        // on theme activation make sure there's a Home page
        // create it if there isn't and set the Home page menu order to -1
        // set WordPress to have the front page display the Home page as a static page
        $default_pages = $title_array;
        $existing_pages = get_pages();
        $temp = array();

        foreach ($existing_pages as $page) {
            $temp[] = $page->post_title;
        }

        $pages_to_create = array_diff($default_pages, $temp);

        foreach ($pages_to_create as $new_page_title) {

            // create post object
            $add_default_pages = array(
                'post_title' => $new_page_title,
                'post_content' => $this->get_post_content(),
                'post_status' => $this->get_post_status(),
                'post_type' => $this->get_post_type(),
                //'post_parent' => $theme_page
            );

            // insert the post into the database
            $result = wp_insert_post($add_default_pages);

        }

// set the theme default home page if home page is set
        $home_page = $this->get_home_page();
        if (isset($home_page) and is_array($home_page)):
            $home = get_page_by_title($home_page);
            if (is_page($home->ID)):
                update_option('show_on_front', 'page');
                update_option('page_on_front', $home->ID);

                $home_menu_order = array(
                    'ID' => $home->ID,
                    'menu_order' => -1
                );
                wp_update_post($home_menu_order);
            endif;
        endif;

        $this->get_page_templates($title_array);
    }

    /**
     * Add Theme page Parent and return the ID
     * @return type
     */
    public function theme_page($parent_title='Theme Pages') {
        $themepage = get_page_by_title($parent_title);

        if (isset($themepage->ID)):
            $theme_page = $themepage->ID;
        else:

            $theme_page_array = array(
                'post_title' => "Theme Pages",
                'post_content' => "Theme pages parent page",
                'post_status' => "publish",
                'post_type' => $this->get_post_type()
            );
            $theme_page = wp_insert_post($theme_page_array);

        endif;

        return $theme_page;

    }

    /**
     * Attaches a template to a (home page) page
     * Add page templates to theme directory to find the template dir and custom page template will be set automatically follow naming convetions
     * Page name convetions (all lowercase / spaces converted to ' - ' ) @example Contact Us (Page Title) > contact-us.php (template name)
     * @param type $title_array
     */
    public function get_page_templates($title_array = array('Home Page')) {

        foreach ($title_array as $titles):

            $title = get_page_by_title($titles);

            if (isset($title->ID)):
                //find page templates and set update the page templates
                //$tpl = strtolower(str_replace(' ', '-', $titles));
                $tpl = strtolower(sanitize_title_with_dashes($titles));
                //$tpl = strtolower($tpl);
                $tpl_file = $tpl . ".php";
                if (file_exists(get_template_directory() . '/' . $tpl_file)):
                    update_post_meta($title->ID, '_wp_page_template', $tpl_file);
                endif;
            endif;

        endforeach;
    }

      /**
     * resets the home page options
     */
    public static function default_home_page_option(){
        update_option('show_on_front', 'posts');
        update_option('page_on_front', '0');
    }

}

class FN_Sidebars {

    private function __construct() {

    }

    /**
     *
     * @param type $name
     * @param type $widget_id
     * @param type $description
     * @param type $id
     * @param type $div
     * @param type $title
     *
     * <code>
     * //example
     * cwp::add_widget('Top Sidebar', 'top-sidebar', 'Top sidebar widget');
     * </code>
     */
    public function register($name, $widget_id, $description = "", $id = 'widgets', $div = "aside", $title = 'h3') {
        //$widget_id = preg_replace(" ", "-", $name);
        register_sidebar(array(
            'name' => ucfirst($name), $id,
            'id' => $name,
            'description' => $description,
            'before_widget' => '<' . $div . ' id="%1$s" class="widget %2$s">',
            'after_widget' => "</{$div}>",
            'before_title' => '<' . $title . ' class="widget-title">',
            'after_title' => '</' . $title . '>',
        ));
    }

}

