<?php
/*
    WP-TeamMatches
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

namespace WP_TeamMatches;

require_once( dirname(__FILE__) . '/db.class.php' );

class Matches {

    static function get_match( $args, $count = false)
    {

        $defaults = array(
            'to_date' => 0,
            'from_date' => 0,
            'id' => false,
            'game_id' => false,
            'sum_tickets' => false,
            'limit' => 0,
            'offset' => 0,
            'orderby' => 'id',
            'order' => 'asc',
            'search' => false,
            'status' => false
        );
        $args = Utils::extract_args($args, $defaults);

        extract($args);

        if(is_numeric($id) AND ($id > 0)) {
            $obj_merged = (object) array_merge((array) get_post($id), (array) \WP_TeamMatches::on_get_meta($id));

            if (((isset($obj_merged->team1_tickets)) AND (isset($obj_merged->team2_tickets)) AND (($obj_merged->team1_tickets == 0) OR ($obj_merged->team2_tickets == 0))) OR (!isset($obj_merged->team1_tickets) AND !isset($obj_merged->team2_tickets))) {

                if(!isset($obj_merged->ID) or empty($obj_merged->ID))$obj_merged->ID = 0;

                $tickets = \WP_TeamMatches::SumTickets($obj_merged->ID);

                if ((isset($obj_merged->team1_tickets) && $obj_merged->team1_tickets != $tickets[0]) OR (isset($obj_merged->team2_tickets) && $obj_merged->team2_tickets != $tickets[1])){
                    update_post_meta($obj_merged->ID, 'team1_tickets', $tickets[0]);
                    update_post_meta($obj_merged->ID, 'team2_tickets', $tickets[1]);
                    $obj_merged->team1_tickets = $tickets[0];
                    $obj_merged->team2_tickets = $tickets[1];
                }

            }

            return $obj_merged;
        }

        $order = strtoupper($order);
        if($order != 'ASC' && $order != 'DESC')
            $order = 'ASC';

        if ($count) {
            if ($search) {
                $args = array(
                    'post_type' => 'matches',
                    'posts_per_page' => -1,
                    's' => $search,
                    'post_status' => 'publish',
                );
            }else{
                $args = array(
                    'post_type' => 'matches',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                );
            }
        }else{
            if ($search) {

                if($orderby == 'date'){

                    $args = array(
                        'post_type' => 'matches',
                        'meta_key' => 'date',
                        'meta_type' => 'NUMERIC',
                        'posts_per_page' => -1,
                        'offset' => $offset,
                        'post_status' => 'publish',
                        'orderby' => 'meta_value_num',
                        's' => $search,
                        'order' => $order,

                    );

                }else{

                    $args = array(
                        'post_type' => 'matches',
                        'posts_per_page' => -1,
                        'offset' => $offset,
                        'post_status' => 'publish',
                        'orderby' => $orderby,
                        's' => $search,
                        'order' => $order,
                    );

                }

            } else {

                if($orderby == 'date'){

                    $args = array(
                        'post_type' => 'matches',
                        'meta_type' => 'NUMERIC',
                        'meta_key' => 'date',
                        'posts_per_page' => $limit,
                        'offset' => $offset,
                        'post_status' => 'publish',
                        'orderby' => 'meta_value_num',
                        'order' => $order,
                    );

                }else {
                    $args = array(
                        'post_type' => 'matches',
                        'posts_per_page' => $limit,
                        'offset' => $offset,
                        'post_status' => 'publish',
                        'orderby' => $orderby,
                        'order' => $order,
                    );
                }
            }
        }

        $temp_metas = array();
        $counter = 0;

        if($status !== false ) {

            if(!is_array($status))
                $status = array($status);

            if (count ($status) > 1) {
                $temp = array();
                foreach ($status as $single) {
                    $temp[] = array(
                        'key' => 'status',
                        'value' => $single,
                        'compare' => '='
                    );
                }
                $temp['relation'] = 'OR';
                $temp_metas[] = $temp;
                $counter++;
            }elseif(count ($status) == 1){
                $temp = array();
                foreach ($status as $single) {
                    $temp[] = array(
                        'key' => 'status',
                        'value' => $single,
                        'compare' => '='
                    );
                }
                $temp_metas[] = $temp;
                $counter++;

            }
        }

        if($to_date > 0) {
            $temp_metas[] = array(
                'key' => 'date_unix',
                'value' => intval($to_date),
                'compare' => '<'
            );

        }

        if($from_date > 0) {
            $temp_metas[] = array(
                'key' => 'date_unix',
                'value' => intval($from_date),
                'compare' => '>='
            );

        }

        if($game_id != 'all' && $game_id !== false) {

            if(!is_array($game_id))
                $game_id = array($game_id);

            if (count ($game_id) > 1) {
                $temp = array();
                foreach ($game_id as $single) {
                    $temp[] = array(
                        'key' => 'game_id',
                        'value' => $single,
                        'compare' => '='
                    );
                }
                $temp['relation'] = 'OR';
                $temp_metas[] = $temp;
                $counter++;
            }elseif(count ($game_id)  == 1){
                $temp = array();
                foreach ($game_id as $single) {
                    $temp[] = array(
                        'key' => 'game_id',
                        'value' => $single,
                        'compare' => '='
                    );
                }
                $temp_metas[] = $temp;
                $counter++;
            }
        }

        if ($counter == 1) {
            $args['meta_query'] = $temp_metas;
        } elseif ($counter > 1) {
            $args['meta_query'] = $temp_metas;
            $args['meta_query']['relation'] = 'AND';
        }

        $posts = get_posts($args);

        if($count) {
            if (is_array($posts)) {
                $ret['total_items'] = count($posts);
                if($limit > 0)
                    $ret['total_pages'] = ceil($ret['total_items'] / $limit);
                return $ret;
            } else {
                $ret['total_items'] = 0;
                $ret['total_pages'] = 0;
                return $ret;
            }

        }

        $returner = array();
        $counter = 0;
        foreach( $posts as $single) {
            $returner[$counter] = (object) array_merge((array) $single, (array) \WP_TeamMatches::on_get_meta($single->ID));
            $counter ++;
        }

        return $returner;

    }


    static function add_match($p)
    {

        $data = Utils::extract_args($p, array(
                    'title' => '',
                    'date' => Utils::current_time_fixed('timestamp', 0),
                    'date_unix' => 0,
                    'post_id' => 0,
                    'team1' => 0,
                    'team2' => 0,
                    'game_id' => 0,
                    'match_status' => 0,
                    'description' => '',
                    'external_url' => '',
                    'status' => 'active',
                    'kills' => 0,
                    'duration' => 0,
                    'winner'  => 0,

            ));

        $postarr = array(
            'post_status' => 'publish',
            'post_content' => '',
            'post_excerpt' => '',
            'post_title' => $data['title'],
            'post_name' => sanitize_title($data['title']),
            'post_type' => 'matches',
            'comment_status' => 'open'
        );

        $new_post_ID = wp_insert_post($postarr);
        if ($new_post_ID) {
            \WP_TeamMatches::on_mass_update_post_meta($new_post_ID, $data);
            return $new_post_ID;
        } else {
            return false;
        }

    }

    static function update_match($id, $p)
    {

        $data = wp_parse_args($p, array());

        // filter external_url field
        if(isset($data['external_url'])) {
            $data['external_url'] = esc_url_raw($data['external_url']);
        }

        if(isset($data['kills'])) {
            $data['kills'] = intval($data['kills']);
        }

        if(isset($data['duration'])) {
            $data['duration'] = intval($data['duration']);
        }

        if(isset($data['winner'])) {
            $data['winner'] = intval($data['winner']);
        }

        \WP_TeamMatches::on_mass_update_post_meta($id, $data);

        if (isset($data['status'])) {

            $m = self::get_match(array('id' => $id, 'sum_tickets' => true));

            if ( (isset($m->status)) AND (!empty($m->status)) AND (strtolower($m->status) == "done")) {
                $newdata['match_postid'] = $id;
                $newdata['match_id'] = $id;

                $t1 = $m->team1_tickets;
                $t2 = $m->team2_tickets;

                $newdata['team1_score'] = $t1;
                $newdata['team2_score'] = $t2;
                if ($t1 > $t2) {
                    $newdata['winner'] = 'team1';
                } elseif ($t1 == $t2) {
                    $newdata['winner'] = 'draw';
                } else {
                    //$t2 > $t1
                    $newdata['winner'] = 'team2';
                }

            } elseif ( (isset($m->status)) AND (!empty($m->status)) AND (strtolower($m->status) == "active")) {

                $newdata['match_postid'] = $id;

            }

        }

        return true;
    }


    static function update_match_post($match_id) {
        //UPDATED FOR POSTS
        $postarr = array(
            'post_status' => 'publish',
            'post_title' => '',
            'post_type' => 'matches',
            'comment_status' => 'open'

        );
        $post = \WP_TeamMatches\Matches::get_match(array('id' => $match_id, 'sum_tickets' => true));

        if(!is_null($post)) {
            $postarr['ID'] = $post->ID;
        }

        $postarr['post_title'] = $post->title;
        wp_update_post($postarr);

        $scores = \WP_TeamMatches::SumTickets($match_id);

        update_post_meta($match_id, 'team1_tickets', $scores[0]);
        update_post_meta($match_id, 'team2_tickets', $scores[1]);
        $games = \WP_TeamMatches\Games::get_game(array('id' => get_post_meta($match_id, 'game_id', true)));

        if (isset($games[0])) {
            update_post_meta($match_id, 'game_title', $games[0]->title);
            update_post_meta($match_id, 'game_icon', $games[0]->icon);
        }

        return $match_id;
    }

    // @TODO: remove post
    static function delete_match($id)
    {
        //CONVERTED TO POSTS
        if(!is_array($id))
            $id = array($id);

        $id = array_map('intval', $id);

        Rounds::delete_rounds_by_match($id);
        if (is_array($id)) {
            foreach ($id as $small_id) {
                wp_delete_post($small_id);
            }
        } else {
            wp_delete_post($id);
        }
        return true;
    }

    static function delete_match_by_team($id) {
        //CONVERTED TO POSTS

        if(!is_array($id))
            $id = array($id);

        $id = array_map('intval', $id);
        if (is_array($id)) {
            foreach ($id as $small_id) {
                $args = array(
                    'post_type' => 'matches',
                    'posts_per_page' => -1,
                    'post_status' => 'any',
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'team1',
                            'value' => $small_id,
                            'compare' => '=',
                            'type' => 'numeric',
                        ),
                        array(
                            'key' => 'team2',
                            'value' => $small_id,
                            'compare' => '=',
                            'type' => 'numeric',
                        ),
                    )
                );

                $posts = get_posts($args);

                if (is_array($posts) AND (count($posts) > 0) ) {
                    foreach ($posts as $post) {
                        wp_delete_post($post->ID);
                    }
                }
            }
        }
        return true;
    }

    static function delete_match_by_game($id) {
        //UPDATED FOR POSTS
        $args = array(
            'post_type' => 'matches',
            'meta_key' => 'game_id',
            'meta_value' => $id
        );
        $posts = get_posts($args);
        if (is_array($posts)) {
            foreach ($posts as $post) {
                wp_delete_post($post->ID);
            }
        }

    }

}
