<?php
/**
 * Theme Footer
 *
 * @package OneWomanJob
 */

if (!defined('ABSPATH')) {
    exit;
}

$phone = owj_get_option('company_phone', '352-808-4623');
$phone_link = preg_replace('/[^0-9+]/', '', $phone);
$email = owj_get_option('contact_email', 'OneWomanJob@Gmail.com');
$location = owj_get_option('service_area', 'Serving All Of Central Florida');
$tagline = owj_get_option('tagline', 'Furniture Assembly & Home Organization Services');
$show_spanish = owj_get_option('show_spanish', true);

$facebook = owj_get_option('social_facebook');
$instagram = owj_get_option('social_instagram');
$tiktok = owj_get_option('social_tiktok');
?>

</main><!-- #main -->

<!-- Footer -->
<footer id="contact" class="site-footer">
    <div class="footer-content">
        <div class="footer-left">
            <div class="footer-logo"><?php echo esc_html(owj_get_option('nav_logo_text', 'ONE WOMAN JOB')); ?></div>
            <p class="footer-location"><?php echo esc_html($location); ?></p>
            <p class="footer-tagline"><?php echo nl2br(esc_html($tagline)); ?></p>
        </div>

        <div class="footer-center">
            <p class="footer-cta-text"><?php esc_html_e('Reach out now for a free quote!', 'owj'); ?></p>
            <a href="tel:<?php echo esc_attr($phone_link); ?>" class="footer-cta" style="border-radius: var(--radius-sm);">
                <?php printf(esc_html__('Call Now %s', 'owj'), esc_html($phone)); ?>
            </a>

            <div class="footer-contact">
                <?php if ($show_spanish) : ?>
                <p class="spanish"><?php esc_html_e('Se Habla Español', 'owj'); ?></p>
                <?php endif; ?>
                <a href="mailto:<?php echo esc_attr($email); ?>">
                    <?php printf(esc_html__('Email: %s', 'owj'), esc_html($email)); ?>
                </a>
            </div>
        </div>

        <div class="footer-right">
            <?php if ($facebook || $instagram || $tiktok) : ?>
            <p class="footer-follow"><?php esc_html_e('Follow Me', 'owj'); ?></p>
            <div class="social-links">
                <?php if ($facebook) : ?>
                <a href="<?php echo esc_url($facebook); ?>" aria-label="Facebook" target="_blank" rel="noopener">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <?php endif; ?>
                <?php if ($instagram) : ?>
                <a href="<?php echo esc_url($instagram); ?>" aria-label="Instagram" target="_blank" rel="noopener">
                    <i class="fab fa-instagram"></i>
                </a>
                <?php endif; ?>
                <?php if ($tiktok) : ?>
                <a href="<?php echo esc_url($tiktok); ?>" aria-label="TikTok" target="_blank" rel="noopener">
                    <i class="fab fa-tiktok"></i>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
