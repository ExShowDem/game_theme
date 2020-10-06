<?php

define('respawn_IMAGE_PLACEHOLDER', get_theme_file_uri('assets/img/defaults/default.jpg'));

function respawn_cat_images_init() {
	$respawn_ci_taxonomies = get_taxonomies();
	if (is_array($respawn_ci_taxonomies)) {
		$respawn_ci_options = get_option('respawn_ci_options');
		if (empty($respawn_ci_options['excluded_taxonomies']))
			$respawn_ci_options['excluded_taxonomies'] = array();

	    foreach ($respawn_ci_taxonomies as $respawn_ci_taxonomy) {
			if (in_array($respawn_ci_taxonomy, $respawn_ci_options['excluded_taxonomies']))
				continue;
	        add_action($respawn_ci_taxonomy.'_add_form_fields', 'respawn_ci_add_texonomy_field');
			add_action($respawn_ci_taxonomy.'_edit_form_fields', 'respawn_ci_edit_texonomy_field');
			add_filter( 'manage_edit-' . $respawn_ci_taxonomy . '_columns', 'respawn_ci_taxonomy_columns' );
			add_filter( 'manage_' . $respawn_ci_taxonomy . '_custom_column', 'respawn_ci_taxonomy_column', 10, 3 );
	    }
	}
}

// add image field in add form
function respawn_ci_add_texonomy_field() {
	wp_enqueue_media();

	echo '<div class="form-field">
		<label for="taxonomy_image">' . esc_html__('Image', 'respawn') . '</label>
		<input type="text" name="taxonomy_image" id="taxonomy_image" value="" />
		<br/>
		<button class="respawn_ci_upload_image_button button">' . esc_html__('Upload/Add image', 'respawn') . '</button>
	</div>';
}

// add image field in edit form
function respawn_ci_edit_texonomy_field($taxonomy) {
	wp_enqueue_media();


	if (respawn_ci_taxonomy_image_url( $taxonomy->term_id, NULL, TRUE ) == respawn_IMAGE_PLACEHOLDER)
		$image_text = "";
	else
		$image_text = respawn_ci_taxonomy_image_url( $taxonomy->term_id, NULL, TRUE );
	echo '<tr class="form-field">
		<th scope="row" valign="top"><label for="taxonomy_image">' . esc_html__('Image', 'respawn') . '</label></th>
		<td><img alt="' . esc_attr__('Thumbnail', 'respawn') . '"  class="taxonomy-image" src="' . respawn_ci_taxonomy_image_url( $taxonomy->term_id, NULL, TRUE ) . '"/><br/><input type="text" name="taxonomy_image" id="taxonomy_image" value="'.esc_attr($image_text).'" /><br />
		<button class="respawn_ci_upload_image_button button">' . esc_html__('Upload/Add image', 'respawn') . '</button>
		<button class="respawn_ci_remove_image_button button">' . esc_html__('Remove image', 'respawn') . '</button>
		</td>
	</tr>';
}


function respawn_ci_save_taxonomy_image($term_id) {
    if(isset($_POST['taxonomy_image']))
        update_option('z_taxonomy_image'.$term_id, $_POST['taxonomy_image']);
}

// get attachment ID by image url
function respawn_ci_get_attachment_id_by_url($image_src) {
    global $wpdb;
    $pst = $wpdb->posts;
    $query = $wpdb->get_results($wpdb->prepare("SELECT ID FROM {$pst} WHERE guid = '%s'", $image_src));
    $id = $wpdb->get_var($query);
    return (!empty($id)) ? $id : NULL;
}

