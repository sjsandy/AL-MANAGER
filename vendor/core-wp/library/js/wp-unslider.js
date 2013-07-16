/**
 * The file description. *
 * @package WordPress
 * @subpackage Basejump
 * @since BJ 1.0
 * @type Javascript
 * @author Shawn Sandy <shawnsandy04@gmail.com>
 */

jQuery(document).ready(function($) {

//    the slider wrapper
    var unslider = $('.unslider');
//    slider element
    var slider_id = unslider.data('slider');

    var slider_options = $(slider_id);
//    slider

//defauts settings
    var speed = 500, delay = 5000, type = 'full', keys = true, dots = true, fluid = true;
//options grabbed from data(attributes)
    if (slider_options.data('speed'))
        speed = slider_options.data('speed');
    if (slider_options.data('delay'))
        delay = slider_options.data('delay');
    if (slider_options.data('type'))
        type = slider_options.data('type');

//go with the basic slider if type = basic;


    if (type === 'basic') {
        keys = false;
        dots = false;
        fluid = false;
    }
    
    $(slider_options).unslider({
        speed: speed, //  The speed to animate each slide (in milliseconds)
        delay: delay, //  The delay between slide animations (in milliseconds)
        complete: function() {
        }, //  A function that gets called after every slide animation
        keys: keys, //  Enable keyboard (left, right) arrow shortcuts
        dots: dots, //  Display dot navigation
        fluid: fluid //  Support responsive design. May break non-responsive designs
    });

//    console.log('speed: ' + speed);
//    console.log('delay ' +delay);
//    console.log('id' + slider_id);
});
