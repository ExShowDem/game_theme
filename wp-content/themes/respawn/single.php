<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 */

?>

<?php get_header();?>
<?php $options = respawn_get_theme_options(); ?>
<?php $post_sidebar_class = ''; $class_post =  ''; $gallery_slider = ''; ?>
<?php
if(!isset($options['blog_single_type'])) $options['blog_single_type'] = 'right-sidebar';
if($options['blog_single_type'] == 'full-width'){
	$class_post = 'col-12 ';
	$post_sidebar_class = 'blog-nosidebar';
}else{
	$class_post = 'col-8 ';
	$post_sidebar_class = 'blog-nosidebar';
}

if($options['blog_single_type'] == 'left-sidebar'){
	$post_sidebar_class = 'blog-leftsidebar';
}elseif($options['blog_single_type'] == 'right-sidebar'){
	$post_sidebar_class = 'blog-rightsidebar';
}

?>

<div class="blog <?php echo esc_attr($post_sidebar_class); ?>">


	<div class="container">

		<?php if($options['blog_single_type'] == 'left-sidebar'){ ?>

			<div class="col-4 ">
				<?php if ( function_exists('dynamic_sidebar'))  dynamic_sidebar('Blog Sidebar'); ?>
			</div><!-- /.span4 -->

		<?php } ?>

		<div <?php post_class($class_post); ?> >
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('blog', 'single'); ?>

			<?php endwhile; endif; ?>
			<div class="clear"></div>
            <div class="blog-extra">
                <div class="be-left">
                    <?php
                    $tags = wp_get_post_tags($post->ID);

                    foreach ($tags as $tag){

                        echo '<a href="'.esc_url(get_tag_link($tag->term_id)).'" class="btn">'.esc_html($tag->name).'</a> ';

                    }
                    ?>

                </div>

                <?php
                    if ( class_exists( 'Respawn_Types' ) ) {
                        require_once WP_PLUGIN_DIR . '/respawn-types/share.php';
                    }
                ?>
            </div>

            <?php if(!isset($options['post_author'])) $options['post_author'] = '0'; ?>
			<?php if($options['post_author'] == '1'){ ?>
                <div id="comments"  class="block-divider"></div>
				<div class="author-wrapper">
					<?php echo get_avatar( get_the_author_meta('ID'), 100, '', 'author image', array('class' => 'authorimg') ); ?>
					<div id="author-info">
						<h3> <?php echo the_author_meta('display_name'); ?></h3>
						<p><?php echo the_author_meta('description'); ?></p>
						<a class="author-link" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>" ><?php esc_html_e("See all author posts", 'respawn'); ?> </a>
					</div>
					<div class="clear"></div>
				</div>
			<?php } ?>
            <div id="comments"  class="block-divider"></div>


            <?php
            the_post_navigation( array(
                'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous Post:', 'respawn' ) . '</span><span class="nav-title"><span class="nav-title-icon-wrapper"><i class="fas fa-arrow-left"></i></span> %title</span>',
                'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next Post:', 'respawn' ) . '</span><span class="nav-title"> %title<span class="nav-title-icon-wrapper"><i class="fas fa-arrow-right"></i></span></span>',
            ) );
            ?>

			<?php comments_template(); ?>

		</div><!-- /.span8 -->
        <?php if(!isset($options['blog_single_type'])) $options['blog_single_type'] = 'right-sidebar'; ?>
		<?php if($options['blog_single_type'] == "right-sidebar"){ ?>

			<div class="col-4  ">
				<?php if ( function_exists('dynamic_sidebar'))  dynamic_sidebar('Blog Sidebar'); ?>
			</div><!-- /.span4 -->

		<?php } ?>

	</div><!-- /container -->
</div><!-- /blog -->
<?php get_footer(); ?>