// get taxonomy image url for the given term_id (Place holder image by default)
function respawn_ci_taxonomy_image_url($term_id = NULL, $size = NULL, $return_placeholder = FALSE) {
	if (!$term_id) {
		if (is_category())
			$term_id = get_query_var('cat');
		elseif (is_tax()) {
			$current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$term_id = $current_term->term_id;
		}
	}

    $taxonomy_image_url = get_option('z_taxonomy_image'.$term_id);
    if(!empty($taxonomy_image_url)) {
	    $attachment_id = respawn_ci_get_attachment_id_by_url($taxonomy_image_url);
	    if(!empty($attachment_id)) {
	    	if (empty($size))
	    		$size = 'full';
	    	$taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
		    $taxonomy_image_url = $taxonomy_image_url[0];
	    }
	}

    if ($return_placeholder)
		return ($taxonomy_image_url != '') ? $taxonomy_image_url : respawn_IMAGE_PLACEHOLDER;
	else
		return $taxonomy_image_url;
}

function respawn_ci_quick_edit_custom_box($column_name, $screen, $name) {
	if ($column_name == 'thumba')
		echo '<fieldset>
		<div class="thumb inline-edit-col">
			<label>
				<span class="title"><img src="'.respawn_IMAGE_PLACEHOLDER.'" alt="' . esc_attr__('Thumbnail', 'respawn') . '"/></span>
				<span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span>
				<span class="input-text-wrap">
					<button class="respawn_ci_upload_image_button button">' . esc_html__('Upload/Add image', 'respawn') . '</button>
					<button class="respawn_ci_remove_image_button button">' . esc_html__('Remove image', 'respawn') . '</button>
				</span>
			</label>
		</div>
	</fieldset>';
}

/**
 * Thumbnail column added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function respawn_ci_taxonomy_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumba'] = esc_html__('Image', 'respawn');

	unset( $columns['cb'] );

	return array_merge( $new_columns, $columns );
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function respawn_ci_taxonomy_column( $columns, $column, $id ) {

	if ( $column == 'thumba' ){
		$columns = '<span><img src="' . respawn_ci_taxonomy_image_url($id, NULL, TRUE) . '" alt="' . esc_attr__('Thumbnail', 'respawn') . '" class="wp-post-image" /></span>';
     }
	return $columns;
}

// Register plugin settings
function respawn_ci_register_settings() {
	register_setting('respawn_ci_options', 'respawn_ci_options', 'respawn_ci_options_validate');
	add_settings_section('respawn_ci_settings', esc_html__('Categories Images settings', 'respawn'), 'respawn_section_text', 'respawn-ci-options');
	add_settings_field('respawn_ci_excluded_taxonomies', esc_html__('Excluded Taxonomies', 'respawn'), 'respawn_ci_excluded_taxonomies', 'respawn-ci-options', 'respawn_ci_settings');
}

// Settings section description
function respawn_section_text() {
	echo '<p>'.esc_html__('Please select the taxonomies you want to exclude from Categories Images', 'respawn').'</p>';
}

// Excluded taxonomies checkboxs
function respawn_ci_excluded_taxonomies() {
	$options = get_option('respawn_ci_options');
    $all = get_taxonomies();
    $taxes = array();
    foreach ($all as $single) {
        if($single != 'multimedia-category' or $single != 'multimedia-category-video')
          $taxes[$single] = $single;
    }
    update_option( 'respawn_ci_options', array(
            'excluded_taxonomies' => $taxes
        ) );

	$disabled_taxonomies = array('nav_menu', 'link_category', 'post_format');
	foreach (get_taxonomies() as $tax) : if (in_array($tax, $disabled_taxonomies)) continue; ?>
		<input type="checkbox" name="respawn_ci_options[excluded_taxonomies][<?php echo esc_attr($tax); ?>]" value="<?php echo esc_attr($tax); ?>" <?php checked(isset($options['excluded_taxonomies'][$tax])); ?> /> <?php echo esc_attr($tax); ?><br />
	<?php endforeach;
}

// Validating options
function respawn_ci_options_validate($input) {
	return $input;
}

// option page
function respawn_ci_options() {
	if (!current_user_can('manage_options'))
		wp_die(esc_html__( 'You do not have sufficient permissions to access this page.', 'respawn'));
		$options = get_option('respawn_ci_options');
	?>
	<div class="wrap">

		<h2><?php esc_html_e('Categories Images', 'respawn'); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields('respawn_ci_options'); ?>
			<?php do_settings_sections('respawn-ci-options'); ?>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}