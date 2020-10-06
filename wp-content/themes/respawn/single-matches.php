<?php get_header();?>
<?php

$match_id = $post->ID;
$respawn_match = \WP_TeamMatches\Matches::get_match(array('id' =>  $match_id, 'sum_tickets' => true));

$team1 = new stdClass;
$team1->ID = $respawn_match->team1;
$team2 = new stdClass;
$team2->ID = $respawn_match->team2;

$datum = get_post_meta($match_id, 'date_unix', true);
$datum = date_i18n(get_option('date_format') . ', ' . get_option('time_format'), $datum);

$match_status = $respawn_match->status;

$t1 = $respawn_match->team1_tickets;
$t2 = $respawn_match->team2_tickets;

$args1 = array(
    'post_type' => 'player',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key'     => '_player_team',
            'value'   => $team1->ID,
            'compare' => '=',
        ),
    ),
);
$igraci_team1 = get_posts($args1);
wp_reset_postdata();

$args2 = array(
    'post_type' => 'player',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key'     => '_player_team',
            'value'   => $team2->ID,
            'compare' => '=',
        ),
    ),
);
$igraci_team2 = get_posts($args2);
wp_reset_postdata();

$options = respawn_get_theme_options();

if(has_post_thumbnail($match_id)) {
    $bck_img = get_the_post_thumbnail_url($match_id);
}else{
    $bck_img = $options['match_header_bg']['url'];
}

