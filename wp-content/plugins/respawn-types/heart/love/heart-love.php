<?php
/*
Name: heartLove
Description: Adds a "Love It" link to posts
Author: Phil Martinez | Themeheart
Author URI: http://themeheart.com
*/
class respawnHeartLove {
	 function __construct()   {
        add_action('wp_ajax_heart-love', array(&$this, 'ajax'));
		add_action('wp_ajax_nopriv_heart-love', array(&$this, 'ajax'));
	}

	function ajax($post_id) {
		//update
		if( isset($_POST['loves_id']) ) {
			$post_id = str_replace('heart-love-', '', $_POST['loves_id']);
			echo $this->love_post($post_id, 'update');
		}
		//get
		else {
			$post_id = str_replace('heart-love-', '', $_POST['loves_id']);
			echo $this->love_post($post_id, 'get');
		}
		exit;
	}
	function love_post($post_id, $action = 'get')
	{
		if(!is_numeric($post_id)) return;

		switch($action) {
			case 'get':
				if( isset($_COOKIE['respawn_heart_love_'. $post_id]) )
				$love_count = '';
				$love_count = get_post_meta($post_id, '_heart_love', true);
				if( !$love_count ){
					$love_count = 0;
					add_post_meta($post_id, '_heart_love', $love_count, true);
				}
				if( isset($_COOKIE['respawn_heart_love_'. $post_id]) ){
					return '<i class="fas fa-heart"></i> <span>'. $love_count .'</span>';
				}else{
					return '<i class="far fa-heart"></i> <span>'. $love_count .'</span>';
				}
				break;
			case 'update':
				$love_count = get_post_meta($post_id, '_heart_love', true);
				if( isset($_COOKIE['respawn_heart_love_'. $post_id]) ) return $love_count;
				$love_count++;
				update_post_meta($post_id, '_heart_love', $love_count);
				setcookie('respawn_heart_love_'. $post_id, $post_id, time()*20, '/');
				return '<i class="far fa-heart"></i> <span>'. $love_count .'</span>';
				break;
		}
	}
	function add_love() {
		global $post;
		$output = $this->love_post($post->ID);
  		$class = 'heart-love';
  		$title = esc_html__('Love this', "respawn");
		if( isset($_COOKIE['heart_love_'. $post->ID]) ){
			$class = 'heart-love loved';
			$title = esc_html__('You already love this!', "respawn");
		}
		return '<a class="'. $class .'" id="heart-love-'. $post->ID .'" title="'. $title .'">'. $output .'</a>';
	}
}
global $respawn_heart_love;
$respawn_heart_love = new respawnHeartLove();
// get the ball rollin'
function respawn_heart_love() {
	global $respawn_heart_love;
    $respawn_allowed = wp_kses_allowed_html( 'post' );
	echo wp_kses($respawn_heart_love->add_love(),$respawn_allowed);
}
function respawn_return_heart_love() {
    global $respawn_heart_love;
    return $respawn_heart_love->add_love();
}
?>