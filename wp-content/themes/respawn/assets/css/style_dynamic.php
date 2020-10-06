<?php
global $respawn_custombck;
$options = respawn_get_theme_options();

/*footer repeat options*/
$footer_repeat_style = '';
if(!isset($options['top_footer_area_image_repeat']) or empty($options['top_footer_area_image_repeat']))$options['top_footer_area_image_repeat'] = 'cover';
if($options['top_footer_area_image_repeat'] == 'repeat'){
    $footer_repeat_style = 'background-position: center';
}elseif($options['top_footer_area_image_repeat'] == 'norepeat'){
    $footer_repeat_style = 'background-repeat: no-repeat';
}elseif($options['top_footer_area_image_repeat'] == 'cover'){
    $footer_repeat_style = 'background-size: cover';
}


$body_font_family = '';
if(isset($options['body_font_family']['font-family']) or !empty($options['body_font_family']['font-family'])) $body_font_family = $options['body_font_family']['font-family'];

$body_font_family_color = '#f7f7f7';
if(isset($options['body_font_family']['color']) or !empty($options['body_font_family']['color'])) $body_font_family_color = $options['body_font_family']['color'];

if(!isset($options['header-general-settings-padding-top']) or empty($options['header-general-settings-padding-top']))$options['header-general-settings-padding-top'] = 100;
$header_top_padding = '';
if(isset($options['header-general-settings-padding-top']) or !empty($options['header-general-settings-padding-top'])) $header_top_padding = $options['header-general-settings-padding-top'];

if(!isset($options['header-general-settings-padding-bottom']) or empty($options['header-general-settings-padding-bottom']))$options['header-general-settings-padding-bottom'] = 100;
$header_bottom_padding = '';
if(isset($options['header-general-settings-padding-bottom']) or !empty($options['header-general-settings-padding-bottom'])) $header_bottom_padding = $options['header-general-settings-padding-bottom'];


if(!isset($options['body_background']['url']) or empty($options['body_background']['url']))$options['body_background']['url'] = '';
$body_background = '';
if(isset($options['body_background']['url']) or !empty($options['body_background']['url'])) $body_background = $options['body_background']['url'];

if(!isset($options['menu-color-hover']) or empty($options['menu-color-hover']))$options['menu-color-hover'] = '#eeeeee';
$menu_hover_color = '';
if(isset($options['menu-color-hover']) or !empty($options['menu-color-hover'])) $menu_hover_color = $options['menu-color-hover'];

if(!isset($options['menu_font_family']['color']) or empty($options['menu_font_family']['color']))$options['menu_font_family']['color'] = '#ffffff';
$menu_font_color = '';
if(isset($options['menu_font_family']['color']) or !empty($options['menu_font_family']['color'])) $menu_font_color = $options['menu_font_family']['color'];

if(!isset($options['header-settings-color-position-font']) or empty($options['header-settings-color-position-font']))$options['header-settings-color-position-font'] = '#ffffff';
$header_color_position_font = '';
if(isset($options['header-settings-color-position-font']) or !empty($options['header-settings-color-position-font'])) $header_color_position_font = $options['header-settings-color-position-font'];

if(!isset($options['general-settings-color-selector']) or empty($options['general-settings-color-selector']))$options['general-settings-color-selector'] = '#696bff';
$general_color = '';
if(isset($options['general-settings-color-selector']) or !empty($options['general-settings-color-selector'])) $general_color = $options['general-settings-color-selector'];

if(!isset($options['general-settings-secondary-color']) or empty($options['general-settings-secondary-color']))$options['general-settings-secondary-color'] = '#8442fd';
$general_color_secondary = '';
if(isset($options['general-settings-secondary-color']) or !empty($options['general-settings-secondary-color'])) $general_color_secondary = $options['general-settings-secondary-color'];



if(!isset($options['page_heading_font_family']['color']))$options['page_heading_font_family']['color'] = '';
$heading_font_color = '';
if(isset($options['page_heading_font_family']['color']) or !empty($options['page_heading_font_family']['color'])) $heading_font_color = $options['page_heading_font_family']['color'];

if(!isset($options['anchor_font_family']['color']) or empty($options['anchor_font_family']['color']))$options['anchor_font_family']['color'] = '#696bff';
$anchor_color = '';
if(isset($options['anchor_font_family']['color']) or !empty($options['anchor_font_family']['color'])) $anchor_color = $options['anchor_font_family']['color'];


