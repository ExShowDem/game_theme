<?php
/*
Plugin Name: Respawn types
Plugin URI: https://www.skywarriorthemes.com/respawn/
Description: Respawn theme custom post types
Version: 1.2
Author: Skywarrior Studios
Author URI: https://www.skywarriorthemes.com/
*/

/**
 * undocumented class
 *
 * @package default
 * @author
 */


// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class Respawn_Types {


     function __construct() {
        register_activation_hook( __FILE__,array( $this,'activate' ) );
        add_action( 'init', array( $this, 'respawn_register_post_types' ), 1 );
    }

    function activate() {
        $this->respawn_register_post_types();
    }


    function respawn_register_post_types() {

        if(class_exists('WP_TeamMatches')) {
            global $wpdb;

            $table_prefix = $wpdb->prefix;
            $dbstruct1 = '';
            $dbstruct2 = '';
            $dbstruct1 .= "CREATE TABLE IF NOT EXISTS {$table_prefix}cw_games (
                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                      `title` varchar(200) NOT NULL,
                      `abbr` varchar(20) DEFAULT NULL,
                      `icon` bigint(20) unsigned DEFAULT NULL,
                      `g_banner_file` bigint(20) unsigned DEFAULT NULL,
                      `store_id` varchar(64) DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      KEY `store_id` (`store_id`),
                      KEY `g_banner_file` (`g_banner_file`),
                      KEY `icon` (`icon`),
                      KEY `title` (`title`),
                      KEY `abbr` (`abbr`)
                    ) CHARACTER SET utf8;";

            $wpdb->query($dbstruct1);

            $dbstruct2 .= "CREATE TABLE IF NOT EXISTS {$table_prefix}cw_maps (
                      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                      `game_id` int(10) unsigned NOT NULL,
                      `title` varchar(200) NOT NULL,
                      `screenshot` bigint(20) unsigned DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      KEY `game_id` (`game_id`,`screenshot`)
                    ) CHARACTER SET utf8;";

            $wpdb->query($dbstruct2);
        }

        /*MASONRY*/
        register_post_type('masonry_gallery',
            array(
                'labels'        => array(
                'name'              => esc_html__('Masonry Galleries','respawn' ),
                'all_items'         => esc_html__('Masonry Galleries','respawn'),
                'singular_name'     => esc_html__('Masonry Gallery','respawn' ),
                'add_new'       => esc_html__('Add New Gallery','respawn'),
                ),
                'public'        =>  false,
                'show_in_menu'  =>  true,
                'show_ui'       =>  true,
                'has_archive'   =>  false,
                'hierarchical'  =>  false,
                'supports'      =>  array('title'),
                'menu_position'     => 25
            )
        );

        /*PLAYER*/
        register_post_type( 'player',
            array(
                'labels' => array(
                'name' => esc_html__( 'Players', 'respawn' ),
                'singular_name' => esc_html__( 'Players', 'respawn' )
                ),
                'supports' => array( 'title', 'editor', 'shortlinks', 'thumbnail' ),
                'public' => true,
                'show_in_rest' => true,
                'publicly_queryable' => true,
                'capability_type' => 'page',
                'rewrite' => true,
                'has_archive' => false,
                'query_var' => true,
                'show_in_menu' => 'wp-teamwars.php',
                'menu_icon' => plugin_dir_url(__FILE__) . 'img/player.png',
            )
        );


        /*TEAMS*/
        register_post_type('team',
            array(
                'labels'        => array(
                'name'              => esc_html__('Teams','respawn' ),
                'all_items'         => esc_html__('All Teams','respawn'),
                'singular_name'     => esc_html__('Team','respawn' ),
                'add_new'       => esc_html__('Add New Team','respawn'),
                ),
                'public'        =>  true,
                'show_in_menu'  =>  'wp-team-matches.php',
                'show_ui'       =>  true,
                'has_archive'   =>  false,
                'hierarchical'  =>  false,
                'supports'      =>  array( 'title', 'editor', 'shortlinks', 'thumbnail', 'author' ),
                'menu_position'     => 25
            )
        );

        /*MATCHES*/
        $labels = array(
            'name' => _x('Matches', 'post type general name','respawn'),
            'singular_name' => _x('Match', 'post type singular name','respawn'),
            'add_new' => _x('Add New', 'match item' ,'respawn'),
            'add_new_item' => esc_html__('Add New Match','respawn'),
            'edit_item' => esc_html__('Edit Match','respawn'),
            'new_item' => esc_html__('New Match','respawn'),
            'view_item' => esc_html__('View Match','respawn'),
            'search_items' => esc_html__('Search Matches','respawn'),
            'not_found' =>  esc_html__('Nothing found','respawn'),
            'not_found_in_trash' => esc_html__('Nothing found in Trash','respawn'),
            'parent_item_colon' => ''
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'supports' => array('title','editor','thumbnail' ),
            'show_in_menu' => false

        );
        register_post_type( 'matches' , $args );


        /*THE PLUS PLUGIN*/
        $labels = array(
            'name'                  => _x( 'TP Testimonials', 'Post Type General Name', 'respawn' ),
            'singular_name'         => _x( 'TP Testimonials', 'Post Type Singular Name', 'respawn' ),
            'menu_name'             => esc_html__( 'TP Testimonials', 'respawn' ),
            'name_admin_bar'        => esc_html__( 'TP Testimonial', 'respawn' ),
            'archives'              => esc_html__( 'Item Archives', 'respawn' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'respawn' ),
            'all_items'             => esc_html__( 'All Items', 'respawn' ),
            'add_new_item'          => esc_html__( 'Add New Item', 'respawn' ),
            'add_new'               => esc_html__( 'Add New', 'respawn' ),
            'new_item'              => esc_html__( 'New Item', 'respawn' ),
            'edit_item'             => esc_html__( 'Edit Item', 'respawn' ),
            'update_item'           => esc_html__( 'Update Item', 'respawn' ),
            'view_item'             => esc_html__( 'View Item', 'respawn' ),
            'search_items'          => esc_html__( 'Search Item', 'respawn' ),
            'not_found'             => esc_html__( 'Not found', 'respawn' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'respawn' ),
            'featured_image'        => esc_html__( 'Profile Image', 'respawn' ),
            'set_featured_image'    => esc_html__( 'Set profile image', 'respawn' ),
            'remove_featured_image' => esc_html__( 'Remove profile image', 'respawn' ),
            'use_featured_image'    => esc_html__( 'Use as profile image', 'respawn' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'respawn' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'respawn' ),
            'items_list'            => esc_html__( 'Items list', 'respawn' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'respawn' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'respawn' ),
        );
        $args = array(
            'label'                 => esc_html__( 'TP Testimonials', 'respawn' ),
            'description'           => esc_html__( 'Post Type Description', 'respawn' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail','revisions' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_icon'             => 'dashicons-testimonial',
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'theplus_testimonial', $args );


        $labels = array(
            'name'                       => esc_html__( 'TP Testimonials Categories','respawn' ),
            'singular_name'              => esc_html__( 'TP Testimonials Category','respawn' ),
            'menu_name'                  => esc_html__('TP Testimonials Category','respawn' ),
            'all_items'                  => esc_html__('All Items','respawn' ),
            'parent_item'                => esc_html__('Parent Item','respawn' ),
            'parent_item_colon'          => esc_html__('Parent Item:','respawn' ),
            'new_item_name'              => esc_html__('New Item Name','respawn' ),
            'add_new_item'               => esc_html__('Add New Item','respawn' ),
            'edit_item'                  => esc_html__('Edit Item','respawn' ),
            'update_item'                => esc_html__('Update Item','respawn' ),
            'view_item'                  => esc_html__('View Item','respawn' ),
            'separate_items_with_commas' => esc_html__('Separate items with commas','respawn' ),
            'add_or_remove_items'        => esc_html__('Add or remove items','respawn' ),
            'choose_from_most_used'      => esc_html__('Choose from the most used','respawn' ),
            'popular_items'              => esc_html__('Popular Items','respawn' ),
            'search_items'               => esc_html__('Search Items','respawn' ),
            'not_found'                  => esc_html__('Not Found','respawn' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'theplus_testimonial_cat', array( 'theplus_testimonial' ), $args );


        $labels = array(
            'name'                  => _x( 'TP Team Members', 'Post Type General Name', 'respawn' ),
            'singular_name'         => _x( 'TP Team Member', 'Post Type Singular Name', 'respawn' ),
            'menu_name'             => esc_html__( 'TP Team Member', 'respawn' ),
            'name_admin_bar'        => esc_html__( 'TP Team Member', 'respawn' ),
            'archives'              => esc_html__( 'Item Archives', 'respawn' ),
            'attributes'            => esc_html__( 'Item Attributes', 'respawn' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'respawn' ),
            'all_items'             => esc_html__( 'All Items', 'respawn' ),
            'add_new_item'          => esc_html__( 'Add New Item', 'respawn' ),
            'add_new'               => esc_html__( 'Add New', 'respawn' ),
            'new_item'              => esc_html__( 'New Item', 'respawn' ),
            'edit_item'             => esc_html__( 'Edit Item', 'respawn' ),
            'update_item'           => esc_html__( 'Update Item', 'respawn' ),
            'view_item'             => esc_html__( 'View Item', 'respawn' ),
            'view_items'            => esc_html__( 'View Items', 'respawn' ),
            'search_items'          => esc_html__( 'Search Item', 'respawn' ),
            'not_found'             => esc_html__( 'Not found', 'respawn' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'respawn' ),
            'featured_image'        => esc_html__( 'Featured Image', 'respawn' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'respawn' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'respawn' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'respawn' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'respawn' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'respawn' ),
            'items_list'            => esc_html__( 'Items list', 'respawn' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'respawn' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'respawn' ),
        );
        $args = array(
            'label'                 => esc_html__( 'TP Team Member', 'respawn' ),
            'description'           => esc_html__( 'Post Type Description', 'respawn' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail','revisions', 'custom-fields', ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'menu_icon'   => 'dashicons-id-alt',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'theplus_team_member', $args );


        $labels = array(
            'name'                       => esc_html__('Team Member Categories','respawn' ),
            'singular_name'              => esc_html__('Team Member Category','respawn' ),
            'menu_name'                  => esc_html__('TP Team Member Category','respawn' ),
            'all_items'                  => esc_html__('All Items','respawn' ),
            'parent_item'                => esc_html__('Parent Item','respawn' ),
            'parent_item_colon'          => esc_html__('Parent Item:','respawn' ),
            'new_item_name'              => esc_html__('New Item Name','respawn' ),
            'add_new_item'               => esc_html__('Add New Item','respawn' ),
            'edit_item'                  => esc_html__('Edit Item','respawn' ),
            'update_item'                => esc_html__('Update Item','respawn' ),
            'view_item'                  => esc_html__('View Item','respawn' ),
            'separate_items_with_commas' => esc_html__('Separate items with commas','respawn' ),
            'add_or_remove_items'        => esc_html__('Add or remove items','respawn' ),
            'choose_from_most_used'      => esc_html__('Choose from the most used','respawn' ),
            'popular_items'              => esc_html__('Popular Items','respawn' ),
            'search_items'               => esc_html__('Search Items','respawn' ),
            'not_found'                  => esc_html__('Not Found','respawn' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'theplus_team_member_cat', array( 'theplus_team_member' ), $args );


        $labels = array(
            'name'                  => _x( 'Tp Clients', 'Post Type General Name', 'respawn' ),
            'singular_name'         => _x( 'Tp Clients', 'Post Type Singular Name', 'respawn' ),
            'menu_name'             => esc_html__( 'Tp Clients', 'respawn' ),
            'name_admin_bar'        => esc_html__( 'Tp Client', 'respawn' ),
            'archives'              => esc_html__( 'Item Archives', 'respawn' ),
            'attributes'            => esc_html__( 'Item Attributes', 'respawn' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'respawn' ),
            'all_items'             => esc_html__( 'All Items', 'respawn' ),
            'add_new_item'          => esc_html__( 'Add New Item', 'respawn' ),
            'add_new'               => esc_html__( 'Add New', 'respawn' ),
            'new_item'              => esc_html__( 'New Item', 'respawn' ),
            'edit_item'             => esc_html__( 'Edit Item', 'respawn' ),
            'update_item'           => esc_html__( 'Update Item', 'respawn' ),
            'view_item'             => esc_html__( 'View Item', 'respawn' ),
            'view_items'            => esc_html__( 'View Items', 'respawn' ),
            'search_items'          => esc_html__( 'Search Item', 'respawn' ),
            'not_found'             => esc_html__( 'Not found', 'respawn' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'respawn' ),
            'featured_image'        => esc_html__( 'Featured Image', 'respawn' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'respawn' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'respawn' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'respawn' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'respawn' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'respawn' ),
            'items_list'            => esc_html__( 'Items list', 'respawn' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'respawn' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'respawn' ),
        );
        $args = array(
            'label'                 => esc_html__( 'Clients', 'respawn' ),
            'description'           => esc_html__( 'Post Type Description', 'respawn' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail','revisions' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'theplus_clients', $args );


        $labels = array(
            'name'                       => esc_html__('Tp Clients Categories','respawn' ),
            'singular_name'              => esc_html__('Tp Clients Category','respawn' ),
            'menu_name'                  => esc_html__('Tp Clients Category','respawn' ),
            'all_items'                  => esc_html__('All Items','respawn' ),
            'parent_item'                => esc_html__('Parent Item','respawn' ),
            'parent_item_colon'          => esc_html__('Parent Item:','respawn' ),
            'new_item_name'              => esc_html__('New Item Name','respawn' ),
            'add_new_item'               => esc_html__('Add New Item','respawn' ),
            'edit_item'                  => esc_html__('Edit Item','respawn' ),
            'update_item'                => esc_html__('Update Item','respawn' ),
            'view_item'                  => esc_html__('View Item','respawn' ),
            'separate_items_with_commas' => esc_html__('Separate items with commas','respawn' ),
            'add_or_remove_items'        => esc_html__('Add or remove items','respawn' ),
            'choose_from_most_used'      => esc_html__ ('Choose from the most used','respawn' ),
            'popular_items'              => esc_html__('Popular Items','respawn' ),
            'search_items'               => esc_html__('Search Items','respawn' ),
            'not_found'                  => esc_html__('Not Found','respawn' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'theplus_clients_cat', array( 'theplus_clients' ), $args );

    }


} // END

new Respawn_Types;


/**
 * Save player meta boxes
 * @param $post_id
 */
function respawn_player_save_meta_box_data($post_id ){
    // verify taxonomies meta box nonce
    if ( !isset( $_POST['player_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['player_meta_box_nonce'], basename( __FILE__ ) ) ){
        return;
    }
    // return if autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
    }
    // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ){
        return;
    }

    if ( isset( $_REQUEST['name'] ) ) {
        update_post_meta( $post_id, '_player_name', sanitize_text_field( $_POST['name'] ) );
    }

    if ( isset( $_REQUEST['player_team'] ) ) {
        update_post_meta( $post_id, '_player_team', sanitize_text_field( $_POST['player_team'] ) );
    }

    if ( isset( $_REQUEST['facebook'] ) ) {
        update_post_meta( $post_id, '_player_facebook', sanitize_text_field( $_POST['facebook'] ) );
    }
    if ( isset( $_REQUEST['twitter'] ) ) {
        update_post_meta( $post_id, '_player_twitter', sanitize_text_field( $_POST['twitter'] ) );
    }
    if ( isset( $_REQUEST['youtube'] ) ) {
        update_post_meta( $post_id, '_player_youtube', sanitize_text_field( $_POST['youtube'] ) );
    }
    if ( isset( $_REQUEST['instagram'] ) ) {
        update_post_meta( $post_id, '_player_instagram', sanitize_text_field( $_POST['instagram'] ) );
    }
    if ( isset( $_REQUEST['steam'] ) ) {
        update_post_meta( $post_id, '_player_steam', sanitize_text_field( $_POST['steam'] ) );
    }
    if ( isset( $_REQUEST['twitch'] ) ) {
        update_post_meta( $post_id, '_player_twitch', sanitize_text_field( $_POST['twitch'] ) );
    }
    if ( isset( $_REQUEST['discord'] ) ) {
        update_post_meta( $post_id, '_player_discord', sanitize_text_field( $_POST['discord'] ) );
    }
    if ( isset( $_REQUEST['description'] ) ) {
        update_post_meta( $post_id, '_player_description', sanitize_text_field( $_POST['description'] ) );
    }

}
add_action( 'save_post_player', 'respawn_player_save_meta_box_data' );



function respawn_player_build_meta_box( $post ){

    // make sure the form request comes from WordPress
    wp_nonce_field( basename( __FILE__ ), 'player_meta_box_nonce' );
    $player_team = get_post_meta( $post->ID, '_player_team', true );

    $name = get_post_meta( $post->ID, '_player_name', true );
    $facebook = get_post_meta( $post->ID, '_player_facebook', true );
    $twitter = get_post_meta( $post->ID, '_player_twitter', true );
    $youtube = get_post_meta( $post->ID, '_player_youtube', true );
    $instagram = get_post_meta( $post->ID, '_player_instagram', true );
    $steam = get_post_meta( $post->ID, '_player_steam', true );
    $twitch = get_post_meta( $post->ID, '_player_twitch', true );
    $discord = get_post_meta( $post->ID, '_player_discord', true );

    $description = get_post_meta( $post->ID, '_player_description', true );


    $args1 = array(
        'posts_per_page'   => -1,
        'post_type'        => 'team',
        'post_status'      => 'publish',
    );
    $timovi = get_posts( $args1 );

    $selected_player = '';
    ?>
    <div class='inside'>
        <h3><?php esc_html_e( 'Player name', 'respawn' ); ?></h3>
        <p>
            <input size="100" type="text" name="name" value="<?php echo esc_attr($name); ?>"  />
        </p>

        <h3><?php esc_html_e( 'Team', 'respawn' ); ?></h3>
        <select name="player_team">
            <?php if($player_team == '0')$selected_player = 'selected'; ?>
            <option <?php echo esc_attr($selected_player);?> value="0"><?php esc_html_e('None', 'respawn'); ?></option>
            <?php foreach($timovi as $team){ ?>
                <?php $selected_player = ''; ?>
                <?php if((int)$player_team == $team->ID)$selected_player = 'selected'; ?>
                <option <?php echo esc_attr($selected_player);?> value="<?php echo esc_attr($team->ID); ?>"><?php echo esc_html($team->post_title); ?></option>
            <?php } ?>
        </select>


        <h3><?php esc_html_e( 'Description', 'respawn' ); ?></h3>
        <p>
            <textarea name="description" rows="4" cols="102"><?php echo esc_attr($description); ?></textarea>
        </p>

        <h3><?php esc_html_e( 'Social', 'respawn' ); ?></h3>
        <h4><?php esc_html_e( 'Facebook', 'respawn' ); ?></h4>
        <p>
            <input size="100" type="text" name="facebook" value="<?php echo esc_attr($facebook); ?>"  />
        </p>

        <h4><?php esc_html_e( 'Twitter', 'respawn' ); ?></h4>
        <p>
            <input size="100" type="text" name="twitter" value="<?php echo esc_attr($twitter); ?>"  />
        </p>

        <h4><?php esc_html_e( 'Youtube', 'respawn' ); ?></h4>
        <p>
            <input size="100" type="text" name="youtube" value="<?php echo esc_attr($youtube); ?>"  />
        </p>

        <h4><?php esc_html_e( 'Instagram', 'respawn' ); ?></h4>
        <p>
            <input size="100" type="text" name="instagram" value="<?php echo esc_attr($instagram); ?>"  />
        </p>

        <h4><?php esc_html_e( 'Steam', 'respawn' ); ?></h4>
        <p>
            <input size="100" type="text" name="steam" value="<?php echo esc_attr($steam); ?>"  />
        </p>

        <h4><?php esc_html_e( 'Twitch', 'respawn' ); ?></h4>
        <p>
            <input size="100" type="text" name="twitch" value="<?php echo esc_attr($twitch); ?>"  />
        </p>

        <h4><?php esc_html_e( 'Discord', 'respawn' ); ?></h4>
        <p>
            <input size="100" type="text" name="discord" value="<?php echo esc_attr($discord); ?>"  />
        </p>
    </div>
    <?php
}


/**
 *
 * Add meta boxes in player page
 *
 */
function respawn_player_add_meta_boxes(){
    add_meta_box( 'player_meta_box', esc_html__( 'Player data', 'respawn' ), 'respawn_player_build_meta_box', 'player', 'normal', 'low' );
}
add_action( 'add_meta_boxes_player', 'respawn_player_add_meta_boxes' );


/**
 * Other matches sort
 * @param $a
 * @param $b
 * @return int
 */
function respawn_other_matches_sort($a, $b){
    $t1 = mysql2date("U", $a->date);
    $t2 = mysql2date("U", $b->date);

    if($t1 == $t2) return 0;

    return $t1 > $t2 ? -1 : 1;
}