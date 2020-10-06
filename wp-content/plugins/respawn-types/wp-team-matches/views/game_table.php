<div class="wrap wp-team-matches-games">
    <h1 class="wp-heading-inline"><?php _e('Games', WP_CLANWARS_TEXTDOMAIN); ?></h1>
    <?php if($show_add_button) : ?>
    <a href="<?php echo admin_url('admin.php?page=wp-team-matches-games&act=add'); ?>" class="page-title-action"><?php _e('Add New', WP_CLANWARS_TEXTDOMAIN); ?></a>
    <?php endif; ?>
    <hr class="wp-header-end" />

    <form method="post">

    <?php $wp_list_table->display(); ?>

    </form>

</div><!-- .wrap -->