if(!isset($options['header-general-settings-size']) or empty($options['header-general-settings-size']))$options['header-general-settings-size'] = 80;
$header_general_size = 80;
if(isset($options['header-general-settings-size']) or !empty($options['header-general-settings-size'])) $header_general_size = $options['header-general-settings-size'];

if(!isset($options['anchor_hover_font_family']['color']) or empty($options['anchor_hover_font_family']['color']))$options['anchor_hover_font_family']['color'] = '#f2f2f2';
$anchor_hover_color = '';
if(isset($options['anchor_hover_font_family']['color']) or !empty($options['anchor_hover_font_family']['color'])) $anchor_hover_color = $options['anchor_hover_font_family']['color'];

if(!isset($options['top_footer_area_image']['url']) or empty($options['top_footer_area_image']['url']))$options['top_footer_area_image']['url'] = '';
$top_footer_area_image = '';
if(isset($options['top_footer_area_image']['url']) or !empty($options['top_footer_area_image']['url'])) $top_footer_area_image = $options['top_footer_area_image']['url'];

if(!isset($options['top_footer_area_top_padding']) or empty($options['top_footer_area_top_padding']))$options['top_footer_area_top_padding'] = 70;
$top_footer_area_top_padding = '';
if(isset($options['top_footer_area_top_padding']) or !empty($options['top_footer_area_top_padding'])) $top_footer_area_top_padding = $options['top_footer_area_top_padding'];

if(!isset($options['top_footer_area_bottom_padding']) or empty($options['top_footer_area_bottom_padding']))$options['top_footer_area_bottom_padding'] = 70;
$top_footer_area_bottom_padding = '';
if(isset($options['top_footer_area_bottom_padding']) or !empty($options['top_footer_area_bottom_padding'])) $top_footer_area_bottom_padding = $options['top_footer_area_bottom_padding'];

if(!isset($options['general-widget-background-color']) or empty($options['general-widget-background-color']))$options['general-widget-background-color'] = '#1f1f22';
$general_widget_background_color = '';
if(isset($options['general-widget-background-color']) or !empty($options['general-widget-background-color'])) $general_widget_background_color = $options['general-widget-background-color'];

if(!isset($options['general-widget-header-color']) or empty($options['general-widget-header-color']))$options['general-widget-header-color'] = '#171719';
$general_widget_header_color = '';
if(isset($options['general-widget-header-color']) or !empty($options['general-widget-header-color'])) $general_widget_header_color = $options['general-widget-header-color'];

$gradient_from = '';
$gradient_to = '';
$gradient_type_main = 'linear';
$gradient_type1 = 'left,';
$gradient_type2 = 'to right,';
$gradient_type3 = 'right,';
$gradient_percent = '100';
$grad_background_from = '';

if(!isset($options['header-settings-background-color-selector']) or empty($options['header-settings-background-color-selector']))$options['header-settings-background-color-selector'] = 'color';
if(!isset($options['header-background-gradient-type']) or empty($options['header-background-gradient-type']))$options['header-background-gradient-type'] = 'vertical';

if($options['header-settings-background-color-selector'] == 'gradient'){
    if(isset($options['header-settings-background-color-gradient']['from']))
    $gradient_from =  $options['header-settings-background-color-gradient']['from'];

    if(isset($options['header-settings-background-color-gradient']['to']))
    $gradient_to =  $options['header-settings-background-color-gradient']['to'];

    if($options['header-background-gradient-type'] == 'horizontal'){
        $gradient_type1 = 'left,'; $gradient_type2 = 'to right,'; $gradient_type3 = 'right,';
    }

     if($options['header-background-gradient-type'] == 'radial'){
        $gradient_type_main = 'radial'; $gradient_percent = '70';
    }

     if($options['header-background-gradient-type'] == 'diagonal'){
        $gradient_type1 = 'left top,'; $gradient_type2 = 'to bottom right,'; $gradient_type3 = 'bottom right,';
    }
}


$gradient_body_from = '';
$gradient_body_to = '';
$gradient_body_type1 = '';
$gradient_body_type2 = '';
$gradient_body_type3 = '';


