/**
 * 
 *
 */

jQuery(document).ready(function($) {

//variables
    var config_data, photoset = '.photoset-grid', rel = 'photoset-gallery', gutter = '5px';

//if data attribute exist assign to data variable
    if ($('.photoset-config').data('photoset-id'))
        photoset = $('.photoset').data('photoset-id');

//find rel
    if ($(photoset).attr('data-rel'))
        rel = $(photoset).attr('data-rel');

//find gutter
    if ($(photoset).data('gutter'))
        gutter = $(photoset).data('gutter');

//photoset settings
    $(photoset).photosetGrid({
        width: '100%',
        gutter: gutter,
        highresLinks: true,
        rel: rel,
        onComplete: function() {
            //$(photoset).attr('style', '');
            $(photoset + ' a').colorbox({
                photo: true,
                scalePhotos: true,
                maxHeight: '90%',
                maxWidth: '90%',
                rel: rel
            });
        }
    });

//console logging tests
    console.log('data - ' + photoset);
    console.log('gutter - ' + gutter);
    console.log($(photoset).find('img').length);

});