
<div class="wp-team-matches-cloud-account-holder">

    <?php if($logged_into_cloud) : ?>

    <div class="wp-team-matches-cloud-account">
        <div class="wp-team-matches-cloud-account-username">
            <img src="<?php echo esc_attr($cloud_account->photo); ?>" alt="<?php echo esc_attr($cloud_account->fullname); ?>" />
            <a href="/#TB_inline?width=320&amp;height=400&amp;inlineId=wp-team-matches-cloud-update-account-holder" class="thickbox"><?php echo esc_html($cloud_account->fullname); ?></a>
        </div>
        <div class="wp-team-matches-cloud-account-logout">
            <span>|</span> <a href="<?php echo wp_nonce_url('admin-post.php?action=wp-team-matches-logout&amp;_wp_http_referer=' . urlencode($_SERVER['REQUEST_URI']), 'wp-team-matches-logout'); ?>"><?php _e( 'Log out', WP_CLANWARS_TEXTDOMAIN ); ?></a>
        </div>
    </div>

    <?php $partial('partials/update_account_box', compact('cloud_account')); ?>

    <?php else : ?>

    <div class="wp-team-matches-cloud-account-why-login">
        <a href="/#TB_inline?width=320&amp;height=400&amp;inlineId=wp-team-matches-cloud-login-holder" class="thickbox"><?php _e( 'Log in', WP_CLANWARS_TEXTDOMAIN ); ?></a> |
        <a href="javascript:void(0);" id="wp-team-matches-why-login" title="<?php _e( 'Log in to vote and share games! More stuff will be added later!', WP_CLANWARS_TEXTDOMAIN ); ?>"><?php _e( 'Why should I?', WP_CLANWARS_TEXTDOMAIN ); ?></a>
    </div>

    <?php $partial('partials/login_box'); ?>

    <?php endif; ?>

</div>