if(!isset($options['general-settings-background-color-selector-option']) or empty($options['general-settings-background-color-selector-option']))$options['general-settings-background-color-selector-option'] = 'color';
if($options['general-settings-background-color-selector-option'] == 'gradient'){
    if(isset($options['body-background-color-gradient']['from']))
    $gradient_body_from =  $options['body-background-color-gradient']['from'];

    if(isset($options['body-background-color-gradient']['to']))
    $gradient_body_to =  $options['body-background-color-gradient']['to'];

    if($options['body-background-color-gradient-type'] == 'horizontal'){
        $gradient_body_type1 = 'left,'; $gradient_body_type2 = 'to right,'; $gradient_body_type3 = 'right,';
    }

     if($options['body-background-color-gradient-type'] == 'diagonal'){
        $gradient_body_type1 = 'left top,'; $gradient_body_type2 = 'to bottom right,'; $gradient_body_type3 = 'bottom right,';
    }
}

if(!isset($options['general-settings-background-color-selector']) or empty($options['general-settings-background-color-selector']))$options['general-settings-background-color-selector'] = '#f9f9f9';
if(!isset($options['body_font_family']['color']) or empty($options['body_font_family']['color']))$options['body_font_family']['color'] = '#888';


$header_gradient = '';
if(isset($gradient_from) && !empty($gradient_from)){
    $header_gradient = "
    .header-bottom, #custom__menu{
    background: ".esc_html($gradient_from).";
    background: -webkit-".esc_html($gradient_type_main)."-gradient(".esc_html($gradient_type1)." ".esc_html($gradient_from)." 0%,".esc_html($gradient_to)." ".esc_html($gradient_percent)."%);
    background: -o-".esc_html($gradient_type_main)."-gradient(".esc_html($gradient_type3)." ".esc_html($gradient_from)." 0%,".esc_html($gradient_to)." ".esc_html($gradient_percent)."%);
    background: -moz-".esc_html($gradient_type_main)."-gradient(".esc_html($gradient_type3)." ".esc_html($gradient_from)." 0%, ".esc_html($gradient_to)." ".esc_html($gradient_percent)."%);
    background: ".esc_html($gradient_type_main)."-gradient(".esc_html($gradient_type2)." ".esc_html($gradient_from)." 0%,".esc_html($gradient_to)." ".esc_html($gradient_percent)."%);
    }";
}

$body_gradient = '';
if(isset($gradient_body_from) && !empty($gradient_body_from)){
    $body_gradient ="html{
    background: ".esc_html($gradient_body_from)." !important;
    background: -webkit-linear-gradient(".esc_html($gradient_body_type1)." ".esc_html($gradient_body_from)." 0%,".esc_html($gradient_body_to)." 100%) !important;
    background: -o-linear-gradient(".esc_html($gradient_body_type3)." ".esc_html($gradient_body_from)." 0%,".esc_html($gradient_body_to)." 100%) !important;
    background: -moz-linear-gradient(".esc_html($gradient_body_type3)." ".esc_html($gradient_body_from)." 0%, ".esc_html($gradient_body_to)." 100%) !important;
    background: linear-gradient(".esc_html($gradient_body_type2)." ".esc_html($gradient_body_from)." 0%,".esc_html($gradient_body_to)." 100%) !important;
    }";
}

$heading_font = '';

if(isset($heading_font_color) && !empty($heading_font_color)){
    $heading_font ="body .pmeta-category a{
    color: ".esc_html($heading_font_color).";
    }";
}

$heading_font2 = "body .pmeta-category a{
    border: 2px solid ".esc_html($heading_font_color).";
    }";


$respawn_dynamic_style = "



body table tbody tr td{
    border-bottom:1px solid ".esc_html($options['general-settings-background-color-selector']).";
}
/* Body background */ 
body{
background: url(".esc_url($body_background).") center top;
}

/* Header gradient */

".esc_html($header_gradient)."

/* Body gradient */
".esc_html($body_gradient)."

/* Menu Global Color changes */

/*Menu Hover Color*/

.header-alt .menucont.cl-effect-6 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-6 div > ul > li > a:focus::before,
.menucont.cl-effect-6 div > ul > li > a:hover::before,
.menucont.cl-effect-6 div > ul > li > a:focus::before {
    text-shadow: 10px 0 ".esc_html($menu_hover_color).", -10px 0 ".esc_html($menu_hover_color).";
}

