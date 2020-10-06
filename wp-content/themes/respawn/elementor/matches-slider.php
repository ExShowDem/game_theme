<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Match slider.
 *
 * Elementor widget that displays set of matches in slick slider.
 *
 * Class Widget_SW_Match_Carousel
 * @package Elementor
 */
class Widget_SW_Match_Carousel extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve match slider widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'match_slider';
    }

    /**
     * Get widget title.
     *
     * Retrieve match slider widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'SW - Matches Slider', 'respawn' );
    }

    /**
     * Retrieve the list of scripts the match slider widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return ['respawn_elementor_minified','respawn_elementor_sliders'];
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
     * Retrieve match slider widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        // Icon name from the Elementor font file, as per https://pojome.github.io/elementor-icons/
        return 'eicon-rating';
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
        return [ 'match', 'matches', 'slider' ];
    }

    /**
     * Register match slider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_match_slider_content',
            [
                'label' => esc_html__( 'Content', 'respawn' ),
            ]
        );


        $this->add_control(
            'title',
            [
                'label' => esc_html__( ' Title', 'respawn' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__( 'Add title text', 'respawn' ),
            ]
        );

        $games = \WP_TeamMatches\Games::get_game('id=all&orderby=title&order=asc');

        foreach ( $games as $game ) {
            $gms[$game->id] = $game->title;
        }

        if(!isset($gms))$gms=array();

        $this->add_control(
            'games',
            [
                'label' => esc_html__( 'Games', 'respawn' ),
                'type' => 'multiselect',
                'options' => $gms,
                'title' => esc_html__( 'Select games', 'respawn' ),
            ]
        );

        $this->add_control(
            'match_type',
            [   'label' => esc_html__( 'Match type', 'respawn' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => array(
                    'all'	=> esc_html__('Show all', 'respawn'),
                    'upcoming'	=> esc_html__('Upcoming', 'respawn'),
                    'playing'	=> esc_html__('Playing', 'respawn'),
                    'ended'	=> esc_html__('Ended', 'respawn'),
                ),
                'title' => esc_html__( 'Add match type', 'respawn' ),
            ]
        );

        $this->add_control(
            'older_than',
            [   'label' => esc_html__( 'Hide older than', 'respawn' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => array(
                    'all'	=> esc_html__('Show all', 'respawn'),
                    '1w'	=> esc_html__('1 week', 'respawn'),
                    '2w'	=> esc_html__('2 weeks', 'respawn'),
                    '3w'	=> esc_html__('3 weeks', 'respawn'),
                    '1m'	=> esc_html__('1 month', 'respawn'),
                    '2m'	=> esc_html__('2 months', 'respawn'),
                    '3m'	=> esc_html__('3 months', 'respawn'),
                    '6m'	=> esc_html__('6 months', 'respawn'),
                    '1y'	=> esc_html__('1 year', 'respawn'),
                ),
                'title' => esc_html__( 'Hide matches older than', 'respawn' ),
            ]
        );

        $this->add_control(
            'order',
            [   'label' => esc_html__( 'Order', 'respawn' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => array(
                    'asc'	=> esc_html__('ASC', 'respawn'),
                    'desc'	=> esc_html__('DESC', 'respawn'),
                ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_match_slider_style',
            [
                'label' => esc_html__( 'Style', 'respawn' ),
            ]
        );

        $this->add_control(
            'number',
            [   'label' => esc_html__( 'Number of matches', 'respawn' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'title' => esc_html__( 'Add number of matches', 'respawn' ),
            ]
        );

        $this->end_controls_section();


    }

    protected function render( ) {
        //Get values (in array "settings")
        $settings = $this->get_settings();

        //Heading
        $title = ! empty( $settings['title'] ) ? $settings['title'] : '';

        $match_type = $settings['match_type'];
        $now = current_time('timestamp');
        $matches = [];
        $games = [];
        $_games = \WP_TeamMatches\Games::get_game(array(
            'id' => empty($settings['games']) ? 'all' : $settings['games'],
            'orderby' => 'title',
            'order' => 'asc'
        ));

        if(isset( $settings['older_than'])) {

            switch ($settings['older_than']){
                case 'all' :
                    $age = 0;
                    break;
                case '1w' :
                    $age = 60*60*24*7;
                    break;
                case '2w' :
                    $age = 60*60*24*14;
                    break;
                case '3w' :
                    $age = 60*60*24*21;
                    break;
                case '1m' :
                    $age = 60*60*24*30;
                    break;
                case '2m' :
                    $age = 60*60*24*30*2;
                    break;
                case '3m' :
                    $age = 60*60*24*30*3;
                    break;
                case '6m' :
                    $age = 60*60*24*30*6;
                    break;
                case '1y' :
                    $age = 60*60*24*30*12;
                    break;
            }

            if($age > 0)
                $from_date = $now - $age;
        }

        if(empty($settings['number'])) $settings['number'] = '';
        if(empty($from_date)) $from_date = '';

        switch ($match_type){
            case 'ended':
                $args = ['limit' => $settings['number'], 'order' => $settings['order'], 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'done','from_date' => $from_date];
                break;
            case 'upcoming':
                $args = ['from_date' => $now, 'limit' => $settings['number'], 'order' => $settings['order'], 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'active'];
                break;
            case 'all':
                $args = ['limit' => $settings['number'], 'order' => $settings['order'], 'orderby' => 'date', 'sum_tickets' => true,'from_date' => $from_date];
                break;
            case 'playing':
                $args = ['to_date' => $now, 'limit' => $settings['number'], 'order' => $settings['order'], 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'active','from_date' => $from_date];
                break;
        }


        foreach($_games as $g) {
            $args['game_id'] = $g->id;

            $m = \WP_TeamMatches\Matches::get_match($args);

            if(sizeof($m)) {
                $games[] = $g;
                $matches = array_merge($matches, $m);
            }
        }

        if(function_exists('respawn_other_matches_sort'))
        usort($matches, 'respawn_other_matches_sort');

        $blog_page = get_pages(
            array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'tmp-all-matches.php'
            )
        );

        $blog_page_id = '';

        if(isset($blog_page[0]->ID))
        $blog_page_id = $blog_page[0]->ID;

        $link =  get_permalink( $blog_page_id );

        ?>

        <?php if(!empty($title)){ ?>
        <h4 class="block-title">
            <?php echo esc_html($title); ?>
            <a href="<?php echo esc_url($link); ?>"><?php esc_html_e('see all','respawn');?> <svg aria-hidden="true" data-prefix="fas" data-icon="arrow-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-arrow-right fa-w-14 fa-2x"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z" class=""></path></svg></a>
        </h4>
        <?php } ?>

        <?php $slick = '{"dots": true, "infinite": true, "speed": "500","fade": true,"cssEase": "linear" }';  ?>

        <div data-slick='<?php echo esc_attr($slick); ?>' class="matches_slider center slider-carousel slick-arrows-fix">

                <?php

                if(empty($matches)){

                    echo '<div class="mc-wrap no-items">';
                        esc_html_e('No matches for selected values', 'respawn');
                    echo '</div>';

                }else{
                    if($settings['number'] > 0)
                    $matches = array_slice($matches, 0, $settings['number']);

                    $matches = array_reverse($matches);
                    foreach($matches as $match) :

                        $team1id = $match->team1;
                        $team2id = $match->team2;

                        if(has_post_thumbnail($team1id)) {
                            $thumb = get_post_thumbnail_id($team1id);
                            $img_url = wp_get_attachment_url($thumb); //get img URL
                            $image1 = $img_url;

                            //check if svg
                            if(stripos(strrev($image1), strrev('svg')) === 0){
                                $image_link1 = $image1;
                            }else{
                                list($width_orig1, $height_orig1) = getimagesize($image1);
                                $ratio_orig1 = $width_orig1/$height_orig1;
                                $image_link1 = respawn_aq_resize($image1, 111, round(111/$ratio_orig1), true, true, true );
                            }

                        }else{
                            $image_link1 = get_theme_file_uri('assets/img/defaults/defteam.png');
                        }

                        if(has_post_thumbnail($team2id)) {
                            $thumb = get_post_thumbnail_id($team2id);
                            $img_url = wp_get_attachment_url($thumb); //get img URL
                            $image2 = $img_url;

                            //check if svg
                            if(stripos(strrev($image2), strrev('svg')) === 0){
                                $image_link2 = $image2;
                            }else{
                                list($width_orig2, $height_orig2) = getimagesize($image2);
                                $ratio_orig2 = $width_orig2/$height_orig2;
                                $image_link2 = respawn_aq_resize($image2, 111, round(111/$ratio_orig2), true, true, true );
                            }

                        }else{
                            $image_link2 = get_theme_file_uri('assets/img/defaults/defteam.png');
                        }

                        $team1_title = get_the_title($team1id);
                        $team2_title = get_the_title($team2id);


                        $scores = \WP_TeamMatches::SumTickets($match->ID);

                        $tickets1 = $scores[0];
                        $tickets2 = $scores[1];


                ?>

                        <div>

                            <a href="<?php echo esc_url(get_permalink($match->ID)); ?>" class="mc-wrap">

                                <?php if(respawn_return_game_banner($match->game_id)){ ?>
                                    <img alt="<?php esc_attr_e('img', 'respawn'); ?>" src="<?php echo esc_url(respawn_return_game_banner($match->game_id)); ?>" />
                                <?php } ?>

                                <div class="mc-infowrap">

                                    <div class="mbtitle-wrapper">

                                        <?php if(respawn_return_game_icon($match->game_id)){ ?>
                                            <img alt="<?php esc_attr_e('img', 'respawn'); ?>" src="<?php echo esc_url(respawn_return_game_icon($match->game_id)); ?>" />
                                        <?php } ?>

                                        <h4><?php echo esc_attr($match->post_title); ?></h4>

                                        <h5><?php echo date(get_option('date_format'), mysql2date('U', $match->date)) ; ?></h5>

                                    </div>


                                    <div class="bmatchscore">

                                        <?php if(isset($image_link1) && !empty($image_link1)){ ?>
                                            <img class="team-logo" src="<?php echo esc_url($image_link1); ?>"
                                                 alt="<?php echo esc_attr($team1_title); ?>"/>
                                        <?php } ?>

                                        <div class="vsresult"><?php echo esc_html($tickets1); ?>
                                            <span><?php esc_html_e("VS", "respawn"); ?></span><?php echo esc_html($tickets2); ?>
                                        </div>

                                        <?php if(isset($image_link2) && !empty($image_link2)){ ?>
                                            <img class="team-logo" src="<?php echo esc_url($image_link2); ?>"
                                                 alt="<?php echo esc_attr($team2_title); ?>"/>
                                        <?php } ?>
                                    </div>

                                </div>

                            </a>

                        </div>

                 <?php

                    endforeach;
                ?>

                <?php } ?>

        </div>

        <?php
    }

}

