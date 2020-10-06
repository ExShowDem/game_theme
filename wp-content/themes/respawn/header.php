<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $options = respawn_get_theme_options();
    ?>

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <?php
    global $respawn_custombck, $post, $woocommerce;
    //check if page has header image


    if(is_page() or 'team' == get_post_type() ){
        $respawn_custombck = get_post_meta($post->ID, 'page_header_image', true);
    }elseif(is_category()){
        $respawn_custombck = respawn_ci_taxonomy_image_url($wp_query->get_queried_object_id());
    }else{
        if(isset($post->ID)){
            $respawn_custombck = get_post_meta($post->ID, 'post_header_image', true);
        }else{
            $respawn_custombck = '';
        }

    }

    if(!empty($respawn_custombck)  && !is_category()) $respawn_custombck= wp_get_attachment_url($respawn_custombck);

    if(is_single() && empty($respawn_custombck) && get_post_type() != 'team'){
        $respawn_custombck = get_the_post_thumbnail_url();
    }



    if(empty($respawn_custombck)){
        if(!isset($options['header-settings-default-image']['url']))
            $options['header-settings-default-image']['url'] = get_theme_file_uri('assets/img/defaults/header-default.jpg');
        $respawn_custombck = $options['header-settings-default-image']['url'];
    }
    ?>

    <?php wp_head(); ?>
</head>

<?php /* initialise vars*/
$content_class = '';
$regular_header_class = '';
$header_classes = array();
?>
<!-- header settings -->
<?php if(isset($options['header-settings-layout-menu'])){ ?>
    <?php if($options['header-settings-layout-menu'] == 'right-aligned-menu') $header_classes[] = 'right-aligned-menu'; ?>
    <?php if($options['header-settings-layout-menu'] == 'center-aligned-menu') $header_classes[] = 'center-aligned-menu'; ?>
    <?php if($options['header-settings-layout-menu'] == 'left-aligned-menu') $header_classes[] = 'left-aligned-menu'; ?>
<?php }else{  $header_classes[] = 'right-aligned-menu'; }  ?>

<?php if(!isset($options['header-settings-parallax'])) $options['header-settings-parallax'] = '1'; ?>

<?php if($options['header-settings-parallax'] == '1'){ ?>
    <?php $header_parallax = 'header-enable-parallax'; ?>
    <?php $rest_parallax = 'rest-enable-parallax'; ?>
<?php } ?>

<!-- menu full with -->
<?php if(!isset($options['header-settings-layout'])) $options['header-settings-layout'] = 'right-aligned-menu'; ?>
<?php if($options['header-settings-layout'] == 'full') {
    $header_classes[] = 'fullwidth';
}elseif($options['header-settings-layout'] == 'boxed'){
    $header_classes[] = 'boxed';
} ?>


<!--header position-->