.menucont.cl-effect-1 div > ul > li > a::before,
.menucont.cl-effect-1 div > ul > li > a::after{
    color: ".esc_html($menu_hover_color).";
}

.menu.menuEffects ul li a:hover,
.menucont ul.navbar-nav > li > a:hover,
.footer_bottom .fb_social a:hover, .menucont ul.navbar-nav > li > a:focus,
.header-alt .menucont.cl-effect-1 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-1 div > ul > li > a:hover::after,
.header-alt .menucont.cl-effect-1 div > ul > li > a:focus::before,
.header-alt .menucont.cl-effect-1 div > ul > li > a:focus::after,
.header-alt .menucont.cl-effect-5 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-5 div > ul > li > a:hover::after,
.header-alt .menucont.cl-effect-5 div > ul > li > a:focus::before,
.header-alt .menucont.cl-effect-5 div > ul > li > a:focus::after,
.header-alt .menucont.cl-effect-2 div > ul > li > a:focus,
.header-alt .menucont.cl-effect-3 div > ul > li > a::before,
.header-alt .menucont.cl-effect-6 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-6 div > ul > li > a:focus::before,
.header-alt .menucont.cl-effect-6 div > ul > li > a:hover,
.header-alt .menucont.cl-effect-6 div > ul > li > a:focus,
.menucont.cl-effect-1 div > ul > li > a:hover::before,
.menucont.cl-effect-1 div > ul > li > a:hover::after,
.menucont.cl-effect-1 div > ul > li > a:focus::before,
.menucont.cl-effect-1 div > ul > li > a:focus::after,
.menucont.cl-effect-5 div > ul > li > a:hover::before,
.menucont.cl-effect-5 div > ul > li > a:hover::after,
.menucont.cl-effect-5 div > ul > li > a:focus::before,
.menucont.cl-effect-5 div > ul > li > a:focus::after,
.menucont.cl-effect-2 div > ul > li > a:focus,
.menucont.cl-effect-3 div > ul > li > a::before,
.menucont.cl-effect-6 div > ul > li > a:hover::before,
.menucont.cl-effect-6 div > ul > li > a:focus::before,
.menucont.cl-effect-6 div > ul > li > a:hover,
.menucont.cl-effect-6 div > ul > li > a:focus{
    color: ".esc_html($menu_hover_color).";
}

.regular-eff.menucont ul.navbar-nav > li > a:after,
.menucont.cl-effect-2 div > ul > li > a::before,
.menucont.cl-effect-2 div > ul > li > a::after,
.menucont.cl-effect-5 div > ul > li > a::before,
.menucont.cl-effect-5 div > ul > li > a::after,
.menucont.cl-effect-3 div > ul > li > a::before,
.menucont.cl-effect-4 div > ul > li > a::after,
.menucont.cl-effect-5 div > ul > li > a::before,
.menucont.cl-effect-5 div > ul > li > a::after{
    background-color: ".esc_html($menu_hover_color).";
}

.menucont.cl-effect-3 div > ul > li > a::before, #custom__menu .open, #custom__menu .open:before, #custom__menu .open:after,
#mega-menu-wrap-header-menu #mega-menu-header-menu > li.mega-menu-item > a.mega-menu-link:before{
    background-color: ".esc_html($menu_hover_color).";
}

.hsearch > a, header .hsearch button,
.header-alt .menucont.cl-effect-2 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-2 div > ul > li > a:focus::before,
.header-alt .menucont.cl-effect-2 div > ul > li > a:hover::after,
.header-alt .menucont.cl-effect-2 div > ul > li > a:focus::after,
.header-alt .menucont.cl-effect-3 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-3 div > ul > li > a:focus::before,
.header-alt .menucont.cl-effect-4 div > ul > li > a:hover::after,
.header-alt .menucont.cl-effect-4 div > ul > li > a:focus::after,
.header-alt .menucont.cl-effect-5 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-5 div > ul > li > a:hover::after,
.header-alt .menucont.cl-effect-5 div > ul > li > a:focus::before,
.header-alt .menucont.cl-effect-5 div > ul > li > a:focus::after,
.menucont.cl-effect-2 div > ul > li > a:hover::before,
.menucont.cl-effect-2 div > ul > li > a:focus::before,
.menucont.cl-effect-2 div > ul > li > a:hover::after,
.menucont.cl-effect-2 div > ul > li > a:focus::after,
.menucont.cl-effect-3 div > ul > li > a:hover::before,
.menucont.cl-effect-3 div > ul > li > a:focus::before,
.menucont.cl-effect-4 div > ul > li > a:hover::after,
.menucont.cl-effect-4 div > ul > li > a:focus::after,
.menucont.cl-effect-5 div > ul > li > a:hover::before,
.menucont.cl-effect-5 div > ul > li > a:hover::after,
.menucont.cl-effect-5 div > ul > li > a:focus::before,
.menucont.cl-effect-5 div > ul > li > a:focus::after{

    background-color: ".esc_html($menu_hover_color).";
}


