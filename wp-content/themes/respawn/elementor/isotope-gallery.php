<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Isotope gallery.
 *
 * Elementor widget that displays set of galleries with isotope.
 *
 * Class Widget_SW_Isotope_Gallery
 * @package Elementor
 */
class Widget_SW_Isotope_Gallery extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve isotope gallery widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'isotope_gallery';
    }

    /**
     * Get widget title.
     *
     * Retrieve isotope gallery widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'SW - Isotope Gallery', 'respawn' );
    }

    /**
     * Retrieve the list of scripts the isotope gallery widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'imagesloaded','isotope','respawn_elementor_minified','respawn_elementor_isotope_gallery' ];
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
     * Retrieve isotope gallery widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        // Icon name from the Elementor font file, as per https://pojome.github.io/elementor-icons/
        return 'eicon-image';
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
        return [ 'respawn_elementor_isotope_gallery', 'isotope' ];
    }

    /**
     * Register isotope gallery widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_isotope_gallery_content',
            [
                'label' => esc_html__( 'Content', 'respawn' ),
            ]
        );


        $postovi = get_posts(

            array(
                'post_type'     => 'masonry_gallery',
                'orderby'       => 'title',
                'order'         => 'ASC',
                'post_status'   => 'publish',
                'posts_per_page'   => -1

            ) );

        foreach ($postovi as $pst) {
            $psts[$pst->ID] = $pst->post_title;
        }
        if(!isset($psts))$psts='';

        $this->add_control(
            'galleries',
            [
                'label' => esc_html__( 'Galleries', 'respawn' ),
                'type' => 'multiselect',
                'options' => $psts,
                'title' => esc_html__( 'Select galleries', 'respawn' ),
            ]
        );

        $this->add_control(
            'all',
            [
                'label' => esc_html__('"All" tab', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add text for "All" tab', 'respawn'),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add text', 'respawn'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button text', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add button text', 'respawn'),
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => esc_html__( 'Button Link', 'respawn' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'respawn' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_isotope_gallery_style',
            [
                'label' => esc_html__( 'Style', 'respawn' ),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Show tabs', 'respawn'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'respawn'),
                'label_off' => esc_html__('No', 'respawn'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'tab_position',
            ['label' => esc_html__('Tabs position', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => array(
                    'right' => esc_html__('Right', 'respawn'),
                    'center' => esc_html__('Center', 'respawn'),
                ),
                'title' => esc_html__('Add tabs position', 'respawn'),
            ]
        );

        $this->add_control(
            'rows',
            ['label' => esc_html__('Number of rows', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'three',
                'options' => array(
                    'gc-one-row' => esc_html__('One', 'respawn'),
                    'gc-two-rows' => esc_html__('Two', 'respawn'),
                    'gc-three-rows' => esc_html__('Three', 'respawn'),
                    'gc-four-rows' => esc_html__('Four', 'respawn'),
                ),
                'title' => esc_html__('Add number of rows', 'respawn'),
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding between elements', 'respawn'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'respawn'),
                'label_off' => esc_html__('No', 'respawn'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

    }

    protected function render( ) {
        //Get values (in array "settings")
        $settings = $this->get_settings();

        $all_tab = $settings['all'];
        $padding = $settings['padding'];
        $rows_isotope = $settings['rows'];
        $padding_class = '';
        $column_class = '';
        $tabs_position_class = '';

        if(empty($all_tab)) $all_tab = esc_html__('All', 'respawn');

        if(!empty($padding)) $padding_class = 'gc-padding';

        if(!empty($rows_isotope)) $column_class = $rows_isotope;


        $masonry_galleries_stack = $settings['galleries'];

        if($settings['tab_position'] == 'right'){
            $tabs_position_class = 'right_tabs';
        }elseif($settings['tab_position'] == 'center'){
            $tabs_position_class = 'center_tabs';
        }

        $no_class = '';
        if(empty($settings['text'])) {
            $no_class = 'gno-left';
        }

        echo '<div id="'.esc_attr(uniqid("gallery_isotope_wrap_")).'">';

        if($settings['tabs'] == 'yes'){

            echo '<div class="gallery-header-wrap '.esc_attr($tabs_position_class).'">';
            echo '<div class="gallery-header-center-right-links gallery-header-center-right-links-current" data-filter="*"><strong>'.esc_attr($all_tab).'</strong></div>';

            if(is_array($masonry_galleries_stack ))
            foreach ($masonry_galleries_stack as $masonry_gallery) {
                $title = get_the_title($masonry_gallery);
                echo '<div class="gallery-header-center-right-links"  data-filter=".'.esc_attr(sanitize_title($title)).'"><strong>'.esc_attr($title).'</strong></div>';

            }

            echo '</div>';

        }

        $target = $settings['url']['is_external'] ? ' target=_blank' : '';
        $nofollow = $settings['url']['nofollow'] ? ' rel=nofollow' : '';

        echo '<div class="'.esc_attr($no_class).'" id="'.esc_attr(uniqid("gallery_content_")).'">';

        echo '<div class="ih-wrap">';

            if(!empty($settings['text'])) {
                echo '<h2>'.esc_html($settings['text']).'</h2>';
            }

            if(!empty($settings['url']['url']) && !empty($settings['button_text'])){

                echo '<a href="'.esc_url($settings['url']['url']).'" '.esc_attr($nofollow).' '.esc_attr($target).' class="btn">';
                    echo esc_html($settings['button_text']);
                echo '</a>';

            }

        echo '</div>';

        echo '<ul id="'.esc_attr(uniqid("gallery_content_center_")).'" class="image-gallery-wrap '.esc_attr($padding_class).' '.esc_attr($column_class).'">';
        $width= 800;
        if($settings['rows'] == 'gc-two-rows'){
            $width = 635;
        }elseif($settings['rows'] == 'gc-three-rows'){
            $width = 406;
        }elseif($settings['rows'] == 'gc-four-rows'){
            $width = 311;
        }

        foreach ($masonry_galleries_stack as $masonry_gallery) {
            $title = get_the_title($masonry_gallery);
            $images = get_post_meta($masonry_gallery, 'image_upload');

            if(!empty($images)){
                foreach ($images as $image) {
                    $url = wp_get_attachment_url($image);

                    if($settings['rows'] == 'gc-one-row'){
                        $image_link = $url;
                    }else{

                        if(isset($url) && !empty($url)) {
                            list($width_orig, $height_orig) = getimagesize($url);
                            $ratio_orig = $width_orig / $height_orig;
                            $image_link = respawn_aq_resize($url, $width, round($width / $ratio_orig), true, true, true);
                        }
                    }

                    if(empty($image_link) or !isset($image_link)) $image_link = $url = get_theme_file_uri('assets/img/defaults/default.jpg');

                    echo '<li class="grid_element '.esc_attr(sanitize_title($title)).'">
                    <a href="'.esc_url($url).'" >
                        <figure>
                        
                            <div class="isotopeItemOverlay">
                            
								<div class="rx_isotope_beacon" >
									<div class="genericBeaconIsotope" data-href="#">
										<div class="beaconCircle1"></div>
										<div class="beaconCircle2">
											<img class="isotopeItemOpenLink" src="'.get_theme_file_uri("/assets/img/link_icon_beacon.png").'" alt="'.esc_attr__("isotope_image","respawn").'">
										</div>
									</div>	
								</div>
															
							</div>
							    
							<img alt="'.esc_attr(sanitize_title($title)).'" src="'.esc_url($image_link).'" />
                        </figure>
                    </a></li>';
                }
            }

        }

        echo '</ul>';
        echo '</div></div>';
    }

}

