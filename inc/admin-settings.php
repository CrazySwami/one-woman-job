<?php
/**
 * Admin Settings Page
 *
 * @package OneWomanJob
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu
 */
function owj_admin_menu() {
    add_menu_page(
        __('One Woman Job', 'owj'),
        __('OWJ Settings', 'owj'),
        'manage_options',
        'owj-settings',
        'owj_settings_page',
        'dashicons-hammer',
        60
    );
}
add_action('admin_menu', 'owj_admin_menu');

/**
 * Register settings
 */
function owj_register_settings() {
    register_setting('owj_options_group', 'owj_options', 'owj_sanitize_options');
}
add_action('admin_init', 'owj_register_settings');

/**
 * Sanitize options
 */
function owj_sanitize_options($input) {
    $sanitized = array();

    // Text fields
    $text_fields = array(
        'business_name', 'tagline', 'owner_name', 'nav_logo_text',
        'company_phone', 'contact_email', 'service_area',
        'hero_welcome', 'hero_text_1', 'hero_text_2', 'hero_text_3', 'hero_text_4',
        'stat_1_number', 'stat_1_label', 'stat_2_number', 'stat_2_label',
        'section_headline',
        'service_1_title', 'service_1_desc', 'service_2_title', 'service_2_desc',
        'assembly_cta', 'organizing_price',
        'story_text_1', 'story_text_2', 'story_text_3',
        'banner_text', 'banner_link_text',
    );

    foreach ($text_fields as $field) {
        if (isset($input[$field])) {
            $sanitized[$field] = sanitize_textarea_field($input[$field]);
        }
    }

    // URL fields
    $url_fields = array(
        'hero_image', 'about_image', 'social_facebook', 'social_instagram', 'social_tiktok'
    );

    foreach ($url_fields as $field) {
        if (isset($input[$field])) {
            $sanitized[$field] = esc_url_raw($input[$field]);
        }
    }

    // Boolean fields
    $bool_fields = array('show_banner', 'show_spanish');
    foreach ($bool_fields as $field) {
        $sanitized[$field] = !empty($input[$field]);
    }

    // Gallery images (array of URLs)
    if (isset($input['gallery_images']) && is_array($input['gallery_images'])) {
        $sanitized['gallery_images'] = array_map('esc_url_raw', $input['gallery_images']);
    }

    return $sanitized;
}

/**
 * Enqueue admin scripts
 */
function owj_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_owj-settings') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('owj-admin', OWJ_URI . '/assets/css/admin.css', array(), OWJ_VERSION);
    wp_enqueue_script('owj-admin', OWJ_URI . '/assets/js/admin.js', array('jquery'), OWJ_VERSION, true);
}
add_action('admin_enqueue_scripts', 'owj_admin_scripts');

/**
 * Settings page HTML
 */
