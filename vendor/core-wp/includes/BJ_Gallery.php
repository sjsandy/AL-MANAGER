<?php

/**
 * The file description. *
 * @package BJ
 * @since BJ 1.0
 */


/**
 * Adds gallery to your posts
 * based on otto's photo gallery primer
 * @link http://ottopress.com/2011/photo-gallery-primer/
 */
class BJ_Gallery extends BJ_POSTDATA {

    private $ID = null,
            $order = 'ASC',
            $total_thumbnails,
            $post_type = 'post';

    public function get_post_type() {
        return $this->post_type;
    }

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
    }

    public function set_ID($ID) {
        $this->ID = $ID;
        return $this;
    }

    public function set_order($order) {
        $this->order = $order;
        return $this;
    }

    public function set_total_thumbnails($total_thumbnails) {
        $this->total_thumbnails = $total_thumbnails;
        return $this;
    }

    public function get_total_thumbnails() {
        return $this->total_thumbnails;
    }



    function __construct() {
        parent::__construct();
        $this->set_template_slug('gallery');
    }


    public static function factory(){
        return $factory = new BJ_Gallery();
    }



    public function gallery_thumbnails() {

        global $post;

        //if $ID NULL use the global post->ID
        if (!isset($this->ID))
            $this->ID = $post->ID;
        //get the post thumbnail ID
        $thumb_id = get_post_thumbnail_id($this->ID);
        //image query
        $images = new WP_Query(array(
                    'post_parent' => $this->ID,
                    'post_status' => 'inherit',
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'order' => $this->order,
                    'orderby' => 'menu_order ID',
                    'posts_per_page' => $this->get_post_per_page(),
                    'post__not_in' => array($thumb_id),
                    'update_post_term_cache' => false,
                ));

        $imagedata = $images->posts;
        $this->total_thumbnails = $images->found_posts+1;
        return $imagedata;
    }


    /**
     * Display thumbnails from your gallery that links to full size image
     * @param string $thumbnail_size
     */
    public function thumbnails($thumbnail_size = 'gallery-tumbnail') {
        $images = $this->gallery_thumbnails();
        foreach ($images as $image) {
            echo '<a href="' . get_permalink($image->ID) . '">' . wp_get_attachment_image($image->ID, $thumbnail_size) . '</a>';
        }
    }



    /**
     * Get exif data from photos
     * @global type $post
     * @param string $exif_info default is camera
     * @param type $post_id
     * @return type
     */
    public function exif_data($exif_info = 'camera', $post_id = null) {

        global $post;

        if (!isset($post_id))
            $post_id = $post->ID;

        $imagemeta = wp_get_attachment_metadata($post_id);

        if ($exif_info = 'shutter_speed'):
            // shutter speed handler
            if ((1 / $imagemeta['image_meta']['shutter_speed']) > 1) {
                echo "1/";
                if (number_format((1 / $imagemeta['image_meta']['shutter_speed']), 1) == number_format((1 / $imagemeta['image_meta']['shutter_speed']), 0)) {
                    echo number_format((1 / $imagemeta['image_meta']['shutter_speed']), 0, '.', '') . ' sec';
                } else {
                    return number_format((1 / $imagemeta['image_meta']['shutter_speed']), 1, '.', '') . ' sec';
                }
            } else {
                return $imagemeta['image_meta']['shutter_speed'] . ' sec';
            }

        else:
            return $imagemeta['image_meta']["{$exif_info}"];

        endif;
    }



    /**
     * Displays the photo exif data in your theme
     * @param type $post_id
     */
    public function display_exif($post_id = null) {
        ?>
        <span class="exif created">Created: <?php echo date("d-M-Y", $this->exif_data('created_timestamp', $post_id)); ?></span>
        <span class="exif camera">Camera: <?php echo $this->exif_data('camera', $post_id) ?></span>
        <span class="exif focal-length">Focal Length: <?php echo $this->exif_data('focal_length', $post_id) ?></span>
        <span class="exif aperture">Aperture: <?php echo $this->exif_data('aperture', $post_id) ?></span>
        <span class="exif iso">ISO: <?php echo $this->exif_data('iso', $post_id) ?></span>
        <span class="exif shutter-speed">Shutter Speed: <?php echo $this->exif_data('shutter_speed', $post_id) ?></span>
        <?php
    }

    /**
     * Creates a loop for post-format-gallery / category gallery on gallery page(s)
     * @global type $query_string
     */
    public function gallery_loop() {
        //make sure the query string is available
        global $query_string;

        $args = wp_parse_args($query_string);

        $query = array(
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'post_format',
                    'terms' => array('post-format-gallery'),
                    'field' => 'slug',
                ),
                array(
                    'taxonomy' => 'category',
                    'terms' => array('gallery'),
                    'field' => 'slug',
                ),
            ),
            'paged' => $args['paged'],
            'post_type' => $this->post_type,
        );

        $this->set_query($query);

        $this->loop();

    }

}
