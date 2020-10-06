<?php
$post_url = get_the_permalink($post->ID);

if(!empty($post_url)){
    $url_tw = "https://twitter.com/home?status=$post_url";
    $url_fb = "https://www.facebook.com/sharer/sharer.php?u=$post_url";
    $url_pin = "http://pinterest.com/pin/create/button/?url=$post_url";
}
?>
<div class="be-right">
    <span><?php esc_html_e('Share:','respawn'); ?></span> <a href="<?php echo esc_url($url_fb); ?>"><i class="fab fa-facebook-f"></i></a> <a href="<?php echo esc_url($url_tw); ?>"><i class="fab fa-twitter"></i></a> <a href="<?php echo esc_url($url_pin); ?>"><i class="fab fa-pinterest"></i></a>
</div>