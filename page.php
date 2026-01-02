<?php
/**
 * Page Template
 *
 * @package OneWomanJob
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="page-section" style="padding: 80px 20px;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="text-align: center; margin-bottom: 40px;">
                    <h1 class="entry-title" style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--text-dark);">
                        <?php the_title(); ?>
                    </h1>
                </header>
                <div class="entry-content" style="color: var(--text-medium); line-height: 1.8;">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</section>

<?php
get_footer();