<body <?php body_class(); ?> >
<?php if(!isset($options['preloading'])) $options['preloading'] = '1'; ?>
<?php if($options['preloading'] == '1'){ ?>
    <div class="se-pre-con">
        <?php if(!isset($options['loading-icon-styles'])) $options['loading-icon-styles'] = 'sk-folding-cube'; ?>
        <?php  switch ($options['loading-icon-styles']) {

            case 'sk-folding-cube': ?>
                <div class="sk-folding-cube">
                    <div class="sk-cube1 sk-cube"></div>
                    <div class="sk-cube2 sk-cube"></div>
                    <div class="sk-cube4 sk-cube"></div>
                    <div class="sk-cube3 sk-cube"></div>
                </div>
                <?php break; ?>

            <?php case 'rotating-plane': ?>
                <div class="rotating-plane"></div>
                <?php break; ?>

            <?php case 'double-bounce': ?>
                <div class="double-bounce">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
                <?php break; ?>

            <?php case 'rectangle-bounce': ?>
                <div class="rectangle-bounce">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
                <?php break; ?>

            <?php case 'wandering-cubes': ?>
                <div class="wandering-cubes">
                    <div class="cube1"></div>
                    <div class="cube2"></div>
                </div>
                <?php break; ?>


            <?php case 'pulse': ?>
                <div class="pulse"></div>
                <?php break; ?>

            <?php case 'chasing-dots': ?>
                <div class="chasing-dots">
                    <div class="dot1"></div>
                    <div class="dot2"></div>
                </div>
                <?php break; ?>

            <?php case 'three-bounce': ?>
                <div class="three-bounce">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
                <?php break; ?>

            <?php case 'sk-circle': ?>
                <div class="sk-circle">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>
                <?php break; ?>

            <?php case 'sk-cube-grid': ?>
                <div class="sk-cube-grid">
                    <div class="sk-cube sk-cube1"></div>
                    <div class="sk-cube sk-cube2"></div>
                    <div class="sk-cube sk-cube3"></div>
                    <div class="sk-cube sk-cube4"></div>
                    <div class="sk-cube sk-cube5"></div>
                    <div class="sk-cube sk-cube6"></div>
                    <div class="sk-cube sk-cube7"></div>
                    <div class="sk-cube sk-cube8"></div>
                    <div class="sk-cube sk-cube9"></div>
                </div>
                <?php break; ?>

            <?php case 'sk-fading-circle': ?>
                <div class="sk-fading-circle">
                    <div class="sk-circle1 sk-circle"></div>
                    <div class="sk-circle2 sk-circle"></div>
                    <div class="sk-circle3 sk-circle"></div>
                    <div class="sk-circle4 sk-circle"></div>
                    <div class="sk-circle5 sk-circle"></div>
                    <div class="sk-circle6 sk-circle"></div>
                    <div class="sk-circle7 sk-circle"></div>
                    <div class="sk-circle8 sk-circle"></div>
                    <div class="sk-circle9 sk-circle"></div>
                    <div class="sk-circle10 sk-circle"></div>
                    <div class="sk-circle11 sk-circle"></div>
                    <div class="sk-circle12 sk-circle"></div>
                </div>
                <?php break; ?>

            <?php } ?>


    </div>
<?php } ?>

