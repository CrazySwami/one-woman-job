/**
 * One Woman Job - Admin JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Media uploader for single images
        $('.owj-upload-btn').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var targetId = button.data('target');
            var targetInput = $('#' + targetId);

            var frame = wp.media({
                title: 'Select Image',
                button: { text: 'Use Image' },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                targetInput.val(attachment.url);

                // Update preview if exists
                var preview = button.closest('td').find('.owj-image-preview');
                if (preview.length) {
                    preview.html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto;">');
                }
            });

            frame.open();
        });

        // Gallery - Add image
        $('#owj-add-gallery-image').on('click', function(e) {
            e.preventDefault();

            var frame = wp.media({
                title: 'Add Gallery Image',
                button: { text: 'Add to Gallery' },
                multiple: true
            });

            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();

                attachments.forEach(function(attachment) {
                    var html = '<div class="owj-gallery-item">' +
                        '<img src="' + attachment.url + '" style="max-width: 200px; height: auto;">' +
                        '<input type="hidden" name="owj_options[gallery_images][]" value="' + attachment.url + '">' +
                        '<button type="button" class="button owj-remove-image">Remove</button>' +
                        '</div>';

                    $('#owj-gallery-container').append(html);
                });
            });

            frame.open();
        });

        // Gallery - Remove image
        $(document).on('click', '.owj-remove-image', function(e) {
            e.preventDefault();
            $(this).closest('.owj-gallery-item').remove();
        });

    });

})(jQuery);
