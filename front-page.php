<?php
/**
 * Front Page Template
 *
 * @package OneWomanJob
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get theme options
$business_name = owj_get_option('business_name', 'ONE WOMAN JOB');
$tagline = owj_get_option('tagline', "Furniture Assembly & Home Organization\nServices");
$owner_name = owj_get_option('owner_name', 'Elizabeth');
$phone = owj_get_option('company_phone', '352-808-4623');
$phone_link = preg_replace('/[^0-9+]/', '', $phone);

// Hero content
$hero_welcome = owj_get_option('hero_welcome', "Hi, I'm Elizabeth — Let Me Help You!");
$hero_text_1 = owj_get_option('hero_text_1', "Furniture assembly doesn't have to be stressful, what might feel like a big chore to you, is actually my favorite thing to do!");
$hero_text_2 = owj_get_option('hero_text_2', 'From dressers to desks, beds to bookshelves (and everything in between).');
$hero_text_3 = owj_get_option('hero_text_3', 'I take the building off your hands so you can enjoy your space without the hassle.');
$hero_text_4 = owj_get_option('hero_text_4', "I also specialize in organizing — from closets to kids' rooms, to make your home feel put together, functional, and stress-free.");
$hero_image = owj_get_option('hero_image');

// Stats
$stat_1_number = owj_get_option('stat_1_number', '1');
$stat_1_label = owj_get_option('stat_1_label', 'Woman Powerhouse');
$stat_2_number = owj_get_option('stat_2_number', '10');
$stat_2_label = owj_get_option('stat_2_label', 'Projects Completed');

// Section title
$section_headline = owj_get_option('section_headline', "ASSEMBLY MADE EASY. ORGANIZATION\nMADE SIMPLE.");

// Services
$service_1_title = owj_get_option('service_1_title', 'Furniture Assembly');
$service_1_desc = owj_get_option('service_1_desc', 'Expert assembly for all your flat-pack furniture from any retailer. Fast, precise & stress-free.');
$service_2_title = owj_get_option('service_2_title', 'Home Organization');
$service_2_desc = owj_get_option('service_2_desc', 'Transform cluttered spaces into functional, peaceful areas. Closets, pantries, bedrooms & more.');

// Pricing
$assembly_cta = owj_get_option('assembly_cta', 'Call/Text for A Personalized Quote');
$organizing_price = owj_get_option('organizing_price', '30');

// Story
$story_text_1 = owj_get_option('story_text_1', 'When I started tackling my own furniture as a self-described "assembly-phobe" I learned to love it. I still needed to get it done. I jumped in, took my time, and figured it out.');
$story_text_2 = owj_get_option('story_text_2', "Eventually, friends and family asked for help — and that's when I realized this was something I genuinely loved. Now, with One Woman Job, I bring my patience and attention to detail to every project.");
$story_text_3 = owj_get_option('story_text_3', "That's how One Woman Job came to life: built from self-resilience, shaped by passion, and driven by the joy of helping others create spaces they love.");

// About image
$about_image = owj_get_option('about_image');
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-header">
        <h1 class="logo-main"><?php echo esc_html($business_name); ?></h1>
        <p class="tagline-main"><?php echo nl2br(esc_html($tagline)); ?></p>
    </div>

    <div class="hero-wrapper">
        <div class="hero-image animate scale-in">
            <?php if ($hero_image) : ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr($owner_name); ?> assembling furniture">
            <?php else : ?>
                <div class="hero-image-placeholder">
                    <?php echo esc_html($owner_name); ?> assembling furniture
                </div>
            <?php endif; ?>
        </div>
        <div class="hero-content">
            <p class="hero-welcome animate fade-up"><?php echo esc_html($hero_welcome); ?></p>
            <div class="hero-text">
                <p class="animate fade-up delay-1"><?php echo esc_html($hero_text_1); ?></p>
                <p class="animate fade-up delay-2"><?php echo esc_html($hero_text_2); ?></p>
                <p class="animate fade-up delay-3"><?php echo esc_html($hero_text_3); ?></p>
                <p class="animate fade-up delay-4"><?php echo esc_html($hero_text_4); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="stat-card cream animate scale-in" style="border-radius: var(--radius-pill);">
        <div class="stat-number"><?php echo esc_html($stat_1_number); ?></div>
        <div class="stat-label"><?php echo esc_html($stat_1_label); ?></div>
    </div>
    <div class="stat-card rose animate scale-in delay-2" style="border-radius: var(--radius-pill);">
        <div class="stat-number"><?php echo esc_html($stat_2_number); ?></div>
        <div class="stat-label"><?php echo esc_html($stat_2_label); ?></div>
    </div>
</section>

<!-- Section Title -->
<div class="section-title-block">
    <h2 class="section-title animate fade-up"><?php echo nl2br(esc_html($section_headline)); ?></h2>
</div>

<!-- Brand Logos Section -->
<section class="brands-section">
    <p class="brands-label animate fade-up"><?php esc_html_e('I Can Assemble Items From All These Brands', 'owj'); ?></p>
    <div class="brands-grid">
        <!-- IKEA Logo -->
        <div class="brand-logo-item animate fade-up delay-1">
            <svg viewBox="0 0 400 160" xmlns="http://www.w3.org/2000/svg">
                <rect fill="#0058A3" width="400" height="160" rx="8"/>
                <text x="200" y="105" font-family="Verdana, sans-serif" font-size="72" font-weight="bold" fill="#FFCC00" text-anchor="middle">IKEA</text>
            </svg>
        </div>
        <!-- Amazon Logo -->
        <div class="brand-logo-item animate fade-up delay-2">
            <svg viewBox="0 0 400 120" xmlns="http://www.w3.org/2000/svg">
                <text x="200" y="70" font-family="Arial, sans-serif" font-size="58" font-weight="bold" fill="#232F3E" text-anchor="middle">amazon</text>
                <path d="M130 85 Q200 110 280 85" stroke="#FF9900" stroke-width="8" fill="none" stroke-linecap="round"/>
                <path d="M270 75 L280 85 L275 95" stroke="#FF9900" stroke-width="8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <!-- Walmart Logo -->
        <div class="brand-logo-item animate fade-up delay-3">
            <svg viewBox="0 0 400 100" xmlns="http://www.w3.org/2000/svg">
                <text x="200" y="65" font-family="Arial, sans-serif" font-size="48" font-weight="bold" fill="#0071CE" text-anchor="middle">Walmart</text>
                <circle cx="355" cy="50" r="8" fill="#FFC220"/>
                <g transform="translate(355,50)">
                    <line x1="0" y1="-15" x2="0" y2="-8" stroke="#FFC220" stroke-width="4" stroke-linecap="round"/>
                    <line x1="0" y1="8" x2="0" y2="15" stroke="#FFC220" stroke-width="4" stroke-linecap="round"/>
                    <line x1="-13" y1="-7.5" x2="-7" y2="-4" stroke="#FFC220" stroke-width="4" stroke-linecap="round"/>
                    <line x1="7" y1="4" x2="13" y2="7.5" stroke="#FFC220" stroke-width="4" stroke-linecap="round"/>
                    <line x1="-13" y1="7.5" x2="-7" y2="4" stroke="#FFC220" stroke-width="4" stroke-linecap="round"/>
                    <line x1="7" y1="-4" x2="13" y2="-7.5" stroke="#FFC220" stroke-width="4" stroke-linecap="round"/>
                </g>
            </svg>
        </div>
        <!-- Wayfair Logo -->
        <div class="brand-logo-item animate fade-up delay-4">
            <svg viewBox="0 0 400 100" xmlns="http://www.w3.org/2000/svg">
                <text x="200" y="62" font-family="Georgia, serif" font-size="46" fill="#7B189F" text-anchor="middle">Wayfair</text>
            </svg>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" id="services">
    <div class="heart-icon">♡</div>
    <p class="services-label animate fade-up"><?php esc_html_e('Services', 'owj'); ?></p>

    <div class="services-grid">
        <div class="service-card animate fade-up delay-1" style="border-radius: var(--radius-md);">
            <h4><?php echo esc_html($service_1_title); ?></h4>
            <p><?php echo esc_html($service_1_desc); ?></p>
        </div>
        <div class="service-card rose animate fade-up delay-2" style="border-radius: var(--radius-md);">
            <h4><?php echo esc_html($service_2_title); ?></h4>
            <p><?php echo esc_html($service_2_desc); ?></p>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="about-container">
        <div class="about-image animate scale-in">
            <?php if ($about_image) : ?>
                <img src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr($owner_name); ?>">
            <?php else : ?>
                <div class="about-image-placeholder">
                    <?php esc_html_e('About Image', 'owj'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="about-content">
            <div class="about-card animate fade-up" style="border-radius: var(--radius-md);">
                <span class="about-icon">✧</span>
                <h3><?php esc_html_e('Bring Your Home To Life', 'owj'); ?></h3>
                <p><?php esc_html_e('Every piece assembled with care & purpose. Function starts here.', 'owj'); ?></p>
            </div>
            <div class="about-card animate fade-up delay-2" style="border-radius: var(--radius-md);">
                <span class="about-icon">✓</span>
                <h3><?php esc_html_e('Create A Home That Works For You', 'owj'); ?></h3>
                <p><?php esc_html_e('Spaces that serve you and reflect your style with inspired organization.', 'owj'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- My Story Section -->
<section class="story-section" id="story">
    <h2 class="story-title animate fade-up"><?php esc_html_e('My Story', 'owj'); ?></h2>
    <div class="story-text">
        <p class="animate fade-up delay-1"><?php echo esc_html($story_text_1); ?></p>
        <p class="animate fade-up delay-2"><?php echo esc_html($story_text_2); ?></p>
        <p class="animate fade-up delay-3"><?php echo esc_html($story_text_3); ?></p>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing-section" id="pricing">
    <h2 class="pricing-title animate fade-up"><?php esc_html_e('Pricing', 'owj'); ?></h2>

    <div class="pricing-grid">
        <div class="pricing-card cream animate fade-up delay-1" style="border-radius: var(--radius-md);">
            <h4><?php esc_html_e('Assembly Services', 'owj'); ?></h4>
            <p><?php esc_html_e('Expert assembly of furniture, equipment, and products for homes and businesses.', 'owj'); ?></p>
            <p><?php esc_html_e('Fast, precise, & reliable.', 'owj'); ?></p>
            <p class="cta-text"><?php echo esc_html($assembly_cta); ?></p>
            <a href="tel:<?php echo esc_attr($phone_link); ?>" class="cta-button" style="border-radius: var(--radius-sm);">
                <?php echo esc_html($phone); ?>
            </a>
        </div>

        <div class="pricing-card rose animate fade-up delay-2" style="border-radius: var(--radius-md);">
            <h4><?php esc_html_e('Organizing Session', 'owj'); ?></h4>
            <p><?php esc_html_e("Let me help you simplify your space — I clean, arrange, & refresh your home or workspace.", 'owj'); ?></p>
            <p class="price-intro"><?php esc_html_e('Prices starting at:', 'owj'); ?></p>
            <div class="price"><sup>$</sup><?php echo esc_html($organizing_price); ?><sub>/hour</sub></div>
        </div>
    </div>
</section>

<!-- My Work Section -->
<section class="work-section" id="work">
    <h2 class="work-title animate fade-up"><?php esc_html_e('My Work', 'owj'); ?></h2>
    <div class="work-slider animate fade-up delay-1">
        <div class="work-slider-track" id="workSlider">
            <?php
            // Get gallery images from theme options or use placeholders
            $gallery_images = owj_get_option('gallery_images', array());

            if (!empty($gallery_images) && is_array($gallery_images)) {
                foreach ($gallery_images as $index => $image_url) {
                    echo '<div class="work-slide" style="border-radius: var(--radius-lg);">';
                    echo '<img src="' . esc_url($image_url) . '" alt="' . sprintf(esc_attr__('Project %d', 'owj'), $index + 1) . '">';
                    echo '</div>';
                }
            } else {
                // Placeholder slides
                for ($i = 1; $i <= 5; $i++) {
                    echo '<div class="work-slide" style="border-radius: var(--radius-lg);">';
                    echo '<div class="work-slide-placeholder">' . sprintf(esc_html__('Project %d', 'owj'), $i) . '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    <div class="slider-dots" id="sliderDots"></div>
</section>

<?php get_footer();
