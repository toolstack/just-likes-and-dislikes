<?php

if (!class_exists('JLAD_Enqueue') ) {

    class JLAD_Enqueue
    {

        /**
         * Includes all the frontend and backend JS and CSS enqueues
         *
         * @since 1.0.0
         */
        function __construct()
        {
            add_action('wp_enqueue_scripts', array( $this, 'register_frontend_assets' ));
            add_action('admin_enqueue_scripts', array( $this, 'register_backend_assets' ));
        }

        function register_frontend_assets()
        {
            /**
             * Fontawesome 5 support
             *
             * @version 1.0.6
             */
            wp_enqueue_style('jlad-font-awesome', JLAD_CSS_DIR . '/fontawesome/css/all.min.css', array(), JLAD_VERSION);
            wp_enqueue_style('jlad-frontend', JLAD_CSS_DIR . '/jlad-frontend.css', array(), JLAD_VERSION);
            wp_enqueue_script('jlad-frontend', JLAD_JS_DIR . '/jlad-frontend.js', array( 'jquery' ), JLAD_VERSION);
            $ajax_nonce = wp_create_nonce('jlad-ajax-nonce');

            $js_object = array( 'admin_ajax_url' => admin_url('admin-ajax.php'), 'admin_ajax_nonce' => $ajax_nonce );
            wp_localize_script('jlad-frontend', 'jlad_js_object', $js_object);
        }

        function register_backend_assets( $hook )
        {
            wp_enqueue_style('jlad-font-awesome', JLAD_CSS_DIR . '/fontawesome/css/all.min.css', array(), JLAD_VERSION);
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_media();
            wp_enqueue_style('jlad-admin-css', JLAD_CSS_DIR . '/jlad-backend.css', array(), JLAD_VERSION);
            wp_enqueue_script('jlad-admin-js', JLAD_JS_DIR . '/jlad-backend.js', array( 'jquery', 'wp-color-picker' ), JLAD_VERSION);
            $ajax_nonce = wp_create_nonce('jlad-backend-ajax-nonce');
            $messages = array( 'wait' => __('Please wait', 'just-likes-and-dislikes'), 'restore_confirm' => __('Are you sure you want to restore default settings?', 'just-likes-and-dislikes') );
            $js_object = array( 'admin_ajax_url' => admin_url('admin-ajax.php'), 'admin_ajax_nonce' => $ajax_nonce, 'messages' => $messages );
            wp_localize_script('jlad-admin-js', 'jlad_admin_js_object', $js_object);
        }

    }

    new JLAD_Enqueue();
}