<?php

/**
 * Description of cwp_social_fb
 *
 * @author Studio365
 */
class cwp_social_fb {
    //put your code here

    private static $appID;

    public function __construct() {

    }

    public static function factory(){
        return new cwp_social_fb();
    }

    /**
     *
     * FB html5 share
     * @param Array $data - href,faces,width,font
     * @return type output html/js
     *
     */
    public function fb_like($data=null) {
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
    public function fb_script() {
        $app_id = cwp::theme_options('fbappid');
        if ($app_id AND !empty($app_id)):
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
     * <?php
     * $title "Comment and Share on Facebook"
     * cwp_social_fb::factory('010101010','So what do you think',800,5,'dark);
     * ?>
     * @param type $app_id
     * @param type $title
     * @param type $width
     * @param type $post
     * @param type $colorscheme
     * @param type $url
     * @return type
     */
    public function fb_comment($title = "Share your thoughts", $width = 600, $post = 10, $colorscheme = 'light', $url = null) {
                $siteurl = isset($url) ? $url : get_permalink();
                add_action('wp_footer', array($this, 'fb_script'));
                ob_start();
                ?>
                <div class="fb-comment-box">
                 <h3><?php echo $title ?></h3>
                        <div class="fb-comments" data-href="<?php echo $siteurl ?>" data-num-posts="<?php echo $post ?>" data-colorscheme="<?php echo $colorscheme ?>" data-width="<?php echo $width ?>"></div>
                </div>

        <?php
        return $content = ob_get_clean();
    }


}

?>
