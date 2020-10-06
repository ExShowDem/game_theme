<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Shop slider.
 *
 * Elementor widget that displays set of matches in slick slider.
 *
 * Class Widget_SW_Shop_Slider
 * @package Elementor
 */

class Widget_SW_Shop_Slider extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve shop slider widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'shop_slider';
    }

    /**
     * Get widget title.
     *
     * Retrieve shop slider widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'SW - Shop Slider', 'respawn' );
    }

    /**
     * Retrieve the list of scripts the shop slider widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'respawn_elementor_minified', 'respawn_elementor_sliders'];
    }

    /**
     * Get widget category
     * @return array
     */
    public function get_categories() {
        return [ 'skywarrior' ];
    }

    /**
     * Get widget icon.
     *
     * Retrieve shop slider widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        // Icon name from the Elementor font file, as per https://pojome.github.io/elementor-icons/
        return 'eicon-cart-light';
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
    public function get_keywords() {
        return [ 'shop', 'woo', 'slider' ];
    }

    /**
     * Register shop slider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_shop_slider_content',
            [
                'label' => esc_html__( 'Content', 'respawn' ),
            ]
        );

        $categories = get_categories(
            [
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => 1,
                'taxonomy' => 'product_cat',
            ]
        );


        foreach ($categories as $cat) {
            $cats[$cat->cat_ID] = $cat->cat_name;
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


        $this->add_control(
            'show',
            ['label' => esc_html__('Show', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => array(
                    'all' => esc_html__('All products', 'respawn'),
                    'featured' => esc_html__('Featured products', 'respawn'),
                    'onsale' => esc_html__('On-sale products', 'respawn'),
                ),
            ]
        );

        $this->add_control(
            'orderby',
            ['label' => esc_html__('Order by', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => array(
                    'date' => esc_html__('Date', 'respawn'),
                    'price' => esc_html__('Price', 'respawn'),
                    'rand' => esc_html__('Random', 'respawn'),
                    'sales' => esc_html__('Sales', 'respawn'),
                ),
            ]
        );

        $this->add_control(
            'order',
            ['label' => esc_html__('Order', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => array(
                    'asc' => esc_html__('ASC', 'respawn'),
                    'desc' => esc_html__('DESC', 'respawn'),
                ),
            ]
        );

        $this->add_control(
            'hide_free',
            [
                'label' => esc_html__('Hide free products', 'respawn'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'respawn'),
                'label_off' => esc_html__('No', 'respawn'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_hidden',
            [
                'label' => esc_html__('Show hidden products', 'respawn'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'respawn'),
                'label_off' => esc_html__('No', 'respawn'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_shop_slider_style',
            [
                'label' => esc_html__('Style', 'respawn'),
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number of items', 'respawn'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'title' => esc_html__('Add number of items', 'respawn'),
            ]

        );


        $this->add_control(
            'centered',
            [
                'label' => esc_html__('Centered', 'respawn'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'respawn'),
                'label_off' => esc_html__('No', 'respawn'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => esc_html__( 'Show Opacity', 'respawn' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'respawn' ),
                'label_off' => esc_html__( 'Off', 'respawn' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Card spacing', 'respawn' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '.spcard' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render shop slider widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render( ) {
        //Get values (in array "settings")
        $settings = $this->get_settings();

        $number = !empty($settings['number']) ? absint($settings['number']) : 5;
        $show = !empty($settings['show']) ? sanitize_title($settings['show']) : 'all';
        $orderby = !empty($settings['orderby']) ? sanitize_title($settings['orderby']) : 'date';
        $order = !empty($settings['order']) ? sanitize_title($settings['order']) : 'asc';

        $product_visibility_term_ids = '';
        $currency = '';

        if ( class_exists( 'WooCommerce' ) ) {
            $product_visibility_term_ids = wc_get_product_visibility_term_ids();
            $currency = get_woocommerce_currency_symbol();
        }


        $query_args = array(
            'posts_per_page' => $number,
            'post_status' => 'publish',
            'post_type' => 'product',
            'no_found_rows' => 1,
            'order' => $order,
            'meta_query' => array(),
            'tax_query' => array(
                'relation' => 'AND',
            ),
        );

        if (!empty($settings['categories'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $settings['categories'],
            );
        }

        if (empty($settings['show_hidden'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field' => 'term_taxonomy_id',
                'terms' => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
                'operator' => 'NOT IN',
            );
            $query_args['post_parent'] = 0;
        }

        if ($settings['hide_free'] == 'yes') {
            $query_args['meta_query'][] = array(
                'key' => '_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'DECIMAL',
            );
        }

        if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'term_taxonomy_id',
                    'terms' => $product_visibility_term_ids['outofstock'],
                    'operator' => 'NOT IN',
                ),
            ); // WPCS: slow query ok.
        }


        switch ($show) {
            case 'featured':
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'term_taxonomy_id',
                    'terms' => $product_visibility_term_ids['featured'],
                );
                break;
            case 'onsale':
                $product_ids_on_sale = wc_get_product_ids_on_sale();
                $product_ids_on_sale[] = 0;
                $query_args['post__in'] = $product_ids_on_sale;
                break;
        }


        switch ($orderby) {
            case 'price':
                $query_args['meta_key'] = '_price'; // WPCS: slow query ok.
                $query_args['orderby'] = 'meta_value_num';
                break;
            case 'rand':
                $query_args['orderby'] = 'rand';
                break;
            case 'sales':
                $query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
                $query_args['orderby'] = 'meta_value_num';
                break;
            default:
                $query_args['orderby'] = 'date';
        }


        $products = new \WP_Query($query_args);

        if($settings['centered'] == 'yes'){
            $slick = '{"centerMode": true,"slidesToShow": 3, "adaptiveHeight": true, "variableWidth": true,  "centerPadding": "60px","infinite": true, "responsive": [{"breakpoint": 1024,"settings": {"slidesToShow": 2,"slidesToScroll": 2,"infinite": true, "dots": false,"variableWidth": true}},{ "breakpoint": 768,"settings": {"slidesToShow": 1,"slidesToScroll": 1,"variableWidth": false, "dots": false}}] }';
        }else{
            $slick = '{"slidesToShow": 3, "adaptiveHeight": true, "variableWidth": true,  "centerPadding": "60px","infinite": true, "responsive": [{"breakpoint": 1024,"settings": {"slidesToShow": 2,"slidesToScroll": 2,"infinite": true, "dots": false,"variableWidth": true}},{ "breakpoint": 768,"settings": {"slidesToShow": 1,"slidesToScroll": 1,"variableWidth": false, "dots": false}}] }';
        }

        $opacity = '';

        if(empty($settings['opacity'])){
            $opacity = 'fullopacity';
        }

        ?>

        <div class="product-list slick-arrows-fix <?php echo esc_attr($opacity); ?>">

            <ul data-slick='<?php echo esc_attr($slick); ?>'  class="shop_slider single-product">

            <?php while ($products->have_posts()) : $products->the_post(); ?>

                <?php
                $_product = '';
                if ( class_exists( 'WooCommerce' ) ) {
                    $_product = wc_get_product(get_the_ID());
                }

                $image_link = '';
                if (has_post_thumbnail(get_the_ID())) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb); //get img URL
                    $image_link = respawn_aq_resize($img_url, 500, 620, true, true, true);

                }
                ?>

                <li class="on-sale">

                    <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                        <?php if ($_product->is_on_sale()) { ?>
                            <div class="product-tag">
                                <span class="tag-sale"><?php esc_html_e('sale', 'respawn'); ?></span>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <?php if(!empty($image_link)){ ?>
                        <a href="<?php the_permalink(); ?>" class="pr-image">
                            <img src="<?php echo esc_url($image_link); ?>" alt="<?php the_title_attribute(); ?>">
                        </a>
                    <?php } ?>

                    <div class="product">
                        <div class="product-wrapper">

                            <a href="<?php the_permalink(); ?>" ><h5 class="product-title"><?php the_title(); ?></h5></a>

                            <div class="product-price">

                                <?php if ($_product->is_on_sale()) { ?>

                                    <span class="regular-price"><del><?php echo esc_html($currency); ?><?php echo esc_html($_product->get_regular_price()); ?></del></span>

                                    <span class="current-price"><?php echo esc_html($currency); ?><?php echo esc_html($_product->get_sale_price()); ?></span>

                                <?php } else { ?>

                                    <span class="current-price"><?php echo esc_html($currency); ?><?php echo esc_html($_product->get_regular_price()); ?></span>

                                <?php } ?>

                            </div>
                            <a class="btn" href="?add-to-cart=<?php echo esc_attr(get_the_ID()); ?>"><?php esc_html_e('add to cart', 'respawn'); ?></a>
                        </div>
                    </div>

                </li>


            <?php endwhile;wp_reset_postdata(); ?>

            </ul>

        </div>
        <?php
    }

}

