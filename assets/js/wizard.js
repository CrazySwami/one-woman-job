/**
 * One Woman Job - Setup Wizard JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        var currentStep = 1;
        var totalSteps = 4;

        // Navigation buttons
        var prevBtn = $('#owj-prev-step');
        var nextBtn = $('#owj-next-step');
        var finishBtn = $('#owj-finish-wizard');

        function updateNavigation() {
            // Previous button
            if (currentStep === 1) {
                prevBtn.hide();
            } else {
                prevBtn.show();
            }

            // Next/Finish buttons
            if (currentStep === totalSteps) {
                nextBtn.hide();
                finishBtn.show();
            } else {
                nextBtn.show();
                finishBtn.hide();
            }
        }

        function showStep(step) {
            // Update panels
            $('.owj-wizard-panel').removeClass('active');
            $('.owj-wizard-panel[data-panel="' + step + '"]').addClass('active');

            // Update steps indicator
            $('.owj-step').removeClass('active completed');
            $('.owj-step').each(function() {
                var stepNum = $(this).data('step');
                if (stepNum < step) {
                    $(this).addClass('completed');
                } else if (stepNum === step) {
                    $(this).addClass('active');
                }
            });

            updateNavigation();
        }

        // Next step
        nextBtn.on('click', function() {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        // Previous step
        prevBtn.on('click', function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Media uploader
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

                // Update preview
                var preview = $('#' + targetId + '_preview');
                preview.html('<img src="' + attachment.url + '" style="max-width: 300px;">');
            });

            frame.open();
        });

        // Initialize
        updateNavigation();
    });

})(jQuery);
