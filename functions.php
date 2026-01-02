<?php
/**
 * One Woman Job Theme Functions
 *
 * @package OneWomanJob
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Force HTTPS when behind Cloudflare/reverse proxy
if (
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
    (!empty($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false)
) {
    $_SERVER['HTTPS'] = 'on';
}

// Theme version
define('OWJ_VERSION', '1.0.0');
define('OWJ_DIR', get_template_directory());
define('OWJ_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function owj_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'owj'),
        'footer'  => __('Footer Menu', 'owj'),
    ));

    // Set content width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'owj_setup');

/**
 * Enqueue Scripts and Styles
 */
function owj_scripts() {
    // Google Fonts - Cormorant for headings, Nunito for body
    wp_enqueue_style(
        'owj-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Nunito:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // Main stylesheet
    wp_enqueue_style(
        'owj-style',
        get_stylesheet_uri(),
        array('owj-fonts', 'font-awesome'),
        OWJ_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'owj-main',
        OWJ_URI . '/assets/js/main.js',
        array(),
        OWJ_VERSION,
        true
    );

    // Localize script
    wp_localize_script('owj-main', 'owjData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('owj_nonce'),
        'homeUrl' => home_url(),
    ));
}
add_action('wp_enqueue_scripts', 'owj_scripts');

/**
 * Theme Options Helper
 */
function owj_get_option($key, $default = '') {
    $options = get_option('owj_options', array());
    if (!is_array($options)) {
        $options = array();
    }
    $value = isset($options[$key]) ? $options[$key] : null;
    // Return default if value is null, empty string, or not set
    if ($value === null || $value === '') {
        return $default;
    }
    return $value;
}

function owj_update_option($key, $value) {
    $options = get_option('owj_options', array());
    $options[$key] = $value;
    update_option('owj_options', $options);
}

/**
 * Primary Menu Fallback
 */
function owj_primary_menu_fallback() {
    ?>
    <ul class="nav-links">
        <li><a href="#services"><?php esc_html_e('Services', 'owj'); ?></a></li>
        <li><a href="#story"><?php esc_html_e('My Story', 'owj'); ?></a></li>
        <li><a href="#pricing"><?php esc_html_e('Pricing', 'owj'); ?></a></li>
        <li><a href="#work"><?php esc_html_e('My Work', 'owj'); ?></a></li>
        <li><a href="#contact"><?php esc_html_e('Contact', 'owj'); ?></a></li>
    </ul>
    <?php
}

/**
 * Mobile Menu Fallback
 */
function owj_mobile_menu_fallback() {
    ?>
    <a href="#services"><?php esc_html_e('Services', 'owj'); ?></a>
    <a href="#story"><?php esc_html_e('My Story', 'owj'); ?></a>
    <a href="#pricing"><?php esc_html_e('Pricing', 'owj'); ?></a>
    <a href="#work"><?php esc_html_e('My Work', 'owj'); ?></a>
    <a href="#contact"><?php esc_html_e('Contact', 'owj'); ?></a>
    <?php
}

/**
 * Register Widget Areas
 */
function owj_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'owj'),
        'id'            => 'footer-1',
        'description'   => __('Footer widget area 1', 'owj'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'owj_widgets_init');

/**
 * Contact Form Handler
 */
function owj_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['owj_contact_nonce']) ||
        !wp_verify_nonce($_POST['owj_contact_nonce'], 'owj_contact_action')) {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    // Sanitize input
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    // Get recipient email
    $to = owj_get_option('contact_email', get_option('admin_email'));

    $subject = '[One Woman Job] New inquiry from ' . $name;

    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    if ($phone) {
        $body .= "Phone: $phone\n";
    }
    $body .= "\nMessage:\n$message";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: One Woman Job <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_owj_contact', 'owj_handle_contact_form');
add_action('admin_post_nopriv_owj_contact', 'owj_handle_contact_form');

/**
 * Add body classes
 */
function owj_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    return $classes;
}
add_filter('body_class', 'owj_body_classes');

/**
 * Set permalink structure on theme activation
 */
function owj_activate_theme() {
    // Set pretty permalinks
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();

    // Mark wizard as needed
    if (!get_option('owj_wizard_completed')) {
        update_option('owj_show_wizard', true);
    }
}
add_action('after_switch_theme', 'owj_activate_theme');

/**
 * Include admin files
 */
if (is_admin()) {
    require_once OWJ_DIR . '/inc/admin-settings.php';
    require_once OWJ_DIR . '/inc/setup-wizard.php';
}

/**
 * Load admin branding CSS on ALL admin pages
 */
function owj_admin_branding_styles() {
    wp_enqueue_style('owj-admin-branding', OWJ_URI . '/assets/css/admin.css', array(), OWJ_VERSION);
}
add_action('admin_enqueue_scripts', 'owj_admin_branding_styles');

/**
 * Load login page branding
 */
function owj_login_styles() {
    wp_enqueue_style('owj-admin-branding', OWJ_URI . '/assets/css/admin.css', array(), OWJ_VERSION);
}
add_action('login_enqueue_scripts', 'owj_login_styles');

/**
 * Phone number formatting helper
 */
function owj_format_phone_link($phone) {
    return preg_replace('/[^0-9+]/', '', $phone);
}

/**
 * Truncate text helper
 */
function owj_truncate($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}
