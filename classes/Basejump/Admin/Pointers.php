<?php


/**
 * Description of Pointers
 *
 * @author studio
 * @link http://bavotasan.com/2013/working-with-custom-admin-pointers-in-wordpress/ -original code used in theis script here
 */
class Basejump_Admin_Pointers {

    private $pointer_id,
            $pointer_anchor,
            $position = 'left',
            $align = 'center',
            $title,
            $content;



    public function set_title($title) {
        $this->title = $title;
        return $this;
    }


    public function set_content($content) {
        $this->content = $content;
        return $this;
    }

    public function set_pointer_id($pointer) {
        $this->pointer_id = $pointer;
        return $this;
    }


    public function set_pointer_anchor($pointer_anchor) {
        $this->pointer_anchor = $pointer_anchor;
        return $this;
    }


    public function set_position($position) {
        $this->position = $position;
        return $this;
    }


    public function set_align($align) {
        $this->align = $align;
        return $this;
    }

    function __construct() {

    }

    static function factory() {
        $factory = new Basejump_Admin_Pointers;

        return $factory;
    }

    function add_pointer(){
        add_action( 'admin_enqueue_scripts',  array($this,'scripts') );
    }

    function scripts() {
        if ($this->admin_pointers_check()) {
            add_action('admin_print_footer_scripts', array($this,'admin_footer'));
            wp_enqueue_script('wp-pointer');
            wp_enqueue_style('wp-pointer');
        }
    }

    function admin_pointers_check() {
        $admin_pointers = $this->admin_pointers();
        foreach ($admin_pointers as $pointer => $array) {
            if ($array['active'])
                return true;
        }
    }

    function admin_footer() {
        $admin_pointers = $this->admin_pointers();
        ?>
        <script type="text/javascript">
            /* <![CDATA[ */
            ( function($) {
        <?php
        foreach ($admin_pointers as $pointer => $array) {
            if ($array['active']) {
                ?>
                                 $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
                                     content: '<?php echo $array['content']; ?>',
                                     position: {
                                         edge: '<?php echo $array['edge']; ?>',
                                         align: '<?php echo $array['align']; ?>'
                                     },
                                     close: function() {
                                         $.post( ajaxurl, {
                                             pointer: '<?php echo $pointer; ?>',
                                             action: 'dismiss-wp-pointer'
                                         } );
                                     }
                                 } ).pointer( 'open' );
                <?php
            }
        }
        ?>
               } )(jQuery);
               /* ]]> */
        </script>
        <?php

    }

    function admin_pointers() {

        $dismissed = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
        $version = '1_0'; // replace all periods in 1.0 with an underscore


        $pointer_content = "<h3>{$this->title }</h3>";
        $pointer_content .= "<p>{$this->content}</p>";

        return array(
            $this->pointer_id . 'new_items' => array(
                'content' => $pointer_content,
                'anchor_id' => $this->pointer_anchor,
                'edge' => $this->position,
                'align' => $this->align,
                'active' => (!in_array($this->pointer_id . 'new_items', $dismissed))
            ),
        );

    }

}