.menucont.cl-effect-7 div > ul > li > a::before,
.menucont.cl-effect-7 div > ul > li > a::after{
    border-color: ".esc_html($menu_hover_color).";
}


.header-alt .menucont.cl-effect-7 div > ul > li > a:hover::before,
.header-alt .menucont.cl-effect-7 div > ul > li > a:focus::before,
.header-alt .menucont.cl-effect-7 div > ul > li > a:hover::after,
.header-alt .menucont.cl-effect-7 div > ul > li > a:focus::after,
.menucont.cl-effect-7 div > ul > li > a:hover::before,
.menucont.cl-effect-7 div > ul > li > a:focus::before,
.menucont.cl-effect-7 div > ul > li > a:hover::after,
.menucont.cl-effect-7 div > ul > li > a:focus::after {
    border-color: ".esc_html($menu_hover_color).";
}



/* Fixed header color fixing */

.header-alt .menucont.cl-effect-1 div > ul > li > a::before,
.header-alt .menucont.cl-effect-1 div > ul > li > a::after{
    color: ".esc_html($header_color_position_font).";
}


.header-alt .menucont.cl-effect-2 div > ul > li > a::before,
.header-alt .menucont.cl-effect-2 div > ul > li > a::after,
.header-alt .menucont.cl-effect-5 div > ul > li > a::before,
.header-alt .menucont.cl-effect-5 div > ul > li > a::after,
.header-alt .menucont.cl-effect-3 div > ul > li > a::before,
.header-alt .menucont.cl-effect-4 div > ul > li > a::after,
.header-alt .menucont.cl-effect-5 div > ul > li > a::before,
.header-alt .menucont.cl-effect-5 div > ul > li > a::after{
    background-color: ".esc_html($header_color_position_font).";
}



.header-alt .menucont.cl-effect-7 div > ul > li > a::before,
.header-alt .menucont.cl-effect-7 div > ul > li > a::after{
    border-color: ".esc_html($menu_font_color).";
}

.hsocial a:hover{
    color: ".esc_html($menu_font_color).";
}

/* Generic colors */


.no_image.blogs-style1.spcard .spcategory:hover, .blogs-style1 .sptitle a, .nw-info > a, .nw-info > div > a, span.sc-price, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,
select, input[type='text'], input[type='password'], input[type='date'], input[type='datetime'],  body .widget_shopping_cart .product_list_widget li.empty, .tagcloud a, .tagcloud a:hover,
.widget.woocommerce.widget_product_search .woocommerce-product-search input[type='submit'], .widget.woocommerce.widget_product_search .woocommerce-product-search button,
.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, 
.woocommerce-error, .woocommerce-info, .woocommerce-message, .bmatchlist .bmatchul li a .bmatchscore .vsresult,
.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span, .woocommerce-tabs ul.tabs li a, .woocommerce div.product .woocommerce-tabs ul.tabs li a,
input[type='email'], input[type='number'], input[type='search'], .blogs-style1.spcard .spauthor a,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
input[type='tel'], input[type='time'], input[type='url'], textarea {
	color: ".esc_html($body_font_family_color).";
}
::placeholder{
    color: ".esc_html($body_font_family_color).";
    font-weight:200;
}
.no_image.blogs-style1.spcard .spcategory:hover{
	border-color: ".esc_html($body_font_family_color).";
}
input, textarea, select, button{
	font-family: ".esc_html($body_font_family).";
}
.spcard .spextra:before, .newslist li:before, .block-divider{
	background: ".esc_html($body_font_family_color).";
}
html .woocommerce #respond input#submit.alt, html .woocommerce a.button.alt, .reply a, .author-wrapper .author-link,body #payment .place-order .button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
html .woocommerce button.button.alt, .reply a, input[type='submit'], a.added_to_cart, ul.mmaps li:hover span:before, .block-title:before, .slide--left,
html .woocommerce input.button.alt, .widget > h4:before, .comment-reply-title:before , .blogs-style1.spcard.blogs-style2.blogs-featured .spbutton, .widget.woocommerce.widget_price_filter .price_slider_wrapper .ui-widget-content .ui-slider-handle,
ul.products li.product .button.product_type_simple, .widget_shopping_cart_content .buttons a, .product-tag .tag-sale, .nw-info .spcategory, .wp-block-button__link,
.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .teamm-slider .slick-slide.slick-active.slick-current .mem-info h6:before,
.widget.woocommerce.widget_product_search .woocommerce-product-search input[type='submit'], input[type='submit'], .select2-container--default .select2-results__option--highlighted[aria-selected],
 .widget.woocommerce.widget_product_search .woocommerce-product-search button, .tagcloud a, html .search__form-inner::after, #bbpress-forums .wp-core-ui .button, #bbpress-forums .wp-core-ui .button-secondary,
 .woocommerce nav.woocommerce-pagination ul li span, .single-product div.product .woocommerce-tabs:before,
