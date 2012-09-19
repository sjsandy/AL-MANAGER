<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cwp_social
 *
 * @author Studio365
 */
class cwp_social {

    //@todo modify/add network_id default (key /id)

    function __construct() {

    }

    public static function factory() {
        return new cwp_social;
    }

    public static function parse_feed($feed=null) {

        $stepOne = explode("<content type=\"html\">", $feed);
        $stepTwo = explode("</content>", $stepOne[1]);
        $tweet = $stepTwo[0];
        $tweet = str_replace('&lt;', '<', $tweet);
        $tweet = str_replace('&gt;', '>', $tweet);
        return $tweet;
    }

    public static function last_tweet($username, $prefix='', $suffix='') {
        $feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1";
        // Prefix - some text you want displayed before your latest tweet.
        // (HTML is OK, but be sure to escape quotes with backslashes: for example href=\"link.html\")
        //$prefix = "";
        // Suffix - some text you want display after your latest tweet. (Same rules as the prefix.)
        //$suffix = "";
        $twitterFeed = file_get_contents($feed);
        echo stripslashes($prefix) . self::parse_feed($twitterFeed) . stripslashes($suffix);
    }

    /**
     *
     * @param strig $username twitter user name
     */
    public static function latest_tweet($username) {
        include_once(ABSPATH . WPINC . '/class-simplepie.php');
        $tweet = fetch_rss("http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1");
        echo $tweet->items[0]['atom_content'];
    }

    public static function extra_contact_info($contactmethods) {

        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['feedburner_page'] = 'Feedburner Url';
        $contactmethods['facebook'] = 'Facebook Url';
        $contactmethods['facebook_page'] = 'Facebook Fan Page';
        $contactmethods['twitter'] = 'Twitter Url';
        $contactmethods['twitter_user'] = 'Twitter Username';
        $contactmethods['linkedin'] = 'LinkedIn';
        $contactmethods['flickr'] = 'Flickr Url';
        $contactmethods['blog'] = 'Blog Url';
        $contactmethods['tumblr'] = 'Tumblr';
        $contactmethods['telephone'] = 'Telephone';
        $contactmethods['cell'] = 'Cellular';
        return $contactmethods;
    }

    public static function contact_info() {
        //http://www.wprecipes.com/how-to-easily-modify-user-contact-info
        //http://thomasgriffinmedia.com/blog/2010/09/how-to-add-custom-user-contact-info-in-wordpress/
        //the_author_meta('facebook', $current_author->ID);
        add_filter('user_contactmethods', array('cwp_social', 'extra_contact_info'));
    }

    /**
     *
     * @param string $name -- twitter, facebook, google_plus, linkedin, feedburner_page
     */
    public static function connections($name=null) {
        $link = false;
        $theme_admin = (cwp::theme_options('themeadmin') ? cwp::theme_options('themeadmin') : 1);
        if (isset($name)):
            $link = the_author_meta($name, $theme_admin);
        endif;
        return $link;
    }

    /**
     *
     * @param type $user_id
     * @return string feed subscriptions url for verification
     */
    public static function feedburner_subscriptions($user_id=1) {
        $feed = get_the_author_meta('feedburner_page', $user_id);
        //$r = explode('=', $feed);
        return "http://feedburner.google.com/fb/a/mailverify?uri={$feed}";
    }

    public static function feedburner_url($user_id=1) {
        $feed = the_author_meta('feedburner_url', $user_id);
        $r = explode('=', $feed);
        return $feed;
    }

    public static function google_plusone($content) {
        $content = $content . '<div class="plusone"><g:plusone size="tall" href="' . get_permalink() . '"></g:plusone></div>';
        return $content;
    }

    public static function google_plusone_script() {
        wp_enqueue_script('google-plusone', 'https://apis.google.com/js/plusone.js', array(), null);
    }

    public static function add_plus_one() {
        add_action('wp_enqueue_scripts', array('cwp_social', 'google_plusone_script'));
        add_filter('the_content', array('cwp_social', 'google_plusone'));
    }

    public static function plusone() {
        self::google_plusone_script();
        $content = '<div class="plusone"><g:plusone size="tall" href="' . get_permalink() . '"></g:plusone></div>';
        return $content;
    }

    /**
     *
     * FB html5 share
     * @param Array $data - href,faces,width,font
     * @return type output html/js
     */
    public static function fb_like($data=null) {
        $faces = isset($data['faces']) ? $data['faces'] : 'true';
        $href = isset($data['href']) ? $data['href'] : site_url();
        $width = isset($data['width']) ? $data['width'] : '450';
        $font = isset($data['font']) ? $data['font'] : 'arial';
        ob_start();
        ?>
        <div class="fb-like" data-href="<?php echo esc_attr($href) ?>"data-send="true" data-width="<?php echo ecs_attr($width) ?>"
             data-show-faces="<?php echo esc_attr($faces) ?>" data-font="<?php echo esc_attr($font) ?>"></div>
             <?php
             return ob_get_clean();
         }

