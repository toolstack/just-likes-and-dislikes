<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!!' );

if ( !class_exists( 'PLD_Admin' ) ) {

    class PLD_Admin extends PLD_Library {

        function __construct() {
            parent::__construct();
            add_action( 'admin_menu', array( $this, 'pld_admin_menu' ) );

            /**
             * Plugin Settings link in plugins screen
             *
             */
            add_filter( 'plugin_action_links_' . PLD_BASENAME, array( $this, 'add_setting_link' ) );

            /**
             * Settings save action
             */
            add_action( 'wp_ajax_pld_settings_save_action', array( $this, 'save_settings' ) );
            add_action( 'wp_ajax_nopriv_pld_settings_save_action', array( $this, 'no_permission' ) );

            /**
             * Settings restore action
             */
            add_action( 'wp_ajax_pld_settings_restore_action', array( $this, 'restore_settings' ) );
            add_action( 'wp_ajax_nopriv_pld_settings_restore_action', array( $this, 'no_permission' ) );
        }

        function pld_admin_menu() {
            add_options_page( __( 'Posts Like Dislike', 'posts-like-dislike' ), __( 'Posts Like Dislike', 'posts-like-dislike' ), 'manage_options', 'posts-like-dislike', array( $this, 'pld_settings' ) );
        }

        function pld_settings() {
            include(PLD_PATH . 'inc/views/backend/settings.php');
        }

        function save_settings() {
            if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'pld-backend-ajax-nonce' ) ) {
                $_POST = stripslashes_deep( $_POST );
                parse_str( $_POST['settings_data'], $settings_data );
                foreach ( $settings_data['pld_settings'] as $key => $val ) {
                    $pld_settings[$key] = array_map( 'sanitize_text_field', $val );
                }
                /**
                 * Fires before storing the settings array into database
                 *
                 * @param type array $settings_data - before sanitization
                 * @param type array $pld_settings - after sanitization
                 *
                 * @since 1.0.0
                 */
                do_action( 'pld_before_save_settings', $settings_data, $pld_settings );

                /**
                 * Filters the settings stored in the database
                 *
                 * @param type array $pld_settings
                 *
                 * @since 1.0.0
                 */
                update_option( 'pld_settings', apply_filters( 'pld_settings', $pld_settings ) );
                die( __( 'Settings saved successfully', PLD_TD ) );
            } else {
                die( 'No script kiddies please!!' );
            }
        }

        function no_permission() {
            die( 'No script kiddies please!!' );
        }

        function restore_settings() {
            $default_settings = $this->get_default_settings();
            update_option( 'pld_settings', $default_settings );
            die( __( 'Settings restored successfully.Redirecting...', PLD_TD ) );
        }

        /**
         * Adds settings link
         *
         * @since 1.0.0
         */
        function add_setting_link( $links ) {
            $settings_link = array(
                '<a href="' . admin_url( 'options-general.php?page=posts-like-dislike' ) . '">' . __( 'Settings', PLD_TD ) . '</a>',
            );
            return array_merge( $links, $settings_link );
        }

    }

    new PLD_Admin();
}