function owj_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $options = get_option('owj_options', array());
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
    ?>
    <div class="wrap owj-settings-wrap">
        <h1>
            <span class="dashicons dashicons-hammer" style="font-size: 30px; margin-right: 10px;"></span>
            <?php esc_html_e('One Woman Job Settings', 'owj'); ?>
        </h1>

        <nav class="nav-tab-wrapper">
            <a href="?page=owj-settings&tab=general" class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('General', 'owj'); ?>
            </a>
            <a href="?page=owj-settings&tab=hero" class="nav-tab <?php echo $active_tab === 'hero' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Hero Section', 'owj'); ?>
            </a>
            <a href="?page=owj-settings&tab=content" class="nav-tab <?php echo $active_tab === 'content' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Content', 'owj'); ?>
            </a>
            <a href="?page=owj-settings&tab=gallery" class="nav-tab <?php echo $active_tab === 'gallery' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Gallery', 'owj'); ?>
            </a>
            <a href="?page=owj-settings&tab=social" class="nav-tab <?php echo $active_tab === 'social' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Social & Contact', 'owj'); ?>
            </a>
        </nav>

        <form method="post" action="options.php">
            <?php settings_fields('owj_options_group'); ?>

            <?php if ($active_tab === 'general') : ?>
            <!-- General Settings -->
            <div class="owj-settings-section">
                <h2><?php esc_html_e('Business Information', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="business_name"><?php esc_html_e('Business Name', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="business_name" name="owj_options[business_name]"
                                   value="<?php echo esc_attr($options['business_name'] ?? 'ONE WOMAN JOB'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nav_logo_text"><?php esc_html_e('Navigation Logo Text', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="nav_logo_text" name="owj_options[nav_logo_text]"
                                   value="<?php echo esc_attr($options['nav_logo_text'] ?? 'ONE WOMAN JOB'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="tagline"><?php esc_html_e('Tagline', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="tagline" name="owj_options[tagline]" rows="2" class="large-text"><?php
                                echo esc_textarea($options['tagline'] ?? "Furniture Assembly & Home Organization\nServices");
                            ?></textarea>
                            <p class="description"><?php esc_html_e('Use line breaks for multiple lines.', 'owj'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="owner_name"><?php esc_html_e('Owner Name', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="owner_name" name="owj_options[owner_name]"
                                   value="<?php echo esc_attr($options['owner_name'] ?? 'Elizabeth'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="service_area"><?php esc_html_e('Service Area', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="service_area" name="owj_options[service_area]"
                                   value="<?php echo esc_attr($options['service_area'] ?? 'Serving All Of Central Florida'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e('Top Banner', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="show_banner"><?php esc_html_e('Show Banner', 'owj'); ?></label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" id="show_banner" name="owj_options[show_banner]" value="1"
                                    <?php checked(!empty($options['show_banner']) || !isset($options['show_banner'])); ?>>
                                <?php esc_html_e('Display the top promotional banner', 'owj'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="banner_text"><?php esc_html_e('Banner Text', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="banner_text" name="owj_options[banner_text]"
                                   value="<?php echo esc_attr($options['banner_text'] ?? 'Now Booking for January!'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="banner_link_text"><?php esc_html_e('Banner Link Text', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="banner_link_text" name="owj_options[banner_link_text]"
                                   value="<?php echo esc_attr($options['banner_link_text'] ?? 'Schedule your assembly today'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>

            <?php elseif ($active_tab === 'hero') : ?>
            <!-- Hero Section -->
            <div class="owj-settings-section">
                <h2><?php esc_html_e('Hero Section', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="hero_image"><?php esc_html_e('Hero Image', 'owj'); ?></label>
                        </th>
                        <td>
                            <div class="owj-media-upload">
                                <input type="text" id="hero_image" name="owj_options[hero_image]"
                                       value="<?php echo esc_url($options['hero_image'] ?? ''); ?>"
                                       class="regular-text">
                                <button type="button" class="button owj-upload-btn" data-target="hero_image">
                                    <?php esc_html_e('Upload Image', 'owj'); ?>
                                </button>
                            </div>
                            <?php if (!empty($options['hero_image'])) : ?>
                            <div class="owj-image-preview" style="margin-top: 10px;">
                                <img src="<?php echo esc_url($options['hero_image']); ?>" style="max-width: 300px; height: auto;">
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_welcome"><?php esc_html_e('Welcome Text', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="hero_welcome" name="owj_options[hero_welcome]"
                                   value="<?php echo esc_attr($options['hero_welcome'] ?? "Hi, I'm Elizabeth — Let Me Help You!"); ?>"
                                   class="large-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_text_1"><?php esc_html_e('Hero Paragraph 1', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="hero_text_1" name="owj_options[hero_text_1]" rows="2" class="large-text"><?php
                                echo esc_textarea($options['hero_text_1'] ?? "Furniture assembly doesn't have to be stressful, what might feel like a big chore to you, is actually my favorite thing to do!");
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_text_2"><?php esc_html_e('Hero Paragraph 2', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="hero_text_2" name="owj_options[hero_text_2]" rows="2" class="large-text"><?php
                                echo esc_textarea($options['hero_text_2'] ?? 'From dressers to desks, beds to bookshelves (and everything in between).');
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_text_3"><?php esc_html_e('Hero Paragraph 3', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="hero_text_3" name="owj_options[hero_text_3]" rows="2" class="large-text"><?php
                                echo esc_textarea($options['hero_text_3'] ?? 'I take the building off your hands so you can enjoy your space without the hassle.');
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_text_4"><?php esc_html_e('Hero Paragraph 4', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="hero_text_4" name="owj_options[hero_text_4]" rows="2" class="large-text"><?php
                                echo esc_textarea($options['hero_text_4'] ?? "I also specialize in organizing — from closets to kids' rooms, to make your home feel put together, functional, and stress-free.");
                            ?></textarea>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e('Stats Section', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Stat 1', 'owj'); ?></th>
                        <td>
                            <input type="text" name="owj_options[stat_1_number]"
                                   value="<?php echo esc_attr($options['stat_1_number'] ?? '1'); ?>"
                                   class="small-text" placeholder="Number">
                            <input type="text" name="owj_options[stat_1_label]"
                                   value="<?php echo esc_attr($options['stat_1_label'] ?? 'Woman Powerhouse'); ?>"
                                   class="regular-text" placeholder="Label">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Stat 2', 'owj'); ?></th>
                        <td>
                            <input type="text" name="owj_options[stat_2_number]"
                                   value="<?php echo esc_attr($options['stat_2_number'] ?? '10'); ?>"
                                   class="small-text" placeholder="Number">
                            <input type="text" name="owj_options[stat_2_label]"
                                   value="<?php echo esc_attr($options['stat_2_label'] ?? 'Projects Completed'); ?>"
                                   class="regular-text" placeholder="Label">
                        </td>
                    </tr>
                </table>
            </div>

            <?php elseif ($active_tab === 'content') : ?>
            <!-- Content Settings -->
            <div class="owj-settings-section">
                <h2><?php esc_html_e('Section Headline', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="section_headline"><?php esc_html_e('Main Headline', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="section_headline" name="owj_options[section_headline]" rows="2" class="large-text"><?php
                                echo esc_textarea($options['section_headline'] ?? "ASSEMBLY MADE EASY. ORGANIZATION\nMADE SIMPLE.");
                            ?></textarea>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e('Services', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Service 1', 'owj'); ?></th>
                        <td>
                            <input type="text" name="owj_options[service_1_title]"
                                   value="<?php echo esc_attr($options['service_1_title'] ?? 'Furniture Assembly'); ?>"
                                   class="regular-text" placeholder="Title">
                            <br><br>
                            <textarea name="owj_options[service_1_desc]" rows="2" class="large-text" placeholder="Description"><?php
                                echo esc_textarea($options['service_1_desc'] ?? 'Expert assembly for all your flat-pack furniture from any retailer. Fast, precise & stress-free.');
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Service 2', 'owj'); ?></th>
                        <td>
                            <input type="text" name="owj_options[service_2_title]"
                                   value="<?php echo esc_attr($options['service_2_title'] ?? 'Home Organization'); ?>"
                                   class="regular-text" placeholder="Title">
                            <br><br>
                            <textarea name="owj_options[service_2_desc]" rows="2" class="large-text" placeholder="Description"><?php
                                echo esc_textarea($options['service_2_desc'] ?? 'Transform cluttered spaces into functional, peaceful areas. Closets, pantries, bedrooms & more.');
                            ?></textarea>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e('Pricing', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="assembly_cta"><?php esc_html_e('Assembly CTA Text', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="assembly_cta" name="owj_options[assembly_cta]"
                                   value="<?php echo esc_attr($options['assembly_cta'] ?? 'Call/Text for A Personalized Quote'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="organizing_price"><?php esc_html_e('Organizing Hourly Rate', 'owj'); ?></label>
                        </th>
                        <td>
                            $<input type="text" id="organizing_price" name="owj_options[organizing_price]"
                                   value="<?php echo esc_attr($options['organizing_price'] ?? '30'); ?>"
                                   class="small-text">/hour
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e('My Story', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="story_text_1"><?php esc_html_e('Story Paragraph 1', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="story_text_1" name="owj_options[story_text_1]" rows="3" class="large-text"><?php
                                echo esc_textarea($options['story_text_1'] ?? 'When I started tackling my own furniture as a self-described "assembly-phobe" I learned to love it. I still needed to get it done. I jumped in, took my time, and figured it out.');
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="story_text_2"><?php esc_html_e('Story Paragraph 2', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="story_text_2" name="owj_options[story_text_2]" rows="3" class="large-text"><?php
                                echo esc_textarea($options['story_text_2'] ?? "Eventually, friends and family asked for help — and that's when I realized this was something I genuinely loved. Now, with One Woman Job, I bring my patience and attention to detail to every project.");
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="story_text_3"><?php esc_html_e('Story Paragraph 3', 'owj'); ?></label>
                        </th>
                        <td>
                            <textarea id="story_text_3" name="owj_options[story_text_3]" rows="3" class="large-text"><?php
                                echo esc_textarea($options['story_text_3'] ?? "That's how One Woman Job came to life: built from self-resilience, shaped by passion, and driven by the joy of helping others create spaces they love.");
                            ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <?php elseif ($active_tab === 'gallery') : ?>
            <!-- Gallery Settings -->
            <div class="owj-settings-section">
                <h2><?php esc_html_e('Work Gallery', 'owj'); ?></h2>
                <p class="description"><?php esc_html_e('Add images to showcase your work. These will appear in the "My Work" slider.', 'owj'); ?></p>

                <div id="owj-gallery-container">
                    <?php
                    $gallery_images = $options['gallery_images'] ?? array();
                    if (!empty($gallery_images)) {
                        foreach ($gallery_images as $index => $image_url) {
                            ?>
                            <div class="owj-gallery-item">
                                <img src="<?php echo esc_url($image_url); ?>" style="max-width: 200px; height: auto;">
                                <input type="hidden" name="owj_options[gallery_images][]" value="<?php echo esc_url($image_url); ?>">
                                <button type="button" class="button owj-remove-image"><?php esc_html_e('Remove', 'owj'); ?></button>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" class="button button-secondary" id="owj-add-gallery-image">
                    <?php esc_html_e('Add Image', 'owj'); ?>
                </button>
            </div>

            <?php elseif ($active_tab === 'social') : ?>
            <!-- Social & Contact Settings -->
            <div class="owj-settings-section">
                <h2><?php esc_html_e('Contact Information', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="company_phone"><?php esc_html_e('Phone Number', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="company_phone" name="owj_options[company_phone]"
                                   value="<?php echo esc_attr($options['company_phone'] ?? '352-808-4623'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="contact_email"><?php esc_html_e('Email Address', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="email" id="contact_email" name="owj_options[contact_email]"
                                   value="<?php echo esc_attr($options['contact_email'] ?? 'OneWomanJob@Gmail.com'); ?>"
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="show_spanish"><?php esc_html_e('Show Spanish Notice', 'owj'); ?></label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" id="show_spanish" name="owj_options[show_spanish]" value="1"
                                    <?php checked(!empty($options['show_spanish']) || !isset($options['show_spanish'])); ?>>
                                <?php esc_html_e('Display "Se Habla Español" in footer', 'owj'); ?>
                            </label>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e('Social Media Links', 'owj'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="social_facebook"><?php esc_html_e('Facebook URL', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="url" id="social_facebook" name="owj_options[social_facebook]"
                                   value="<?php echo esc_url($options['social_facebook'] ?? ''); ?>"
                                   class="regular-text" placeholder="https://facebook.com/...">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="social_instagram"><?php esc_html_e('Instagram URL', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="url" id="social_instagram" name="owj_options[social_instagram]"
                                   value="<?php echo esc_url($options['social_instagram'] ?? ''); ?>"
                                   class="regular-text" placeholder="https://instagram.com/...">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="social_tiktok"><?php esc_html_e('TikTok URL', 'owj'); ?></label>
                        </th>
                        <td>
                            <input type="url" id="social_tiktok" name="owj_options[social_tiktok]"
                                   value="<?php echo esc_url($options['social_tiktok'] ?? ''); ?>"
                                   class="regular-text" placeholder="https://tiktok.com/...">
                        </td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
