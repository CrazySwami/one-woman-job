<?php
/**
 * Theme Header
 *
 * @package OneWomanJob
 */

if (!defined('ABSPATH')) {
    exit;
}

$phone = owj_get_option('company_phone', '352-808-4623');
$phone_link = preg_replace('/[^0-9+]/', '', $phone);
$banner_text = owj_get_option('banner_text', 'Now Booking for January!');
$banner_link_text = owj_get_option('banner_link_text', 'Schedule your assembly today');
$show_banner = owj_get_option('show_banner', true);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ($show_banner) : ?>
<!-- Top Banner -->
<div class="top-banner">
    🛠️ <?php echo esc_html($banner_text); ?> <a href="#contact"><?php echo esc_html($banner_link_text); ?></a> →
</div>
<?php endif; ?>

<!-- Navigation -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo">
            <?php echo esc_html(owj_get_option('nav_logo_text', 'ONE WOMAN JOB')); ?>
        </a>

        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'nav-links',
            'menu_id'        => 'primary-menu',
            'fallback_cb'    => 'owj_primary_menu_fallback',
        ));
        ?>

        <a href="tel:<?php echo esc_attr($phone_link); ?>" class="nav-cta">Call Now</a>

        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="<?php esc_attr_e('Menu', 'owj'); ?>">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'fallback_cb'    => 'owj_mobile_menu_fallback',
        ));
        ?>
        <a href="tel:<?php echo esc_attr($phone_link); ?>" style="color: var(--dusty-rose-dark); font-weight: 600;">
            <?php printf(esc_html__('Call: %s', 'owj'), esc_html($phone)); ?>
        </a>
    </div>
</nav>

<main id="main" class="site-main" role="main">
