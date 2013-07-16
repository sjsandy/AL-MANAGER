/**
 * The file description. *
 * @package WordPress
 * @subpackage Basejump
 * @since BJ 1.0
 * @type javascript
 * @author Shawn Sandy <shawnsandy04@gmail.com>
 */

jQuery(document).ready(function($) {

    var config, slider, prev = 'Prev', next = 'Next';

//slider container name
    config = $('.nivo-config').data('nivo-id');

    if ($(config).data('prev'))
        prev = $(config).data('prev');
    if ($(config).data('next'))
        next = $(config).data('next');

    $(config).nivoSlider({
        effect: $(config).data('effect'), // Specify sets like: 'fold,fade,sliceDown'
        slices: $(config).data('slices'), // For slice animations
        boxCols: $(config).data('cols'), // For box animations
        boxRows: $(config).data('rows'), // For box animations
        animSpeed: $(config).data('speed'), // Slide transition speed
        pauseTime: $(config).data('pause-time'), // How long each slide will show
        startSlide: $(config).data('start-slide'), // Set starting Slide (0 index)
        directionNav: $(config).data('direction-nav'), // Next & Prev navigation
        controlNav: $(config).data('nav'), // 1,2,3... navigation
        controlNavThumbs: $(config).data('thumbs'), // Use thumbnails for Control Nav
        pauseOnHover: $(config).data('pause-on-hover'), // Stop animation while hovering
        manualAdvance: $(config).data('manual'), // Force manual transitions
        prevText: prev, // Prev directionNav text
        nextText: next, // Next directionNav text
        randomStart: $(config).data('random-start') // Start on a random slide
    });

    console.log(config);

});
