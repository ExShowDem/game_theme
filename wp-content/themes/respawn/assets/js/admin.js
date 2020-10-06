let $sw = jQuery.noConflict();
let post_id = settingsAdmin.post_id;

$sw(document).ready(function(){
	"use strict";
    $sw('.catcolorpicker').wpColorPicker();

    $sw('#post-formats-select input').change(show_format);

    $sw("#postbox-container-2 #wpseo_meta").insertAfter($sw("#postbox-container-2 div:last"));


});

function show_format(){
	"use strict";
let format_type = $sw('#post-formats-select input:checked').attr('value');
$sw('#normal-sortables div[id$=-settings]').hide();
$sw('#normal-sortables #'+format_type+'-settings').stop(true,true).fadeIn(500);
}


$sw(window).load(function(){
	"use strict";
	show_format();
})


jQuery(document).ready(function() {
"use strict";
	jQuery(".respawn_ci_upload_image_button").on( "click", function(event) {
	let upload_button = jQuery(this);
	let frame;
		event.preventDefault();
		if (frame) {
			frame.open();
			return;
		}
		frame = wp.media();
		frame.on( "select", function() {
			// Grab the selected attachment.
			let attachment = frame.state().get("selection").first();
			frame.close();
			if (upload_button.parent().prev().children().hasClass("tax_list")) {
				upload_button.parent().prev().children().val(attachment.attributes.url);
				upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
			}
			else
				jQuery("#taxonomy_image").val(attachment.attributes.url);
		});
		frame.open();
});

	jQuery(".respawn_ci_remove_image_button").on( "click", function() {
	"use strict";
	jQuery("#taxonomy_image").val("");
	jQuery(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
	return false;
});

jQuery(document).on("click", '.editinline', function(){
	"use strict";
    let tax_id = jQuery(this).parents("tr").attr("id").substr(4),
    	thumb = jQuery("#tag-"+tax_id+" .thumba img").attr("src");

	if (thumb !== settingsAdmin.bip) {
		jQuery(".inline-edit-col :input[name=\'taxonomy_image\']").val(thumb);
	} else {
		jQuery(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
	}
	jQuery(".inline-edit-col .title img").attr("src",thumb);
	    return false;
});

let redux_logo = jQuery('.display_header h2');
redux_logo.html('<a href="https://skywarriorthemes.com" target="_blank"><img alt="logo" src="https://skywarriorthemes.com/respawn/wp-content/themes/respawn/assets/img/logo-options.png" /></a>');


jQuery('#respawn_redux_home_slider_categories_99999_0').click(function(){
	jQuery("input[id^=respawn_redux_home_slider_categories]").prop('checked', jQuery(this).prop('checked'));

	if(jQuery(this).prop("checked") == true) {
		jQuery("input[name^='respawn_redux[home_slider_categories]']").val('1');
	}else{
		jQuery("input[name^='respawn_redux[home_slider_categories]']").val('0');
	}


	});

});

jQuery(document).ready(function() {
	let columnTab = $sw('.post-type-product .column-thumb');
	columnTab.remove();
});