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

require_once( dirname(__FILE__) . '/acl.class.php' );
require_once( dirname(__FILE__) . '/utils.class.php' );

if(!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

add_filter('set-screen-option', array('\WP_TeamMatches\MatchTable', 'handle_screen_option'), 10, 3);

class MatchTable extends \WP_List_Table {

    const PER_PAGE_OPTION = 'wp_team-matches_matches_per_page';
    const PER_PAGE_DEFAULT = 10;

    static function handle_screen_option($status, $option, $value) {
        if($option === static::PER_PAGE_OPTION) {
            $value = (int)$value;
            if($value < 1 || $value > 999) {
                return;
            }
        }
        return $value;
    }

    function __construct($args = array()) {
        $base_args = array(
            'singular' => 'match',
            'plural' => 'matches'
        );

        parent::__construct( array_merge($base_args, $args) );

        // register screen options for match_table
        $screen_options = array(
            'label' => esc_html__('Matches per page', WP_CLANWARS_TEXTDOMAIN),
            'default' => static::PER_PAGE_DEFAULT,
            'option' => static::PER_PAGE_OPTION
        );
        add_screen_option('per_page', $screen_options);
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => esc_html__('Title', WP_CLANWARS_TEXTDOMAIN),
            'game' => esc_html__('Game', WP_CLANWARS_TEXTDOMAIN),
            'date' => esc_html__('Date', WP_CLANWARS_TEXTDOMAIN),
            'match_status' => esc_html__('Status', WP_CLANWARS_TEXTDOMAIN),
            'team1' => esc_html__('Team 1', WP_CLANWARS_TEXTDOMAIN),
            'team2' => esc_html__('Team 2', WP_CLANWARS_TEXTDOMAIN),
            'tickets' => esc_html__('Tickets', WP_CLANWARS_TEXTDOMAIN)
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'title' => 'title', 
            'game' => 'game_id', 
            'date' => 'date',
            'match_status' => 'match_status'
        );
        return $sortable_columns;
    }

    function get_table_classes() {
        $classes = parent::get_table_classes();
        $classes[] = 'wp-team-matches-match-table';
        return $classes;
    }

    protected function get_bulk_actions() {
        return array(
            'delete' => esc_html__('Delete', WP_CLANWARS_TEXTDOMAIN)
        );
    }

    function no_items() {
        esc_html_e('No matches found.', WP_CLANWARS_TEXTDOMAIN);
    }

    function column_cb($item) {
        return '<input type="checkbox" name="id[]" value="' . esc_attr($item->ID) . '" />';
    }

    function column_date($item) {
        return mysql2date(get_option('date_format') . ' ' . get_option('time_format'), $item->date);
    }

    function column_default($item, $column_name) {
        if(isset($item->$column_name)) {
            return esc_html($item->$column_name);
        }
    }

    function column_title($item) {

      echo '<a href="'.esc_url(admin_url('admin.php?page=wp-team-matches-matches&amp;act=edit&amp;id=' . $item->ID)).'" title="'.sprintf(esc_html__('Edit &#8220;%s&#8221; Match', 'arcane'), esc_attr($item->post_title)).'">'.esc_html($item->post_title).'</a>';

    }

    function column_game($item) {
        global $wpdb;
        $output = '';
        $game_id = get_post_meta($item->ID, 'game_id', true);

        $games = $wpdb->prefix."cw_games";
        $game_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $games WHERE `id`= %s", $game_id),ARRAY_A );

        if(!empty($game_data[0]['icon'])){
            $img_url = wp_get_attachment_url( $game_data[0]['icon']); //get img URL
            $image = respawn_aq_resize( $img_url, 85, 116, true, true, true ); //resize & crop img
        }
        if(empty($image)){ $image = get_theme_file_uri('assets/img/defaults/gamedef.png');  }

        $g_title = '';
        if(!empty($game_data[0]['title']))
            $g_title = $game_data[0]['title'];

        if($image !== false) {
            $output .= '<img src="' . esc_attr($image) . '" alt="' . esc_attr($g_title) . '" class="icon" /> ';
        }

        $output .= esc_html($g_title);

        return $output;
    }

    function column_team1($item) {
        $team1 = get_post_meta($item->ID, 'team1', true);
        return get_the_title($team1);
        //return \WP_TeamMatches\Utils::get_country_flag($item->team1_country) . ' ' . $item->team1_title;
    }

    function column_team2($item) {
        $team2 = get_post_meta($item->ID, 'team2', true);
        return get_the_title($team2);
        //return \WP_TeamMatches\Utils::get_country_flag($item->team2_country) . ' ' . $item->team2_title;
    }

    function column_match_status($item) {
        $status = array(
            esc_html__('PCW', WP_CLANWARS_TEXTDOMAIN),
            esc_html__('Official', WP_CLANWARS_TEXTDOMAIN)
        );
        return $status[ $item->match_status ];
    }

    function column_tickets($item) {
        $tickets = \WP_TeamMatches::SumTickets($item->ID);
        return sprintf(esc_html__('%s:%s', WP_CLANWARS_TEXTDOMAIN), $tickets[0], $tickets[1]);
    }

    protected function handle_row_actions( $item, $column_name, $primary ) {
        if ( $primary !== $column_name ) {
            return '';
        }

        $actions = array();

        $edit_link = esc_url(admin_url('admin.php?page=wp-team-matches-matches&act=edit&id=' . $item->ID));
        $delete_link = wp_nonce_url('admin-post.php?action=wp-team-matches-delete-match&id=' . $item->ID . '&_wp_http_referer=' . urlencode($_SERVER['REQUEST_URI']), 'wp-team-matches-delete-match');

        $actions['edit'] = '<a href="' . esc_attr($edit_link) . '">' . __('Edit', WP_CLANWARS_TEXTDOMAIN) . '</a>';
        $actions['delete'] = '<a href="' . esc_attr($delete_link) . '">' . __('Delete', WP_CLANWARS_TEXTDOMAIN) . '</a>';

        return $this->row_actions( $actions );
    }

    function prepare_items() {
        $per_page = $this->get_items_per_page(static::PER_PAGE_OPTION, static::PER_PAGE_DEFAULT);


        $current_page = $this->get_pagenum();

        $orderby = ( isset( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'date';
        $order = ( isset( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'desc';

        $offset = ($current_page - 1) * $per_page;
        $limit = $per_page;

        if(isset($_GET['s']))
            $search = $_GET['s'];
        if (isset($search)) {
            $search = urldecode($search);
            $search = sanitize_text_field($search);
        } else {
            $search = "";
        }

        $game_filter = \WP_TeamMatches\ACL::user_can('which_games');
        $args = array(
            'id' => 'all',
            'game_id' => $game_filter,
            'sum_tickets' => true,
            'orderby' => $orderby,
            'order' => $order,
            'limit' => $limit,
            'search' =>$search,
            'offset' => ($limit * ($current_page-1))
        );

        $matches = \WP_TeamMatches\Matches::get_match( $args );

        if (!empty($search)) {

            $filtered = array();
            foreach ($matches as $match) {

                if (strpos (strtolower($match->post_title), strtolower($search)) !== false) {
                    $filtered[] = $match;
                }
            }

            $matches = $filtered;
            $stat['total_items'] = count($matches);
            if($limit > 0)
                $stat['total_pages'] = ceil($stat['total_items'] / $limit);
        }

        $args = array(
            'id' => 'all',
            'game_id' => $game_filter,
            'limit' => -1,
        );
        $matches_total = \WP_TeamMatches\Matches::get_match( $args );

        $this->set_pagination_args(array(
            'total_pages' => ceil(count($matches_total)/$limit),
            'total_items' => count($matches_total),
            'per_page' => $per_page
        ));

        $this->items = $matches;
    }

}
