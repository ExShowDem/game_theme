<div class="blog-post"><!-- blog-post -->

	<div class="blog-content"><!-- /.blog-content -->
		<?php the_content();?>
	</div><!-- /.blog-content -->

    <?php
        $args = array(
            'before'           => '<div class="pagination default_wp_p"><ul class="wp_pag">' . esc_html__( 'Pages:', 'respawn' ),
            'after'            => '</ul></div>',
            'link_before'      => '<li>',
            'link_after'       => '</li>',
        );
        wp_link_pages($args); ?>

	<div class="clear"></div>
</div><!-- /.blog-post -->
<?php  posts_nav_link(); previous_posts_link();  ?>