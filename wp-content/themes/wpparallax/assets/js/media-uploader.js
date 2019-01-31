jQuery(document).ready(function($){

var wpparallax_upload;
var wpparallax_selector;

function wpparallax_add_file(event, selector) {

    var upload = $(".uploaded-file"), frame;
    var $el = $(this);
    wpparallax_selector = selector;

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( wpparallax_upload ) {
        wpparallax_upload.open();
    } else {
        // Create the media frame.
        wpparallax_upload = wp.media.frames.wpparallax_upload =  wp.media({
            // Set the title of the modal.
            title: $el.data('choose'),

            // Customize the submit button.
            button: {
               // Set the text of the button.
               text: $el.data('update'),
               // Tell the button not to close the modal, since we're
               // going to refresh the page when the image is selected.
               close: false
            }
        });

        // When an image is selected, run a callback.
        wpparallax_upload.on( 'select', function() {
            // Grab the selected attachment.
            var attachment = wpparallax_upload.state().get('selection').first();
            wpparallax_upload.close();
            wpparallax_selector.find('.upload').val(attachment.attributes.url);
            
            if ( attachment.attributes.type == 'image' ) {
               wpparallax_selector.find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '" style="width:100%;">').slideDown('fast');
            }
            
            wpparallax_selector.find('.ap-upload-button').unbind().addClass('remove-file').removeClass('ap-upload-button').val(wpparallax_l10n.remove);
            wpparallax_selector.find('.of-background-properties').slideDown();
            wpparallax_selector.find('.remove-image, .remove-file').on('click', function() {
               wpparallax_remove_file( $(this).parents('.section') );
            });
        });
    }

// Finally, open the modal.
    wpparallax_upload.open();
}

function wpparallax_remove_file(selector) {
    selector.find('.remove-image').hide();
    selector.find('.upload').val('');
    selector.find('.of-background-properties').hide();
    selector.find('.screenshot').slideUp();
    selector.find('.remove-file').unbind().addClass('ap-upload-button').removeClass('remove-file').val(wpparallax_l10n.upload);
    
    // We don't display the upload button if .upload-notice is present
    // This means the user doesn't have the WordPress 3.5 Media Library Support
    if ( $('.section-upload .upload-notice').length > 0 ) {
        $('.ap-upload-button').remove();
    }
    
    selector.find('.ap-upload-button').on('click', function(event) {
        wpparallax_add_file(event, $(this).parents('.sub-option'));
    });
}

$('body').on('click', '.remove-image, .remove-file', function() {
    wpparallax_remove_file( $(this).parents('.sub-option') );
});

$('body').on('click', '.ap-upload-button', function( event ) {
    wpparallax_add_file(event, $(this).parents('.sub-option'));
});

});