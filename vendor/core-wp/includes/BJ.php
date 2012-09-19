<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bj_template
 *
 * @author studio
 */
class BJ {

    public function __construct() {

    }

    /**
     * Displays themes site logo
     * @param type $img_url default logo img url
     * @return string hmtl img of site name or set $img_url
     */
    public static function site_logo($img_url = null) {
        $logo = get_theme_mod('bjc_logo');
        if (!empty($logo)):
            return '<figure class="site-logo"><img src="' . $logo . '" alt="' . get_bloginfo('name') . '"  ></figure>';
        elseif (isset($img_url)):
            return '<figure class="site-logo"><img src="' . $img_url . '" alt="' . get_bloginfo('name') . '"  ></figure>';
        else :
            return get_bloginfo('name');
        endif;
    }

    public static function footer_info() {
        ?>
        <?php do_action('bj_credits'); ?>
        <p class="footer-slug">
            <?php echo esc_textarea($bjc_fslug = get_theme_mod('bjc_footer_slug')); ?>
        </p>
        <p class="copyrignt-info">
        <p class="copyright">&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>.
            <?php echo esc_textarea($bjc_cslug = get_theme_mod('bjc_copyright_slug', __('All rights reserved', 'bj'))); ?>

        </p>

        </p>

        <!-- ###### -->

        <?php
        $bjc_copyinfo = get_theme_mod('bjc_enable_copyinfo');
        if (empty($bjc_copyinfo)):
            ?>
            <a href="http://wordpress.org/" title="<?php esc_attr_e('A Semantic Personal Publishing Platform', 'bj'); ?>" rel="generator"><?php printf(__('Proudly powered by %s', 'bj'), 'WordPress'); ?></a>
            <span class="sep"> | </span>
            <?php printf(__('Theme: %1$s by %2$s.', 'bj'), 'bj', '<a href="http://shawnsandy.com/" rel="designer">ShawnSandy.com</a>'); ?>
        <?php else : ?>
            <!--     <?php printf(__('Proudly powered by %s', 'bj'), 'WordPress'); ?>      -->
            <!--     <?php printf(__('Theme: %1$s by %2$s.', 'bj'), 'bj', '<a href="http://shawnsandy.com/" rel="designer">ShawnSandy.com</a>'); ?>       -->
        <?php endif; ?>
        <?php
    }

    public static function contact_org() {
        ?>

        <address>
            <span class="bjc-contact-message">
                <?php echo get_theme_mod('bjc_contact_message') ?></br>
            </span>
            <strong><?php echo get_theme_mod('bjc_org_name'); ?></strong><br>
            <?php echo get_theme_mod('bjc_contact_address') ?>
            <br>
            <?php echo get_theme_mod('bjc_contact_city') . '  ' . get_theme_mod('bjc_contact_zip') . ' ' . get_theme_mod('bjc_contact_zip'); ?>
            <br>
            <abbr title="Phone">P:</abbr> <?php echo get_theme_mod('bjc_contact_tel'); ?>
        </address>

        <?php
    }

    public static function contact_author() {
        global $post;
        $author = $post->post_author;
        ?>
        <address>
            <strong><?php echo get_the_author_meta('first_name', $author) . ' ' . get_the_author_meta('last_name', $author); ?></strong><br>
            <a href="mailto:#"><?php echo antispambot(get_the_author_meta('user_email', $author)); ?></a>
        </address>
        <?php
    }

    public static function flickr_badge($flickrID = null, $postcount = 9, $display = 'latest', $type = 'user') {
        if (isset($flickrID)):
            ?>
            <div id="bj-flickr-badge">
                <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
            </div>
            <?php
        else :
            echo "Flickr ID required";
        endif;
    }

    public static function locate_uri($template_names, $dir_path = NULL) {
        $located = FALSE;
        foreach ((array) $template_names as $template_name) {
            if (!$template_name)
                continue;
            if (file_exists(get_stylesheet_directory() . '/' . $template_name)) {
                $located = get_stylesheet_directory_uri() . '/' . $template_name;
                break;
            } else if (file_exists(get_template_directory() . '/' . $template_name)) {
                $located = get_template_directory_uri() . '/' . $template_name;
                break;
            }
        }
        return $located;
    }

