<?php

/**
 * @package WordPress
 * @subpackage Toolbox
 */
class csf_showcase {

    /**
     * *********************************************************************
     * post types
     * *********************************************************************
     */
    public function post_type() {
        /**
         * custom post type template
         * http://codex.wordpress.org/Function_Reference/register_post_type
         */
        $labels = array(
            'name' => _x('Articles', 'post type general name'),
            'singular_name' => _x('Article', 'post type singular name'),
            'add_new' => _x('Add New', 'Article'),
            'add_new_item' => __('Add New Article'),
            'edit_item' => __('Edit Article'),
            'new_item' => __('New Article'),
            'view_item' => __('View Article'),
            'search_items' => __('Search Articles'),
            'not_found' => __('No Articles found'),
            'not_found_in_trash' => __('No Articles found in Trash'),
            'parent_item_colon' => '',
            'menu_name' => 'Article'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => 5,
            //'show_in_menu' => 'index.php',//for submenu
            'menu_icon' => CWP_URL .'/images/showcase.png',
            'supports' => array('title','editor','author', 'excerpt','page-attributes','thumbnail')
            //'title','editor','author','thumbnail','excerpt','comments',trackbacks,custom-fields,post-formats,revisions,page-attributes
        );
        //>>>>> change post type from Article
        register_post_type('csf_articles', $args);
    }

    /**
     * ************************messages*****************************************
     */

    /**
     * Add postype update message filter
     */
    public function update_message_filter() {
        add_filter('post_updated_messages', array(&$this, 'updated_messages'));
    }

//add filter to ensure the text Article, or Article, is displayed when user updates a Article
//add_filter('post_updated_messages', 'codex_Article_updated_messages');
    public function updated_messages($messages) {
        global $post, $post_ID;

        //************** change name here*********************
        $messages['Article'] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf(__('Article updated. <a href="%s">View Article</a>'), esc_url(get_permalink($post_ID))),
            2 => __('Custom field updated.'),
            3 => __('Custom field deleted.'),
            4 => __('Article updated.'),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf(__('Article restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__('Article published. <a href="%s">View Article</a>'), esc_url(get_permalink($post_ID))),
            7 => __('Article saved.'),
            8 => sprintf(__('Article submitted. <a target="_blank" href="%s">Preview Article</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__('Article scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Article</a>'),
                    // translators: Publish box date format, see http://php.net/date
                    date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__('Article draft updated. <a target="_blank" href="%s">Preview Article</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );

        return $messages;
    }

    /**
     * ******************************HELP**************************************
     */
    //display contextual help for Articles
    //remove comments on contextual_hel action (//) to use
    //

    public function help_text_filter() {
        add_action('contextual_help', array(&$this, 'help_text'), 10, 3);
    }

    public function help_text($contextual_help, $screen_id, $screen) {
        //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
        if ('Article' == $screen->id) {
            $contextual_help =
                    '<p>' . __('Things to remember when adding or editing a Article:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Specify the correct writer of the Article.  Remember that the Author module refers to you, the author of this Article review.') . '</li>' .
                    '</ul>' .
                    '<p>' . __('If you want to schedule the Article review to be published in the future:') . '</p>' .
                    '<ul>' .
                    '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
                    '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
                    '</ul>' .
                    '<p><strong>' . __('For more information:') . '</strong></p>' .
                    '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
                    '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>';
        } elseif ('edit-Article' == $screen->id) {
            $contextual_help =
                    '<p>' . __('This is the help screen displaying the table of Articles blah blah blah.') . '</p>';
        }
        return $contextual_help;
    }

    /**
     * ******************************TAXONMY**********************************
     */
    function taxonomy_showcases() {

        /**
         * *******************************************
         */
        $labels = array(
            'name' => _x('Article Categories', 'Article Categories'),
            'singular_name' => _x('Article Category', 'Article Category'),
            'search_items' => __('Search Articles'),
            'popular_items' => __('Popular Articles'),
            'all_items' => __('All Articles'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Article Categories'),
            'update_item' => __('Update Article Categories'),
            'add_new_item' => __('Add New Article Category'),
            'new_item_name' => __('New Article Name'),
            'separate_items_with_commas' => __('Separate Categories with commas'),
            'add_or_remove_items' => __('Add or remove Articles'),
            'choose_from_most_used' => __('Choose from the most used Articles'),
            'menu_name' => __('Articles Tags'),
        );

        register_taxonomy('csf_showcases_tags', array('csf_showcase'), array(
            'public' => true,
            'labels' => $labels,
            'hierarchical' => true
             )
        );
    }

    /**
     * *************************************************************************
     * meta boxes
     * *************************************************************************
     */
    public function Article_options_meta() {
        $csf_options_meta = new MetaBox(array(
                    'id' => 'Article-options',
                    'title' => 'Article Options',
                    'types' => array('csf_Article'), //
                    'context' => 'side', //side, advance, normal
                    'priority' => 'high', //low , high
                    'template' => MTS_PATH . '/includes/Article-options.php', //meta from
                    'autosave' => TRUE
                ));
    }

}