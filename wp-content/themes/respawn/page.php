<?php get_header(); ?>
<div class="container">
	<div class="row">
    <?php while ( have_posts() ) : the_post(); ?>
    <?php  the_content(); ?>
    <?php endwhile; // end of the loop. ?>

	<div class="clear"></div>
	<?php
        $args = array(
            'before'           => '<div class="pagination default_wp_p"><ul class="wp_pag">' . esc_html__( 'Pages:', 'respawn' ),
            'after'            => '</ul></div>',
            'link_before'      => '<li>',
            'link_after'       => '</li>',
        );
        wp_link_pages($args); ?>

	 <?php if(comments_open()){ ?>
		<div id="comments"  class="block-divider"></div>
		<?php  comments_template(); ?>
	<?php } ?>

	</div>
 </div>

<?php get_footer(); ?>