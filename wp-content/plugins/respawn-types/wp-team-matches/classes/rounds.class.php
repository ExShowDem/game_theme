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

class Rounds {


    static function get_rounds($match_id)
    {
        $rounds =  get_post_meta($match_id, 'tickets', true);
        if (is_array($rounds)) {
            $temparray = array();
            foreach ($rounds as $round) {
                $m = Maps::get_map(array('id' => $round['map_id']));
                $round['title'] = $m[0]->title;
                $round['screenshot'] = $m[0]->screenshot;

                $temparray[] = (object)$round;
            }
            return $temparray;
        } else {
            return array();
        }
    }

    static function add_round($p)
    {
        $data = Utils::extract_args($p, array(
                    'match_id' => 0,
                    'group_n' => 0,
                    'map_id' => 0,
                    'tickets1' => 0,
                    'tickets2' => 0
            ));

        if(is_admin() && ($data['tickets1'] != 0 or $data['tickets2'] != 0)){
            update_post_meta($data['match_id'], 'status', 'done');
        }
        $tickets = get_post_meta($data['match_id'], 'tickets', true);

        if (is_array($tickets)) {
            $counter = count($tickets);
            //find new empty ticket ID
            while (isset($tickets[$counter])) {
                $counter++;
            }
            $newdata = array_map('intval', $data);
            $tickets[$counter] = $newdata;
            if(update_post_meta($data['match_id'], 'tickets', $tickets)) {
                return $counter;
            } else {
                return false;
            }
        } else {
            $tickets = array();
            $tickets[1] = array_map('intval', $data);

            if(update_post_meta($data['match_id'], 'tickets', $tickets)) {
                return 1;
            } else {
                return false;
            }
        }
    }

    static function update_round($id, $p)
    {

        $data = wp_parse_args($p, array());

        if(is_admin() && ($data['tickets1'] != 0 or $data['tickets2'] != 0)){
            update_post_meta($data['match_id'], 'status', 'done');
        }

        $tickets = get_post_meta($data['match_id'], 'tickets', true);

        if (is_array($tickets)) {
            $newdata = array_map('intval', $data);

            $tickets[$id] = $newdata;

            if(update_post_meta($data['match_id'], 'tickets', $tickets)) {
                return $counter;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    static function delete_round($id)
    {
        global $wpdb;

        if(!is_array($id))
            $id = array($id);

        $id = array_map('intval', $id);

        return $wpdb->query('DELETE FROM `' . self::table() . '` WHERE id IN(' . implode(',', $id) . ')');
    }

    static function delete_rounds_not_in($match_id, $id)
    {
        //UPDATED FOR POSTS
        if(!is_array($id))
            $id = array($id);

        $newrounds = array();
        $rounds = get_post_meta($match_id, 'tickets', true);
        if (is_array($rounds)) {
            foreach ($rounds as $key => $value) {
                if (in_array($key, $id)) {
                    $newrounds[$key] = $value;
                }
            }
        }
        $reset = array_values($newrounds);
        update_post_meta($match_id, 'tickets', $reset);
        return true;
    }

    static function delete_rounds_by_match($match_id)
    {
        //UPDATED FOR POSTS
        update_post_meta($match_id, 'tickets', '');
        return true;
    }

}