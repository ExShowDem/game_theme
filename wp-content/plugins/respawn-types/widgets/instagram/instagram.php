<?php

/*
	INSTAGRAM WIDGET
*/
class respawn_instagram extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_instagram', 'description' => 'Displays photos from Instagram' );
		WP_Widget::__construct( 'instagram','Instagram', $widget_ops );

	}



	function widget( $args, $instance ) {

		$allowed_tags = array(
			'div' => array(
				'class' => array()
			),
			'h3' => array(
				'class' => array()
			),
		);


		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if(isset( $instance['instagram_id']))
		$instagram_id = $instance['instagram_id'];
		if(isset( $instance['accessToken']))
		$accessToken = $instance['accessToken'];
		if(isset( $instance['sort_by']))
		$sort_by = $instance['sort_by'];
		if(isset( $instance['accessToken']))
		$accessToken = $instance['accessToken'];
		if(isset( $instance['count'])){
		$count = (int)$instance['count'];
		}else{
			$count = 0;
		}
		if(isset( $instance['column']))
		$column = $instance['column'];
		$display = empty( $instance['display'] ) ? 'latest' : $instance['display'];

		if( $count < 1 ) {
			$count = 1;
		}


        echo  wp_kses($before_widget, $allowed_tags);
            if ( $title )
        echo  wp_kses($before_title.$title.$after_title, $allowed_tags);

		if ( !empty( $instagram_id ) ) {


			$id = mt_rand( 99, 999 );

            $insta_script ="
            jQuery(window).ready(function(){
            var feed = new Instafeed({
                get: 'user',
                target : 'insta-feeds-".esc_attr($id)."',
                resolution : 'thumbnail',
                sortBy : '".esc_attr($sort_by)."',
                limit : '".esc_attr($count)."',
                userId: '".esc_attr($instagram_id)."',
                accessToken : '".esc_attr($accessToken)."',
                template: '<a class=\"featured-image\" href=\"{{link}}\" target=\"_blank\"><div class=\"item-holder\"><img src=\"{{image}}\" /><div class=\"image-hover-overlay\"></div></div></a>'
            });


            feed.run();
        });
            ";

            wp_add_inline_script('respawn-global', $insta_script);
?>

		<div id="insta-feeds-<?php echo esc_attr($id); ?>" class="insta-feeds"></div>
		<?php
			echo  wp_kses($after_widget, $allowed_tags);
		}else{
		    ?>
		    <div class="textwidget"><p><?php esc_html_e("Missing Instagram ID", "respawn"); ?></p></div>
		    <?php
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['instagram_id'] = strip_tags( $new_instance['instagram_id'] );
		$instance['count'] = (int) $new_instance['count'];
		$instance['column'] = $new_instance['column'];
		$instance['accessToken'] = $new_instance['accessToken'];
		$instance['sort_by'] = $new_instance['sort_by'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$instagram_id = isset( $instance['instagram_id'] ) ? esc_attr( $instance['instagram_id'] ) : '';
		$sort_by = isset( $instance['sort_by'] ) ? esc_attr( $instance['sort_by'] ) : 'most-recent';
		$accessToken = isset( $instance['accessToken'] ) ? esc_attr( $instance['accessToken'] ) : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 3;
		$column = isset( $instance['column'] ) ? $instance['column'] : 'two';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title :', 'respawn'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'instagram_id' )); ?>"><?php esc_html_e('Instagram User Id', 'respawn'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'instagram_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram_id' )); ?>" type="text" value="<?php echo esc_attr($instagram_id); ?>" />
		</p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'accessToken' )); ?>"><?php esc_html_e('Access Token', 'respawn'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'accessToken' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'accessToken' )); ?>" type="text" value="<?php echo esc_attr($accessToken); ?>" />
		</p>


		<p><label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_html_e('Number of photos to show :', 'respawn'); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" type="text" value="<?php echo esc_attr($count); ?>" size="3" /></p>


		<p><label for="<?php echo esc_attr($this->get_field_id( 'sort_by' )); ?>"><?php esc_html_e('Sort by:', 'respawn'); ?></label>
		<select id="<?php echo esc_attr($this->get_field_id( 'sort_by' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'sort_by' )); ?>" class="widefat">
			<option<?php if ( $sort_by == 'most-recent' ) echo ' selected="selected"'?> value="most-recent"><?php esc_html_e('Most Recent', 'respawn'); ?></option>
			<option<?php if ( $sort_by == 'least-recent' ) echo ' selected="selected"'?> value="least-recent"><?php esc_html_e('Least Recent', 'respawn'); ?></option>
			<option<?php if ( $sort_by == 'most-liked' ) echo ' selected="selected"'?> value="most-liked"><?php esc_html_e('Most Liked', 'respawn'); ?></option>
			<option<?php if ( $sort_by == 'least-liked' ) echo ' selected="selected"'?> value="least-liked"><?php esc_html_e('Least Liked', 'respawn'); ?></option>
			<option<?php if ( $sort_by == 'most-commented' ) echo ' selected="selected"'?> value="most-commented"><?php esc_html_e('Most Commented', 'respawn'); ?></option>
			<option<?php if ( $sort_by == 'least-commented' ) echo ' selected="selected"'?> value="least-commented"><?php esc_html_e('Least-commented', 'respawn'); ?></option>
			<option<?php if ( $sort_by == 'random' ) echo ' selected="selected"'?> value="random"><?php esc_html_e('Random', 'respawn'); ?></option>
		</select>
		</p>

		<p><em><?php esc_html_e('Generate Instagram Access Token', 'respawn'); ?> <a target="_blank" href="http://instagram.pixelunion.net/"> <?php esc_html_e('Here','respawn'); ?> </a>.</em></p>
		<p><em><?php esc_html_e('Check how to get User ID', 'respawn'); ?> <a target="_blank" href="https://smashballoon.com/instagram-feed/find-instagram-user-id"> <?php esc_html_e('Here','respawn'); ?> </a>.</em></p>

<?php
	}
}


function respawn_return_instagram_widget(){
    return register_widget("respawn_instagram");
}
// register widget
add_action('widgets_init', 'respawn_return_instagram_widget');
?>