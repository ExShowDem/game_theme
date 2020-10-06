<div class="wrap wp-team-matches-matches">
    <h1 class="wp-heading-inline"><?php _e('Matches', WP_CLANWARS_TEXTDOMAIN); ?></h1>
    <a href="<?php echo admin_url('admin.php?page=wp-team-matches-matches&act=add'); ?>" class="page-title-action"><?php _e('Add New', WP_CLANWARS_TEXTDOMAIN); ?></a>
    <hr class="wp-header-end" />
    <form id="posts-filter" >
        <div class="alignright actions">
            <label class="screen-reader-text" for="matches-search-input"><?php esc_html_e('Search Matches:', 'respawn'); ?></label>
            <input id="matches-search-input" name="s" value="<?php if(isset($search)) echo esc_html($search); ?>" type="text" onkeypress="GoSubmit(event);" />

            <input id="matches-search-submit" value="<?php esc_html_e('Search Matches', 'respawn'); ?>" class="button" type="button" />
            <input name="post_type" class="post_type_matches" value="matches" type="hidden">

        </div>
    </form>
    <form method="post">
    
        <?php $wp_list_table->display(); ?>

    </form>

</div>