<div class="main-wrapper">

    <header id="custom__menu" class="<?php respawn_print_array($header_classes); ?>  page_header <?php echo esc_attr($regular_header_class); ?> <?php if(class_exists('Mega_Menu')) { if(max_mega_menu_is_enabled('header-menu')) echo 'mobmenu';} ?>">

        <!-- Main menu container -->
        <div class="header-bottom">
            <div class="container">
                <?php if(!isset($options['logo']['url'])) $options['logo']['url'] = get_theme_file_uri('assets/img/logo-main.png'); ?>
                <?php $logo_url = $options['logo']['url']; ?>

                <div class="hlogo">
                    <div class="hlogoinner">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img alt="<?php echo get_bloginfo('name'); ?>" src="<?php echo esc_url($logo_url); ?>" />

                            <?php

                            if(!isset($options['header-settings-fixed-logo']['url'])) $options['header-settings-fixed-logo']['url'] = '';

                            if(!empty($options['header-settings-fixed-logo']['url']) && $options['header-position'] == 'fixed' ){
                                $fixed_logo = $options['header-settings-fixed-logo']['url'];
                            }else{
                                $fixed_logo = $logo_url;
                            }
                            ?>

                            <img class="fixed_header_logo" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" src="<?php echo esc_url($fixed_logo); ?>" />
                        </a>
                    </div>
                </div>



                <?php if(!isset($options['menu-settings-effect']))$options['menu-settings-effect'] = 'regular-eff'; ?>

                <div class="mainmenucont menucont <?php echo esc_attr($options['menu-settings-effect']); ?>">

                    <?php if(has_nav_menu('header-menu')) { ?>

                        <?php wp_nav_menu( array( 'theme_location'  => 'header-menu', 'depth' => 0,'sort_column' => 'menu_order', 'items_wrap' => '<ul  class="nav navbar-nav">%3$s</ul>' ) ); ?>

                    <?php }else { ?>

                        <?php if(is_user_logged_in() && current_user_can('administrator') ){ ?>
                            <ul  class="nav">
                                <li>
                                    <a rel="nofollow"><?php esc_html_e('No menu assigned!', 'respawn'); ?></a>
                                </li>
                            </ul>
                        <?php } ?>

                    <?php } ?>

                </div>


                <div class="fullscreen-menu">
                    <div class="menuArea">
                        <input type="checkbox" id="mobilemenu">

                        <label for="mobilemenu" class="menuOpen">
                            <span class="open"></span>
                        </label>

                        <div class="menu menuEffects">
                            <label for="mobilemenu"></label>
                            <div class="menuContent">

                                <?php wp_nav_menu( array( 'theme_location'  => 'header-menu', 'depth' => 0,'sort_column' => 'menu_order', 'items_wrap' => '<ul  class="nav navbar-nav">%3$s</ul>') ); ?>

                            </div>
                        </div>
                    </div>
                </div>

                <?php if(!isset($options['header-settings-social'])) $options['header-settings-social'] = 0; ?>
                <?php if($options['header-settings-social'] == 1){ ?>
                    <div class="hsocial">
                        <?php  if(!empty($options['twitter-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['twitter-url']); ?>"><i class="fab fa-twitter"></i> </a><?php } ?>
                        <?php  if(!empty($options['facebook-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['facebook-url']); ?>"><i class="fab fa-facebook-f"></i> </a> <?php } ?>
                        <?php  if(!empty($options['vimeo-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['vimeo-url']); ?>"> <i class="fab fa-vimeo-v"></i> </a> <?php } ?>
                        <?php  if(!empty($options['pinterest-url']) ) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['pinterest-url']); ?>"><i class="fab fa-pinterest"></i> </a> <?php } ?>
                        <?php  if(!empty($options['linkedin-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['linkedin-url']); ?>"><i class="fab fa-linkedin-in"></i> </a> <?php } ?>
                        <?php  if(!empty($options['youtube-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['youtube-url']); ?>"><i class="fab fa-youtube"></i> </a> <?php } ?>
                        <?php  if(!empty($options['tumblr-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['tumblr-url']); ?>"><i class="fab fa-tumblr"></i> </a> <?php } ?>
                        <?php  if(!empty($options['dribbble-url'])) { ?><a rel="nofollow" target="_blank" href="<?php echo esc_url($options['dribbble-url']); ?>"><i class="fab fa-dribbble"></i> </a> <?php } ?>
                        <?php  if(!empty($options['rss-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php  (!empty($options['rss-url'])) ? $url = esc_url($options['rss-url']) : $url = esc_url(get_bloginfo('rss_url')); echo esc_url($url); ?>"> <i class="fas fa-rss"></i> </a><?php } ?>
                        <?php  if(!empty($options['github-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['github-url']); ?>"><i class="fab fa-github"></i></a> <?php } ?>
                        <?php  if(!empty($options['behance-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['behance-url']); ?>"> <i class="fab fa-behance"></i> </a> <?php } ?>
                        <?php  if(!empty($options['instagram-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['instagram-url']); ?>"><i class="fab fa-instagram"></i></a> <?php } ?>
                        <?php  if(!empty($options['stackexchange-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['stackexchange-url']); ?>"><i class="fab fa-stack-exchange"></i></a> <?php } ?>
                        <?php  if(!empty($options['soundcloud-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['soundcloud-url']); ?>"><i class="fab fa-soundcloud"></i></a> <?php } ?>
                        <?php  if(!empty($options['flickr-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['flickr-url']); ?>"><i class="fab fa-flickr"></i></a> <?php } ?>
                        <?php  if(!empty($options['spotify-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['spotify-url']); ?>"><i class="fab fa-spotify"></i></a> <?php } ?>
                        <?php  if(!empty($options['steam-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['steam-url']); ?>"><i class="fab fa-steam"></i></a> <?php } ?>
                        <?php  if(!empty($options['vk-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['vk-url']); ?>"><i class="fab fa-vk"></i></a> <?php } ?>
                        <?php  if(!empty($options['vine-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['vine-url']); ?>"><i class="fab fa-vine"></i></a> <?php } ?>
                        <?php  if(!empty($options['twitch-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['twitch-url']); ?>"><i class="fab fa-twitch"></i></a> <?php } ?>
                        <?php  if(!empty($options['discord-url'])) { ?> <a rel="nofollow" target="_blank" href="<?php echo esc_url($options['discord-url']); ?>"><i class="fab fa-discord"></i></a> <?php } ?>
                    </div>
                <?php } ?>


                <?php if(!isset($options['header-settings-search'])) $options['header-settings-search'] = 0; ?>
                <?php if($options['header-settings-search'] == '1'){ ?>
                    <div class="hsearch search-wrap">
                        <button id="btn-search" class="btn btn--search"><i class="fas fa-search icon icon--search"></i></button>
                    </div>
                <?php } ?>

                <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                    <?php if(isset($options['enable_cart']) && $options['enable_cart'] == '1'){ ?>
                        <div class="hsearch hcart">
                            <a class="btn"><i class="fas fa-shopping-bag" aria-hidden="true"></i> <span><?php if(isset($woocommerce->cart->cart_contents_count))echo esc_attr($woocommerce->cart->cart_contents_count); ?> </span></a>
                            <?php if ($woocommerce) { ?>

                                <?php if(!isset($options['cart_in_woo_pages'])) $options['cart_in_woo_pages'] = '0'; ?>
                                <?php if($options['cart_in_woo_pages'] == '1'){ ?>
                                    <?php if(is_woocommerce()){ ?>
                                        <?php  esc_html_e('Your cart.', 'respawn'); ?>


                                        <div class="cart-notification">
                                            <span class="item-name"></span> <?php  esc_html_e('was successfully added to your cart.', 'respawn'); ?>
                                        </div>
                                        <?php the_widget( 'WC_Widget_Cart', 'title= ' ); ?>

                                    <?php } ?>

                                <?php }else{ ?>

                                    <div class="cart-notification">
                                        <span class="item-name"></span> <?php  esc_html_e('was successfully added to your cart.', 'respawn'); ?>
                                    </div>
                                    <?php the_widget( 'WC_Widget_Cart', 'title= ' ); ?>

                                <?php } ?>
                            <?php } ?>

                        </div>
                    <?php } ?>
                <?php } ?>


                <div class="clear"></div>
            </div>
        </div>


        <div id="search_wrapper">
            <form method="get" id="searchForma">
                <i class="fas fa-search"></i>
                <a id="search_close"><i class="fas fa-times"></i></a>
                <input type="text" class="field" name="s" placeholder="<?php esc_attr_e('Enter your search', 'respawn'); ?>">
                <input type="submit" class="submit" value="">
            </form>

        </div>

    </header>



    <!-- end Custom menu link HEADER -->


    <?php /* init vars*/
    /*page*/
    $single_page_subtitle_value = '';
    $single_page_subtitle_text = '';

    /*post*/
    $single_post_subtitle_value = '';
    $single_post_subtitle_text = '';

    $title = '';
    ?>

    <!-- page -->
    <?php if(isset($post->ID)){ ?>
        <?php $single_page_subtitle_value = get_post_meta($post->ID, 'page_subtitle', true); ?>
        <?php $single_page_subtitle_text = get_post_meta($post->ID, 'page_subtitle_text', true); ?>
        <?php $single_page_header = get_post_meta($post->ID, 'page_header', true); ?>
    <?php }else{ ?>
        <?php $single_page_subtitle_value = ''; ?>
        <?php $single_page_subtitle_text = ''; ?>
        <?php $single_page_header = ''; ?>
    <?php } ?>

    <!-- post -->
    <?php if(isset($post->ID)){ ?>
        <?php $single_post_header = get_post_meta($post->ID, 'post_header', true); ?>
    <?php }else{ ?>
        <?php $single_post_header = ''; ?>
    <?php } ?>

    <?php
    if ( class_exists( 'WooCommerce' ) ) {
        if (is_shop()){ $title = get_the_title(respawn_get_ID_by_slug ('shop'));}
        else{ if(is_tag()){ $title = get_query_var('tag' ); }elseif(is_tax()){$title = get_queried_object()->name;}elseif(is_category()){$title = get_the_category_by_ID(get_query_var('cat'));}elseif(is_author()){$title = get_the_author_meta('nickname', get_query_var('author' )). esc_html__('\'s posts','respawn');}elseif(is_archive()){ ?>
            <?php if ( is_day() ) : ?>
                <?php /* translators: %s: archives term */ ?>
                <?php $title = sprintf( esc_html__( 'Daily Archives: %s', 'respawn' ), get_the_date() ); ?>
            <?php elseif ( is_month() ) : ?>
                <?php /* translators: %s: archives term */ ?>
                <?php $title = sprintf( esc_html__( 'Monthly Archives: %s', 'respawn' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'respawn' ) ) ); ?>
            <?php elseif ( is_year() ) : ?>
                <?php /* translators: %s: archives term */ ?>
                <?php $title = sprintf( esc_html__( 'Yearly Archives: %s', 'respawn' ), get_the_date( _x( 'Y', 'yearly archives date format', 'respawn' ) ) ); ?>
            <?php else : ?>
                <?php $title = esc_html__( 'Blog Archives', 'respawn' ); ?>
            <?php endif; }elseif(is_home()){$title = get_bloginfo('name');}else{$title = get_the_title();} }
    }else{  if(is_tag()){$title = get_query_var('tag' );}elseif(is_tax()){$title = get_queried_object()->name;}elseif(is_category()){$title = get_the_category_by_ID(get_query_var('cat'));}elseif(is_author()){$title = get_the_author_meta('nickname', get_query_var('author' )). esc_html__('\'s posts','respawn');}elseif(is_archive()){ ?>
        <?php if ( is_day() ) : ?>
            <?php /* translators: %s: archives term */ ?>
            <?php $title = sprintf( esc_html__( 'Daily Archives: %s', 'respawn' ), get_the_date() ); ?>
        <?php elseif ( is_month() ) : ?>
            <?php /* translators: %s: archives term */ ?>
            <?php $title = sprintf( esc_html__( 'Monthly Archives: %s', 'respawn' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'respawn' ) ) ); ?>
        <?php elseif ( is_year() ) : ?>
            <?php /* translators: %s: archives term */ ?>
            <?php $title = sprintf( esc_html__( 'Yearly Archives: %s', 'respawn' ), get_the_date( _x( 'Y', 'yearly archives date format', 'respawn' ) ) ); ?>
        <?php else : ?>
            <?php $title = esc_html__( 'Blog Archives', 'respawn' ); ?>
        <?php endif; }elseif(is_home()){$title = get_bloginfo('name');}else{$title = get_the_title();} } ?>

    <?php if(!isset($options['page-title-subtitle'])) $options['page-title-subtitle'] =  ''; ?>
    <?php if(!isset($options['header-settings-switch']))$options['header-settings-switch'] = '1'; ?>

    <?php if(get_post_type() == 'team'){ ?>

        <div class="team-header page-title-wrap" data-type="<?php echo esc_attr($title); ?>">
            <div class="page-title-bg <?php echo esc_attr($rest_parallax); ?>"></div>
            <div class="page-title-tint"></div>
            <div class="container header-flex <?php echo esc_attr($header_parallax); ?>">

                <?php
                if(has_post_thumbnail($post->ID)) {
                    echo '<img alt="'.esc_attr__("team_image","respawn").'" src="'.get_the_post_thumbnail_url($post->ID).'" />';
                }
                ?>


                <h1>
                    <?php echo esc_attr($title); ?>
                </h1>

                <?php if($single_page_subtitle_value == 'subtitle'){ ?>
                    <h2><?php echo esc_attr($single_page_subtitle_text);?></h2>
                <?php } ?>

            </div>
        </div>

    <?php }elseif(get_post_type() == 'player'){ ?>


        <!-- page -->
        <?php if($options['header-settings-switch'] == '1' and ($single_page_header == 'yes' or empty($single_page_header)) ){ ?>

            <div class="page-title-wrap " data-type="<?php echo esc_attr($title); ?>">
                <div class="page-title-bg <?php echo esc_attr($rest_parallax); ?>"></div>
                <div class="page-title-tint"></div>
                <div class="container header-flex <?php echo esc_attr($header_parallax); ?>">
                    <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                        <h1>
                            <?php if (is_shop()){
                                echo get_the_title(get_page_by_path ('shop'));
                            }else{
                                echo esc_attr($title);
                            } ?>
                        </h1>
                    <?php }else{ ?>
                        <h1>
                            <?php echo esc_attr($title); ?>
                        </h1>
                    <?php } ?>
                    <?php if($single_page_subtitle_value == 'subtitle'){ ?>
                        <h4><?php echo esc_attr($single_page_subtitle_text);?></h4>
                    <?php }elseif($single_page_subtitle_value == 'breadcrumbs'){ ?>
                        <h4><?php
                            if ( function_exists('yoast_breadcrumb') ) {
                                yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                            }
                            ?></h4>
                    <?php }elseif($single_page_subtitle_value == 'nothing'){} ?>

                    <?php if(empty($single_page_subtitle_value)){ ?>

                        <?php if(isset($options['page-title-subtitle']) && $options['page-title-subtitle'] == '1'){ ?>
                            <h4><?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                                }
                                ?></h4>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>



    <?php }elseif(is_single()){ ?>

        <!-- post -->
        <?php if($options['header-settings-switch'] == '1' and ($single_post_header == 'yes' or empty($single_post_header)) ){ ?>

            <div class="page-title-wrap blog-ptw  ">
                <div class="page-title-bg <?php echo esc_attr($rest_parallax); ?>"></div>
                <div class="page-title-tint"></div>
                <div class="container header-flex <?php echo esc_attr($rest_parallax); ?>">

                    <?php $postcats = wp_get_post_categories($post->ID);

                    if(!isset($options['general-settings-color-selector']))$options['general-settings-color-selector'] = '#ff3e58';

                    if ($postcats) { ?>

                        <div class="pmeta-category">
                            <?php
                            $i = 0;
                            foreach($postcats as $c) {
                                $postcats1 = wp_get_post_categories($post->ID);
                                $cat_data = get_option("category_$postcats1[$i]");
                                if(!isset($cat_data['catBG'])) $cat_data['catBG'] = '#eeeeee';
                                $cat = get_category( $c );  ?>
                                <a class="cat_color_<?php echo esc_attr(str_replace("#","",$cat_data['catBG'])); ?>_border cat_color_<?php echo esc_attr(str_replace("#","",$cat_data['catBG'])); ?>_color"  href="<?php echo esc_url(get_category_link($cat->cat_ID)); ?>"> <?php echo esc_attr($cat->cat_name) . ' '; ?> </a>
                                <?php $i++; } ?>
                        </div>
                    <?php } ?>
                    <h1>
                        <?php echo esc_attr($title); ?>
                    </h1>
                    <?php if( class_exists( 'WooCommerce' ) && is_product()){ ?>
                        <h4><?php
                            if ( function_exists('yoast_breadcrumb') ) {
                                yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                            }
                            ?></h4>
                    <?php }else{ ?>

                        <?php setup_postdata($post); ?>
                        <div class="post-meta">
							<span class="pmeta-author">
								<i class="icon-user"></i>
								<?php esc_html_e('By', 'respawn'); ?>
								<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ))); ?>" title="<?php esc_attr_e("View all posts by",  'respawn'); ?> <?php echo esc_attr(get_the_author()); ?>" rel="author"><?php echo esc_attr(the_author_meta( 'display_name' )); ?></a>
							</span>
                            <span class="pmeta-date"><i class="icon-calendar"></i> <?php the_time(get_option('date_format')); ?></span>

                            <?php if (  class_exists( 'Disqus' )){ ?>
                                <span class="pmeta-comments"><a  href="<?php echo the_permalink(); ?>#comments" >
					        <i class="icon-bubbles"></i> <?php comments_number( esc_html__('0 Comments', 'respawn'), esc_html__('1 Comment', 'respawn'), esc_html__('% Comments', 'respawn') ) ?> </a></span>

                            <?php }else{ ?>
                                <span class="pmeta-comments"><a data-original-title="<?php comments_number( esc_attr__('No comments in this post', 'respawn'), esc_attr__('One comment in this post', 'respawn'), esc_attr__('% comments in this post', 'respawn')); ?>" href="<?php echo the_permalink(); ?>#comments" data-toggle="tooltip">
					        <i class="icon-bubbles"></i> <?php comments_number( esc_html__('0 Comments', 'respawn'), esc_html__('1 Comment', 'respawn'), esc_html__('% Comments', 'respawn') ) ?></a></span>

                            <?php } ?>
                            <?php if(has_tag()){ ?>
                                <span class="pmeta-tags"><i class="icon-tag" aria-hidden="true"></i> <?php the_tags( '', ', '); ?></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>


    <?php }elseif(is_home()){  ?>

        <?php	/*page*/
        $single_page_subtitle_value = '';
        $single_page_subtitle_text = '';
        ?>
        <!-- page -->
        <?php $single_page_subtitle_value = get_post_meta(get_option('page_for_posts'), 'page_subtitle', true); ?>
        <?php $single_page_subtitle_text = get_post_meta(get_option('page_for_posts'), 'page_subtitle_text', true); ?>
        <?php $single_page_header = get_post_meta(get_option('page_for_posts'), 'page_header', true); ?>

        <?php if($options['header-settings-switch'] == '1' and ($single_page_header == 'yes' or empty($single_page_header)) ){ ?>

            <div class="page-title-wrap">
                <div class="page-title-bg <?php echo esc_attr($rest_parallax); ?>"></div>
                <div class="page-title-tint"></div>
                <div class="container header-flex <?php echo esc_attr($header_parallax); ?>">
                    <?php if ( get_option('page_on_front') != '0') { ?>
                        <h1>
                            <?php echo esc_attr($title); ?>
                        </h1>
                    <?php } ?>
                    <?php if($single_page_subtitle_value == 'subtitle'){ ?>
                        <h4><?php echo esc_attr($single_page_subtitle_text);?></h4>
                    <?php }elseif($single_page_subtitle_value == 'breadcrumbs'){ ?>
                        <h4><?php
                            if ( function_exists('yoast_breadcrumb') ) {
                                yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                            }
                            ?></h4>
                    <?php }elseif($single_page_subtitle_value == 'nothing'){} ?>

                    <?php if(empty($single_page_subtitle_value)){ ?>

                        <?php if(isset($options['page-title-subtitle']) && $options['page-title-subtitle'] == '1'){ ?>
                            <h4><?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                                }
                                ?></h4>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>


    <?php }elseif(is_category()){  ?>
        <?php if(!isset($options['header-settings-switch']))$options['header-settings-switch'] = '1'; ?>
        <?php if($options['header-settings-switch'] == '1'){ ?>

            <div class="page-title-wrap">
                <div class="page-title-bg <?php echo esc_attr($rest_parallax); ?>"></div>
                <div class="page-title-tint"></div>
                <div class="container header-flex <?php echo esc_attr($header_parallax); ?>">
                    <h1>
                        <?php echo esc_attr($title); ?>
                    </h1>
                    <?php if(empty($single_page_subtitle_value)){ ?>

                        <?php if(isset($options['page-title-subtitle']) && $options['page-title-subtitle'] == '1'){ ?>
                            <h4><?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                                }
                                ?></h4>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>


    <?php }elseif(is_search()){ ?>
        <!-- page -->
        <?php if($options['header-settings-switch'] == '1' and ($single_page_header == 'yes' or empty($single_page_header)) ){ ?>

            <div class="page-title-wrap">
                <div class="page-title-bg <?php echo esc_attr($rest_parallax); ?>"></div>
                <div class="page-title-tint"></div>
                <div class="container header-flex <?php echo esc_attr($header_parallax); ?>">
                    <h1>
                        <?php esc_html_e('Search: ', 'respawn');  echo get_search_query(); ?>
                    </h1>
                    <?php if($single_page_subtitle_value == 'subtitle'){ ?>
                        <h4><?php echo esc_attr($single_page_subtitle_text);?></h4>
                    <?php }elseif($single_page_subtitle_value == 'breadcrumbs'){ ?>
                        <h4><?php
                            if ( function_exists('yoast_breadcrumb') ) {
                                yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                            }
                            ?></h4>
                    <?php }elseif($single_page_subtitle_value == 'nothing'){} ?>

                    <?php if(empty($single_page_subtitle_value)){ ?>

                        <?php if(isset($options['page-title-subtitle']) && $options['page-title-subtitle'] == '1'){ ?>
                            <h4><?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                                }
                                ?></h4>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>

    <?php }else{  ?>
        <!-- page -->

        <?php if($options['header-settings-switch'] == '1' and ($single_page_header == 'yes' or empty($single_page_header)) ){ ?>

            <div class="page-title-wrap " data-type="<?php echo esc_attr($title); ?>">
                <div class="page-title-bg <?php echo esc_attr($rest_parallax); ?>"></div>
                <div class="page-title-tint"></div>
                <div class="container header-flex <?php echo esc_attr($header_parallax); ?>">
                    <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                        <h1>
                            <?php if (is_shop()){
                                echo get_the_title(get_page_by_path ('shop'));
                            }else{
                                echo esc_attr($title);
                            } ?>
                        </h1>
                    <?php }else{ ?>
                        <h1>
                            <?php echo esc_attr($title); ?>
                        </h1>
                    <?php } ?>
                    <?php if($single_page_subtitle_value == 'subtitle'){ ?>
                        <h4><?php echo esc_attr($single_page_subtitle_text);?></h4>
                    <?php }elseif($single_page_subtitle_value == 'breadcrumbs'){ ?>
                        <h4><?php
                            if ( function_exists('yoast_breadcrumb') ) {
                                yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                            }
                            ?></h4>
                    <?php }elseif($single_page_subtitle_value == 'nothing'){} ?>

                    <?php if(empty($single_page_subtitle_value)){ ?>

                        <?php if(isset($options['page-title-subtitle']) && $options['page-title-subtitle'] == '1'){ ?>
                            <h4><?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                                }
                                ?></h4>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>

    <?php } ?>

    <div class="main-content <?php echo esc_html($content_class); ?>">