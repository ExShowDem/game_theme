<?php

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Posts list style.
 *
 * Elementor widget that displays set of posts in different layouts.
 *
 * Class Widget_SW_Posts_List
 * @package Elementor
 */
class Widget_SW_Posts_List extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve posts list widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'posts_list';
    }

    /**
     * Get widget title.
     *
     * Retrieve posts list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('SW - Posts List', 'respawn');
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
     * Retrieve posts list widget icon.
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
     * Register posts list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_posts_list_content',
            [
                'label' => esc_html__('Content', 'respawn'),
            ]
        );


        $this->add_control(
            'title',
            [
                'label' => esc_html__(' Title', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add title text', 'respawn'),
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
            'section_posts_list_style',
            [
                'label' => esc_html__('Style', 'respawn'),
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

    protected function render()
    {
        //Get values (in array "settings")
        $settings = $this->get_settings();

        //Heading
        $title = !empty($settings['title']) ? $settings['title'] : '';
        $categories = $settings['categories'];
        $ct = [];

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
        ?>

        <div class="newslist block-wrap">

            <?php if (!empty($title)) { ?>

                <?php

                $blog_page = get_pages(
                    array(
                        'meta_key' => '_wp_page_template',
                        'meta_value' => 'tmp-blog.php'
                    )
                );

                $blog_page_id = '';

                if (isset($blog_page[0]->ID))
                    $blog_page_id = $blog_page[0]->ID;

                $link = get_permalink($blog_page_id);

                if (count($ct) == 1)
                    $link = get_category_link($ct[0]);
                ?>

                <h4 class="block-title">
                    <?php echo esc_html($title); ?>
                    <a href="<?php echo esc_url($link); ?>"><?php esc_html_e('see all', 'respawn'); ?>
                        <svg aria-hidden="true" data-prefix="fas" data-icon="arrow-right" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                             class="svg-inline--fa fa-arrow-right fa-w-14 fa-2x">
                            <path fill="currentColor"
                                  d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"
                                  class=""></path>
                        </svg>
                    </a>
                </h4>

            <?php } ?>

            <ul>
                <?php while ($posts->have_posts()) : $posts->the_post(); ?>

                    <li>

                        <div class="nw-img">

                            <?php
                            global $post;
                            $categories = wp_get_post_categories($post->ID);
                            $options = respawn_get_theme_options();

                            $cat_data = get_option("category_$categories[0]");
                            if (!isset($options['general-settings-color-selector'])) $options['general-settings-color-selector'] = '#696bff';
                            if (empty($cat_data)) $cat_data['catBG'] = $options['general-settings-color-selector'];

                            ?>

                            <a class="spcategory <?php echo 'cat_color_' . esc_attr(str_replace("#", "", $cat_data['catBG'])) . '_background_color cat_color_' . esc_attr(str_replace("#", "", $cat_data['catBG'])) . '_border'; ?>" href="<?php echo esc_url(get_category_link($categories[0])); ?>" href="<?php echo the_permalink(); ?>#comments">
                                <i class="icon-bubbles"></i> <?php comments_number('0', '1', '%') ?>
                            </a>

                            <a href="<?php the_permalink(); ?>">

                                <?php if (has_post_thumbnail()) {
                                    $thumb = get_post_thumbnail_id();
                                    $img_url = wp_get_attachment_url($thumb); //get img URL
                                    $image = respawn_aq_resize($img_url, 125, 125, true, '', true); //resize & crop img
                                    ?>

                                    <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>"/>

                                <?php }  ?>
                            </a>

                        </div>

                        <div class="nw-info">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                            <div>

                                <a class="spcategory <?php echo 'cat_color_' . esc_attr(str_replace("#", "", $cat_data['catBG'])) . '_background_color cat_color_' . esc_attr(str_replace("#", "", $cat_data['catBG'])) . '_border'; ?> href="<?php echo esc_url(get_category_link($categories[0])); ?>">
                                    <?php echo get_cat_name($categories[0]); ?>
                                </a>

                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php the_author(); ?>
                                </a>

                                <span>- <?php the_time(get_option('date_format')); ?></span>

                            </div>

                            <p><?php the_excerpt(); ?></p>

                        </div>

                    </li>

                <?php endwhile;
                wp_reset_postdata(); ?>

            </ul>

        </div>


        <?php
    }

}