    public static function fixie($element = null) {

        wp_enqueue_script('fixie');

        switch ($element) {
            case 'h1':
                $content = '<h1 class="fixie"></h1>';
                break;
            case 'h2':
                $content = '<h2 class="fixie"></h2>';
                break;
            case 'h3':
                $content = '<h31 class="fixie"></h3>';
                break;
            case 'h4':
                $content = '<h4 class="fixie"></h4>';
                break;
            case 'h5':
                $content = '<h5 class="fixie"></h5>';
                break;
            case 'h6':
                $content = '<h6 class="fixie"></h6>';
                break;
            case 'article' :
                $content = '<article class="fixie"></article>';
                break;
            case 'section':
                $content = '<section class="fixie"></section>';
                break;
            case 'a':
                $content = '<a class="fixie"></a>';
                break;
            default:
                $content = '<p class="fixie"></p>';
                break;
        }
        echo $content;
    }

    /**
     * Display a place holder images in your blog
     * use array with sizes for desktop tablet and phone required to display on each device
     * @param array $size : array( 'desktop' => '300x200', 'tablet' => '300x200', 'phone' => '300x200' )
     * @param string $color : #000:#fff (background/foreground)
     * @param string $text
     */
    public static function img_placeholder($size = array('desktop' => '300x200'), $color = '#000:#fff', $text = 'SAMPLE-IMAGE') {
        //@link http://imsky.github.com/holder/

        wp_enqueue_script('holder-js');

        if (isset($size['desktop']))
            echo $content = '<figure class="img-placeholder visible-desktop" ><img  data-src="holder.js/' . $size['desktop'] . '/' . $color . '/' . $text . '"></figure>';

        if (isset($size['tablet']))
            echo $content = '<figureclass="img-placeholder visible-tablet" ><img  data-src="holder.js/' . $size['tablet'] . '/' . $color . '/' . $text . '"></figure>';

        if (isset($size['phone']))
            echo $content = '<figure class="img-placeholder visible-phone" ><img  data-src="holder.js/' . $size['phone'] . '/' . $color . '/' . $text . '"></figure>';
    }

    /**
     * display a default post thumbnail.
     */
    public static function default_post_thumbanils() {
        add_filter('post_thumbnail_html', array('BJ', 'default_thumbnail'));
    }

    function default_thumbnail($html) {
        if (empty($html))
            $html = '<figure class="defautl-post-thumbnail">';
        $html .= '<img src="' . trailingslashit(get_stylesheet_directory_uri()) . 'images/default-thumbnail.png' . '" alt="" />';
        $html .='</figure>';
        return $html;
    }

    public static function posts_summary($ps_query = null, $length = 55) {
        if (!isset($ps_query))
            $q_args = array('showposts' => 5, 'post__not_in' => get_option('sticky_posts'));
        $q_args = $ps_query;
        $t_query = new WP_Query($q_args);
        if ($t_query->have_posts()):
            while ($t_query->have_posts()):
                $t_query->the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'general');

//                if ($tpl_slug == 'post_type')
//                    $tpl_slug = $post_type;
//                if ($tpl_slug == 'format')
//                    $tpl_slug = $post_format;
//
//                $slug = isset($tpl_slug) ? $tpl_slug : 'base';
//                $name = isset($tpl_name) ? $tpl_name : 'general';
                //cwp_layout::tpl_part($slug, $name);
                ?>

                <div class="post-summary">
                    <!-- ###### -->
                    <h3 class="post-summary-title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>">
                            <?php the_title() ?>
                        </a>
                    </h3>
                    <p class="post-summary">
                        <?php echo wp_trim_words($text = get_the_excerpt(), $length); ?>
                    </p>
                </div>
                <!-- ###### -->
                <?php
            endwhile;
        else :
            cwp_layout::tpl_part(null, $def_tpl);
        endif;
        wp_reset_postdata();
    }


    public static function image_navigation() {
                        ?>
                        <nav id="image-navigation">
                	<span class="previous-image"><?php previous_image_link(false, __('&larr; Previous', '_s')); ?></span>
                	<span class="next-image"><?php next_image_link(false, __('Next &rarr;', '_s')); ?></span>
                	</nav><!-- #image-navigation -->

        <?php
    }

}
