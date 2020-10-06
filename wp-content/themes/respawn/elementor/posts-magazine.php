<?php

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


/**
 * Posts magazine style.
 *
 * Elementor widget that displays set of posts in different layouts.
 *
 * Class Widget_SW_Posts_Magazine
 * @package Elementor
 */
class Widget_SW_Posts_Magazine extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve posts magazine widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'posts_magazine';
    }

    /**
     * Get widget title.
     *
     * Retrieve posts magazine widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('SW - Posts Magazine', 'respawn');
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
     * Retrieve posts magazine widget icon.
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
     * Register posts magazine widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_posts_magazine_content',
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
            'section_posts_magazine_style',
            [
                'label' => esc_html__('Style', 'respawn'),
            ]
        );

        $this->add_control(
            'number',
            ['label' => esc_html__('Number of items', 'respawn'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'max' => 6,
                'min' => 1,
                'title' => esc_html__('Add number of items', 'respawn'),
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render posts magazine widget output on the frontend.
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

        $posts = new \WP_Query(array(
            'showposts' => $settings['number'],
            'category__in' => $ct
        ));

        $class = '';
        switch ($settings['number']) {
            case '1':
                $class = 'magb1';
                break;
            case '2':
                $class = 'magb2';
                break;
            case '3':
                $class = 'magb3';
                break;
            case '4':
                $class = 'magb4';
                break;
            case '5':
                $class = 'magb5';
                break;
            case '6':
                $class = 'magb6';
                break;
            default:
                break;

        }

        $i = 1;
        ?>

        <ul class="magazine-blog <?php echo esc_attr($class); ?> ">

            <?php while ($posts->have_posts()) : $posts->the_post(); ?>

                <?php
                global $post;
                $post_format = get_post_format($post->ID);
                $no_image_class = '';
                $vertical_class = '';


                if (has_post_thumbnail($post->ID)) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb); //get img URL

                    switch ($i){
                        case '1':
                            $image_link = respawn_aq_resize($img_url, 1330, 450, true, true, true);
                            break;
                        case '2':
                            $image_link = respawn_aq_resize($img_url, 575, 450, true, true, true);
                            break;
                        case '3':
                            $image_link = respawn_aq_resize($img_url, 438, 300, true, true, true);
                            break;
                        case '4':
                            $image_link = respawn_aq_resize($img_url, 480, 250, true, true, true);
                            break;
                        case '5':
                            $image_link = respawn_aq_resize($img_url, 475, 250, true, true, true);
                            break;
                        default:
                            $image_link = respawn_aq_resize($img_url, 480, 250, true, true, true);
                            break;
                    }

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

                <li id="post-<?php echo esc_attr($post->ID); ?>" <?php post_class(esc_attr($vertical_class) . ' ' . esc_attr($no_image_class) . '  blogs-style1 spcard '); ?>>

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

                                    ?> <i>/</i> <?php the_time(get_option('date_format')); ?>

                                </div>


                                <h1 class="sptitle">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        if (in_array($i, [2, 4, 5, 6])) {
                                            echo substr($title, 0, 30);
                                            echo '...';
                                        } else {
                                            the_title();
                                        }
                                        ?>
                                    </a>
                                </h1>


                            </div>

                            <a href="<?php the_permalink(); ?>"> <?php esc_html_e('read more', 'respawn'); ?>
                                <svg aria-hidden="true" data-prefix="fas" data-icon="arrow-right" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                     class="svg-inline--fa fa-arrow-right fa-w-14 fa-2x">
                                    <path fill="currentColor"
                                          d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"
                                          class=""></path>
                                </svg>
                            </a>

                        </div>

                        <i class="fas fa-quote-left" aria-hidden="true"></i>

                    </div>
                </li>

                <?php $i++; endwhile;
            wp_reset_postdata(); ?>
        </ul>


        <?php
    }

}