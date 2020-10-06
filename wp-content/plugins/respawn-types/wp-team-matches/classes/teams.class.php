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

class Teams {


    static function get_team( $args )
    {
        global $wpdb;

        $defaults = array(
            'id' => false,
            'title' => false,
            'limit' => 0,
            'offset' => 0,
            'orderby' => 'id',
            'order' => 'ASC'
        );
        $args = Utils::extract_args($args, $defaults);
        extract($args);

        $order = strtoupper($order);
        if($order != 'ASC' && $order != 'DESC')
            $order = 'ASC';


        if(($id != 'all' && $id !== false) OR ((is_array($id)) AND (!empty($id)))) {
            if (is_array($id)) {
                $returns = array();
                $counter = 0;
                foreach ($id as $single) {
                    $returns[$counter] = (object) array_merge((array) get_post($single), (array) \WP_TeamMatches::on_get_meta($single));
                    $returns[$counter]->title = $returns[$counter]->post_title;
                    $returns[$counter]->id = $returns[$counter]->ID;
                    $counter++;
                }
                return $returns;
            } else {
                $obj_merged = (object) array_merge((array) get_post($id), (array) \WP_TeamMatches::on_get_meta($id));
                if(isset($obj_merged->post_title))
                    $obj_merged->title = $obj_merged->post_title;
                if(isset($obj_merged->ID))
                    $obj_merged->id = $obj_merged->ID;
                return $obj_merged;
            }
        } else {
            //id not set
            if ($limit == 0) {
                $limit = -1;
            }
            $args = array(
                'post_type' => 'team',
                'posts_per_page' => $limit,
                'offset' => $offset,
                'post_status' => 'publish',
                'orderby' => $orderby,
                'order' => $order
            );

            if($title !== false) {
                $test = get_page_by_title($title, OBJECT, 'post');
                if ($test) {
                    return $test;
                } else {
                    return false;
                }
            }
            $posts = get_posts ($args);
            $returner = array();
            if (is_array($posts)) {
                foreach ($posts as $post) {
                    $obj_merged = (object) array_merge((array) $post, (array) \WP_TeamMatches::on_get_meta($post->ID));
                    $obj_merged->title = $obj_merged->post_title;
                    $obj_merged->id = $obj_merged->ID;
                    $returner[] = $obj_merged;
                }
            }
            return $returner;
        }
    }

    static function add_team( $args )
    {

        $defaults = array(
            'title' => '',
            'logo' => 0,
            'country' => '',
            'home_team' => 0,
            'post_id' => ''
        );

        $data = Utils::extract_args($args, $defaults);

        if ( FALSE === get_post_status( $data['post_id'] ) ) {
            //team doesn't exist create it
            $args = array(
                'post_type' => 'team',
                'post_title' => $data['title'],
                'post_status'=> 'publish',
                'post_content' => '',
                'post_name'   => sanitize_title($data['title'])
            );
            $pid = wp_insert_post($args);
            if ($pid) {
                update_post_meta($pid, 'team_photo', $data['logo']);
                update_post_meta($pid, 'home_team', $data['home_team']);
                update_post_meta($pid, 'country', $data['country']);
                return true;
            } else {
                return false;
            }
        } else {
            //team exists update it
            $args = array(
                'ID' => $data['post_id'],
                'post_title'   => $data['title'],
                'post_name'   => sanitize_title($data['title'])
            );
            wp_update_post( $args );
            update_post_meta($data['post_id'], 'team_photo', $data['logo']);
            update_post_meta($data['post_id'], 'home_team', $data['home_team']);
            return $data['post_id'];
        }
    }

    static function set_hometeam($id) {
        //UPDATED TO POSTS
        return update_post_meta($id, 'home_team', 1);
    }

    static function get_hometeam() {
        $args = array(
            'post_type'  => 'team',
            'meta_query' => array(
                array(
                    'key' => 'home_team',
                    'value' => '1',
                    'compare' => '=',
                )
            )
        );
        return get_posts($args);
    }

    static function update_team($id, $args)
    {
        //UPDATED TO POSTS
        $data = wp_parse_args($args, array());

        //update title
        if (isset($data['title']) AND (strlen($data['title']) > 1)) {
            $args = array(
                'ID' => $id,
                'post_title'   => $data['title']
            );
            wp_update_post( $args );
        }
        //update home_team
        if (isset($data['home_team']) AND (strlen($data['home_team']) > 1)) {
            update_post_meta($id, 'home_team', $data['home_team']);
        }
        if (isset($data['logo']) AND (strlen($data['logo']) > 1)) {
            update_post_meta($id, 'team_photo', $data['logo']);
        }

        return $id;
    }

    static function delete_team($id, $skipdelete = false)
    {
        //UPDATED TO POSTS
        if(!is_array($id))
            $id = array($id);

        $id = array_map('intval', $id);

        // delete matches belongs to this team
        \WP_TeamMatches::on_delete_match_by_team($id);

        //parse ids, remove post
        if (is_array($id)) {
            foreach($id as $small_id) {
                if ($small_id > 0) {
                    if ($skipdelete == false) {
                        wp_delete_post($small_id);
                    }
                }
            }
        } else {
            if (is_int($id)) {
                if ($id > 0) {
                    if ($skipdelete == false) {
                        wp_delete_post($id);
                    }
                }
            }
        }
        return true;
    }
    /*
    static function most_popular_countries()
    {
        global $wpdb;

        static $cache = false;

        $limit = 10;

        if($cache !== false) {
            return $cache;
        }

        $teams_table = \WP_TeamMatches\Teams::table();
        $matches_table = \WP_TeamMatches\Matches::table();

        $query = $wpdb->prepare(
            "(SELECT t1.country, COUNT(t2.id) AS cnt
            FROM $teams_table AS t1, $matches_table AS t2
            WHERE t1.id = t2.team1
            GROUP BY t1.country
            LIMIT %d)
            UNION
            (SELECT t1.country, COUNT(t2.id) AS cnt
            FROM $teams_table AS t1, $matches_table AS t2
            WHERE t1.id = t2.team2
            GROUP BY t1.country
            LIMIT %d)
            ORDER BY cnt DESC
            LIMIT %d", $limit, $limit, $limit
        );

        $cache = $wpdb->get_results( $query, ARRAY_A );

        return $cache;
    }
    */

};