?>
    <div class="match-header">
        <h6 data-nick="<?php the_title_attribute(); ?>"><?php the_title(); ?></h6>
        <img alt="<?php esc_attr_e('match_bck', 'respawn'); ?>" src="<?php echo esc_url($bck_img); ?>" />
        <div class="container">

            <div class="col-4">
                <a href="<?php echo get_the_permalink($team1->ID); ?>">
                    <?php
                    if(has_post_thumbnail($team1->ID)) {
                        $team1_img = get_the_post_thumbnail_url($team1->ID);
                    }else{
                        $team1_img = get_theme_file_uri('assets/img/defaults/defteam.png');
                    }
                    ?>
                    <img alt="<?php esc_attr_e('team1_img', 'respawn'); ?>" src="<?php echo esc_url($team1_img); ?>" />
                    <h3><?php echo get_the_title($team1->ID); ?></h3>
                </a>
                <div class="mtmembers">
                    <?php foreach($igraci_team1 as $igrac1){ ?>
                        <a  href="<?php the_permalink($igrac1->ID); ?>"><img title-tip="<?php echo get_the_title($igrac1->ID); ?>"  alt="player_img" src="<?php echo respawn_return_player_image_fn($igrac1->ID, 100, 100); ?>" /></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-4 ">

                <?php $game_img = respawn_return_game_image_nocrop($respawn_match->game_id); ?>
                <?php if(isset($game_img) && !empty($game_img)){ ?>
                    <img alt="<?php esc_attr_e('game_img', 'respawn'); ?>" src="<?php echo esc_url($game_img); ?>" />
                <?php } ?>

                <h1><?php the_title(); ?></h1>
                <div class="mscore"><?php echo esc_html($t1); ?> <span><?php esc_html_e('vs','respawn'); ?></span> <?php echo esc_html($t2); ?></div>
                <span class="mtime"><?php echo esc_html($datum); ?></span>
            </div>
            <div class="col-4">
                <a href="<?php echo get_the_permalink($team2->ID); ?>">
                    <?php
                    if(has_post_thumbnail($team2->ID)) {
                        $team2_img = get_the_post_thumbnail_url($team2->ID);
                    }else{
                        $team2_img = get_theme_file_uri('assets/img/defaults/defteam.png');
                    }
                    ?>
                    <img alt="<?php esc_attr_e('team1_img', 'respawn'); ?>" src="<?php echo esc_url($team2_img); ?>" />
                    <h3><?php echo get_the_title($team2->ID); ?></h3>
                </a>
                <div class="mtmembers">
                    <?php foreach($igraci_team2 as $igrac2){ ?>
                        <a href="<?php the_permalink($igrac2->ID); ?>"><img title-tip="<?php echo get_the_title($igrac2->ID); ?>"  alt="<?php esc_attr_e('player_img', 'respawn'); ?>" src="<?php echo respawn_return_player_image_fn($igrac2->ID, 100, 100); ?>" /></a>
                    <?php } ?>
                </div>
            </div>


        </div>
    </div>

    <div class="mcontent">
        <div class="col-6">
            <?php the_content(); ?>
        </div>

        <?php
        $r = \WP_TeamMatches\Rounds::get_rounds($match_id);

        $rounds = array();

        // group rounds by map
        foreach($r as $v) {
            if(!isset($rounds[$v->group_n]))
                $rounds[$v->group_n] = array();
            $rounds[$v->group_n][] = $v;
        }
        ?>

        <div class="col-6 msidebar" >
            <section class="widget">
                <?php
                $winner = $respawn_match->winner;
                $status = get_post_meta($respawn_match->ID, 'status', true);

                if(has_post_thumbnail($winner)) {
                    $winner_img = get_the_post_thumbnail_url($winner);
                }else{
                    $winner_img = get_theme_file_uri('assets/img/defaults/defteam.png');
                }
                ?>

                <?php if($status == 'done'){ ?>
                    <img alt="<?php esc_attr_e('img', 'respawn'); ?>" src="<?php echo esc_url($winner_img); ?>" />
                <?php } ?>

                <h4><?php esc_html_e('match', 'respawn'); ?> <span><?php esc_html_e('statistics', 'respawn'); ?></span></h4>
                <ul class="matchstats">
                    <?php
                    $winner = $respawn_match->winner;
                    if(isset($winner) && !empty($winner) && $winner > 0){   ?>
                        <li>
                            <img alt="<?php esc_attr_e('winner_img', 'respawn'); ?>" src="<?php echo esc_url($winner_img); ?>" />
                            <span><?php esc_html_e('winner', 'respawn'); ?></span>
                        </li>
                    <?php }else{ ?>
                        <li>
                            <h3>-</h3>
                            <span><?php esc_html_e('winner', 'respawn'); ?></span>
                        </li>
                    <?php } ?>

                    <?php
                    $kills = $respawn_match->kills;
                    if(isset($kills) && !empty($kills) && $kills > 0){ ?>
                        <li>
                            <h3><?php echo esc_html($kills); ?></h3>
                            <span><?php esc_html_e('kills', 'respawn'); ?></span>
                        </li>
                    <?php }else{ ?>
                        <li>
                            <h3>-</h3>
                            <span><?php esc_html_e('kills', 'respawn'); ?></span>
                        </li>
                    <?php } ?>

                    <li>
                        <h3><?php echo count($rounds); ?></h3>
                        <span><?php esc_html_e('maps', 'respawn'); ?></span>
                    </li>
                    <li>
                        <h3><?php echo count($r); ?></h3>
                        <span><?php esc_html_e('rounds', 'respawn'); ?></span>
                    </li>
                    <?php
                    $duration = $respawn_match->duration;
                    if(isset($duration) && !empty($duration) && $duration > 0){ ?>
                        <li>
                            <h3><?php echo esc_html($duration); ?><i><?php esc_html_e('min','respawn'); ?></i></h3>
                            <span><?php esc_html_e('duration', 'respawn'); ?></span>
                        </li>
                    <?php }else{ ?>
                        <li>
                            <h3>-<i><?php esc_html_e('min','respawn'); ?></i></h3>
                            <span><?php esc_html_e('duration', 'respawn'); ?></span>
                        </li>
                    <?php } ?>
                </ul>
            </section>

            <section class="widget">
                <h4><?php esc_html_e('match', 'respawn'); ?> <span><?php esc_html_e('maps', 'respawn'); ?></span></h4>
                <ul class="mmaps">
                    <?php

                    // render maps/rounds
                    foreach($rounds as $map_group) {

                        $first = $map_group[0];
                        $image = wp_get_attachment_image_src($first->screenshot, $size = 'full' );
                        if(!isset($image[0]) or empty($image[0]))$image[0] = get_theme_file_uri('assets/img/defaults/mapdef.jpg');
                        ?>
                        <li>
                            <img alt="<?php esc_attr_e('map_img', 'respawn'); ?>" src="<?php echo esc_url($image[0]); ?>" />
                            <h3><?php echo esc_html($first->title); ?></h3>
                            <div class="mapscore">
                                <?php
                                $map_group = array_reverse ($map_group);
                                foreach($map_group as $round) {
                                    $t1 = $round->tickets1;
                                    $t2 = $round->tickets2;
                                    ?>


                                    <?php if($match_status == 'done'){ ?>

                                        <span><?php echo sprintf(esc_html__('%1$d:%2$d', 'respawn'), $t1, $t2); ?></span>

                                    <?php }else{ ?>

                                        <span><?php if(isset($admin) && $admin){ echo sprintf(esc_html__('%1$d:%2$d', 'respawn'), $t1, $t2);  }else{ echo '0:0';  } ?></span>

                                    <?php } ?>


                                <?php } ?>
                            </div> <!-- mscore -->
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </section>

        </div>
        <div class="clear"></div>
    </div>
<?php
$datum = get_post_meta($match_id, 'date_unix', true);

$args_prev = [
    'post_type' => 'matches',
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'orderby' => 'date_unix',
    'meta_key' => 'date_unix',
    'order' => 'desc',
    'meta_query' => [
        [
            'key'     => 'date_unix',
            'value'   => $datum,
            'compare' => '<',
            'type'    => 'NUMERIC'
        ],
    ],
];

$posts_prev = get_posts($args_prev);


$args_next = [
    'post_type' => 'matches',
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'orderby' => 'date_unix',
    'meta_key' => 'date_unix',
    'order' => 'asc',
    'meta_query' => [
        [
            'key'     => 'date_unix',
            'value'   => $datum,
            'compare' => '>',
            'type'    => 'NUMERIC'
        ],
    ],
];

$posts_next = get_posts($args_next);

$single_class = '';
if(count($posts_next) == 0 or count($posts_prev) == 0)
    $single_class = 'single_match_nav';
?>

<div class="playerpag <?php echo esc_attr($single_class); ?>">

<?php
if(count($posts_prev) == 1){

if(has_post_thumbnail($posts_prev[0]->ID)) {
    $bck_img = get_the_post_thumbnail_url($posts_prev[0]->ID);
}else{
    $bck_img = $options['match_header_bg']['url'];
}
?>
        <div class="col-6 prevmember" data-nick="WidowMaker">
            <img alt="<?php esc_attr_e('match_img', 'respawn'); ?>" src="<?php echo esc_url($bck_img); ?>">
            <div class="meminfo">
                <h3><?php esc_html_e('prev match', 'respawn'); ?></h3>
                <h2><?php echo get_the_title($posts_prev[0]->ID); ?></h2>
                <a href="<?php echo get_the_permalink($posts_prev[0]->ID); ?>" class="btn"><?php esc_html_e('View match', 'respawn'); ?></a>
                <div class="clear"></div>
            </div>
        </div>
<?php }

if(count($posts_next) == 1){

if(has_post_thumbnail($posts_next[0]->ID)) {
    $bck_img = get_the_post_thumbnail_url($posts_next[0]->ID);
}else{
    $bck_img = $options['match_header_bg']['url'];
}
?>
        <div class="col-6 nextmember" data-nick="WidowMaker">
            <div class="meminfo">
                <h3><?php esc_html_e('next match', 'respawn'); ?></h3>
                <h2><?php echo get_the_title($posts_next[0]->ID); ?></h2>
                <a href="<?php echo get_the_permalink($posts_next[0]->ID); ?>" class="btn"><?php esc_html_e('View match', 'respawn'); ?></a>
            </div>
            <img alt="<?php esc_attr_e('match_img', 'respawn'); ?>" src="<?php echo esc_url($bck_img); ?>">
            <div class="clear"></div>
        </div>
<?php } ?>

</div>

<?php get_footer(); ?>