body .protip-skin-default--scheme-pro.protip-container, .mejs__volume-current, .mejs__volume-handle, .btn, .slick-arrows-fix .slick-arrow:hover:after, .elementor-widget-videos_slider .slick-slide a:before,
.mejs__horizontal-volume-current, .mejs__time-current, .mejs__time-handle-content, .blogs-style1.spcard .spbgimg, ul.sub-menu, .magazine-blog .spcard:hover .spbgimg,
 .widget.widget_calendar #wp-calendar tbody tr td a:hover:before, .example-1 .spmenu-content li, .newslist li .nw-img > a:first-child,
 .gallery-header-wrap .gallery-header-center-right-links strong::after, button, .button, input[type='submit'] { 
    background: ".esc_html($general_color).";
} 

::selection {
  background: ".esc_html($general_color).";
} 
::-moz-selection {
  background: ".esc_html($general_color).";
}

 .single-product .woocommerce-product-gallery .woocommerce-product-gallery__trigger{
 background: ".esc_html($general_color)." !important;
 }
html .woocommerce div.product .stock, .pagination ul li a:hover, .pagination.default_wp_p .wp_pag > li:hover, .pagination.default_wp_p .wp_pag > a:hover, .slide--current .s-numbers,
 .post-meta a:hover, .post-meta a:focus, .post-meta a:active, .newslist li:hover .nw-info > a, .nw-info > div > a:hover, a, .magazine-blog .spcard .spheader i,
 .spcard .spauthor a:hover, .match-header .mscore span, .pmeta-category a:hover, .pmeta-category a:focus, .spcard:hover .sptitle a, .bmatchlist .bmatchul li a .mbtitle-wrapper h3,
 .sticky.spcard .sptitle a, body .woocommerce ul.cart_list li a:hover,  #custom__menu ul.navbar-nav li ul.submenu li:hover a,
  .main-content .pagination.default_wp_p .wp_pag > a,
 .menucont, header .hsocial a, header .hsearch, p.stars a.star-1:hover:before, .single-product div.product .summary .woocommerce-Price-amount,
 p.stars a.star-1.active:hover:before,
p.stars a.star-2.active:hover:before,
p.stars a.star-3.active:hover:before,
p.stars a.star-4.active:hover:before,
p.stars a.star-5.active:hover:before,
p.stars a.star-2:hover:before,
p.stars a.star-3:hover:before,
p.stars a.star-4:hover:before,
p.stars a.star-5:hover:before,
p.stars a.star-1.active:before,
p.stars a.star-2.active:before,
p.stars a.star-3.active:before,
p.stars a.star-4.active:before,
p.stars a.star-5.active:before,
.star-rating span:before, #mega-menu-wrap-header-menu #mega-menu-header-menu li.mega-menu-item a.mega-menu-link:before, .is-style-outline,
.spcard .spauthor a, .portfolio-navigation.portfolio-nav-imgs .port-next:hover, .portfolio-navigation.portfolio-nav-imgs .port-previous:hover, ul.matchstats li span, .block-title a:hover,
.portfolio-navigation.portfolio-nav-imgs .port-links .back-to-list:hover, .portfolio-navigation .port-previous:hover i, .portfolio-navigation .port-next:hover i, .gallery-header-center-right-links-current,
.gallery-header-center-right-links:hover, .portfolio-navigation a.back-to-list:hover, .team-header h2 {
    color: ".esc_html($general_color).";
}

