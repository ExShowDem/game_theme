<?php namespace Elementor; ?>

</div> <!-- content -->


<footer>


    <?php if(class_exists('Elementor\Shapes')){ ?>

        <?php

        global $post;
        $options = respawn_get_theme_options();
        $shape_class = '';
        $shape_page = '';

        if(isset($post->ID))
        $shape_page = get_post_meta($post->ID, 'page-shape-type', true);
        $shape_global = $options['shape-type'];

        if(!empty($shape_page) && $shape_page != 'none'){

            $shape = $shape_page;
            $shape_class = "elementor-shape-page elementor-shape-footer";

        }elseif(!empty($shape_global) && $shape_global != 'none' ){

            $shape = $shape_global;
            $shape_class = "elementor-shape-global elementor-shape-footer";

        }

        ?>
            <?php if( ($shape_global != 'none' or $shape_page != 'none') && !empty($shape)  ){ ?>
                <div class="elementor-shape elementor-shape-bottom custom-shape <?php echo esc_attr($shape_class); ?>" data-negative="false">

                    <?php $shapes = new Shapes; ?>

                    <?php include $shapes::get_shape_path($shape, false); ?>

                </div>
            <?php } ?>

    <?php } ?>

    <?php $options = respawn_get_theme_options(); ?>
    <?php
    $footer_column_class = '';
    $footer_first_column = '';
    $footer_second_column = '';
    $footer_third_column = '';
    $footer_fourth_column = '';
    ?>
    <?php
    if(!isset($options['footer_columns'])) $options['footer_columns'] = '4';
    if($options['footer_columns'] == '1'){
        $footer_column_class = 'footer_onecolumns';
        $footer_first_column = true;
    }elseif($options['footer_columns'] == '2'){
        $footer_column_class = 'footer_twocolumns';
        $footer_second_column = true;
    }elseif($options['footer_columns'] == '3'){
        $footer_column_class = 'footer_threecolumns';
        $footer_third_column = true;
    }elseif($options['footer_columns'] == '4'){
        $footer_column_class = 'footer_fourcolumns';
        $footer_fourth_column = true;
    }
    ?>
    <?php if(!isset($options['top_footer_area'])) $options['top_footer_area'] = '1'; ?>
    <?php if($options['top_footer_area'] == '1' && (is_active_sidebar('footer_widget_one') or is_active_sidebar('footer_widget_two') or is_active_sidebar('footer_widget_three') or is_active_sidebar('footer_widget_four'))){ ?>
    <div class="main_footer <?php echo esc_attr($footer_column_class); ?>">
        <div class="container">
            <?php if($footer_first_column or $footer_second_column or $footer_third_column or  $footer_fourth_column){ ?>
            <div class="footer_column">
                <div class="fc_inner">
                    <!-- Footer widget area 1 -->
                     <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget Area 1') ) : endif; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($footer_second_column or $footer_third_column or  $footer_fourth_column){ ?>
            <div class="footer_column">
                <div class="fc_inner">
                    <!-- Footer widget area 2 -->
                     <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget Area 2') ) : endif; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($footer_third_column or $footer_fourth_column){ ?>
            <div class="footer_column">
                <div class="fc_inner">
                    <!-- Footer widget area 3 -->
                     <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget Area 3') ) : endif; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($footer_fourth_column){ ?>
            <div class="footer_column">
                <div class="fc_inner">
                    <!-- Footer widget area 4 -->
                     <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget Area 4') ) : endif; ?>
                </div>
            </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!isset($options['bottom_footer_area'])) $options['bottom_footer_area'] = '1'; ?>
    <?php if($options['bottom_footer_area'] == '1'){ ?>
    <div class="footer_bottom">
        <div class="container">
            <div class="fb_text">
                <?php if(isset($options['footer-copyright-text'])) echo wp_kses_post($options['footer-copyright-text']); ?>
            </div>
            <div class="fb_social">
                <?php if(!isset($options['enable_social_in_footer'])) $options['enable_social_in_footer'] = '0'; ?>
                <?php if($options['enable_social_in_footer'] == 1){ ?>
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
            </div>
            <div class="clear"></div>
        </div>
    </div><?php } ?>
</footer>
<?php if(!isset($options['general-settings-to-top'])) $options['general-settings-to-top'] = '1'; ?>
<?php if($options['general-settings-to-top']== '1') { ?>
<a id="back-to-top" title="<?php esc_attr_e('Back to top', 'respawn');?>"><i class="fas fa-angle-double-up" aria-hidden="true"></i></a>
<?php } ?>
</div> <!-- wrapper -->

<div class="headsearch">
    <button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form"><i class="fas fa-times"></i></button>
    <form  method="get" class="search__form" action="<?php echo esc_url( site_url( '/' ) ); ?>" >
        <div class="search__form-inner">
            <input class="search__input" name="s" type="search" placeholder="<?php esc_attr_e('Search...', 'respawn'); ?>" autocomplete="off" autocapitalize="off" spellcheck="false" />
            <input type="hidden" name="post_type[]" value="post" />
            <input type="hidden" name="post_type[]" value="page" />
            <input type="hidden" name="post_type[]" value="matches" />
            <input type="hidden" name="post_type[]" value="players" />
            <input type="hidden" name="post_type[]" value="team" />
        </div>
        <span class="search__info"><?php esc_html_e('Hit enter to search or ESC to close', 'respawn'); ?></span>
    </form>
</div><!-- /search -->
<?php wp_footer(); ?>
</body></html>