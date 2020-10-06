<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Players slider.
 *
 * Elementor widget that displays set of players in slick slider.
 *
 * Class Widget_SW_Players_Slider
 * @package Elementor
 */
class Widget_SW_Players_Slider extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve players slider widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'players_slider';
    }

    /**
     * Get widget title.
     *
     * Retrieve players slider widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'SW - Players Slider', 'respawn' );
    }

    /**
     * Retrieve the list of scripts the players slider widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'respawn_elementor_minified','respawn_elementor_sliders' ];
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
     * Retrieve players slider widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        // Icon name from the Elementor font file, as per https://pojome.github.io/elementor-icons/
        return 'eicon-person';
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
        return [ 'player', 'players', 'slider' ];
    }

    /**
     * Register players slider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_players_slider_content',
            [
                'label' => esc_html__( 'Content', 'respawn' ),
            ]
        );


        $postovi = get_posts(

            array(
                'post_type'     => 'team',
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
            'teams',
            [
                'label' => esc_html__( 'Teams', 'respawn' ),
                'type' => 'multiselect',
                'options' => $psts,
                'title' => esc_html__( 'Select teams', 'respawn' ),
            ]
        );


        $this->add_control(
            'single_use',
            [
                'label' => esc_html__('Single player', 'respawn'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'respawn'),
                'label_off' => esc_html__('No', 'respawn'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Show only one player in the block.', 'respawn'),
            ]
        );


        $players = get_posts(

            array(
                'post_type'     => 'player',
                'orderby'       => 'title',
                'order'         => 'ASC',
                'post_status'   => 'publish',
                'posts_per_page'   => -1

            ) );

        foreach ($players as $ply) {
            $plys[$ply->ID] = $ply->post_title;
        }
        if(!isset($plys))$plys='';


        $this->add_control(
            'single',
            [
                'label' => esc_html__( 'Single player', 'respawn' ),
                'type' => 'select',
                'options' => $plys,
                'title' => esc_html__( 'Select player', 'respawn' ),

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_players_slider_style',
            [
                'label' => esc_html__( 'Style', 'respawn' ),
            ]
        );

        $this->add_control(
            'number',
            [   'label' => esc_html__( 'Number of players', 'respawn' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'title' => esc_html__( 'Add number of players', 'respawn' ),
                'min' => 1
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
                        '.mem-wrap' => 'margin-left: {{SIZE}}{{UNIT}} !important; margin-right: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render( ) {
        //Get values (in array "settings")
        $settings = $this->get_settings();

        $teams = $settings['teams'];


        if($settings['single_use'] == 'yes'){

            $query = new \WP_Query([
                'showposts' => 1,
                'post_type' => 'player',
                'post__in'  => [$settings['single']]
            ]);

        }else{

            $query= new \WP_Query([
                'showposts' => $settings['number'],
                'post_type' => 'player',
                'meta_query' => [
                    [
                        'key'     => '_player_team',
                        'value'   =>$teams,
                        'compare' => 'IN',
                    ],
                ],
            ]);

        }

        $showSlides = 3;
        if($settings['number'] <= 3)
            $showSlides = 2;

        $spacing = '';
        if ($settings['spacing'] == 'yes') {
            $spacing = 'cspacing';
        }

        if($settings['centered'] == 'yes'){
            $slick = '{"centerMode": true,"slidesToShow": '.$showSlides.', "adaptiveHeight": true, "variableWidth": true,  "centerPadding": "60px","infinite": true, "responsive": [{"breakpoint": 1024,"settings": {"slidesToShow": 2,"slidesToScroll": 2,"infinite": true, "dots": false,"variableWidth": true}},{ "breakpoint": 768,"settings": {"slidesToShow": 1,"slidesToScroll": 1,"variableWidth": false, "dots": false}}] }';
        }else{
            $slick = '{"slidesToShow": '.$showSlides.', "adaptiveHeight": true, "variableWidth": true,  "centerPadding": "60px","infinite": true, "responsive": [{"breakpoint": 1024,"settings": {"slidesToShow": 2,"slidesToScroll": 2,"infinite": true, "dots": false,"variableWidth": true}},{ "breakpoint": 768,"settings": {"slidesToShow": 1,"slidesToScroll": 1,"variableWidth": false, "dots": false}}] }';
        }

        $opacity = '';

        if(empty($settings['opacity'])){
            $opacity = 'fullopacity';
        }

        ?>


        <div class="product-list slick-arrows-fix <?php echo esc_attr($opacity).' '.esc_attr($spacing); ?>">

            <div data-slick='<?php echo esc_attr($slick); ?>'  class="teamm-slider players_slider">

                <?php if ( $query->have_posts() ) :while ($query->have_posts()) : $query->the_post(); ?>

                <?php
                $name = get_post_meta( get_the_ID(), '_player_name', true );

                $facebook = get_post_meta( get_the_ID(), '_player_facebook', true );
                $twitter = get_post_meta( get_the_ID(), '_player_twitter', true );
                $youtube = get_post_meta( get_the_ID(), '_player_youtube', true );
                $instagram = get_post_meta( get_the_ID(), '_player_instagram', true );
                $steam = get_post_meta( get_the_ID(), '_player_steam', true );
                $twitch = get_post_meta( get_the_ID(), '_player_twitch', true );
                $discord = get_post_meta( get_the_ID(), '_player_discord', true );

                ?>

                <div class="mem-wrap">
                    <div class="mem-wrap-bg player_<?php echo get_the_ID(); ?>"></div>

                    <div class="mem-info">

                       <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

                        <h6><?php echo esc_html($name); ?></h6>

                        <?php
                        if(isset($facebook) && !empty($facebook))
                            echo'<a target="_blank" href="'.esc_url($facebook).'"><i class="fab fa-facebook"></i> </a>';

                        if(isset($twitter) && !empty($twitter))
                            echo '<a target="_blank" href="'.esc_url($twitter).'"><i class="fab fa-twitter"></i> </a>';

                        if(isset($youtube) && !empty($youtube))
                            echo '<a target="_blank" href="'.esc_url($youtube).'"><i class="fab fa-youtube"></i> </a>';

                        if(isset($instagram) && !empty($instagram))
                            echo '<a target="_blank" href="'.esc_url($instagram).'"><i class="fab fa-instagram"></i> </a>';

                        if(isset($steam) && !empty($steam))
                            echo '<a target="_blank" href="'.esc_url($steam).'"><i class="fab fa-steam"></i> </a>';

                        if(isset($twitch) && !empty($twitch))
                            echo '<a target="_blank" href="'.esc_url($twitch).'"><i class="fab fa-twitch"></i> </a>';

                        if(isset($discord) && !empty($discord))
                            echo '<a target="_blank" href="'.esc_url($discord).'"><i class="fab fa-discord"></i> </a>';

                        ?>

                    </div>

                </div>

                <?php endwhile; wp_reset_postdata(); else : ?>
                <?php esc_html_e( 'Sorry, no players in selected team.', 'respawn' ); ?>
                <?php endif; ?>

            </div>

        </div>

        <?php
    }

}

