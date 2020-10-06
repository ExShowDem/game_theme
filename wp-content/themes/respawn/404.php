<?php get_header(); ?>
	<div class="container">
		<div id="error-404">
			<h1>
                <img alt="<?php esc_attr_e('Nothing found', 'respawn'); ?>" src="<?php echo get_theme_file_uri('assets/img/sad.png'); ?>">
                <?php esc_html_e('404', 'respawn'); ?>
            </h1>
			<h2><?php  esc_html_e('Sorry, Nothing Here.', 'respawn'); ?></h2>
            <p><?php  esc_html_e('It looks like nothing was found at this location. Try using the search box below:', 'respawn'); ?></p>
            <form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchw404">
                <input id="s" name="s" type="text" placeholder="<?php esc_html_e('Search...', 'respawn'); ?>" autocomplete="off" autocapitalize="off" spellcheck="false" >
                <button class="btn"><?php esc_html_e('Search', 'respawn'); ?></button>
            </form>
		</div>
	</div>
<?php get_footer(); ?>