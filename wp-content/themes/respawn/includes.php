<?php

#-----------------------------------------------------------------#
# Theme includes
#-----------------------------------------------------------------#

require_once get_theme_file_path('includes/functions/class-tgm-plugin-activation.php');
require_once get_theme_file_path('includes/functions/categories-images/categories-images.php');
require_once get_theme_file_path('elementor/init.php');

if (class_exists( 'ReduxFrameworkPlugin' )) {
    require_once get_parent_theme_file_path('options-config.php');
}

if ( class_exists( 'Respawn_Types' ) ) {
    require_once WP_PLUGIN_DIR . '/respawn-types/heart/love/heart-love.php';
    require_once WP_PLUGIN_DIR . '/respawn-types/wp-team-matches/wp-team-matches.php';
    require_once  WP_PLUGIN_DIR . '/respawn-types/widgets/instagram/instagram.php';
    require_once  WP_PLUGIN_DIR . '/respawn-types/widgets/gallery/gallery.php';
}

#-----------------------------------------------------------------#
# Theme support
#-----------------------------------------------------------------#

add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-formats', array('quote','video','audio','gallery') );
add_theme_support( 'yoast-seo-breadcrumbs' );

$defaults = array(
'default-repeat'         => 'no-repeat',
'default-position-x'     => 'left',
'default-position-y'     => 'top',
);
add_theme_support( 'custom-background', $defaults );

$defaults = array(
'width'                  => 0,
'height'                 => 0,
'flex-height'            => false,
'flex-width'             => false,
'uploads'                => false,
'random-default'         => false,
'header-text'            => false,
);
add_theme_support( 'custom-header', $defaults );

if ( ! isset( $content_width ) ) $content_width = 1300;