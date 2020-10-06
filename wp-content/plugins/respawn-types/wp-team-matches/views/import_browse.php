<div class="wrap wp-team-matches-cloud-page">

    <?php $partial('partials/cloud_nav', compact( 'active_tab', 'cloud_account', 'logged_into_cloud', 'search_query' )); ?>

    <?php if ( isset( $api_error_message ) ) : ?>
    <?php $partial( 'partials/browse_games_error', compact( 'api_error_message' ) ) ?>
    <?php endif; ?>

    <?php if ( empty($api_games) ) : ?>
    <p class="wp-team-matches-api-error"><?php _e( 'No games found.', WP_CLANWARS_TEXTDOMAIN ); ?></p>
    <?php endif; ?>

    <ul class="wp-team-matches-cloud-items wp-team-matches-clearfix" id="wp-team-matches-cloud-items">

    <?php 

    foreach ( $api_games as $game ) : 

        $item_classes = array( 'wp-team-matches-cloud-item' );

        if( $logged_into_cloud && !property_exists($game, 'vote') ) {
            $item_classes[] = 'wp-team-matches-cloud-item-votes-enabled';
        }

        if( $logged_into_cloud && property_exists($game, 'vote') ) {
            $item_classes[] = 'wp-team-matches-cloud-item-voted';
        }

    ?>
    <li class="<?php echo esc_attr(join(' ', $item_classes)) ?>" data-remote-id="<?php echo esc_attr($game->_id); ?>">
        <?php $partial('partials/browse_game_item', compact('game', 'install_action', 'logged_into_cloud')); ?>
    </li>
    <?php endforeach; ?>

    </ul>

</div>