<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: https://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "respawn_redux";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );



    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $theme_menu_icon = get_theme_file_uri('assets/img/icons/wplogo.png');


    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        'disable_tracking' => true,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => 'Respawn',
        'page_title'           => 'Respawn Options',
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => 27,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => $theme_menu_icon,
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => '',
        // icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'     => ' ',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );


    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => '',
        'title' => esc_html__('Like us on Facebook', 'respawn'),
        'icon'  => 'el el-facebook'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = '';
    } else {
         $args['intro_text'] = '';
    }

    // Add content after the form.
    $args['footer_text'] = '';

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /* EXT LOADER */
    if(!function_exists('redux_register_custom_extension_loader') && class_exists( 'Respawn_Types' )) :
    function redux_register_custom_extension_loader($ReduxFramework) {
        $path = WP_PLUGIN_DIR.'/respawn-types/extensions/';
        $folders = scandir( $path, 1 );
        foreach($folders as $folder) {
            if ($folder === '.' or $folder === '..' or !is_dir($path . $folder) ) {
                continue;
            }
            $extension_class = 'ReduxFramework_Extension_' . $folder;
            if( !class_exists( $extension_class ) ) {
                // In case you wanted override your override, hah.
                $class_file = $path . $folder . '/extension_' . $folder . '.php';
                $class_file = apply_filters( 'redux/extension/'.$ReduxFramework->args['opt_name'].'/'.$folder, $class_file );
                if( $class_file ) {
                    require_once( $class_file );
                    $extension = new $extension_class( $ReduxFramework );
                }
            }
        }
    }
    // Modify {$redux_opt_name} to match your opt_name
    add_action("redux/extensions/".$opt_name ."/before", 'redux_register_custom_extension_loader', 0);
    endif;


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*
        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
     */

     #************************************************
	# General
	#************************************************

	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General Settings', 'respawn' ),
        'id'               => 'general-settings',
        'customizer_width' => '200px',
        'desc'             => esc_html__('Welcome to the Respawn options panel! You can switch between option groups by using the left-hand tabs.', 'respawn' ),
        'fields'           => array(
		   )
    ) );

	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General Settings', 'respawn' ),
        'id'               => 'general-settings-options',
        'subsection'       => true,
        'fields'           => array(

         array(
                'id' => 'logo',
                'type' => 'media',
                'title' => esc_html__('Upload Your Logo', 'respawn'),
                'subtitle' => esc_html__('Upload your logo image.', 'respawn'),
                'default' => array(
				        'url'=> get_theme_file_uri('assets/img/logo-main.png')
				    ),
            ),

             array(
                'id' => 'general-settings-to-top',
                'type' => 'switch',
                'title' => esc_html__('To Top', 'respawn'),
                'subtitle' => esc_html__('This will enable back to top button.', 'respawn'),
                'desc' => '',
                'default' => true
            ),
            array(
                'id' => 'general-settings-one-page',
                'type' => 'switch',
                'title' => esc_html__('One Page Template', 'respawn'),
                'subtitle' => esc_html__('Enable this if you want to use one page website. This option will load necesary script for smooth transition when you click on menu item.', 'respawn'),
                'desc' => '',
                'default' => false
            ),
              array(
                'id' => 'general-settings-color-selector',
                'type' => 'color',
                'title' => esc_html__('Choose Website General Color', 'respawn'),
                'transparent' => false,
                'subtitle' => esc_html__('This will affect different elements in the site.', 'respawn'),
                'default' => '#696bff',
            ),
            array(
                'id' => 'general-settings-secondary-color',
                'type' => 'color',
                'title' => esc_html__('Choose Website Secondary Color', 'respawn'),
                'transparent' => false,
                'subtitle' => esc_html__('This will affect different elements in the site.', 'respawn'),
                'default' => '#8442fd',
            ),
            array(
                'id' => 'general-widget-header-color',
                'type' => 'color',
                'title' => esc_html__('Choose Website Widget Header Color', 'respawn'),
                'transparent' => false,
                'subtitle' => esc_html__('This will affect different widget and block headers in the site.', 'respawn'),
                'default' => '#171719',
            ),
            array(
                'id' => 'general-widget-background-color',
                'type' => 'color',
                'title' => esc_html__('Choose Website Widget Background Color', 'respawn'),
                'transparent' => false,
                'subtitle' => esc_html__('This will affect different widget and block backgrounds in the site.', 'respawn'),
                'default' => '#1f1f22',
            ),

        )
    ) );


	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Page preloader', 'respawn' ),
        'id'               => 'general-settings-styling',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id' => 'preloading',
                'type' => 'switch',
                'title' => esc_html__('Enable Page Preloading', 'respawn'),
                'subtitle' => esc_html__('Turn this on to enable page preloading.', 'respawn'),
                'desc' => '',
                'default' => true
            ),
             array(
			'type' => 'select',
			'id'     => 'loading-icon-styles',
		    'title' => esc_html__('Loading Icon', 'respawn'),
		    'subtitle' => esc_html__('Choose preferred loading icon styling.', 'respawn'),
		    'options' => array(
	                "sk-folding-cube" => esc_html__("Folding Cube", 'respawn'),
	                "rotating-plane" => esc_html__("Rotating Plane", 'respawn'),
	                "double-bounce" => esc_html__("Double Bounce", 'respawn'),
	                "rectangle-bounce" => esc_html__("Rectangle Bounce", 'respawn'),
	                "wandering-cubes" => esc_html__("Wandering Cubes", 'respawn'),
	                "pulse" => esc_html__("Pulse", 'respawn'),
	                "chasing-dots" => esc_html__("Chasing Dots", 'respawn'),
	                "three-bounce" => esc_html__("Three Bounce", 'respawn'),
	                "sk-circle" => esc_html__("Circle", 'respawn'),
	                "sk-cube-grid" => esc_html__("Cube Grid", 'respawn'),
	                "sk-fading-circle" => esc_html__("Fading Circle", 'respawn'),

	            ),
			'default' => 'sk-folding-cube',
			'required' => array( 'preloading', '=', '1' ),
			 ),
			 array(
                'id' => 'loading-icon-background-color',
                'type' => 'color',
                'title' => esc_html__('Preloader Icon Color', 'respawn'),
                'transparent' => false,
                'desc' => '',
                'default' => '#696bff',
                'output' => array('background-color' => '.sk-folding-cube .sk-cube:before,
                .rotating-plane, .double-bounce1, .double-bounce2, .rectangle-bounce > div,
                .cube1, .cube2, .pulse, .dot1, .dot2, .three-bounce > div, .sk-circle .sk-child:before,
                .sk-cube-grid .sk-cube, .sk-fading-circle .sk-circle:before'),
                'required' => array( 'preloading', '=', '1' ),
            ),
			  array(
                'id' => 'loading-icon-color',
                'type' => 'color',
                'title' => esc_html__('Preloader Background Color', 'respawn'),
                'transparent' => false,
                'desc' => '',
                'default' => '#000c21',
                'output' => array('background-color' => '.se-pre-con'),
                'required' => array( 'preloading', '=', '1' ),
            ),
        )
    )
    );

    #************************************************
    # Team wars
    #************************************************
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Team Matches', 'respawn' ),
        'id'               => 'team-wars',
        'customizer_width' => '450px',
        'icon'             => 'fas fa-shield-alt',
        'fields'           => array(

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Team Matches Settings', 'respawn' ),
        'id'               => 'team-wars-settings',
        'subsection'       => true,
        'fields'           => array(

            array(
                'id' => 'match_header_bg',
                'type' => 'media',
                'title' => esc_html__('Background', 'respawn'),
                'subtitle' => esc_html__('Default background for the match page.', 'respawn'),
                'default' => array(
                    'url'=> get_theme_file_uri('assets/img/defaults/matchbg.jpg')
                ),
            ),
        )
    ) );



	#************************************************
	# Header
	#************************************************
	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header', 'respawn' ),
        'id'               => 'header-settings',
        'customizer_width' => '450px',
    	'icon'			   => 'fas fa-heading',
        'fields'           => array(

        )
    ) );

	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header General Settings', 'respawn' ),
        'id'               => 'header-general-settings-bckcolor',
        'subsection'       => true,
        'fields'           => array(

             array(
                'id' => 'header-settings-background-color-selector',
                'type' => 'select',
                'title' => esc_html__('Background Color Option', 'respawn'),
                'subtitle' => esc_html__('Choose background color option.', 'respawn'),
                'options' => array(
                    'color' => esc_html__('Color', 'respawn'),
                    'gradient' => esc_html__('Color Gradient', 'respawn')
                ),
                'default' => 'color'
            ),
        	array(
                'id' => 'header-settings-background-color',
                'type' => 'color_rgba',
                'title' => esc_html__('Background Color', 'respawn'),
                'subtitle' => esc_html__('Select background color for header.', 'respawn'),
                'desc' => '',
                'default' => 'rgba(0, 0, 0, 0.1)',
                'output' => array('background-color' => '.header-bottom, #custom__menu'),
                'required' => array('header-settings-background-color-selector', '=', 'color')
            ),
            array(
                'id' => 'header-settings-background-color-gradient',
                'type' => 'color_gradient',
                'title' => esc_html__('Background Color Gradient', 'respawn'),
                'subtitle' => esc_html__('Select background color gradient for header.', 'respawn'),
                'validate' => 'color',
                'required' => array('header-settings-background-color-selector', '=', 'gradient')
            ),
             array(
                'id' => 'header-background-gradient-type',
                'type' => 'select',
                'title' => esc_html__('Background Color Gradient Type', 'respawn'),
                'subtitle' => esc_html__('Select background color gradient type for header.', 'respawn'),
                'required' => array('header-settings-background-color-selector', '=', 'gradient'),
                'options' => array(
                    'vertical' => esc_html__('Vertical', 'respawn'),
                    'horizontal' => esc_html__('Horizontal', 'respawn'),
                    'radial' => esc_html__('Radial', 'respawn'),
                    'diagonal' => esc_html__('Diagonal', 'respawn')
                ),
                 'default' => 'vertical',
            ),

             array(
                'id' => 'header-settings-layout-menu',
                'type' => 'image_select',
                'title' => esc_html__('Menu Layout', 'respawn'),
                'subtitle' => esc_html__('Please select the layout of your menu.', 'respawn'),
                'options' => array(
                                'right-aligned-menu' => array('title' => esc_html__('Right Aligned Menu Layout', 'respawn'), 'img' => get_theme_file_uri('assets/img/right-aligned-menu.png', dirname(__FILE__) )),
                                'center-aligned-menu' => array('title' => esc_html__('Center Aligned Menu Layout', 'respawn'), 'img' => get_theme_file_uri('assets/img/center-aligned-menu.png', dirname(__FILE__) )),
                                'left-aligned-menu' => array('title' => esc_html__('Left Aligned Menu Layout', 'respawn'), 'img' => get_theme_file_uri('assets/img/left-aligned-menu.png', dirname(__FILE__) )),
                            ),
                'default' => 'right-aligned-menu',
            ),

			 array(
                'id' => 'header-general-settings-size',
                'type' => 'text',
                'title' => esc_html__('Header Height', 'respawn'),
                'subtitle' => esc_html__('Choose desired height. Don\'t include "px" in the string. e.g. 30.', 'respawn'),
                'desc' => '',
                'validate' => 'numeric',
                'default' => 80
            ),

             array(
                'id' => 'header-settings-layout',
                'type' => 'select',
                'title' => esc_html__('Header Layout', 'respawn'),
                'subtitle' => esc_html__('Choose header layout.', 'respawn'),
                'desc' => '',
                'default' => 'normal',
                 'options' => array(
                    'normal' => esc_html__('Normal', 'respawn'),
                    'full' => esc_html__('Fullwidth', 'respawn'),
                    'boxed' => esc_html__('Boxed', 'respawn')
                ),

            ),
			 array(
                'id' => 'header-position',
                'type' => 'select',
                'title' => esc_html__('Header Style', 'respawn'),
                'subtitle' => esc_html__('Choose style of your header.', 'respawn'),
                'desc' => '',
                'options' => array(
                    'fixed' => esc_html__('Fixed', 'respawn'),
                    'regular' => esc_html__('Regular', 'respawn')
                ),
                'default' => 'regular',

            ),
             array(
                'id' => 'header-settings-background-color-position',
                'type' => 'color_rgba',
                'title' => esc_html__('Background Color For Fixed Header', 'respawn'),
                'subtitle' => esc_html__('Header background will change to this color when scrolling.', 'respawn'),
                'desc' => '',
                'default' => 'rgba(0, 0, 0, 0.7)',
                'output' => array('background-color' => '.header-alt .header-bottom, #custom__menu.header-alt'),
                'required' => array( 'header-position', '=', 'fixed' ),

            ),
             array(
                'id' => 'header-settings-color-position-font',
                'type' => 'color',
                'title' => esc_html__('Text Color In Fixed Header', 'respawn'),
                'subtitle' => esc_html__('Header text will change to this color when scrolling.', 'respawn'),
                'transparent' => false,
                'default' => '#ffffff',
                'required' => array( 'header-position', '=', 'fixed' ),
            ),
            array(
                'id' => 'header-settings-fixed-logo',
                'type' => 'media',
                'title' => esc_html__('Second Logo For Fixed Header', 'respawn'),
                'subtitle' => esc_html__('This logo will replace main one when you scroll down.', 'respawn'),
                'required' => array( 'header-position', '=', 'fixed' ),
            ),
             array(
                'id' => 'header-settings-social',
                'type' => 'switch',
                'title' => esc_html__('Enable Social Icons', 'respawn'),
                'subtitle' => esc_html__('This will enable social icons in your header.', 'respawn'),
                'desc' => '',
                'default' => true
            ),

        )
    ) );


		Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Search Settings', 'respawn' ),
        'id'               => 'search-settings',
        'subsection'       => true,
        'fields'           => array(
		array(
                'id' => 'header-settings-search',
                'type' => 'switch',
                'title' => esc_html__('Enable Search', 'respawn'),
                'subtitle' => esc_html__('This will enable search box in your header.', 'respawn'),
                'desc' => '',
                'default' => true
            ),

	   )
    ) );

	#************************************************
	# Menu
	#************************************************

	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Menu Settings', 'respawn' ),
        'id'               => 'menu-settings',
        'icon'				=> 'el el-lines',
        'fields'           => array( )
		));

		Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Menu General Settings', 'respawn' ),
        'id'               => 'menu-settings-general',
        'subsection'       => true,
        'fields'           => array(

             array(
                'id' => 'menu-settings-effect',
                'type' => 'select',
                'title' => esc_html__('Menu Hover Effects', 'respawn'),
                'subtitle' => esc_html__('Choose menu hover effect.', 'respawn'),
                'desc' => '',
                'default' => '3',
                   'options' => array(
                    "regular-eff" => esc_html__("Regular", 'respawn'),
	                "cl-effect-1" => esc_html__("Effect 1", 'respawn'),
	                "cl-effect-2" => esc_html__("Effect 2", 'respawn'),
	                "cl-effect-3" => esc_html__("Effect 3", 'respawn'),
	                "cl-effect-4" => esc_html__("Effect 4", 'respawn'),
	                "cl-effect-5" => esc_html__("Effect 5", 'respawn'),
	                "cl-effect-6" => esc_html__("Effect 6", 'respawn'),
	                "cl-effect-7" => esc_html__("Effect 7", 'respawn'),
	            ),
			'default' => 'cl-effect-3',
            ),
            array(
                'id'       => 'menu_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Menu Font', 'respawn' ),
                'subtitle' => esc_html__( 'Specify menu font properties.', 'respawn' ),
                'google'   => true,
                'all_styles'  => false,
                'letter-spacing' => true,
                 'text-transform'  => true,
                'output'    => array('.menu.menuEffects ul li a, .menucont ul.navbar-nav > li > a, .regular-eff.menucont ul.navbar-nav > li > a:hover  ',
				'color' => '.hsocial a, .hsearch a '
				),
				'default'     => array(
			        'color'       => '#ffffff',
			        'font-weight'  => '600',
			        'font-family' => 'Montserrat',
			        'google'      => true,
			        'font-size'   => '12px',
			        'line-height' => '21px'
			    ),

            ),

            array(
                'id' => 'menu-color-hover',
                'type' => 'color',
                'title' => esc_html__('Menu Hover Color', 'respawn'),
                'subtitle' => esc_html__('Choose menu hover color.', 'respawn'),
                'transparent' => false,
                'desc' => '',
                'default' => '#696bff',
                'output' => array(
				'color' => '.hsocial a,
							.menucont ul.navbar-nav > li > a:hover,
							.menucont ul.navbar-nav > li > a:focus',
				)
            )
	   )
    ) );

    #************************************************
    # Body
    #************************************************
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Body', 'respawn' ),
        'id'               => 'page-body',
        'customizer_width' => '450px',
        'icon'             => 'fas fa-list-alt',
        'fields'           => array(

         )
    ) );


        Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Body General Settings', 'respawn' ),
        'id'               => 'body-general-settings',
        'subsection'       => true,
        'fields'           => array(

             array(
                'id' => 'general-settings-background-color-selector-option',
                'type' => 'select',
                'title' => esc_html__('Website Background Color Option', 'respawn'),
                'subtitle' => esc_html__('Choose background color option.', 'respawn'),
                'options' => array(
                    'color' => esc_html__('Color', 'respawn'),
                    'gradient' => esc_html__('Color Gradient', 'respawn')
                ),
                'default' => 'color'
            ),
             array(
                'id' => 'body-background-color-gradient',
                'type' => 'color_gradient',
                'title' => esc_html__('Background Color Gradient', 'respawn'),
                'subtitle' => esc_html__('Select background color gradient for header.', 'respawn'),
                'validate' => 'color',
                'required' => array('general-settings-background-color-selector-option', '=', 'gradient')
            ),
             array(
                'id' => 'body-background-color-gradient-type',
                'type' => 'select',
                'title' => esc_html__('Background Color Gradient Type', 'respawn'),
                'subtitle' => esc_html__('Select background color gradient type for body.', 'respawn'),
                'required' => array('general-settings-background-color-selector-option', '=', 'gradient'),
                'options' => array(
                    'vertical' => esc_html__('Vertical', 'respawn'),
                    'horizontal' => esc_html__('Horizontal', 'respawn'),
                    'diagonal' => esc_html__('Diagonal', 'respawn')
                ),
                 'default' => 'vertical',
            ),

           array(
                'id' => 'general-settings-background-color-selector',
                'type' => 'color',
                'title' => esc_html__('Website Background Color', 'respawn'),
                'transparent' => false,
                'subtitle' => esc_html__('This will affect background color of the website.', 'respawn'),
                'default' => '#202125',
                'output'    => array('background-color' => 'body'),
                'required' => array('general-settings-background-color-selector-option', '=', 'color'),
            ),

            array(
                'id' => 'body_background',
                'type' => 'media',
                'title' => esc_html__('Body Background', 'respawn'),
                'subtitle' => esc_html__('Upload body background image.', 'respawn'),
            ),
            array(
                'id' => 'body_background_repeat',
                'type' => 'switch',
                'title' => esc_html__('Background Repeat', 'respawn'),
                'subtitle' => esc_html__('Use this option to turn background repeat on/off.', 'respawn'),
            ),
             array(
                'id' => 'body_background_fixed',
                'type' => 'switch',
                'title' => esc_html__('Fixed Background', 'respawn'),
                'subtitle' => esc_html__('Use this option to turn fixed background on/off.', 'respawn'),
            ),


          )
    ) );

          Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Content', 'respawn' ),
        'id'               => 'general-settings-content',
        'subsection'       => true,
        'fields'           => array(
              array(
                'id' => 'content-excerpt',
                'type' => 'text',
                'title' => esc_html__('Excerpt Length', 'respawn'),
                'subtitle' => esc_html__('Custom excerpt length. Default is 25.', 'respawn'),
                'default' => '25',
                'validate' => 'numeric',
            ),

        )
    )
    );


	#************************************************
	# Page Header
	#************************************************
	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Page Header', 'respawn' ),
        'id'               => 'page-header-general',
        'customizer_width' => '450px',
    	'icon'			   => 'fas fa-file-alt',
        'fields'           => array(

		 )
	) );


		Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'P. Header General Settings', 'respawn' ),
        'id'               => 'page-header-general-settings',
        'subsection'       => true,
        'fields'           => array(
        	array(
                'id' => 'header-settings-switch',
                'type' => 'switch',
                'title' => esc_html__('Show Page Header', 'respawn'),
                'subtitle' => esc_html__('Use this option to turn header on/off.', 'respawn'),
                'default' => true

            ),
           array(
                'id' => 'header-settings-default-image',
                'type' => 'media',
                'title' => esc_html__('Select Default Background Image', 'respawn'),
                'subtitle' => esc_html__('Select default background image for header.', 'respawn'),
                'default'  => array(
			        'url'=> get_theme_file_uri('assets/img/defaults/header-default.jpg')
			    ),
            ),

			array(
                'id' => 'page-title-subtitle',
                'type' => 'switch',
                'title' => esc_html__('Page Subtitle Breadcrumbs', 'respawn'),
                'subtitle' => esc_html__('Use this option to turn breadcrumbs on/off.', 'respawn'),
                'options' => array(
	                "nothing" => esc_html__("Nothing", 'respawn'),
	                "breadcrumbs" => esc_html__("Breadcrumbs", 'respawn'),
	            )
            ),
             array(
                'id' => 'header-settings-parallax',
                'type' => 'switch',
                'title' => esc_html__('Header Parallax Effect', 'respawn'),
                'subtitle' => esc_html__('This will enable header parallax effect.', 'respawn'),
                'desc' => '',
                'default' => true,
            ),
             array(
                'id' => 'header-settings-tint',
                'type' => 'color_rgba',
                'title' => esc_html__('Page Header Tint', 'respawn'),
                'subtitle' => esc_html__('Adds a tint color to the page header so the title can be read better.', 'respawn'),
                'desc' => '',
                'default' => '',
                'output' => array('background-color' => '.page-title-tint')
            ),
            array(
                'id' => 'header-general-settings-padding-top',
                'type' => 'text',
                'title' => esc_html__('Page Top Padding', 'respawn'),
                'subtitle' => esc_html__('Choose desired top padding. Don\'t include "px" in the string. e.g. 30.', 'respawn'),
                'desc' => '',
                'validate' => 'numeric',
                'default' => 100
            ),
            array(
                'id' => 'header-general-settings-padding-bottom',
                'type' => 'text',
                'title' => esc_html__('Page Bottom Padding', 'respawn'),
                'subtitle' => esc_html__('Choose desired bottom padding. Don\'t include "px" in the string. e.g. 30.', 'respawn'),
                'desc' => '',
                'validate' => 'numeric',
                'default' => 100
            ),
          )
	) );


	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'P. Header Typography', 'respawn' ),
        'id'               => 'header-typography-settings',
        'subsection'       => true,
        'fields'           => array(

		 array(
                'id'       => 'page_heading_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Page Heading Title Font', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the page heading title font properties.', 'respawn' ),
                'google'   => true,
                'all_styles'  => false,
                 'letter-spacing' => true,
                'fonts' =>  '',
                'default'  => array(),
				'output' => array('.page-title-wrap h1')

            ),

             array(
                'id'       => 'page_heading_subtitle_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Page Heading Subtitle Font', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the page heading subtitle font properties.', 'respawn' ),
                'google'   => true,
                'fonts' =>  '',
                'all_styles'  => false,
                 'letter-spacing' => true,
                'default'  => array(),
                 'output' => array('body .page-title-wrap h4')
            ),

		)
    ) );

	#************************************************
	# Typography
	#************************************************

	Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Typography', 'respawn' ),
        'id'     => 'typography',
        'desc'   => esc_html__( 'All typography related options are listed here', 'respawn' ),
        'icon'   => 'fas fa-font',
        'fields' => array(
		 )
    ) );


    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General HTML elements', 'respawn' ),
        'id'               => 'typography-general',
        'subsection'       => true,
        'fields'           => array(
             array(
                'id'       => 'body_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Body Font', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the body font properties.', 'respawn' ),
                'google'   => true,
                'fonts' =>  '',
                'all_styles'  => false,
                 'letter-spacing' => true,
                'default'     => array(
			        'color'       => '#f7f7f7',
			        'font-weight'  => '400',
			        'font-family' => 'Montserrat',
			        'google'      => true,
			        'font-size'   => '14px',
			        'line-height' => '24px'
			    ),
                'output'   => array('body')

            ),
             array(
                'id'       => 'h1_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Heading 1', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the H1 text properties.', 'respawn' ),
                'google'   => true,
                'all_styles'  => false,
                 'letter-spacing' => true,
                'fonts' =>  '',
                'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Montserrat',
			    ),
                'output'   => array('h1')
            ),

             array(
                'id'       => 'h2_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Heading 2', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the H2 text properties.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'fonts' =>  '',
                'all_styles'  => false,
                 'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Montserrat',
			    ),
                'output'   => array('h2')
            ),

              array(
                'id'       => 'h3_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Heading 3', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the H3 text properties.', 'respawn' ),
                'google'   => true,
                'all_styles'  => false,
                 'letter-spacing' => true,
                'fonts' =>  '',
                 'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Montserrat',
			    ),
                'output'   => array('h3')
            ),

            array(
                'id'       => 'h4_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Heading 4', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the H4 text properties.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'all_styles'  => false,
                'fonts' =>  '',
                 'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Montserrat',
			    ),
                'output'   => array('h4')
            ),

             array(
                'id'       => 'h5_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Heading 5', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the H5 text properties.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'all_styles'  => false,
                'fonts' =>  '',
                 'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Montserrat',
			    ),
                'output'   => array('h5')
            ),

            array(
                'id'       => 'h6_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Heading 6', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the H6 text properties.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'all_styles'  => false,
                'fonts' =>  '',
                'default'     => array(
                    'font-weight'  => '800',
                    'font-family' => 'Montserrat',
                ),
                'output'   => array('h6')
            ),

            array(
                'id'       => 'i_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Italic', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the italic text properties.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'all_styles'  => false,
                'fonts' =>  '',
                'default'     => array(
                    'font-weight'  => '300',
                    'font-family' => 'Montserrat',
                ),
                'output'   => array('i')
            ),
            array(
                'id'       => 'strong_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Strong', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the strong text properties.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'all_styles'  => false,
                'fonts' =>  '',
                'default'  => array(),
                'output'   => array('strong')
            ),

             array(
                'id'       => 'label_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Form Labels', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the form label properties.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'all_styles'  => false,
                'fonts' =>  '',
                'default'  => array(),
                'output'   => array('label')
            ),

        )
    ) );

	 Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Other elements', 'respawn' ),
        'id'               => 'typography-other',
        'subsection'       => true,
        'fields'           => array(
			array(
                'id'       => 'widget_title_font_family',
                'type'     => 'typography',
                'title'    => esc_html__( 'Widget Title', 'respawn' ),
                'subtitle' => esc_html__( 'Specify the widget title properties.', 'respawn' ),
                'google'   => true,
                'all_styles'  => false,
                 'letter-spacing' => true,
                'fonts' =>  '',
                'default'  => array(),
                'output'   => array('.widget > h4,.meminfo h2')
            ),
	 )
    ) );


    #************************************************
    # Home slider
    #************************************************
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Home slider', 'respawn' ),
        'id'               => 'home-slider',
        'customizer_width' => '450px',
        'icon'             => 'fas fa-heading',
        'fields'           => array(

        )
    ) );

    $post_categories = get_categories(array(
        'orderby' => 'name',
        'order'   => 'ASC'
    ));
    $final_cats = array();
    $final_cats[99999] = esc_html__('All', 'respawn');
    foreach($post_categories as $post_category){
        $final_cats[$post_category->term_id] = $post_category->name;
    }

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Settings', 'respawn' ),
        'id'               => 'home-slider-use',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'home_slider_categories',
                'type'     => 'checkbox',
                'title'    => esc_html__('Post Categories', 'respawn'),
                'subtitle' => esc_html__('Choose post categories you want to show', 'respawn'),
                //Must provide key => value pairs for multi checkbox options
                'options'  => $final_cats,
                'default' => '99999',
            ),
            array(
                'id' => 'slider-number-posts',
                'type' => 'text',
                'title' => esc_html__('Number Of Posts', 'respawn'),
                'subtitle' => esc_html__('Choose number of posts you want to show in slider.', 'respawn'),
                'validate' => 'numeric',
                'default' => 5
            ),
            array(
                'id' => 'slider-post-order',
                'type' => 'select',
                'title' => esc_html__('Post Order', 'respawn'),
                'subtitle' => esc_html__('Choose order of posts in slider.', 'respawn'),
                'options' => array(
                    "ASC" => esc_html__("Asc", 'respawn'),
                    "DESC" => esc_html__("Desc", 'respawn'),
                ),
                'default' => 'ASC',
            ),
            array(
                'id' => 'slider-post-orderby',
                'type' => 'select',
                'title' => esc_html__('Post Order By', 'respawn'),
                'subtitle' => esc_html__('Choose order by of posts in slider.', 'respawn'),
                'options' => array(
                    "none" => esc_html__("None", 'respawn'),
                    "ID" => esc_html__("ID", 'respawn'),
                    "author" => esc_html__("Author", 'respawn'),
                    "title" => esc_html__("Title", 'respawn'),
                    "name" => esc_html__("Name", 'respawn'),
                    "date" => esc_html__("Date", 'respawn'),
                    "rand" => esc_html__("Random", 'respawn'),
                ),
                'default' => 'ASC',
            ),
        )
    ) );



    #************************************************
	# WooCommerce
	#************************************************

	global $woocommerce;
    if ($woocommerce) {

         Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'WooCommerce', 'respawn' ),
        'id'               => 'woocommerce',
        'desc'             => esc_html__( 'All WooCommerce related options are listed here', 'respawn' ),
        'customizer_width' => '400px',
        'icon'             => 'fas fa-shopping-cart',
        'fields' => array()
        )
		);


		 Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Woo General Settings', 'respawn' ),
        'id'               => 'woo-functionality',
        'subsection'       => true,
        'fields'           => array(

                    array(
                        'id' => 'enable_cart',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Cart In Nav', 'respawn'),
                        'sub_desc' => esc_html__('This will add a cart item to your main navigation.', 'respawn'),
                        'desc' => '',
                        'default' => true
                    ),
					array(
		                'id' => 'cart_in_woo_pages',
		                'type' => 'checkbox',
		                'title' => esc_html__('Show Cart In WooCommerce Pages', 'respawn'),
		                'subtitle' => esc_html__('Do you want to display shopping cart only in WooCoomerce pages?', 'respawn'),
		                'desc' => '',
		                'default' => '0',
		                'required' => array( 'enable_cart', '=', '1' ),
		            ),
		            	array(
			                'id' => 'woo_shoping_cart_bck_color',
			                'type' => 'color',
			                'title' => esc_html__('Shopping Cart Background Color', 'respawn'),
			                'subtitle' => esc_html__('Please select the background color for shopping cart.', 'respawn'),
			                'desc' => '',
			                'transparent' => false,
			                 'output' => array('background-color' => '.cart-notification,.widget_shopping_cart,.woocommerce .cart-notification'),
			            ),

								array(
			                'id' => 'woo_shoping_cart_font_color',
			                'type' => 'color',
			                'title' => esc_html__('Shopping Cart Font Color', 'respawn'),
			                'subtitle' => esc_html__('Please select the font color for shopping cart.', 'respawn'),
			                'desc' => '',
			                'transparent' => false,
			                 'output' => array('color' => '.cart-notification, .widget_shopping_cart, .woocommerce .cart-notification'),
			            ),
        )
    ) );
				 Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Layout', 'respawn' ),
        'id'               => 'woo-layout',
        'subsection'       => true,
        'fields'           => array(

				  array(
                        'id' => 'main_shop_layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Main Shop Page Layout', 'respawn'),
                        'sub_desc' => esc_html__('Choose page layout that you want to use on main WooCommerce page.', 'respawn'),
                        'options' => array(
                                        'no-sidebar' => array('title' => esc_html__('No Sidebar', 'respawn'), 'img' => get_theme_file_uri('assets/img/redux/full.png')),
                                        'right-sidebar' => array('title' => esc_html__('Right Sidebar', 'respawn'), 'img' => get_theme_file_uri('assets/img/redux/right.png')),
                                        'left-sidebar' => array('title' => esc_html__('Left Sidebar','respawn' ), 'img' => get_theme_file_uri('assets/img/redux/left.png'))
                                    ),
                        'default' => 'right-sidebar'
                    ),
                    array(
                        'id' => 'single_product_layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Single Product Page Layout', 'respawn'),
                        'sub_desc' => esc_html__('Choose page layout that you want to use on single product WooCommerce page.', 'respawn'),
                        'options' => array(
                                        'no-sidebar' => array('title' => esc_html__('No Sidebar', 'respawn'), 'img' => get_theme_file_uri('assets/img/redux/full.png')),
                                        'right-sidebar' => array('title' => esc_html__('Right Sidebar', 'respawn'), 'img' => get_theme_file_uri('assets/img/redux/right.png')),
                                        'left-sidebar' => array('title' => esc_html__('Left Sidebar','respawn' ), 'img' => get_theme_file_uri('assets/img/redux/left.png'))
                                    ),
                        'default' => 'right-sidebar'
                    ),

		    )
    ) );

}


	#************************************************
	# Footer
	#************************************************

     Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Footer', 'respawn' ),
        'id'     => 'footer',
        'desc'   => esc_html__( 'All footer related options are listed here.', 'respawn' ),
        'icon'   => 'fas fa-columns',
        'fields' => array(
          )
    ) );


		Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer General Settings', 'respawn' ),
        'id'               => 'footer-general',
        'subsection'       => true,
        'fields'           => array(
             array(
                'id' => 'top_footer_area',
                'type' => 'switch',
                'title' => esc_html__('Main Footer Area', 'respawn'),
                'subtitle' => esc_html__('Turn this option on to use main footer area.', 'respawn'),
                'desc' => '',
                'default' => true
            ),
             array(
                'id' => 'footer_columns',
                'type' => 'image_select',
                'title' => esc_html__('Footer Columns', 'respawn'),
                'subtitle' => esc_html__('Please select the number of columns you would like for your footer.', 'respawn'),
                'options' => array(
                                '1' => array('title' => esc_html__('1 Column', 'respawn'), 'img' => get_theme_file_uri('assets/img/1col.png')),
                                '2' => array('title' => esc_html__('2 Columns', 'respawn'), 'img' => get_theme_file_uri('assets/img/2col.png')),
                                '3' => array('title' => esc_html__('3 Columns', 'respawn'), 'img' => get_theme_file_uri('assets/img/3col.png')),
                                '4' => array('title' => esc_html__('4 Columns', 'respawn'), 'img' => get_theme_file_uri('assets/img/4col.png'))
                            ),
                'default' => '4',
                'required' => array( 'top_footer_area', '=', '1' ),
            ),

             array(
                'id' => 'top_footer_area_image',
                'type' => 'media',
                'title' => esc_html__('Main Footer Area Background Image', 'respawn'),
                'subtitle' => esc_html__('Add main footer area background image.', 'respawn'),
                'required' => array( 'top_footer_area', '=', '1' ),
            ),
            array(
                'id' => 'top_footer_area_image_repeat',
                'type' => 'select',
                'required' => array( 'top_footer_area_image', '!=', '' ),
                'title' => esc_html__('Main Footer Area Background Image Repeat', 'respawn'),
                'subtitle' => esc_html__('Choose main footer area background image repeat.', 'respawn'),
                 'options' => array(
                    "repeat" => esc_html__("Repeat", 'respawn'),
                    "norepeat" => esc_html__("No Repeat", 'respawn'),
                    "cover" => esc_html__("Cover", 'respawn'),
                ),
                'default' => 'cover',
                'required' => array( 'top_footer_area', '=', '1' ),

            ),
             array(
                'id' => 'top_footer_area_color',
                'type' => 'color',
                'title' => esc_html__('Main Footer Area Color', 'respawn'),
                'subtitle' => esc_html__('Select background color for main footer area.', 'respawn'),
                'output' => array('background-color' => '.main_footer'),
                'transparent' => false,
                'required' => array( 'top_footer_area', '=', '1' ),
                'default' => '#202329'
            ),
            array(
                'id' => 'top_footer_area_top_padding',
                'type' => 'text',
                'title' => esc_html__('Main Footer Area Top Padding', 'respawn'),
                'subtitle' => esc_html__('Choose desired padding. Don\'t include "px" in the string. e.g. 30.', 'respawn'),
                'validate' => 'numeric',
                'required' => array( 'top_footer_area', '=', '1' ),
                 'default' => 70
            ),
            array(
                'id' => 'top_footer_area_bottom_padding',
                'type' => 'text',
                'title' => esc_html__('Main Footer Area Bottom Padding', 'respawn'),
                'subtitle' => esc_html__('Choose desired padding. Don\'t include "px" in the string. e.g. 30.', 'respawn'),
                'validate' => 'numeric',
                'required' => array( 'top_footer_area', '=', '1' ),
                'default' => 70
            ),
            array(
                'id' => 'bottom_footer_area',
                'type' => 'switch',
                'title' => esc_html__('Sub Footer Area', 'respawn'),
                'subtitle' => esc_html__('Turn this option on to use sub footer area.', 'respawn'),
                'desc' => '',
                'default' => true
            ),
			array(
                'id' => 'bottom_footer_area_color',
                'type' => 'color',
                'title' => esc_html__('Sub Footer Area Color', 'respawn'),
                'subtitle' => esc_html__('Select background color for sub footer area.', 'respawn'),
                'output' => array('background-color' => '.footer_bottom'),
                'transparent' => false,
                'required' => array( 'bottom_footer_area', '=', '1' ),
                'default' => '#282d33'
            ),


            array(
                'id' => 'footer-copyright-text',
                'type' => 'text',
                'title' => esc_html__('Footer Copyright Section Text', 'respawn'),
                'subtitle' => esc_html__('Please enter the copyright section text. e.g. All Rights Reserved, Respawn Inc.', 'respawn'),
                'required' => array( 'bottom_footer_area', '=', '1' ),
            ),

			 array(
                'id' => 'enable_social_in_footer',
                'type' => 'switch',
                'title' => esc_html__('Enable Social Icons?', 'respawn'),
                'subtitle' => esc_html__('Do you want the secondary nav to display social icons?', 'respawn'),
                'desc' => '',
                'default' => false,
                'required' => array( 'bottom_footer_area', '=', '1' ),
            ),

        )
    ) );


	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Typography', 'respawn' ),
        'id'               => 'footer-typography',
        'subsection'       => true,
        'fields'           => array(



	 array(
                'id'       => 'footer-typography-header',
                'type'     => 'typography',
                'title'    => esc_html__( 'Footer Widget Areas Font', 'respawn' ),
                'subtitle' => esc_html__( 'Specify footer widget areas font properties.', 'respawn' ),
                'google'   => true,
                'all_styles'  => false,
                 'letter-spacing' => true,
                'default'  => array(),
                'output'    => array('body footer .widget > h4')

            ),
		 array(
                'id'       => 'footer-typography-general',
                'type'     => 'typography',
                'title'    => esc_html__( 'Footer General Font', 'respawn' ),
                'subtitle' => esc_html__( 'Specify general font properties for footer.', 'respawn' ),
                'google'   => true,
                 'letter-spacing' => true,
                'all_styles'  => false,
                'default'  => array(),
                'output'    => array('body footer')
            ),
		 array(
                'id' => 'footer-typography-color',
                'type' => 'color',
                'title' => esc_html__('Subfooter Font Color', 'respawn'),
                'subtitle' => esc_html__('Select font color for subfooter area.', 'respawn'),
                'output' => array('color' => '.footer_bottom .fb_text, .footer_bottom .fb_social a'),
                'transparent' => false
            ),

	   )
    ) );


    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Shape Divider', 'respawn' ),
        'id'               => 'shape-divider',
        'subsection'       => true,
        'fields'           => array(



            array(
                'id'       => 'shape-type',
                'type'     => 'select',
                'title'    => esc_html__( 'Type', 'respawn' ),
                'subtitle' => esc_html__( 'Choose shape type.', 'respawn' ),
                'options' => array(
                    "none" => esc_html__("None", 'respawn'),
                    "mountains" => esc_html__("Mountains", 'respawn'),
                    "drops" => esc_html__("Drops", 'respawn'),
                    "clouds" => esc_html__("Clouds", 'respawn'),
                    "zigzag" => esc_html__("Zigzag", 'respawn'),
                    "pyramids" => esc_html__("Pyramids", 'respawn'),
                    "triangle" => esc_html__("Triangle", 'respawn'),
                    "triangle-asymmetrical" => esc_html__("Triangle Asymmetrical", 'respawn'),
                    "tilt" => esc_html__("Tilt", 'respawn'),
                    "opacity-tilt" => esc_html__("Tilt Opacity", 'respawn'),
                    "opacity-fan" => esc_html__("Fan Opacity", 'respawn'),
                    "curve-asymmetrical" => esc_html__("Curve Asymmetrical", 'respawn'),
                    "waves" => esc_html__("Waves", 'respawn'),
                    "wave-brush" => esc_html__("Waves Brush", 'respawn'),
                    "waves-pattern" => esc_html__("Waves Pattern", 'respawn'),
                    "arrow" => esc_html__("Arrow", 'respawn'),
                    "split" => esc_html__("Split", 'respawn'),
                    "book" => esc_html__("Book", 'respawn'),
                ),
                'default' => 'none',

            ),
            array(
                'id' => 'shape-color',
                'type' => 'color',
                'title' => esc_html__('Color', 'respawn'),
                'subtitle' => esc_html__('Select shape color.', 'respawn'),
                'transparent' => false
            ),

            array(
                'id' => 'shape-height',
                'type' => 'slider',
                'title' => esc_html__('Height', 'respawn'),
                'subtitle' => esc_html__('Choose shape height.', 'respawn'),
                'min' => 100,
                'max' => 500,
                'step' => 1,
            ),

            array(
                'id' => 'shape-front',
                'type' => 'switch',
                'title' => esc_html__('Bring to Front', 'respawn'),
                'subtitle' => esc_html__('Turn this on to bring the shape to the front.', 'respawn'),
                'desc' => '',
                'default' => true
            ),

        )
    ) );

	#************************************************
	# Blog
	#************************************************

 Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Blog', 'respawn' ),
        'id'               => 'blog',
        'desc'             => esc_html__( 'All blog options are listed here.', 'respawn' ),
        'customizer_width' => '400px',
        'icon'             => 'fas fa-list-ul',
        'fields' => array(

        )
    ) );


Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Blog Feed', 'respawn' ),
        'id'               => 'blog-feed',
        'subsection'       => true,
        'fields'           => array(

              array(
			'type' => 'select',
			'id'     => 'blog-feed-template',
		    'title' => esc_html__('Blog Page Template', 'respawn'),
		    'subtitle' => esc_html__('Choose desired page template.', 'respawn'),
		    'options' => array(
	                "standard_right" => esc_html__("Standard Right Sidebar", 'respawn'),
	                "standard_left" => esc_html__("Standard Left Sidebar", 'respawn'),
	                "standard_full" => esc_html__("Standard Full Width", 'respawn'),
	                "masonry_right" => esc_html__("Masonry Right Sidebar", 'respawn'),
	                "masonry_left" => esc_html__("Masonry Left Sidebar", 'respawn'),
	                "masonry_full" => esc_html__("Masonry Full Width", 'respawn'),


	            ),
			'default' => 'standard_right',
			 ),

			 array(
			'type' => 'select',
			'id'     => 'blog-feed-post-effect',
		    'title' => esc_html__('Posts Animation', 'respawn'),
		    'subtitle' => esc_html__('Choose post appearing effect.', 'respawn'),
		    'options' => array(
		    	"none" => "None",
                "effect_1" => esc_html__("Fade In", 'respawn'),
                 "effect_3" => esc_html__("Fade Up", 'respawn'),
                "effect_4" => esc_html__("Scale Up", 'respawn'),
                "effect_5" => esc_html__("Fly", 'respawn'),
                "effect_6" => esc_html__("Flip", 'respawn'),
                "effect_7" => esc_html__("Helics", 'respawn'),
                "effect_8" => esc_html__("Bounce", 'respawn'),
            ),
			'default' => 'effect_3',

			 ),


        )
    ) );


	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single Page', 'respawn' ),
        'id'               => 'post-single',
        'subsection'       => true,
        'fields'           => array(

              array(
                'id' => 'blog_single_type',
                'type' => 'image_select',
                'title' => esc_html__('Blog Single Layout Type', 'respawn'),
                'sub_desc' => esc_html__('Please select your blog single post format here.', 'respawn'),
                'options' => array(
                        'full-width' => array('title' => esc_html__('Full Width', 'respawn'), 'img' => get_theme_file_uri('assets/img/redux/full.png')),
                        'right-sidebar' => array('title' => esc_html__('Right Sidebar', 'respawn'), 'img' => get_theme_file_uri('assets/img/redux/right.png')),
                        'left-sidebar' => array('title' => esc_html__('Left Sidebar','respawn' ), 'img' => get_theme_file_uri('assets/img/redux/left.png'))
                            ),
                'default' => 'right-sidebar'
            ),


            array(
                'id' => 'post_social',
                'type' => 'switch',
                'title' => esc_html__('Social Media Sharing Buttons', 'respawn'),
                'subtitle' => esc_html__('Turn this on to enable social sharing buttons on your post single pages.', 'respawn'),
                'desc' => '',
                'default' => true
            ),

			array(
                'id' => 'post_author',
                'type' => 'switch',
                'title' => esc_html__('Show author section in single page', 'respawn'),
                'subtitle' => esc_html__('Turn this on to enable author section in single post page.', 'respawn'),
                'desc' => '',
                'default' => false
            ),
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Social Media', 'respawn' ),
        'id'               => 'social_media',
        'desc'             => esc_html__( 'Remember to include "https://" in all URLs!', 'respawn' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-share',
        'fields' => array(

            array(
                'id' => 'facebook-url',
                'type' => 'text',
                'title' => esc_html__('Facebook URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Facebook URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'twitter-url',
                'type' => 'text',
                'title' => esc_html__('Twitter URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Twitter URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'vimeo-url',
                'type' => 'text',
                'title' => esc_html__('Vimeo URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Vimeo URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'dribbble-url',
                'type' => 'text',
                'title' => esc_html__('Dribbble URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Dribbble URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'pinterest-url',
                'type' => 'text',
                'title' => esc_html__('Pinterest URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Pinterest URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'youtube-url',
                'type' => 'text',
                'title' => esc_html__('Youtube URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Youtube URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'tumblr-url',
                'type' => 'text',
                'title' => esc_html__('Tumblr URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Tumblr URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'linkedin-url',
                'type' => 'text',
                'title' => esc_html__('LinkedIn URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your LinkedIn URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'rss-url',
                'type' => 'text',
                'title' => esc_html__('RSS URL', 'respawn'),
                'subtitle' => esc_html__('If you have an external RSS feed such as Feedburner, please enter it here. Will use built in Wordpress feed if left blank.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'behance-url',
                'type' => 'text',
                'title' => esc_html__('Behance URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Behance URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'flickr-url',
                'type' => 'text',
                'title' => esc_html__('Flickr URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Flickr URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'spotify-url',
                'type' => 'text',
                'title' => esc_html__('Spotify URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Spotify URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'steam-url',
                'type' => 'text',
                'title' => esc_html__('Steam URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Steam URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'instagram-url',
                'type' => 'text',
                'title' => esc_html__('Instagram URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Instagram URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'github-url',
                'type' => 'text',
                'title' => esc_html__('GitHub URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your GitHub URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'stackexchange-url',
                'type' => 'text',
                'title' => esc_html__('StackExchange URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your StackExchange URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'soundcloud-url',
                'type' => 'text',
                'title' => esc_html__('SoundCloud URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your SoundCloud URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'vk-url',
                'type' => 'text',
                'title' => esc_html__('VK URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your VK URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'vine-url',
                'type' => 'text',
                'title' => esc_html__('Vine URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Vine URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'twitch-url',
                'type' => 'text',
                'title' => esc_html__('Twitch URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Twitch URL.', 'respawn'),
                'desc' => ''
            ),
            array(
                'id' => 'discord-url',
                'type' => 'text',
                'title' => esc_html__('Discord URL', 'respawn'),
                'subtitle' => esc_html__('Please enter your Discord URL.', 'respawn'),
                'desc' => ''
            )


        )
    ) );



    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'respawn' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'respawn' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }
