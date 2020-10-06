<?php

final class ElementorCustomElement {

    private static $instance = null;

    public static function get_instance() {
        if ( ! self::$instance )
            self::$instance = new self;
        return self::$instance;
    }

    public function init(){
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_registered' ] );

        // Register Widget Scripts
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

        // Register Widget Styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
    }

    public function widgets_registered() {

        if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {

            //REGISTER WIDGETS

            if ( class_exists( 'Elementor\Plugin' ) && class_exists('Respawn_Types') ) {
                if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {
                    $elementor = Elementor\Plugin::instance();

                    if ( isset( $elementor->widgets_manager ) ) {

                        //LOAD WIDGETS

                        if ( method_exists( $elementor->widgets_manager, 'register_widget_type' ) ) {

                            //Include | Posts slider | *Can be used globally
                            require_once(get_theme_file_path('elementor/posts-slider.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Posts_Slider() );

                            //Include | Posts magazine | *Can be used globally
                            require_once(get_theme_file_path('elementor/posts-magazine.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Posts_Magazine() );

                            //Include | Posts list | *Can be used globally
                            require_once(get_theme_file_path('elementor/posts-list.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Posts_List() );

                            //Include | Posts simple | *Can be used globally
                            require_once(get_theme_file_path('elementor/posts-simple.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Posts_Simple() );

                            //Include | Match slider | *Can be used globally
                            require_once(get_theme_file_path('elementor/matches-slider.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Match_Carousel() );

                            //Include | Matches list | *Can be used globally
                            require_once(get_theme_file_path('elementor/matches-list.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Matches_List() );

                            //Include | Team members slider | *Can be used globally
                            require_once(get_theme_file_path('elementor/players-slider.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Players_Slider() );

                            //Include | Isotope gallery | *Can be used globally
                            require_once(get_theme_file_path('elementor/isotope-gallery.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Isotope_Gallery() );

                            //Include | Videos slider | *Can be used globally
                            require_once(get_theme_file_path('elementor/videos-slider.php'));
                            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_SW_Videos_Slider() );


                            if ( class_exists( 'WooCommerce' ) ) {
                                //Include | Shop Simple | *Can be used globally
                                require_once(get_theme_file_path('elementor/shop-simple.php'));
                                Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor\Widget_SW_Shop_Simple());

                                //Include | Shop slider | *Can be used globally
                                require_once(get_theme_file_path('elementor/shop-slider.php'));
                                Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor\Widget_SW_Shop_Slider());

                            }


                        }
                    }
                }
            }
        }
    }


    public function widget_scripts() {
        global $respawn_version;

        /*STYLES*/
        wp_enqueue_style( 'respawn_elementor_minified_style',   get_theme_file_uri('elementor/css/elementor-minified.css' ), [], $respawn_version);


        /*SCRIPTS*/
        wp_enqueue_script( 'respawn_elementor_minified', get_theme_file_uri('elementor/js/elementor-minified.min.js'),'',$respawn_version,true);


        if (!wp_script_is( 'theplus_ele_frontend_scripts', 'enqueued' )) {
            wp_enqueue_script('isotope', get_theme_file_uri('elementor/js/isotope.pkgd.min.js'), '', $respawn_version, true);
            wp_enqueue_script('slick', get_theme_file_uri('elementor/js/core/slick.min.js'), '', $respawn_version, true);
        }

        wp_enqueue_script( 'respawn_elementor_sliders',  get_theme_file_uri('elementor/js/es-sliders.min.js' ), '', $respawn_version, true );
        wp_enqueue_script( 'respawn_elementor_isotope_gallery',   get_theme_file_uri('elementor/js/es-isotope-gallery.min.js'),['imagesloaded'],$respawn_version,true);

    }

    public function widget_styles() {
        global $respawn_version;

        /*STYLES*/
        wp_enqueue_style( 'respawn_elementor_minified_style',   get_theme_file_uri('elementor/css/elementor-minified.css' ), [], $respawn_version);

    }
}


ElementorCustomElement::get_instance()->init();


final class Elementor_Extension {

    private static $instance = null;

    public static function get_instance() {
        if ( ! self::$instance )
            self::$instance = new self;
        return self::$instance;
    }
    public function init() {

        // Include plugin files
        $this->includes();

        // Register controls
        add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

    }

    public function includes() {

        require_once( __DIR__ . '/controls/multiselect.php' );

    }

    public function register_controls() {

        $controls_manager = \Elementor\Plugin::$instance->controls_manager;
        $controls_manager->register_control( 'multiselect', new Control_Multiselect() );

    }

}

Elementor_Extension::get_instance()->init();


function respawn_add_elementor_widget_categories( $elements_manager ) {

    $elements_manager->add_category(
        'skywarrior',
        [
            'title' => esc_html__( 'Skywarrior', 'respawn' ),
            'icon' => 'fa fa-plug',
        ]
    );

}
add_action( 'elementor/elements/categories_registered', 'respawn_add_elementor_widget_categories' );