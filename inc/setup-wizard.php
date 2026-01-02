<?php
/**
 * Setup Wizard
 *
 * @package OneWomanJob
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if wizard should be shown
 */
function owj_maybe_show_wizard() {
    if (get_option('owj_show_wizard') && current_user_can('manage_options')) {
        add_action('admin_notices', 'owj_wizard_notice');
    }
}
add_action('admin_init', 'owj_maybe_show_wizard');

/**
 * Display wizard notice
 */
function owj_wizard_notice() {
    $wizard_url = admin_url('admin.php?page=owj-wizard');
    ?>
    <div class="notice notice-info is-dismissible owj-wizard-notice">
        <p>
            <strong><?php esc_html_e('Welcome to One Woman Job!', 'owj'); ?></strong>
            <?php esc_html_e("Let's set up your theme. It only takes a few minutes.", 'owj'); ?>
        </p>
        <p>
            <a href="<?php echo esc_url($wizard_url); ?>" class="button button-primary">
                <?php esc_html_e('Start Setup Wizard', 'owj'); ?>
            </a>
            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?owj_dismiss_wizard=1'), 'owj_dismiss_wizard')); ?>" class="button">
                <?php esc_html_e('Skip', 'owj'); ?>
            </a>
        </p>
    </div>
    <?php
}

/**
 * Dismiss wizard
 */
