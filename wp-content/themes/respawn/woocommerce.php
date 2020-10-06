<?php get_header();?>
<?php $options = respawn_get_theme_options(); ?>

<div class="container">
		<div class="row">

		    <?php
		    if(!isset($options['main_shop_layout']))$options['main_shop_layout'] = 'right-sidebar';
            if(!isset($options['single_product_layout']))$options['single_product_layout'] = 'right-sidebar';
            $main_shop_layout = $options['main_shop_layout'];
            $single_product_layout = $options['single_product_layout'];

            if(is_product()){

                switch($single_product_layout) {
                    case 'no-sidebar':
                        echo '<div class="col-12 product-list">';
                         woocommerce_content();
                        echo '</div><!--/col-9-->';

                      break;
                    case 'right-sidebar':

                        echo '<div class="col-9 product-list">';
                            woocommerce_content();
                        echo '</div><!--/col-9-->';

                        echo '<div id="sidebar" class="col-3">';
                            get_sidebar();
                        echo '</div><!--/col-9-->';

                        break;

                    case 'left-sidebar':
                        echo '<div class="col-3">';
                            get_sidebar();
                        echo '</div><!--/col-9-->';

                        echo '<div class="col-9 product-list">';
                            woocommerce_content();
                        echo '</div><!--/col-9-->';

                        break;
                    default:
                        woocommerce_content();
                        break;
                }

            }

            //Main Shop page layout
            elseif(is_shop() || is_product_category() || is_product_tag()) {

                switch($main_shop_layout) {
                    case 'no-sidebar' :
                    echo '<div class="col-12 product-list">';
                        woocommerce_content();
                    echo '</div>'; ?>
                    <div class="clear"></div>
                    <?php    break;
                    case 'right-sidebar':

                        echo '<div class="col-9 product-list">';
                            woocommerce_content();
                        echo '</div><!--/col-9-->';

                        echo '<div id="sidebar" class="col-3">';
                            get_sidebar();
                        echo '</div><!--/col-9-->';

                        break;

                    case 'left-sidebar':
                        echo '<div id="sidebar" class="col-3">';
                            get_sidebar();
                        echo '</div><!--/col-9-->';

                        echo '<div class="col-9 product-list">';
                            woocommerce_content();
                        echo '</div><!--/col-9-->';
                        break;
                    default:
                        woocommerce_content();
                        break;
                }

            }

            //regular WooCommerce page layout
            else {
            echo '<div class="col-12 product-list">'; ?>
                <?php woocommerce_content(); ?>
            </div>
            <div class="clear"></div>
          <?php  }

             ?>

			</div>

		<div class="clear"></div>

</div>
<?php get_footer(); ?>