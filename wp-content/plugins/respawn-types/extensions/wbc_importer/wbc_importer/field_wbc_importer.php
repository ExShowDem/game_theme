<?php
/**
 * Extension-Boilerplate
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_wbc_importer' ) ) {

    /**
     * Main ReduxFramework_wbc_importer class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wbc_importer {

        /**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            $class = ReduxFramework_extension_wbc_importer::get_instance();

            if ( !empty( $class->demo_data_dir ) ) {
                $this->demo_data_dir = $class->demo_data_dir;
                $this->demo_data_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->demo_data_dir ) );
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }
        }

        /**
         * Field Render Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            echo '</fieldset></td></tr><tr><td colspan="2"><fieldset class="redux-field wbc_importer">';

            $nonce = wp_create_nonce( "redux_{$this->parent->args['opt_name']}_wbc_importer" );

            // No errors please
            $defaults = array(
                'id'        => '',
                'url'       => '',
                'width'     => '',
                'height'    => '',
                'thumbnail' => '',
            );

            $this->value = wp_parse_args( $this->value, $defaults );

            $imported = false;

            $this->field['wbc_demo_imports'] = apply_filters( "redux/{$this->parent->args['opt_name']}/field/wbc_importer_files", array() );

            echo '<div class="theme-browser"><div class="themes">';

            if ( !empty( $this->field['wbc_demo_imports'] ) ) {

                foreach ( $this->field['wbc_demo_imports'] as $section => $imports ) {

                    if ( empty( $imports ) ) {
                        continue;
                    }

                    if ( !array_key_exists( 'imported', $imports ) ) {
                        $extra_class = 'not-imported';
                        $imported = false;
                        //$import_message = esc_html__( 'Import Demo', 'respawn' );
                    }else {
                        $imported = true;
                        $extra_class = 'active imported';
                        //$import_message = esc_html__( 'Demo Imported', 'respawn' );
                    }

					if(esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) == 'Esports'){
						$view_demo = '<a id="demo_link" target="_blank" href="https://skywarriorthemes.com/respawn/">'.esc_html__( 'View Demo', 'respawn' ).'</a>';
					}elseif(esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) == 'Magazine'){
						$view_demo = '<a id="demo_link"  target="_blank" href="https://skywarriorthemes.com/respawn/homepage-magazine/">'.esc_html__( 'View Demo', 'respawn' ).'</a>';
					}elseif(esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) == 'Event'){
						$view_demo = '<a id="demo_link"  target="_blank" href="https://skywarriorthemes.com/respawn/event-home/">'.esc_html__( 'View Demo', 'respawn' ).'</a>';
					}elseif(esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) == 'Player'){
						$view_demo = '<a id="demo_link"  target="_blank" href="https://skywarriorthemes.com/respawn/player-home/">'.esc_html__( 'View Demo', 'respawn' ).'</a>';
					}elseif(esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) == 'Shop'){
						$view_demo = '<a id="demo_link"  target="_blank" href="https://skywarriorthemes.com/respawn/shop-home/">'.esc_html__( 'View Demo', 'respawn' ).'</a>';
					}elseif(esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) == 'Streamer'){
						$view_demo = '<a id="demo_link"  target="_blank" href="https://skywarriorthemes.com/respawn/streamer-home">'.esc_html__( 'View Demo', 'respawn' ).'</a>';
					}elseif(esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) == 'Matches'){
						$view_demo = '<a id="demo_link"  target="_blank" href="https://skywarriorthemes.com/respawn/matches-home">'.esc_html__( 'View Demo', 'respawn' ).'</a>';
					}

                    echo '<div class="wrap-importer theme '.$extra_class.'" data-demo-id="'.esc_attr( $section ).'"  data-nonce="' . $nonce . '" id="' . $this->field['id'] . '-custom_imports">';

                    echo '<div class="theme-screenshot">';

                    if ( isset( $imports['image'] ) ) {
                        echo '<img class="wbc_image" src="'.esc_attr( esc_url( $this->demo_data_url.$imports['directory'].'/'.$imports['image'] ) ).'"/>';

                    }
                    echo '</div>';

                    echo '<span class="more-details">'.$view_demo.'</span>';
                    echo '<h3 class="theme-name">'. esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) .'</h3>';

                    echo '<div class="theme-actions">';
                    if ( false == $imported ) {
                        echo '<div class="wbc-importer-buttons"><span class="spinner">'.esc_html__( 'Please Wait...', 'respawn' ).'</span><span class="button-primary importer-button import-demo-data">' . __( 'Import Demo', 'respawn' ) . '</span></div>';
                    }else {
                        echo '<div class="wbc-importer-buttons button-secondary importer-button">'.esc_html__( 'Imported', 'respawn' ).'</div>';
                        echo '<span class="spinner">'.esc_html__( 'Please Wait...', 'respawn' ).'</span>';
                        echo '<div id="wbc-importer-reimport" class="wbc-importer-buttons button-primary import-demo-data importer-button">'.esc_html__( 'Re-Import', 'respawn' ).'</div>';
                    }
                    echo '</div>';
                    echo '</div>';


                }

            } else {
                echo "<h5>".esc_html__( 'No Demo Data Provided', 'respawn' )."</h5>";
            }

            echo '</div></div>';
            echo '</fieldset></td></tr>';

        }

        /**
         * Enqueue Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            $min = Redux_Functions::isMin();

            wp_enqueue_script(
                'redux-field-wbc-importer-js',
                $this->extension_url . '/field_wbc_importer' . $min . '.js',
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-wbc-importer-css',
                $this->extension_url . 'field_wbc_importer.css',
                time(),
                true
            );

        }
    }
}
