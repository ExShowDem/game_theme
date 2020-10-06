<script type="text/javascript">
jQuery(document).ready(function ($) {
    // add maps
    var maps_payload = <?php echo json_encode($scores); ?>;
    $.each(maps_payload, function (i, item) {
        var match = wpMatchManager.addMap(item.map_id);
        var len = item.team1.length;
        $.each(item.team1, function (j) {
            match.addRound(item.team1[j], item.team2[j], item.round_id[j]);
        });
    });

    // add gallery
    var gallery = <?php echo json_encode($gallery); ?>;
    if(gallery.ids) {
        var ids = gallery.ids.split(',');
        $.each(ids, function (i, id) {
            wpGalleryManager.add(id, gallery.src[i]);
        });
    }
});
</script>

<div class="wrap wp-team-matches-matcheditor">

    <h2><?php echo esc_html($page_title); ?>

    <?php $post_id = $_GET['id']; ?>

    <?php if($post_id) : ?>
    <ul class="linkbar">
        <li class="edit-post"><a href="<?php echo esc_attr(admin_url('post.php?post=' . $post_id . '&action=edit')); ?>" target="_blank"><?php esc_html_e('Edit post', WP_CLANWARS_TEXTDOMAIN); ?></a></li>
        <li class="view-post"><a href="<?php echo esc_attr(get_permalink($post_id)); ?>" target="_blank"><?php esc_html_e('View post', WP_CLANWARS_TEXTDOMAIN); ?></a></li>
        <li class="post-comments"><a href="<?php echo get_comments_link($post_id); ?>" target="_blank"><?php printf( _n( '%d Comment', '%d Comments', $num_comments, WP_CLANWARS_TEXTDOMAIN), $num_comments ); ?></a></li>
    </ul>
    <?php endif; ?>

    </h2>

    <form name="match-editor" id="match-editor" method="post" action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">

        <input type="hidden" name="action" value="<?php echo esc_attr($page_action); ?>" />
        <input type="hidden" name="id" value="<?php echo esc_attr($id); ?>" />

        <?php wp_nonce_field($page_action); ?>

        <table class="form-table">

        <tr class="form-field form-required">
            <th scope="row" valign="top"><label for="game_id"><?php _e('Game', WP_CLANWARS_TEXTDOMAIN); ?></label></th>
            <td>
                <select id="game_id" class="select2" name="game_id">
                    <?php foreach($games as $item) : ?>
                    <option value="<?php echo esc_attr($item->id); ?>"<?php selected($item->id, $game_id); ?>><?php echo esc_html($item->title); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr class="form-field form-required">
            <th scope="row" valign="top"><label for="title"><?php esc_html_e('Title', WP_CLANWARS_TEXTDOMAIN); ?></label></th>
            <td>
                <input name="title" id="title" type="text" value="<?php echo esc_attr($title); ?>" placeholder="<?php esc_html_e('For example: ESL Winter League', WP_CLANWARS_TEXTDOMAIN); ?>" maxlength="200" autocomplete="off" aria-required="true" />
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top"><label for="description"><?php esc_html_e('Description', WP_CLANWARS_TEXTDOMAIN); ?></label></th>
            <td>
                <?php esc_html_e('Click', 'respawn');?> <a href="<?php echo esc_url(admin_url( ).'post.php?post='.$post_id.'&action=edit'); ?>"><?php esc_html_e('here', 'respawn'); ?></a> <?php esc_html_e('to add a description', 'respawn'); ?>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top"><label for="external_url"><?php esc_html_e('External URL', WP_CLANWARS_TEXTDOMAIN); ?></label></th>
            <td>
                <input type="text" name="external_url" id="external_url" value="<?php echo esc_attr($external_url); ?>" />

                <p class="description"><?php esc_html_e('Enter league or external match URL.', WP_CLANWARS_TEXTDOMAIN); ?></p>
            </td>
        </tr>


        <tr class="form-required">
            <th scope="row" valign="top"><label for=""><?php esc_html_e('Date', WP_CLANWARS_TEXTDOMAIN); ?></label></th>
            <td>
                <?php $html_date_helper('date', $date, 0, 'select2'); ?>
            </td>
        </tr>

        <tr class="form-required">
            <th scope="row" valign="top"></th>
            <td>
                <div class="match-results" id="matchsite">

                    <div class="teams">
                    <select name="team1" class="select2 team-select">
                    <?php foreach($teams as $team) : ?>
                        <option value="<?php echo $team->id; ?>"<?php selected(true, $team1 > 0 ? ($team->id == $team1) : $team->home_team, true); ?>><?php echo esc_html($team->title); ?></option>
                    <?php endforeach; ?>
                    </select>&nbsp;<?php esc_html_e('vs', WP_CLANWARS_TEXTDOMAIN); ?>&nbsp;<select name="team2" class="select2 team-select">
                    <?php foreach($teams as $team) : ?>
                        <option value="<?php echo $team->id; ?>"<?php selected(true, $team->id==$team2, true); ?>><?php echo esc_html($team->title); ?></option>
                    <?php endforeach; ?>
                    </select>
                    </div>

                    <div class="team2-inline">
                        <p><label for="new_team_title"><?php esc_html_e('or type in the name of the opponent team and it will be automatically created:', WP_CLANWARS_TEXTDOMAIN); ?></label></p>
                        <p class="wp-team-matches-clearfix">
                        <input name="new_team_title" id="new_team_title" type="text" value="" placeholder="<?php esc_html_e('New Team', WP_CLANWARS_TEXTDOMAIN); ?>" maxlength="200" autocomplete="off" aria-required="true" />
                        <?php $html_country_select_helper('name=new_team_country&show_popular=1&id=country&class=select2'); ?>
                        </p>
                    </div>
                    <div id="mapsite"></div>
                    <div class="add-map" id="wp-team-matches-addmap">
                        <button class="button button-secondary"><span class="dashicons dashicons-plus"></span> <?php esc_html_e('Add map', WP_CLANWARS_TEXTDOMAIN); ?></button>
                    </div>

                </div>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top"><label for="winner"><?php esc_html_e('Choose winner', 'gutengame'); ?></label></th>
            <td>

                <select name="winner" class="winner">
                    <option value="0"<?php selected(true, 0==$winner, true); ?>><?php esc_html_e('None', 'gutengame'); ?></option>
                    <?php

                    foreach($winner_candidates as $key=>$t) :
                        ?>
                        <option value="<?php echo esc_attr($key); ?>"<?php selected(true, $key==$winner, true); ?>><?php echo esc_attr($t); ?></option>
                    <?php endforeach; ?>
                </select>

                <p class="description"><?php esc_html_e('Choose match winner.', 'gutengame'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top"><label for="kills"><?php esc_html_e('Kills', 'gutengame'); ?></label></th>
            <td>
                <input type="text" name="kills" id="kills" value="<?php echo esc_attr($kills); ?>" />

                <p class="description"><?php esc_html_e('Add number of kills.', 'gutengame'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top"><label for="duration"><?php esc_html_e('Match duration', 'gutengame'); ?></label></th>
            <td>
                <input type="text" name="duration" id="duration" value="<?php echo esc_attr($duration); ?>" />

                <p class="description"><?php esc_html_e('Add match duration.', 'gutengame'); ?></p>
            </td>
        </tr>

        </table>

        <p class="submit"><input type="submit" class="button button-primary" id="wp-team-matches-submit" name="submit" value="<?php echo esc_attr($page_submit); ?>" /></p>

    </form>

</div><!-- .wrap -->