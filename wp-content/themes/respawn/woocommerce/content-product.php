<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
    return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
    $classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
    $classes[] = 'last';
}

$currency = '';

if ( class_exists( 'WooCommerce' ) ) {
    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
    $currency = get_woocommerce_currency_symbol();
}

$image_link = '';
if (has_post_thumbnail(get_the_ID())) {
    $thumb = get_post_thumbnail_id();
    $img_url = wp_get_attachment_url($thumb); //get img URL
    $image_link = respawn_aq_resize($img_url, 500, 620, true, true, true);

}
?>
<li class="col-3">

    <?php if ( class_exists( 'WooCommerce' ) ) { ?>
        <?php if ($product->is_on_sale()) { ?>
            <div class="product-tag">
                <span class="tag-sale"><?php esc_html_e('sale', 'respawn'); ?></span>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if(!empty($image_link)){ ?>
        <a href="<?php the_permalink(); ?>" class="pr-image">
            <img src="<?php echo esc_url($image_link); ?>" alt="<?php the_title(); ?>">
        </a>
    <?php } ?>

    <div class="product">
        <div class="product-wrapper">

            <a href="<?php the_permalink(); ?>" ><h5 class="product-title"><?php the_title(); ?></h5></a>

            <div class="product-price">

                <?php if ($product->is_on_sale()) { ?>

                    <span class="regular-price"><del><?php echo esc_html($currency); ?><?php echo esc_html($product->get_regular_price()); ?></del></span>

                    <span class="current-price"><?php echo esc_html($currency); ?><?php echo esc_html($product->get_sale_price()); ?></span>

                <?php } else { ?>

                    <span class="current-price"><?php echo esc_html($currency); ?><?php echo esc_html($product->get_regular_price()); ?></span>

                <?php } ?>

            </div>
            <a class="btn" href="?add-to-cart=<?php echo esc_attr(get_the_ID()); ?>"><?php esc_html_e('add to cart', 'respawn'); ?></a>
        </div>
    </div>

</li>