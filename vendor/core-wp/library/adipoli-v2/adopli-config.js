/**
 * The file description. *
 * @package WordPress
 * @subpackage Basejump
 * @since BJ 1.0
 * @type javascript
 * @author Shawn Sandy <shawnsandy04@gmail.com>
 */



jQuery(document).ready(function($) {

    //setup variables
    var adipoli_id, config_data, start_effect = 'normal', hover_effect ='' ;

    //get the selector name
    adipoli_id = $('.adipoli').data('slector');

    //adopli settings
    $('#image1').adipoli({
        'startEffect': start_effect,
        'hoverEffect': hover_effect
    });

    //
    console.log('Id : '+ adipoli_id);

});