.pagination ul li a:hover, body .pagination.default_wp_p .wp_pag > li,.pagination ul li a, body blockquote, .spcategory , .wp-team-matches-pagination .page-numbers, .pagination.default_wp_p .wp_pag > li,
 .main-content .pagination.default_wp_p .wp_pag > a, .main-content .pagination.default_wp_p .wp_pag > span,
 .pagination.default_wp_p .wp_pag > li:hover, .pagination.default_wp_p .wp_pag > a:hover, .pagination ul li.active a, button, .button, input[type='submit'], button{
    border-color: ".esc_html($general_color).";
}
input[type='submit']:hover, a.added_to_cart:hover,  .blogs-style1 .spbutton:hover, .btn:hover, button:hover, input[type='submit']:hover, .widget.woocommerce.widget_product_search .woocommerce-product-search input[type='submit']:hover,
.blogs-style1.spcard .spmenu-content a:hover,  .reply a:hover, .widget.woocommerce.widget_product_search .woocommerce-product-search button:hover, .woocommerce div.product .woocommerce-tabs ul.tabs:before,
.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover,  .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span.current, 
.example-1.spcard .spmeta a:first-child:hover, .example-1 .sptitle a:hover, .example-1.spcard .spmeta a:hover i, .woocommerce-noreviews, p.no-comments{
	border-color: ".esc_html($general_color)." !important;
}
".esc_html($heading_font).' '.esc_html($heading_font2)." 

.pmeta-category a:hover, .pmeta-category a:focus{
    border: 2px solid ".esc_html($general_color).";
}

 body .protip-skin-default--scheme-pro[data-pt-position='top'] .protip-arrow {
    border-color: ".esc_html($general_color)." transparent transparent transparent ;
}

 .cart-notification, .widget_shopping_cart, .woocommerce .cart-notification{
    background: ".esc_html($options['general-settings-background-color-selector']).";
 }



/* SECONDARY COLORS */

.meminfo h3,  body .newslist li .nw-info > a:hover, .spcard .sptitle a:hover, a:hover, h3.ns-secondstyle i, .bmatchlist .bmatchul li a .mbtitle-wrapper:hover h4, .block-title a, .search .blog-content i,
body .woocommerce ul.product_list_widget li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a{
	color:".esc_html($general_color_secondary).";
}
.nw-info > div > a:first-child:hover, body .newslist li .nw-img > a:first-child:hover, .slick-arrows-fix .slick-arrow:after, .mem-info h6:before, a.mc-wrap:after, a.pr-image, .isotopeItemOverlay:before, .slide--right,
.tagcloud a:hover, .woocommerce-noreviews, p.no-comments, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,
.select2-container--default .select2-results__option[aria-selected=true], .select2-container--default .select2-results__option[data-selected=true],
#bbpress-forums .wp-core-ui .button:hover, #bbpress-forums .wp-core-ui .button-secondary:hover,
 body .widget.woocommerce.widget_price_filter .price_slider_wrapper .ui-widget-content{
	background: ".esc_html($general_color_secondary).";
}

/* Widgets header  */

select, input[type='text'], input[type='password'], input[type='date'], input[type='datetime'], input[type='email'], input[type='number'], input[type='search'], input[type='tel'],
 input[type='time'], input[type='url'], textarea, #bbpress-forums fieldset.bbp-form legend, #bbpress-forums li.bbp-header, .bbp-topic-title h3, .blogs-style1.spcard.blogs-style2.spquote-post .spwrapper,
 #bbpress-forums div.bbp-the-content-wrapper div.quicktags-toolbar, #bbpress-forums div.bbp-forum-header, #bbpress-forums div.bbp-topic-header, #bbpress-forums div.bbp-reply-header,
 .menucont ul.sub-menu, .comment-list .comment .avatar, .widget > h4, .comment-reply-title, .block-title, .select2-dropdown, #bbpress-forums li.bbp-footer,
 .widget.widget_calendar #wp-calendar tbody tr td a:before, table thead th, table thead, table tfoot, table tbody tr.alt,  table tbody tr.even,  table tbody tr:nth-child(even),
 #add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment, ul.single-product .product, .woocommerce-error, .woocommerce-info, 
 .woocommerce-message, .select2-container--default .select2-selection--single{
    background: ".esc_html($general_widget_header_color)." ;
}

