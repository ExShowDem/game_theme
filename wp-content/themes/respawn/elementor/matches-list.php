<?php

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Matches list.
 *
 * Elementor widget that displays set of matches in a list.
 *
 * Class Widget_SW_Match_Carousel
 * @package Elementor
 */
class Widget_SW_Matches_List extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve matches list widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'matches_list';
    }

    /**
     * Get widget title.
     *
     * Retrieve matches list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('SW - Matches List', 'respawn');
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
     * Retrieve matches list widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
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
    public function get_keywords()
    {
        return ['match', 'matches'];
    }


    /**
     * Register match slider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'matches_list_content',
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

        $games = \WP_TeamMatches\Games::get_game('id=all&orderby=title&order=asc');

        foreach ($games as $game) {
            $gms[$game->id] = $game->title;
        }

        if (!isset($gms)) $gms = array();

        $this->add_control(
            'games',
            [
                'label' => esc_html__('Games', 'respawn'),
                'type' => 'multiselect',
                'options' => $gms,
                'title' => esc_html__('Select games', 'respawn'),
            ]
        );

        $this->add_control(
            'match_type',
            ['label' => esc_html__('Match type', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => array(
                    'all' => esc_html__('Show all', 'respawn'),
                    'upcoming' => esc_html__('Upcoming', 'respawn'),
                    'playing' => esc_html__('Playing', 'respawn'),
                    'ended' => esc_html__('Ended', 'respawn'),
                ),
                'title' => esc_html__('Add match type', 'respawn'),
            ]
        );

        $this->add_control(
            'older_than',
            ['label' => esc_html__('Hide older than', 'respawn'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => array(
                    'all' => esc_html__('Show all', 'respawn'),
                    '1w' => esc_html__('1 week', 'respawn'),
                    '2w' => esc_html__('2 weeks', 'respawn'),
                    '3w' => esc_html__('3 weeks', 'respawn'),
                    '1m' => esc_html__('1 month', 'respawn'),
                    '2m' => esc_html__('2 months', 'respawn'),
                    '3m' => esc_html__('3 months', 'respawn'),
                    '6m' => esc_html__('6 months', 'respawn'),
                    '1y' => esc_html__('1 year', 'respawn'),
                ),
                'title' => esc_html__('Hide matches older than', 'respawn'),
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'matches_list_style',
            [
                'label' => esc_html__('Style', 'respawn'),
            ]
        );

        $this->add_control(
            'number',
            ['label' => esc_html__('Number of matches', 'respawn'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'title' => esc_html__('Add number of matches', 'respawn'),
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

        $match_type = $settings['match_type'];
        $now = current_time('timestamp');
        $matches = [];
        $games = [];
        $_games = \WP_TeamMatches\Games::get_game(array(
            'id' => empty($settings['games']) ? 'all' : $settings['games'],
            'orderby' => 'title',
            'order' => 'asc'
        ));


        if (empty($settings['number'])) $settings['number'] = '';

        switch ($match_type) {
            case 'ended':
                $args = ['limit' => $settings['number'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'done'];
                break;
            case 'upcoming':
                $args = ['from_date' => $now, 'limit' => $settings['number'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'active'];
                break;
            case 'all':
                $args = ['limit' => $settings['number'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true];
                break;
            case 'playing':
                $args = ['to_date' => $now, 'limit' => $settings['number'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'active'];
                break;
        }


        foreach ($_games as $g) {
            $args['game_id'] = $g->id;

            $m = \WP_TeamMatches\Matches::get_match($args);

            if (sizeof($m)) {
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

        if (isset($blog_page[0]->ID))
            $blog_page_id = $blog_page[0]->ID;

        $link = get_permalink($blog_page_id);

        ?>


        <div class="bmatchlist block-wrap">

            <?php if (!empty($title)) { ?>
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

            <ul class="bmatchul">

                <?php

                if (empty($matches)) {

                    echo '<div class="mc-wrap no-items">';
                    esc_html_e('No matches for selected values', 'respawn');
                    echo '</div>';

                } else { ?>

                    <?php
                    if($settings['number'] > 0)
                    $matches = array_slice($matches, 0, $settings['number']);
                    $matches = array_reverse($matches);
                    foreach ($matches as $match) :

                        $team1id = $match->team1;
                        $team2id = $match->team2;

                        if (has_post_thumbnail($team1id)) {
                            $thumb = get_post_thumbnail_id($team1id);
                            $img_url = wp_get_attachment_url($thumb); //get img URL

                            //check if svg
                            if(stripos(strrev($img_url), strrev('svg')) === 0){
                                $image_link1 = $img_url;
                            }else{
                                list($width_orig1, $height_orig1) = getimagesize($img_url);
                                $ratio_orig1 = $width_orig1/$height_orig1;
                                $image_link1 = respawn_aq_resize($img_url, 60, round(60/$ratio_orig1), true, true, true );
                            }

                        } else {
                            $image_link1 = get_theme_file_uri('assets/img/defaults/defteam70.png');
                        }

                        if (has_post_thumbnail($team2id)) {
                            $thumb = get_post_thumbnail_id($team2id);
                            $img_url = wp_get_attachment_url($thumb); //get img URL

                            //check if svg
                            if(stripos(strrev($img_url), strrev('svg')) === 0){
                                $image_link2 = $img_url;
                            }else{
                                list($width_orig2, $height_orig2) = getimagesize($img_url);
                                $ratio_orig2 = $width_orig2/$height_orig2;
                                $image_link2 = respawn_aq_resize($img_url, 60, round(60/$ratio_orig2), true, true, true );
                            }
                        } else {
                            $image_link2 = get_theme_file_uri('assets/img/defaults/defteam70.png');
                        }

                        $team1_title = get_the_title($team1id);
                        $team2_title = get_the_title($team2id);


                        $scores = \WP_TeamMatches::SumTickets($match->ID);

                        $tickets1 = $scores[0];
                        $tickets2 = $scores[1];


                        ?>

                        <li>
                            <a href="<?php echo esc_url(get_permalink($match->ID)); ?>">

                                <?php if (respawn_return_game_banner($match->game_id)) { ?>
                                    <img alt="<?php esc_attr_e('img', 'respawn'); ?>" class="grayscalebg"
                                         src="<?php echo esc_url(respawn_return_game_banner($match->game_id)); ?>"/>
                                <?php } ?>

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

                                <div class="mbtitle-wrapper">
                                    <h3><?php echo date(get_option('date_format'), mysql2date('U', $match->date)) . ' <span>' . date(get_option('time_format'), mysql2date('U', $match->date)) . '</span>'; ?></h3>
                                    <h4><?php echo esc_attr($match->post_title); ?></h4>
                                </div>

                            </a>
                        </li>

                    <?php

                    endforeach;
                    ?>

                <?php } ?>

            </ul>
        </div>

        <?php
    }

}

