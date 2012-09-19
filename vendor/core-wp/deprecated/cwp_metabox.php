<?php
/**
 * Description of alchemy
 *
 * @author Studio365
 */
require_once CWP_PATH . "/includes/wpalchemy/MetaBox.php";
require_once CWP_PATH . "/includes/wpalchemy/MediaAccess.php";

class cwp_metabox {

    //put your code here
    public function __construct() {
        //$this->register_style();
        add_action('init', array(&$this, 'register_style'));
    }

    public function register_style() {
        wp_register_style('alchemy-meta', CWP_URL . "/includes/wpalchemy/metaboxes/meta.css");
    }

    public static function print_style() {
        wp_print_styles('alchemy-meta');
    }

    public static function ui_metabox_style() {
        //alchemy_setup::print_style();
        echo "<link rel='stylesheet' id='alchemy'  href='" . CWP_URL . "'/includes/wpalchemy/metaboxes/meta.css' type='text/css' media='screen' />";
    }

    private
    $types = array('post'),
    $context = 'side',
    $priority = 'low',
    $mode = WPALCHEMY_MODE_ARRAY,
    $prefix = null,
    $init_action = null,
    $save_action = null,
    $save_filter = null,
    $head_action = array('cwp_metabox', 'print_style'),
    $foot_action = null,
    $lock = NULL,
    $autosave = false;

    public function setTypes($types) {
        $this->types = $types;
        return $this;
    }

    public function setContext($context) {
        $this->context = $context;
        return $this;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
        return $this;
    }

    /**
     *
     * @param type $mode
     * @return cwp_metabox
     */
    public function setMode($mode) {
        $this->mode = $mode;
        return $this;
    }

    public function setPrefix($prefix) {
        $this->prefix = $prefix;
        return $this;
    }

    public function setInit_action($init_action) {
        $this->init_action = $init_action;
        return $this;
    }

    public function setSave_action($save_action) {
        $this->save_action = $save_action;
        return $this;
    }

    public function setSave_filter($save_filter) {
        $this->save_filter = $save_filter;
        return $this;
    }

    public function setHead_action($head_action) {
        $this->head_action = $head_action;
        return $this;
    }

    public function setFoot_action($foot_action) {
        $this->foot_action = $foot_action;
        return $this;
    }

    public function setLock($lock) {
        $this->lock = $lock;
        return $this;
    }

    public function setAutosave($autosave) {
        $this->autosave = $autosave;
        return $this;
    }

    /**
     * Gives a Description of the product additionals images, details etc
     * @param type $id
     * @param type $template_name
     * @return string
     */
    public function meta_args($id='_meta_', $title="Description", $template_name = 'meta_tpl') {
        $mp_args = array(
            'id' => $id,
            'title' => $title,
            'types' => $this->types, // added only for pages and to custom post type "events"
            'context' => $this->context, // same as above, defaults to "normal" (‘normal’, ‘advanced’, or ‘side’)
            'priority' => $this->priority, // same as above, defaults to "high" (‘high’ or ‘low’)
            'mode' => $this->mode, // defaults to WPALCHEMY_MODE_ARRAY / WPALCHEMY_MODE_EXTRACT
            'template' => get_stylesheet_directory() . "/tpl/metabox/{$template_name}.php",
            'init_action' => $this->init_action, // runs only when metabox is present - defaults to NULL
            'lock' => $this->lock, // defaults to NULL ; WPALCHEMY_LOCK_XXX  (“top”, “bottom”, “before_post_title”, “after_post_title”)
            'prefix' => $this->prefix, // defaults to NULL
            'head_action' => array('cwp_metabox', 'print_style'), //run your head action
            'save_filter' => $this->save_filter, //
            'foot_action' => $this->foot_action,
            'autosave' => $this->autosave
        );
        return $mp_args;
    }

    public function input($field, $description='') {
        ?>
        <?php $mb->the_field($field); ?>
        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <?php if (isset($description)): ?>
            <span id="<?php echo $field . '-id' ?>" class="description">
            <?php echo $description; ?>
            </span>
            <?php endif ?>
        <?php
    }

    public function textarea($field, $description=null) {
        ?>
        <?php $mb->the_field($field); ?>
        <textarea name="<?php $metabox->the_name(); ?>" rows="3"><?php $metabox->the_value(); ?></textarea>
        <?php if (isset($description)): ?>
            <span id="<?php echo $field . '-id' ?>" class="description">
            <?php echo $description; ?>
            </span>
            <?php endif ?>

        <?php
    }

    public function checkbox($field, $value='', $description=null) {
        ?>
        <?php $mb->the_field($field); ?>
        <input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo $value ?>"<?php $mb->the_checkbox_state($value); ?>/>
        <?php echo ucfirst($value) ?>
        <br/>
        <?php if (isset($description)): ?>
            <span id="<?php echo $field . '-id' ?>" class="description">
            <?php echo $description; ?>
            </span>
        <?php endif ?>
        <?php
    }

    public function select($field, $array=array(), $description=null) {
        ?>
        <?php $mb->the_field($field); ?>
        <select name="<?php $mb->the_name(); ?>">
            <option value="">Select...</option>
        <?php if (is_array($array)) : ?>
            <?php foreach ($array as $key => $value): ?>
                    <option value="<?php echo $value ?>" <?php $mb->the_select_state($value); ?>>
                <?php echo $key ?>
                    </option>
                <?php endforeach; ?>
            <?php endif ?>
        </select>
                <?php if (isset($description)): ?>
            <span id="<?php echo $field . '-id' ?>" class="description"><?php echo $description; ?></span>
            <?php endif ?>

        <?php
    }

    public function radio($field,$value='',$description=null) {
        ?>
        <?php $mb->the_field($field); ?>
            <input type="radio" name="<?php $mb->the_name(); ?>" value="<?php echo $value ?>"<?php $mb->the_radio_state($value); ?>/>
            <?php echo ucfirst($value) ?><br/>
        <?php if (isset($description)): ?>
            <span id="<?php echo $field . '-id' ?>" class="description">
            <?php echo $description; ?>
            </span>
        <?php endif ?>
        <?php
    }

    public function xxxxx($field, $description=null) {
        ?>
        <?php $mb->the_field($field); ?>

        <?php if (isset($description)): ?>
            <span id="<?php echo $field . '-id' ?>" class="description">
            <?php echo $description; ?>
            </span>
        <?php endif ?>
        <?php
    }

}

