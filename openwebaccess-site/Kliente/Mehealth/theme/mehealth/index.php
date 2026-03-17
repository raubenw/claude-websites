<?php
/**
 * Main index template — redirects to front page.
 */
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        the_content();
    endwhile;
else :
    echo '<section style="padding:140px 24px 80px;min-height:60vh;"><div class="container"><p>No content found.</p></div></section>';
endif;

get_footer();