function owj_dismiss_wizard() {
    if (isset($_GET['owj_dismiss_wizard']) && wp_verify_nonce($_GET['_wpnonce'], 'owj_dismiss_wizard')) {
        delete_option('owj_show_wizard');
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'owj_dismiss_wizard');

/**
 * Add wizard page
 */
function owj_add_wizard_page() {
    add_submenu_page(
        null, // Hidden from menu
        __('Setup Wizard', 'owj'),
        __('Setup Wizard', 'owj'),
        'manage_options',
        'owj-wizard',
        'owj_wizard_page'
    );
}
add_action('admin_menu', 'owj_add_wizard_page');

/**
 * Enqueue wizard scripts
 */
function owj_wizard_scripts($hook) {
    if ($hook !== 'admin_page_owj-wizard') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('owj-wizard', OWJ_URI . '/assets/css/wizard.css', array(), OWJ_VERSION);
    wp_enqueue_script('owj-wizard', OWJ_URI . '/assets/js/wizard.js', array('jquery'), OWJ_VERSION, true);
}
add_action('admin_enqueue_scripts', 'owj_wizard_scripts');

/**
 * Handle wizard form submission
 */
function owj_handle_wizard_submit() {
    if (!isset($_POST['owj_wizard_nonce']) || !wp_verify_nonce($_POST['owj_wizard_nonce'], 'owj_wizard_action')) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    $options = get_option('owj_options', array());

    // Business info
    $options['business_name'] = sanitize_text_field($_POST['business_name'] ?? 'ONE WOMAN JOB');
    $options['owner_name'] = sanitize_text_field($_POST['owner_name'] ?? 'Elizabeth');
    $options['nav_logo_text'] = sanitize_text_field($_POST['nav_logo_text'] ?? 'ONE WOMAN JOB');
    $options['tagline'] = sanitize_textarea_field($_POST['tagline'] ?? "Furniture Assembly & Home Organization\nServices");
    $options['service_area'] = sanitize_text_field($_POST['service_area'] ?? 'Serving All Of Central Florida');

    // Contact info
    $options['company_phone'] = sanitize_text_field($_POST['company_phone'] ?? '352-988-4621');
    $options['contact_email'] = sanitize_email($_POST['contact_email'] ?? 'OneWomanJob@Gmail.com');

    // Social links
    $options['social_facebook'] = esc_url_raw($_POST['social_facebook'] ?? '');
    $options['social_instagram'] = esc_url_raw($_POST['social_instagram'] ?? '');
    $options['social_tiktok'] = esc_url_raw($_POST['social_tiktok'] ?? '');

    // Hero image
    if (!empty($_POST['hero_image'])) {
        $options['hero_image'] = esc_url_raw($_POST['hero_image']);
    }

    // Pricing
    $options['organizing_price'] = sanitize_text_field($_POST['organizing_price'] ?? '30');

    // Default settings
    $options['show_banner'] = true;
    $options['show_spanish'] = true;

    update_option('owj_options', $options);
    update_option('owj_wizard_completed', true);
    delete_option('owj_show_wizard');

    wp_redirect(admin_url('admin.php?page=owj-settings&wizard=complete'));
    exit;
}
add_action('admin_post_owj_wizard_submit', 'owj_handle_wizard_submit');

/**
 * Wizard page HTML
 */
function owj_wizard_page() {
    $options = get_option('owj_options', array());
    ?>
    <div class="owj-wizard-wrap">
        <div class="owj-wizard-header">
            <h1><?php esc_html_e('One Woman Job', 'owj'); ?></h1>
            <p><?php esc_html_e('Setup Wizard', 'owj'); ?></p>
        </div>

        <div class="owj-wizard-content">
            <div class="owj-wizard-steps">
                <div class="owj-step active" data-step="1">
                    <span class="step-number">1</span>
                    <span class="step-title"><?php esc_html_e('Business', 'owj'); ?></span>
                </div>
                <div class="owj-step" data-step="2">
                    <span class="step-number">2</span>
                    <span class="step-title"><?php esc_html_e('Contact', 'owj'); ?></span>
                </div>
                <div class="owj-step" data-step="3">
                    <span class="step-number">3</span>
                    <span class="step-title"><?php esc_html_e('Branding', 'owj'); ?></span>
                </div>
                <div class="owj-step" data-step="4">
                    <span class="step-number">4</span>
                    <span class="step-title"><?php esc_html_e('Finish', 'owj'); ?></span>
                </div>
            </div>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="owj-wizard-form">
                <input type="hidden" name="action" value="owj_wizard_submit">
                <?php wp_nonce_field('owj_wizard_action', 'owj_wizard_nonce'); ?>

                <!-- Step 1: Business Info -->
                <div class="owj-wizard-panel active" data-panel="1">
                    <h2><?php esc_html_e('Business Information', 'owj'); ?></h2>
                    <p class="description"><?php esc_html_e("Let's start with your business details.", 'owj'); ?></p>

                    <div class="owj-form-group">
                        <label for="business_name"><?php esc_html_e('Business Name', 'owj'); ?></label>
                        <input type="text" id="business_name" name="business_name"
                               value="<?php echo esc_attr($options['business_name'] ?? 'ONE WOMAN JOB'); ?>"
                               class="large-text" required>
                    </div>

                    <div class="owj-form-group">
                        <label for="owner_name"><?php esc_html_e('Your Name', 'owj'); ?></label>
                        <input type="text" id="owner_name" name="owner_name"
                               value="<?php echo esc_attr($options['owner_name'] ?? 'Elizabeth'); ?>"
                               class="regular-text" required>
                    </div>

                    <div class="owj-form-group">
                        <label for="nav_logo_text"><?php esc_html_e('Navigation Logo Text', 'owj'); ?></label>
                        <input type="text" id="nav_logo_text" name="nav_logo_text"
                               value="<?php echo esc_attr($options['nav_logo_text'] ?? 'ONE WOMAN JOB'); ?>"
                               class="regular-text">
                        <p class="description"><?php esc_html_e('Text shown in the navigation bar (usually your business name).', 'owj'); ?></p>
                    </div>

                    <div class="owj-form-group">
                        <label for="tagline"><?php esc_html_e('Tagline', 'owj'); ?></label>
                        <textarea id="tagline" name="tagline" rows="2" class="large-text"><?php
                            echo esc_textarea($options['tagline'] ?? "Furniture Assembly & Home Organization\nServices");
                        ?></textarea>
                    </div>

                    <div class="owj-form-group">
                        <label for="service_area"><?php esc_html_e('Service Area', 'owj'); ?></label>
                        <input type="text" id="service_area" name="service_area"
                               value="<?php echo esc_attr($options['service_area'] ?? 'Serving All Of Central Florida'); ?>"
                               class="regular-text">
                    </div>
                </div>

                <!-- Step 2: Contact Info -->
                <div class="owj-wizard-panel" data-panel="2">
                    <h2><?php esc_html_e('Contact Information', 'owj'); ?></h2>
                    <p class="description"><?php esc_html_e('How can customers reach you?', 'owj'); ?></p>

                    <div class="owj-form-group">
                        <label for="company_phone"><?php esc_html_e('Phone Number', 'owj'); ?></label>
                        <input type="tel" id="company_phone" name="company_phone"
                               value="<?php echo esc_attr($options['company_phone'] ?? '352-988-4621'); ?>"
                               class="regular-text" required>
                    </div>

                    <div class="owj-form-group">
                        <label for="contact_email"><?php esc_html_e('Email Address', 'owj'); ?></label>
                        <input type="email" id="contact_email" name="contact_email"
                               value="<?php echo esc_attr($options['contact_email'] ?? 'OneWomanJob@Gmail.com'); ?>"
                               class="regular-text" required>
                    </div>

                    <div class="owj-form-group">
                        <label for="social_facebook"><?php esc_html_e('Facebook URL', 'owj'); ?> <span class="optional">(optional)</span></label>
                        <input type="url" id="social_facebook" name="social_facebook"
                               value="<?php echo esc_url($options['social_facebook'] ?? ''); ?>"
                               class="regular-text" placeholder="https://facebook.com/...">
                    </div>

                    <div class="owj-form-group">
                        <label for="social_instagram"><?php esc_html_e('Instagram URL', 'owj'); ?> <span class="optional">(optional)</span></label>
                        <input type="url" id="social_instagram" name="social_instagram"
                               value="<?php echo esc_url($options['social_instagram'] ?? ''); ?>"
                               class="regular-text" placeholder="https://instagram.com/...">
                    </div>

                    <div class="owj-form-group">
                        <label for="social_tiktok"><?php esc_html_e('TikTok URL', 'owj'); ?> <span class="optional">(optional)</span></label>
                        <input type="url" id="social_tiktok" name="social_tiktok"
                               value="<?php echo esc_url($options['social_tiktok'] ?? ''); ?>"
                               class="regular-text" placeholder="https://tiktok.com/...">
                    </div>
                </div>

                <!-- Step 3: Branding -->
                <div class="owj-wizard-panel" data-panel="3">
                    <h2><?php esc_html_e('Branding', 'owj'); ?></h2>
                    <p class="description"><?php esc_html_e('Upload your hero image and set your pricing.', 'owj'); ?></p>

                    <div class="owj-form-group">
                        <label for="hero_image"><?php esc_html_e('Hero Image', 'owj'); ?></label>
                        <div class="owj-media-upload">
                            <input type="text" id="hero_image" name="hero_image"
                                   value="<?php echo esc_url($options['hero_image'] ?? ''); ?>"
                                   class="regular-text">
                            <button type="button" class="button owj-upload-btn" data-target="hero_image">
                                <?php esc_html_e('Upload Image', 'owj'); ?>
                            </button>
                        </div>
                        <div id="hero_image_preview" class="owj-image-preview">
                            <?php if (!empty($options['hero_image'])) : ?>
                            <img src="<?php echo esc_url($options['hero_image']); ?>" style="max-width: 300px;">
                            <?php endif; ?>
                        </div>
                        <p class="description"><?php esc_html_e('This image appears in the hero section of your homepage.', 'owj'); ?></p>
                    </div>

                    <div class="owj-form-group">
                        <label for="organizing_price"><?php esc_html_e('Organizing Hourly Rate', 'owj'); ?></label>
                        <div>
                            $<input type="text" id="organizing_price" name="organizing_price"
                                   value="<?php echo esc_attr($options['organizing_price'] ?? '30'); ?>"
                                   class="small-text" style="width: 80px;">/hour
                        </div>
                    </div>
                </div>

                <!-- Step 4: Finish -->
                <div class="owj-wizard-panel" data-panel="4">
                    <h2><?php esc_html_e("You're All Set!", 'owj'); ?></h2>
                    <div class="owj-finish-icon">✨</div>
                    <p class="description"><?php esc_html_e('Click the button below to save your settings and complete the setup.', 'owj'); ?></p>

                    <div class="owj-summary">
                        <h3><?php esc_html_e('What happens next:', 'owj'); ?></h3>
                        <ul>
                            <li><?php esc_html_e('Your theme settings will be saved', 'owj'); ?></li>
                            <li><?php esc_html_e('Your homepage will display your business info', 'owj'); ?></li>
                            <li><?php esc_html_e('You can customize more in OWJ Settings', 'owj'); ?></li>
                        </ul>
                    </div>
                </div>

                <div class="owj-wizard-nav">
                    <button type="button" class="button" id="owj-prev-step" style="display: none;">
                        <?php esc_html_e('← Previous', 'owj'); ?>
                    </button>
                    <button type="button" class="button button-primary" id="owj-next-step">
                        <?php esc_html_e('Next →', 'owj'); ?>
                    </button>
                    <button type="submit" class="button button-primary" id="owj-finish-wizard" style="display: none;">
                        <?php esc_html_e('Complete Setup', 'owj'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
