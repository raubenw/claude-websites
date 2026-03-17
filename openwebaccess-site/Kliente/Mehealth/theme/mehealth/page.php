<?php
/**
 * Generic page template.
 */
get_header();
?>

<section class="page-content" style="padding-top: 140px; padding-bottom: 80px; min-height: 60vh;">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <h1 class="section-title"><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>
