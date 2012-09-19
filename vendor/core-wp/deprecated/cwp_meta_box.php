<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 * @
 */
class cwp_meta_box {
    //put your code here

    /**
     *
     * @var string
     */
    private $meta_name;

    /**
     *
     * @var array
     */
    private $meta_feilds = '';

    /**
     *
     * @var string path to meta box form
     */
    private $meta_form_url = null;

    /**
     *
     * @var string list of post types
     */
    private $meta_post_types = "'page','post'";

    public function set_meta_post_types($meta_post_types) {
        $this->meta_post_types = $meta_post_types;
        return $this;
    }

    public function get_meta_name() {
        return $this->meta_name;
    }

    public function set_meta_name($meta_name) {
        $this->meta_name = $meta_name;
        return $this;
    }

    public function get_meta_feilds() {
        return $this->meta_feilds;
    }

    public function set_meta_feilds($meta_feilds) {
        $this->meta_feilds = $meta_feilds;
        return $this;
    }

    public function get_meta_box_tpl() {
        return $this->meta_form_url;
    }

    public function set_meta_box_tpl($meta_form_url) {
        $this->meta_form_url = $meta_box_tpl;
        return $this;
    }

    public function __construct() {

    }

    public function add() {
        add_action("admin_init", array(&$this, "admin_init"));
        add_action('save_post', array(&$this, 'save_meta'));
        return $this;
    }

    public function admin_init() {
        //add_meta_box($id, $title, $callback, $page, $context, $priority)
        add_meta_box("{$this->meta_name}-meta", "{$this->meta_name} Options", array(&$this, "meta_options"), "product", "side", "low");
    }

    public function meta_options() {
        global $post;
        $custom = get_post_custom($post->ID);
        $meta_value = $custom["{$this->get_meta_name()}"][0];
        if (isset($this->meta_form_url) AND file_exists($this->meta_form_url)):
            include_once $this->meta_form_url;
        else :
            ?>
            <label><?php ucfirst($this->get_meta_name()) ?></label>
            <input name="<?php $this->get_meta_name() ?>" value="<?php echo $meta_value; ?>" />
        <?php
        endif;
    }

    public function save_meta() {
        global $post;
        if (is_array($this->get_meta_feilds())):
            foreach ($this->get_meta_feilds() as $key => $val):
                update_post_meta($post->ID, $key, $_POST[$value]);
            endforeach;
        else:
            update_post_meta($post->ID, $key, $_POST[$this->meta_name]);
        endif;
    }

}