table, #bbpress-forums fieldset.bbp-form{
    border: 1px solid ".esc_html($general_widget_header_color).";
}


/* Widgets Background */

.block-wrap,  .spdata, .comment-list > li article, .widget, body table , code, .woocommerce-thankyou-order-details.order_details, .woocommerce-thankyou-order-received,
#bbpress-forums div.odd, #bbpress-forums ul.odd, #bbpress-forums div.even, #bbpress-forums ul.even, .page-template-tmp-all-matches ul.bmatchul.block-wrap {
    background: ".esc_html($general_widget_background_color)." ;
}


.prevmember:after{
    background: -webkit-linear-gradient(left, ".esc_html($general_widget_background_color)." 0%, rgba(49, 48, 52, 0) 0%, ".esc_html($general_widget_background_color)." 67%);
    background: linear-gradient(to right, ".esc_html($general_widget_background_color)." 0%, rgba(49, 48, 52, 0) 0%, ".esc_html($general_widget_background_color)." 67%);
}
.nextmember:after{
    background: -webkit-linear-gradient(right, ".esc_html($general_widget_background_color)." 0%, rgba(49, 48, 52, 0) 0%, ".esc_html($general_widget_background_color)." 67%);
    background: linear-gradient(to left, ".esc_html($general_widget_background_color)." 0%, rgba(49, 48, 52, 0) 0%, ".esc_html($general_widget_background_color)." 67%);
}



.match-header:before{
background: -moz-linear-gradient(bottom, ".$options['general-settings-background-color-selector']." 17%, rgba(0,0,0,0) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(bottom, ".$options['general-settings-background-color-selector']." 17%,rgba(0,0,0,0) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to top, ".$options['general-settings-background-color-selector']." 17%,rgba(0,0,0,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
}
.match-header{
    background: -webkit-linear-gradient(left,".$options['general-settings-background-color-selector']." 10%, #252529 100%);
	background: linear-gradient(to right, ".$options['general-settings-background-color-selector']." 10%, #252529  100%);

}


/* Header */

/*Header Size*/
.hlogo a, .hlogo, .menuArea, header, .no_header{
    height:".esc_html($header_general_size)."px;
}
.menucont, .menucont div > ul > li > a, header .hsocial a, header .hsearch {
    line-height: ".esc_html($header_general_size)."px;
}
header .hsocial a, header .hsearch {
	height: ".esc_html($header_general_size)."px;
}
.hsocial a i, .hsearch a i{
	line-height: ".esc_html($header_general_size)."px !important;
}
header.burger-menu .menuEffects{
    padding-top:".esc_html($header_general_size)."px;
}

.single-matches .main-content{
	margin-top:-".esc_html($header_general_size)."px;
}

.header-alt .menu.menuEffects ul li a, .header-alt .menucont ul.navbar-nav > li > a,  .header-alt .mega-menu a{
    color: ".esc_html($header_color_position_font)." !important;
}

.header-alt .menucont.cl-effect-3 div > ul > li > a::before, #custom__menu.header-alt .open, #custom__menu.header-alt .open:before, #custom__menu.header-alt .open:after{
    background-color: ".esc_html($header_color_position_font).";
}



/* Page Title */

.page-title-wrap{
    padding-top:".esc_html($header_top_padding)."px;
    padding-bottom:".esc_html($header_bottom_padding)."px !important;
    margin-top:-".esc_html($header_general_size)."px;
}


/* Header image */


 .page-title-bg{
    background-image:url(".esc_url($respawn_custombck).") !important;
}



/* Footer image */
.main_footer{
    background-image:url(".esc_url($top_footer_area_image).") !important;
    padding-top: ".esc_html($top_footer_area_top_padding)."px;
    padding-bottom: ".esc_html($top_footer_area_bottom_padding)."px;
    ".esc_html($footer_repeat_style).";
}

";

?>