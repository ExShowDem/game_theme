<?php get_header();?>
<?php $options = get_option('respawn_redux'); ?>
<?php $class_blog = '';
$class_sidebar = '';
$item_appear_class = '';
if(!isset($options['blog-feed-template']))$options['blog-feed-template'] = 'standard_right';
if($options['blog-feed-template'] == 'standard_full' or $options['blog-feed-template'] == 'masonry_full' or !is_active_sidebar('Blog Sidebar')){
	$class_blog = 'col-12 ';
}else{
	$class_blog = 'col-8 ';
}

if($options['blog-feed-template'] == 'standard_left' or $options['blog-feed-template'] == 'masonry_left'){
	$class_sidebar = 'blog-leftsidebar';
}elseif($options['blog-feed-template'] == 'standard_right' or $options['blog-feed-template'] == 'masonry_right'){
	$class_sidebar = 'blog-rightsidebar';
}
elseif($options['blog-feed-template'] == 'standard_full'){
	$class_sidebar = 'blog-standardfull';
}

if(!isset($options['blog-feed-post-effect']))$options['blog-feed-post-effect'] = 'effect_3';
$effect = $options['blog-feed-post-effect'];
if(!empty($effect)) $item_appear_class = $effect;

?>

<div class="blog  <?php echo esc_attr($class_sidebar); ?>">

	<div class="container">

		<div class="row">

            <?php if(($options['blog-feed-template'] == 'standard_left' or $options['blog-feed-template'] == 'masonry_left') && is_active_sidebar('Blog Sidebar')) { ?>

				<div class="col-4 ">
					<?php if ( function_exists('dynamic_sidebar') )  dynamic_sidebar('Blog Sidebar'); ?>
				</div><!-- /.span4 -->

			<?php } ?>

			<div class="blog_item_wrapper <?php echo esc_attr($item_appear_class); ?>  <?php echo esc_attr($class_blog); ?>">
				<div class="grid-sizer"></div>

                <?php
                $showposts = get_option('posts_per_page');
                $category = get_query_var('cat' );
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $new_query = new WP_Query();
                $new_query->query( 'cat='.$category.'&showposts='.$showposts.'&paged='.$paged);


                if ( $new_query->have_posts() ) : while ( $new_query->have_posts() ) : $new_query->the_post();
                    get_template_part('blog', 'roll');
                endwhile;endif;


                echo respawn_kriesi_pagination($new_query->max_num_pages);
                wp_reset_postdata();

                ?>

				<div class="clear"></div>

			</div><!-- /.span8 -->

            <?php if(($options['blog-feed-template'] == 'standard_right' or $options['blog-feed-template'] == 'masonry_right') && is_active_sidebar('Blog Sidebar')){ ?>

				<div class="col-4  ">
					<?php if ( function_exists('dynamic_sidebar'))  dynamic_sidebar('Blog Sidebar'); ?>
				</div><!-- /.span4 -->

			<?php } ?>

		</div><!-- /row -->

	</div><!-- /container -->

</div><!-- /containerblog -->
<?php get_footer(); ?>