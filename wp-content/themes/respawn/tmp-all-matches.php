<?php
/*
 * Template name: All matches page
*/
?>
<?php get_header(); ?>
    <div class="page normal-page ">
        <div class="container">
            <div class="row">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php echo do_shortcode('[wp-team-matches]') ?>
                <?php endwhile; wp_reset_postdata(); // end of the loop. ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>