<?php



/** include class the file won't autoload **/

//include_once dirname(__FILE__) . '/classes/Plugin/Settings.php';

class auto_load_settings {

    protected $api;

    public function __construct() {

        $this->api = Plugin_Settings::settings_api();
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'menu'));
        
    }

    public function menu() {
        add_options_page("WP.Autoload", "Autoload", 'administrator', 'wp_auto_load', array($this, 'menu_page'));
    }

    public function menu_page() {
        echo '<div class="wrap">';
        $this->api->show_navigation();
        $this->api->show_forms();
        echo '</div>';
    }

    public function admin_init() {

        $sections = array(
            array(
                'id' => 'autoload_setting',
                'title' => 'Settings'
            ),
            array(
                'id' => 'autoload_components',
                'title' => 'Components'
            )
        );


        $autoload_settings[] = Plugin_Settings::html('<b>Some HTML</b><p>Some text here lets seeee!!!</p>');
        $autoload_settings[] = Plugin_Settings::input('input');
        $autoload_settings[] = Plugin_Settings::checkbox('t2', 'test2');

        $autoload_components[] = Plugin_Settings::checkbox('t1', 'test1');
        $autoload_components[] = Plugin_Settings::checkbox('t2', 'test2');


        $fields = array(
            'autoload_setting' => $autoload_settings,
            'autoload_components' => $autoload_components
        );

        $this->api->set_sections($sections);
        $this->api->set_fields($fields);

        $this->api->admin_init();
    }

}

$wp_auto = new auto_load_settings();