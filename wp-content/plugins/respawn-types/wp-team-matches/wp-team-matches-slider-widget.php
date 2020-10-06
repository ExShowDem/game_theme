<?php
/*
    WP-TeamMatches sidebar widget
    (c) 2011 Andrej Mihajlov

    This file is part of WP-TeamMatches.

    WP-TeamMatches is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WP-TeamMatches is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WP-TeamMatches.  If not, see <http://www.gnu.org/licenses/>.
*/

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

require_once (dirname(__FILE__) . '/classes/utils.class.php');

use \WP_TeamMatches\Utils;

class WP_TeamMatches_Slider_Widget extends WP_Widget {

    const ONE_DAY = 60 * 60 * 24;

    var $default_settings = [];
    var $newer_than_options = [];
    var $match_type_options = [];

    function __construct()
    {
        $wp_theme = wp_get_theme();
        $wp_theme_name = $wp_theme->get_template();
        $theme_class = 'widget_team-matches_' . $wp_theme_name;

        $widget_ops = array(
            'classname' => 'widget_team-matches ' . $theme_class,
            'description' => esc_html__('TeamMatches slider widget', WP_CLANWARS_TEXTDOMAIN)
        );
        parent::__construct('team-matches-slider', esc_html__('TeamMatches Slider', WP_CLANWARS_TEXTDOMAIN), $widget_ops);

        $this->default_settings = array(
            'title' => esc_html__('Team Matches Slider', WP_CLANWARS_TEXTDOMAIN),
            'display_both_teams' => false,
            'display_game_icon' => true,
            'show_limit' => 10,
            'hide_title' => false,
            'hide_older_than' => '1m',
            'custom_hide_duration' => 0,
            'visible_games' => array()
        );

        $this->newer_than_options = array(
            'all' => array('title' => esc_html__('Show all', WP_CLANWARS_TEXTDOMAIN), 'value' => 0),
            '1d' => array('title' => esc_html__('1 day', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY),
            '2d' => array('title' => esc_html__('2 days', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 2),
            '3d' => array('title' => esc_html__('3 days', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 3),
            '1w' => array('title' => esc_html__('1 week', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 7),
            '2w' => array('title' => esc_html__('2 weeks', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 14),
            '3w' => array('title' => esc_html__('3 weeks', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 21),
            '1m' => array('title' => esc_html__('1 month', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 30),
            '2m' => array('title' => esc_html__('2 months', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 30 * 2),
            '3m' => array('title' => esc_html__('3 months', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 30 * 3),
            '6m' => array('title' => esc_html__('6 months', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 30 * 6),
            '1y' => array('title' => esc_html__('1 year', WP_CLANWARS_TEXTDOMAIN), 'value' => self::ONE_DAY * 30 * 12)
        );

        $this->match_type_options = array(
            'all' => array('title' => esc_html__('Show all', WP_CLANWARS_TEXTDOMAIN)),
            'upcoming' => array('title' => esc_html__('Upcoming', WP_CLANWARS_TEXTDOMAIN)),
            'playing' => array('title' => esc_html__('Playing', WP_CLANWARS_TEXTDOMAIN)),
            'ended' => array('title' => esc_html__('Ended', WP_CLANWARS_TEXTDOMAIN)),
        );

        wp_register_script('jquery-cookie', WP_CLANWARS_URL . '/js/jquery.cookie.pack.js', array('jquery'), WP_CLANWARS_VERSION);
        wp_register_script('wp-team-matches-tabs', WP_CLANWARS_URL . '/js/tabs.js', array('jquery', 'jquery-cookie'), WP_CLANWARS_VERSION);
        wp_register_script('wp-team-matches-widget-admin', WP_CLANWARS_URL . '/js/widget-admin.js', array('jquery'), WP_CLANWARS_VERSION);

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    private function _sort_games($a, $b) {
        $t1 = mysql2date('U', $a->date);
        $t2 = mysql2date('U', $b->date);

        if($t1 == $t2) {
            return 0;
        }

        return ($t1 > $t2) ? -1 : 1;
    }

    function admin_enqueue_scripts() {
        wp_enqueue_script('wp-team-matches-widget-admin');
    }

    function widget($args, $instance) {
        wp_enqueue_script('wp-team-matches-tabs');
        $respawn_allowed = wp_kses_allowed_html( 'post' );
        extract($args);

        $instance = wp_parse_args((array)$instance, $this->default_settings);

        $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('TeamMatches', WP_CLANWARS_TEXTDOMAIN) : $instance['title']);


        $match_type = $instance['match_type'];
        $now = current_time('timestamp');
        $matches = [];
        $games = [];
        $_games = \WP_TeamMatches\Games::get_game(array(
            'id' => empty($instance['visible_games']) ? 'all' : $instance['visible_games'],
            'orderby' => 'title',
            'order' => 'asc'
        ));


        if(empty($settings['number'])) $settings['number'] = '';

        switch ($match_type){
            case 'ended':
                $args = ['limit' => $instance['show_limit'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'done'];
                break;
            case 'upcoming':
                $args = ['from_date' => $now, 'limit' => $instance['show_limit'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'active'];
                break;
            case 'all':
                $args = ['limit' => $settings['number'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true];
                break;
            case 'playing':
                $args = ['to_date' => $now, 'limit' => $instance['show_limit'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'active'];
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

        <?php echo wp_kses($before_widget,$respawn_allowed); ?>

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
                if($instance['show_limit'] > 0)
                $matches = array_slice($matches, 0, $instance['show_limit']);
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
                            $image_link1 = respawn_aq_resize($image1, 71, round(71/$ratio_orig1), true, true, true );
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
                            $image_link2 = respawn_aq_resize($image2, 71, round(71/$ratio_orig2), true, true, true );
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
                                <img alt="img" src="<?php echo esc_url(respawn_return_game_banner($match->game_id)); ?>" />
                            <?php } ?>

                            <div class="mc-infowrap">

                                <div class="mbtitle-wrapper">

                                    <?php if(respawn_return_game_icon($match->game_id)){ ?>
                                        <img alt="img" src="<?php echo esc_url(respawn_return_game_icon($match->game_id)); ?>" />
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

        <?php echo wp_kses($after_widget,$respawn_allowed); ?>

        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = wp_parse_args( (array)$new_instance, $this->default_settings );

        $instance['show_limit'] = abs((int)$instance['show_limit']);
        $instance['custom_hide_duration'] = abs((int)$instance['custom_hide_duration']);
        $instance['display_game_icon'] = array_key_exists('display_game_icon', (array)$new_instance);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array)$instance, $this->default_settings );
        $games = \WP_TeamMatches\Games::get_game('id=all&orderby=title&order=asc');
        $items = $instance['show_limit'];

        ?>

        <div class="wp-team-matches-widget-settings">

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', WP_CLANWARS_TEXTDOMAIN); ?></label>
                <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" type="text" />
            </p>

            <p><?php esc_html_e('Show games:', WP_CLANWARS_TEXTDOMAIN); ?></p>
            <p>
                <?php foreach($games as $item) : ?>
                    <label for="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>"><input type="checkbox" name="<?php echo esc_attr($this->get_field_name('visible_games')); ?>[]" id="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>" value="<?php echo esc_attr($item->id); ?>" <?php checked(true, in_array($item->id, $instance['visible_games'])); ?>/> <?php echo esc_html($item->title); ?></label><br/>
                <?php endforeach; ?>
            </p>
            <p><?php esc_html_e('Do not check any game if you want to show all games.', WP_CLANWARS_TEXTDOMAIN); ?></p>

            <p class="widget-setting-match-type">
                <label for="<?php echo esc_attr($this->get_field_id('match_type')); ?>"><?php esc_html_e('Match type', WP_CLANWARS_TEXTDOMAIN); ?></label>
                <select name="<?php echo esc_attr($this->get_field_name('match_type')); ?>" id="<?php echo esc_attr($this->get_field_id('match_type')); ?>">
                    <?php foreach($this->match_type_options as $key => $option) : ?>
                        <option value="<?php echo esc_attr($key); ?>"<?php selected($key, $instance['match_type']); ?>><?php echo esc_html($option['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p class="widget-setting-hide-older-than">
                <label for="<?php echo esc_attr($this->get_field_id('hide_older_than')); ?>"><?php esc_html_e('Hide matches older than', WP_CLANWARS_TEXTDOMAIN); ?></label>
                <select name="<?php echo esc_attr($this->get_field_name('hide_older_than')); ?>" id="<?php echo esc_attr($this->get_field_id('hide_older_than')); ?>">
                    <?php foreach($this->newer_than_options as $key => $option) : ?>
                        <option value="<?php echo esc_attr($key); ?>"<?php selected($key, $instance['hide_older_than']); ?>><?php echo esc_html($option['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('show_limit')); ?>"><?php esc_html_e('Number of items', WP_CLANWARS_TEXTDOMAIN); ?></label>
                <input class="widefat" name="<?php echo esc_attr($this->get_field_name('show_limit')); ?>" id="<?php echo esc_attr($this->get_field_id('show_limit')); ?>" value="<?php echo esc_attr($items); ?>" type="text" />
            </p>

        </div>

        <?php
    }
}

?>