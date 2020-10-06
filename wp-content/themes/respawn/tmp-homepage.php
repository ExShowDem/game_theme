<?php
/*
 * Template name: Homepage
*/
?>
<?php get_header();?>
    <!-- Page content
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
<?php $options = respawn_get_theme_options(); ?>

<?php $orderby = $options['slider-post-orderby']; ?>
<?php $order = $options['slider-post-order']; ?>
<?php
$cats = array();
if(isset($options['home_slider_categories']) && !empty($options['home_slider_categories']))  $cats = $options['home_slider_categories'];
$num_posts = 5;
if(isset($options['slider-number-posts']) && !empty($options['slider-number-posts']))  $num_posts = $options['slider-number-posts'];


$selected_cats = array();
if(!empty($cats))
foreach ($cats as $key => $cat) {
    if($cat == '1')$selected_cats[] = $key;
}

if((count($selected_cats) == 1 && $selected_cats[0] == '99999')){
    $args = array(
        'posts_per_page'   => $num_posts,
        'orderby'          => $orderby,
        'order'            => $order,
    );
}elseif(isset($selected_cats) && !empty($selected_cats)){
    $args = array(
        'posts_per_page'   => $num_posts,
        'category__in'    => $selected_cats,
        'orderby'          => $orderby,
        'order'            => $order,
    );
}else{
    $args = array(
        'posts_per_page'   => $num_posts,
        'orderby'          => $orderby,
        'order'            => $order,
    );
}

$query = new WP_Query( $args );
$i = 1;

$total = $query->post_count;

if($total <= 9)
    $total = '0'.$total;

?>
    <main>
        <div class="slideshow">
            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php $kategorije = wp_get_post_categories($post->ID);  ?>
                <div class="slide">
                    <div class="s-numbers">
                        <?php
                            if($i <= 9)$i = '0'.$i;
                            echo esc_html($i);
                        ?>
                        <span><?php echo esc_html($total); ?></span></div>
                    <svg aria-hidden="true" data-prefix="fal" data-icon="angle-right" role="img" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 192 512" class="svg-inline--fa fa-angle-right fa-w-6 fa-2x"><path fill="currentColor" d="M166.9 264.5l-117.8 116c-4.7 4.7-12.3 4.7-17 0l-7.1-7.1c-4.7-4.7-4.7-12.3 0-17L127.3 256 25.1 155.6c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0l117.8 116c4.6 4.7 4.6 12.3-.1 17z" class=""></path></svg>
                    <div class="slide__img-wrap">
                        <div class="slide__img pid_<?php echo esc_attr($post->ID); ?>"></div>
                        <div class="slide__img-reveal"></div>
                    </div>
                    <div class="slide__title-wrap">
                        <h3 class="slide__title">
                            <span class="slide__box"></span>
                            <span class="slide__title-inner"><?php the_title(); ?></span>
                        </h3>
                        <h4 class="slide__subtitle"><span class="slide__box"></span><span class="slide__subtitle-inner"><?php the_title(); ?></span></h4>
                        <a href="<?php the_permalink(); ?>" class="slide__explore btn">
                            <span class="slide__explore-inner"><?php esc_html_e('Read more', 'respawn'); ?></span>
                        </a>
                    </div>
                    <div class="slide__side">
                        <h5 class="slide__category"><?php the_time(get_option('date_format')); ?></h5>
                    </div>
                </div>
                <?php $i++; endwhile; endif; wp_reset_postdata(); // end of the loop. ?>
        </div>
    </main>
    <div class="loader">
        <div class="loader__inner"></div>
    </div>
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php  the_content(); ?>
        <?php endwhile; wp_reset_postdata(); // end of the loop. ?>
    </div>
<?php get_footer();?>