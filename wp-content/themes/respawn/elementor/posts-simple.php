<?php

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


/**
 * Blog posts slider.
 *
 * Elementor widget that displays set of posts in different layounts.
 *
 * Class Widget_post_slider
 * @package Elementor
 */
class Widget_SW_Posts_Simple extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve posts simple widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'sw_posts_simple';
    }

    /**
     * Get widget title.
     *
     * Retrieve posts simple widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('SW - Posts Simple', 'respawn');
    }


    /**
     * Get widget category
     * @return array
     */
    public function get_categories()
    {
        return ['skywarrior'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve posts simple widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        // Icon name from the Elementor font file, as per https://pojome.github.io/elementor-icons/
        return 'eicon-info-box';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['post', 'posts'];
    }

    /**
     * Register posts simple widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_posts_simple_content',
            [
                'label' => esc_html__('Content', 'respawn'),
            ]
        );

        $categories = get_categories(

            array(
                'type' => 'post',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => 1,
                'taxonomy' => 'category',

            ));

        foreach ($categories as $cat) {
            $cats[$cat->cat_name] = $cat->cat_name;
        }
        if (!isset($cats)) $cats = '';

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'respawn'),
                'type' => 'multiselect',
                'options' => $cats,
                'title' => esc_html__('Select categories', 'respawn'),
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_posts_simple_style',
            [
                'label' => esc_html__('Style', 'respawn'),
            ]
        );

        $this->add_control(
            'spacing',
            [
                'label' => esc_html__('Spacing', 'respawn'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'respawn'),
                'label_off' => esc_html__('No', 'respawn'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
            ]
        );

        $this->add_control(
            'number',
            ['label' => esc_html__('Number of items', 'respawn'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'title' => esc_html__('Add number of items', 'respawn'),
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render sw posts widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        //Get values (in array "settings")
        $settings = $this->get_settings();

        $categories = $settings['categories'];
        $ct = array();

        if (is_array($categories)) {
            foreach ($categories as $category) {
                $cat_id = get_cat_ID($category);
                array_push($ct, $cat_id);
            }
        }

        $column = '';

        switch ($settings['columns']) {
            case '1':
                $column = 'c1';
                break;
            case '2':
                $column = 'c2';
                break;
            case '3':
                $column = 'c3';
                break;
            case '4':
                $column = 'c4';
                break;
            case '5':
                $column = 'c5';
                break;

        }

        $spacing = '';
        if ($settings['spacing'] == 'yes') {
            $spacing = 'cspacing';
        }

        $posts = new \WP_Query(array(
            'showposts' => $settings['number'],
            'category__in' => $ct
        ));
        ?>

        <div class="psimple-wrap <?php echo esc_attr($column);
        echo ' ';
        echo esc_attr($spacing); ?>">

            <?php while ($posts->have_posts()) : $posts->the_post(); ?>

                <?php
                global $post;
                $post_format = get_post_format($post->ID);
                $no_image_class = '';
                $vertical_class = '';


                if (has_post_thumbnail($post->ID)) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb); //get img URL
                    $image_link = respawn_aq_resize($img_url, 438, 300, true, true, true);

                } else {
                    if (get_post_format($post->ID) == 'gallery') {

                        $gallery = get_post_gallery_images($post->ID);
                        if (isset($gallery) && is_array($gallery)) {
                            $image_link = $gallery[0];
                        }

                    } else {
                        $no_image_class = 'no_image';
                    }
                }


                if (isset($image_link)) {
                    list($width, $height) = getimagesize($image_link);
                    if ($height > $width + 260) {
                        $vertical_class = 'vertical_image';
                    }
                }

                if ($post_format == 'quote') {
                    $title = get_post_meta($post->ID, 'quote-value', true);
                    if (empty($title)) $title = esc_html__('Please insert a quote', 'respawn');
                } else {
                    $title = get_the_title();
                }

                ?>

                <div id="post-<?php echo esc_attr($post->ID); ?>" <?php post_class(esc_attr($vertical_class) . ' ' . esc_attr($no_image_class) . '  blogs-style1 spcard '); ?>>

                    <div class="spwrapper">

                        <div class="spbgimg blog-roll-i">

                            <a href="<?php the_permalink(); ?>" class="spvideolink"><i class="fas fa-play"
                                                                                       aria-hidden="true"></i></a>
                            <a href="<?php the_permalink(); ?>" class="spaudiolink"><i class="fas fa-microphone"
                                                                                       aria-hidden="true"></i></a>

                            <a href="<?php the_permalink(); ?>">
                                <?php if (isset($image_link)) { ?>
                                    <img alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>"
                                         src="<?php echo esc_url($image_link); ?>"/>
                                <?php } ?>
                            </a>

                        </div>

                        <div class="spdata">

                            <div class="spcontent">

                                <div class="spheader">

                                    <?php
                                    $options = respawn_get_theme_options();
                                    $postcats = wp_get_post_categories($post->ID);

                                    if ($postcats) {

                                        $cat_data = get_option("category_$postcats[0]");
                                        if (!isset($options['general-settings-color-selector'])) $options['general-settings-color-selector'] = '#696bff';
                                        if (empty($cat_data)) $cat_data['catBG'] = $options['general-settings-color-selector'];

                                        foreach ($postcats as $c) {
                                            $cat = get_category($c); ?>
                                            <a class="spcategory <?php echo 'cat_color_' . esc_attr(str_replace("#", "", $cat_data['catBG'])) . '_color cat_color_' . esc_attr(str_replace("#", "", $cat_data['catBG'])) . '_border'; ?>"
                                               href="<?php echo esc_url(get_category_link($cat->cat_ID)); ?>"> <?php echo esc_attr($cat->cat_name) . ' '; ?> </a>
                                            <?php
                                            break;
                                        }
                                    }

                                    $respawn_allowed = array(
                                        'a' => array(
                                            'class' => array(),
                                            'id' => array(),
                                            'title' => array(),
                                        ),
                                        'i' => array(
                                            'class' => array(),
                                        ),
                                        'span' => array()
                                    );
                                    ?>
                                    <ul class="spmenu-content">
                                        <?php if (function_exists('respawn_return_heart_love')) { ?>
                                            <li><?php echo wp_kses(respawn_return_heart_love(), $respawn_allowed); ?></li><?php } ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>#comments" class="far fa-comments">
                                                <span><?php comments_number('0', '1', '%'); ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                                <h1 class="sptitle">
                                    <a rel="bookmark"
                                       href="<?php the_permalink(); ?>"><?php echo esc_attr($title); ?></a>
                                </h1>

                                <p class="sptext"><?php echo esc_html(respawn_excerpt(esc_attr(25))); ?></p>


                            </div>

                            <div class="spextra">

                                <span class="spauthor">

                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php if (function_exists('get_avatar')) {
                                            echo get_avatar(get_the_author_meta('email'), 40);
                                        } ?>
                                    </a>

                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <span><?php esc_html_e('by', 'respawn'); ?> <?php the_author_meta( 'display_name' ) ?></span>
                                    </a>

                                </span>

                                <div class="spdate">
                                    <i class="icon-calendar"
                                       aria-hidden="true"></i> <?php the_time(get_option('date_format')); ?>
                                </div>

                                <div class="sptags">
                                    <?php $tags_array = get_the_tags($post->ID); ?>
                                    <i class="icon-tag" aria-hidden="true"></i> <?php echo is_array($tags_array) ? count($tags_array) : 0 ?>
                                </div>
                            </div>

                        </div>

                        <i class="fas fa-quote-left" aria-hidden="true"></i>

                    </div>
                </div>

            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>


        <?php
    }

}