<?php

class respawn_gallery extends WP_Widget {

	var $default_settings = array();

	function __construct()
	{
		$widget_ops = array('classname' => 'widget_gallery', 'description' => esc_html__('Image gallery feed.', 'respawn'));
		parent::__construct('gallery', esc_html__('Gallery Items', 'respawn'), $widget_ops);

		$this->default_settings = array('title' => esc_html__('Gallery', 'respawn'),
				'show_limit' => 10,
				'hide_title' => false,
                'visible_posts' => array());

	}



	function widget($args, $instance) {

		$allowed = wp_kses_allowed_html( 'post' );
		extract($args);

		$instance = wp_parse_args((array)$instance, $this->default_settings);

		$title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Gallery', 'respawn') : $instance['title']);

		$images = array();
		$galleries = empty($instance['visible_posts']) ? 'all' : $instance['visible_posts'];

		if($galleries == 'all'){
		$galleries = array();
		$_galleries = get_posts(
			    array(
			        'posts_per_page' => $instance['show_limit'],
			        'post_type' => 'masonry_gallery',
			        'orderby' => 'date',
			    )
			);

		foreach ($_galleries as $_gallery) {
			$galleries[] = $_gallery->ID;
		}
		}
		?>

		<?php echo wp_kses($before_widget,$allowed); ?>
		<?php if ( $title && !$instance['hide_title'] )
			 echo wp_kses($before_title . $title . $after_title, $allowed); ?>

			<?php

			foreach($galleries as $gallery){
				$_images = get_post_meta($gallery, 'image_upload');
				foreach ($_images as $_image) {
					$images[] = $_image;
				}
			}



			if(!empty($instance['show_limit'])){
				shuffle($images);
				$final_array = array_slice($images, 0, $instance['show_limit']);

			}else{
				$final_array = $images;
			}

			foreach ($final_array as $el) {
				$url = wp_get_attachment_url($el);

                if(!empty($url)){
                    $image = respawn_aq_resize( $url, 100, 100, true, '', true ); //resize & crop img
                    $image_link = $image[0];

                } else{

                    $image_link = get_theme_file_uri('assets/img/defaults/default.jpg');
                }

			?>
				<a rel="prettyPhoto[pp_gal]"   href="<?php echo esc_url($url); ?>">
					<img alt="gallery-widget"  src="<?php echo esc_url($image_link); ?>" />
				</a>

			<?php }

			 echo wp_kses($after_widget,$allowed);
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {

		$instance = wp_parse_args((array)$instance, $this->default_settings);

		$show_limit = (int)$instance['show_limit'];
		$title = esc_attr($instance['title']);
        $visible_posts = $instance['visible_posts'];

        $posts = get_posts(array('post_type' => 'masonry_gallery'));

	?>
		<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'respawn'); ?></label> <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($title); ?>" type="text" /></p>

		<p>
			<input class="checkbox" name="<?php echo esc_attr($this->get_field_name('hide_title')); ?>" id="<?php echo esc_attr($this->get_field_id('hide_title')); ?>" value="1" type="checkbox" <?php checked($instance['hide_title'], true)?>/> <label for="<?php echo esc_attr($this->get_field_id('hide_title')); ?>"><?php esc_html_e('Hide title', 'respawn'); ?></label>
		</p>


        <p><?php esc_html_e('Show gallery images:', 'respawn'); ?></p>
        <p class="widefat">
            <?php foreach($posts as $post) : ?>
            <label for="<?php echo esc_attr($this->get_field_id('visible_posts-' . $post->ID)); ?>"><input type="checkbox" name="<?php echo esc_attr($this->get_field_name('visible_posts')); ?>[]" id="<?php echo esc_attr($this->get_field_id('visible_posts-' . $post->ID)); ?>" value="<?php echo esc_attr($post->ID); ?>" <?php checked(true, in_array($post->ID, $visible_posts)); ?>/> <?php echo esc_html($post->post_title); ?></label><br/>
            <?php endforeach; ?>
        </p>
        <p class="description"><?php esc_html_e('Do not check anything if you want to show all.', 'respawn'); ?></p>

		<p><label for="<?php echo esc_attr($this->get_field_id('show_limit')); ?>"><?php esc_html_e('Show items:', 'respawn'); ?></label> <input name="<?php echo esc_attr($this->get_field_name('show_limit')); ?>" id="<?php echo esc_attr($this->get_field_id('show_limit')); ?>" value="<?php echo esc_attr($show_limit); ?>" type="text" /></p>

	<?php
	}
}

function respawn_return_gallery_widget(){

    register_widget("respawn_gallery");
}

// register widget
add_action('widgets_init','respawn_return_gallery_widget');

?>