         /**
          * FB html5 share
          * Include the JavaScript SDK on your page once, ideally right after the opening <body> tag.
          * @param type $app_id
          * @return html/js
          */
         public static function fb_js($app_id=null) {
             ob_start();
             ?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo esc_attr($app_id) ?>";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <?php
        return ob_get_clean();
    }

    public static function sfc_like_button() {
        if (function_exists('sfc_like_button')) {
            sfc_like_button();
        } else {
            echo _e('Please install Simple Facebook Connect', 'corewp');
        }
    }

    public static function sfc_share_button() {
        if (function_exists('sfc_share_button')):
            sfc_share_button();
        else :
            echo _e('Please install Simple Facebook Connect', 'corewp');
        endif;
    }


   /**
    *
    * @global type $post
    * @param type $text default post title or site desctiption;
    * @param type $hashtags default sitename
    * @param type $via
    * @param type $btn_title
    */
    public static function twitter_button($text=null, $hashtags=null, $via=null,  $btn_title='Tweet') {
        global $post;
        if (!isset($via)) $via = get_bloginfo('name');
        if(!isset($text)) $text = get_the_title($post->ID) ? get_the_title($post->ID) : get_bloginfo('description') ;
        if(!isset($hashtags)) $hashtags = get_bloginfo('hashtags');
        ?>
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $text; ?>" data-via="@<?php echo $via; ?>" data-size="large" data-hashtags="<?php echo $hashtags; ?>">

        <?php echo $btn_title; ?> </a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <?php
    }

    public static function fb_comment_script() {
        $app_id = cwp::theme_options('fbappid');
        if($app_id AND !empty($app_id)):

       ?>
       <div id="fb-root"></div>
        <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $app_id; ?>";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>
        <?php

        endif;
    }

    /**
     * adds a facebook comment to your to your theme/page
     * <code>
     * <?php
     * $title "Comment and Share on Facebook"
     * cwp_social::fb_comment($title);
     * ?>
     * </code>
     * @param string $title
     * @param string $url -
     * @param init $post
     * @param init $width
     * @param string $colorscheme
     */
    public static function fb_comment($title = "Share your comment with us via Facebook", $url = null, $post = 10, $width = 600, $colorscheme = 'light') {
                $siteurl = isset($url) ? $url : get_permalink();
                add_action('wp_footer', array('cwp_social', 'fb_comment_script'));

                ob_start();
                ?>
                <div class="fb-comment-box">
                 <h3><?php echo $title ?></h3>
                        <div class="fb-comments" data-href="<?php echo $siteurl ?>" data-num-posts="<?php echo $post ?>" data-colorscheme="<?php echo $colorscheme ?>" data-width="<?php echo $width ?>"></div>
                </div>

        <?php
        return $content = ob_get_clean();
    }

     /**
     *
     * @param type $url_value link text or image value -default 1
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
     public static function twitter_link($url_value = 'l', $class_attr = 'social-icons font-large') {
        self::social_links('twitter',$url_value, $class_attr);
    }

     /**
     *
     * @param type $url_value link text or image value -default f
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function facebook_link($url_value = 'f', $class_attr = 'social-icons font-large') {
         self::social_links('facebook',$url_value, $class_attr);
    }

     /**
     *
     * @param type $url_value link text or image value -default g
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function gplus_link($url_value = 'g', $class_attr = 'social-icons font-large') {
         self::social_links('google_plus',$url_value, $class_attr);
    }



     /**
     *
     * @param type $url_value link text or image value -default i
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function linkedin_link($url_value = 'i', $class_attr = 'social-icons font-large') {

        self::social_links('linkedin',$url_value, $class_attr);
    }

     /**
     *
     * @param type $url_value link text or image value -default r
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function rss_link($url_value = 'r', $class_attr = 'social-icons font-large') {
         self::social_links('feedburner_page',$url_value, $class_attr);
    }

     /**
     *
     * @param type $url_value link text or image value -default 1
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function flickr_link($url_value = 'l', $class_attr = 'social-icons font-large') {
        self::social_links('twitter',$url_value, $class_attr);
    }

    /**
     *
     * @param type $network social network value - default twitter
     * @param type $url_value link text or image value -default 1
     * @param type $class_attr link class attributes - default 'social-icons font-large'
     */
    public static function social_links($network='twitter',$url_value = 'l', $class_attr = 'social-icons font-large') {

        ob_start()
        ?>
                     <a href="<?php the_author_meta($network, cwp_themeadmin()); ?>">
                         <span class="<?php echo $class_attr ?>"><?php echo $url_value ?></span>

                     </a>
        <?php
        echo $link = ob_get_clean();
    }


}

