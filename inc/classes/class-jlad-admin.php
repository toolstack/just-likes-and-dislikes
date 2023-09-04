<?php

defined('ABSPATH') or die(__('No script kiddies please!!', 'just-likes-and-dislikes'));

if (!class_exists('JLAD_Admin')) {

    class JLAD_Admin extends JLAD_Library
    {

        function __construct()
        {
            parent::__construct();
            add_action('admin_menu', array($this, 'jlad_admin_menu'));

            /**
             * Plugin Settings link in plugins screen
             */
            add_filter('plugin_action_links_' . JLAD_BASENAME, array($this, 'add_setting_link'));

            /**
             * Count Info Meta Box for Posts
             */
            add_action('add_meta_boxes', array($this, 'render_count_info_metabox_posts'));

            /**
             * Count Info Meta Box for Comments
             */
            add_action('add_meta_boxes', array($this, 'render_count_info_metabox_comments'));

            /**
             * Save posts like dislike meta box
             */
            add_action('save_post', array($this, 'save_jlad_metabox'));
        }

        function jlad_admin_menu()
        {
            add_options_page(_x('Just Likes and Dislikes', 'Page Title', 'just-likes-and-dislikes'), _x('Just Likes and Dislikes', 'Menu Title', 'just-likes-and-dislikes'), 'manage_options', 'just-likes-and-dislikes', array($this, 'jlad_settings'));
        }

        function jlad_settings()
        {
            // Save the settings before loading the rest of the page.
            $this->save_settings();

            include JLAD_PATH . 'inc/views/backend/settings.php';
        }

        function save_settings()
        {
            // Make sure we have a valid nounce.
            if( isset($_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'just-likes-and-dislikes-options' ) && current_user_can( 'manage_options' ) ) {
                // Check to make sure we have an array and it has both settings types.
                if( is_array( $_POST['jlad_settings'] ) && ( ! array_key_exists('basic_settings', $_POST['jlad_settings'] ) && ! array_key_exists('design_settings', $_POST['jlad_settings'] ) ) ) {

                    return;
                }

                // Setup our settings array.
                $jlad_settings['basic_settings'] = array();
                $jlad_settings['design_settings'] = array();

                // Setup all the subkeys without setting any values, avoids any array key missing warnings.
                $jlad_settings = $this->merge_settings_and_defaults_keys( $jlad_settings, null );

                // Get the post types to validate against.
                $post_types_objects = get_post_types(array('public' => true), 'object');

                foreach( $post_types_objects as $pt ) {
                    $post_types[] = $pt->name;
                }

                // Validate each setting that's been passed in for the basic settings page.
                foreach( $_POST['jlad_settings']['basic_settings'] as $key => $value ) {
                    switch( $key ) {
                        case 'status':
                        case 'display_zero':
                        case 'hide_counter_info_metabox':
                        case 'hide_like_dislike_admin':
                            if( intval($_POST['jlad_settings']['basic_settings'][$key] ) == 1 ) { $jlad_settings['basic_settings'][$key] = 1; } else { $jlad_settings['basic_settings'][$key] = ''; }
                            break;
                        case 'login_link':
                            $jlad_settings['basic_settings'][$key] = sanitize_text_field( $_POST['jlad_settings']['basic_settings'][$key] );
                            break;
                        case 'display_order':
                            if( $_POST['jlad_settings']['basic_settings'][$key] == 'like-dislike' ) { $jlad_settings['basic_settings'][$key] = 'like-dislike'; } else { $jlad_settings['basic_settings'][$key] = 'dislike-like'; }
                            break;
                        case 'like_dislike_position':
                            if( $_POST['jlad_settings']['basic_settings'][$key] == 'after' ) { $jlad_settings['basic_settings'][$key] = 'after'; } else { $jlad_settings['basic_settings'][$key] = 'before'; }
                            break;
                        case 'post_types':
                            if( is_array( $_POST['jlad_settings']['basic_settings'][$key] ) ) {
                                $jlad_settings['basic_settings'][$key] = array();
                                foreach( $_POST['jlad_settings']['basic_settings'][$key] as $post_type ) {
                                    $pt = array_search( $post_type, $post_types );
                                    if( $pt != false ) { $jlad_settings['basic_settings'][$key][] = $post_types[$pt]; };
                                }
                            }
                            break;
                        case 'like_dislike_display':
                            switch( $_POST['jlad_settings']['basic_settings'][$key] ) {
                                case 'like_only':
                                    $jlad_settings['basic_settings'][$key] = 'like_only';
                                    break;
                                case 'dislike_only':
                                    $jlad_settings['basic_settings'][$key] = 'dislike_only';
                                    break;
                                default:
                                    $jlad_settings['basic_settings'][$key] = 'both';
                            }

                            break;
                        case 'like_dislike_resistriction':
                            switch( $_POST['jlad_settings']['basic_settings'][$key] ) {
                                case 'cookie':
                                    $jlad_settings['basic_settings'][$key] = 'cookie';
                                    break;
                                case 'ip':
                                    $jlad_settings['basic_settings'][$key] = 'ip';
                                    break;
                                case 'user':
                                    $jlad_settings['basic_settings'][$key] = 'user';
                                    break;
                                default:
                                    $jlad_settings['basic_settings'][$key] = 'no';
                            }

                            break;
                        case 'like_hover_text':
                        case 'dislike_hover_text':
                            $jlad_settings['basic_settings'][$key] = sanitize_text_field( $_POST['jlad_settings']['basic_settings'][$key] );
                            break;
                    }
                }

                // Get the list of templates to validate against.
                $templates = $this->get_template_names();

                // Validate each setting that's been passed in for the design settings page.
                foreach( $_POST['jlad_settings']['design_settings'] as $key => $value ) {
                    switch( $key ) {
                        case 'template':
                            if( array_key_exists( $_POST['jlad_settings']['design_settings'][$key], $templates ) ) { $jlad_settings['design_settings'][$key] = sanitize_text_field( $_POST['jlad_settings']['design_settings'][$key] ); }
                            break;
                        case 'like_icon':
                        case 'dislike_icon':
                            $jlad_settings['design_settings'][$key] = sanitize_text_field( $_POST['jlad_settings']['design_settings'][$key] );
                            break;
                        case 'icon_color':
                        case 'count_color':
                            $jlad_settings['design_settings'][$key] = sanitize_text_field( $_POST['jlad_settings']['design_settings'][$key] );

                            break;
                    }
                }

                // Store the new settings in the database.
                update_option('jlad_settings', $jlad_settings);

                // Reset the class's settings to the new settings.
                $this->jlad_settings = $jlad_settings;
            }
        }

        function no_permission()
        {
            die('No script kiddies please!!');
        }

        function restore_settings()
        {
            $default_settings = $this->get_default_settings();
            update_option('jlad_settings', $default_settings);
            die(__('Settings restored successfully.Redirecting...', 'just-likes-and-dislikes'));
        }

        /**
         * Adds settings link
         *
         * @since 1.0.0
         */
        function add_setting_link($links)
        {
            $settings_link = array(
                '<a href="' . admin_url('options-general.php?page=just-likes-and-dislikes') . '">' . __('Settings', 'just-likes-and-dislikes') . '</a>',
            );
            return array_merge($links, $settings_link);
        }

        function render_count_info_metabox_posts()
        {
            $jlad_settings = $this->jlad_settings;

            // If the metabox has been disabled in settings, just return now.
            if( $jlad_settings['basic_settings']['hide_counter_info_metabox'] == '1' ) {
                return;
            }

            // Get the list of available post types.
            $available_post_types = get_post_types(array('public' => true), 'names');

            // Get the list of excluded post types.
            $post_types = (!empty($jlad_settings['basic_settings']['post_types'])) ? $jlad_settings['basic_settings']['post_types'] : array();

            // Remove the disabled post types from the available list.
            foreach( $post_types as $key => $value ) {
                unset( $available_post_types[$value] );
            }

            // Show the metabox if we have any post types left.
            if ( ! empty($available_post_types)) {
                add_meta_box('jlad-count-info', esc_html_x('Just Likes and Dislikes', 'Metabox Title', 'just-likes-and-dislikes'), array($this, 'render_posts_count_info_html'), $available_post_types, 'normal');
            }
        }

        function render_count_info_metabox_comments()
        {
            if (empty($this->jlad_settings['basic_settings']['hide_counter_info_metabox'])) {
                add_meta_box('jlad-count-info', esc_html_x('Just Likes and Dislikes', 'Metabox Title', 'just-likes-and-dislikes'), array($this, 'render_comments_count_info_html'), 'comment', 'normal');
            }
        }

        function render_posts_count_info_html($post)
        {
            $post_id = $post->ID;
            $like_count = get_post_meta($post_id, 'jlad_like_count', true);
            $dislike_count = get_post_meta($post_id, 'jlad_dislike_count', true);
            include JLAD_PATH . '/inc/views/backend/metabox.php';
        }

        function render_comments_count_info_html($comment)
        {
            $comment_id = $comment->comment_ID;
            $like_count = get_comment_meta($comment_id, 'jlad_like_count', true);
            $dislike_count = get_comment_meta($comment_id, 'jlad_dislike_count', true);
            include JLAD_PATH . '/inc/views/backend/metabox.php';
        }

        function save_jlad_metabox($post_id)
        {
            $nonce_name = isset($_POST['jlad_metabox_nonce_field']) ? $_POST['jlad_metabox_nonce_field'] : '';
            $nonce_action = 'jlad_metabox_nonce';

            // Check if nonce is valid.
            if (!wp_verify_nonce($nonce_name, $nonce_action)) {
                return;
            }

            // Check if user has permissions to save data.
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }

            // Check if not an autosave.
            if (wp_is_post_autosave($post_id)) {
                return;
            }

            // Check if not a revision.
            if (wp_is_post_revision($post_id)) {
                return;
            }
            if (isset($_POST['jlad_like_count'], $_POST['jlad_dislike_count'])) {
                $jlad_like_count = sanitize_text_field($_POST['jlad_like_count']);
                $jlad_dislike_count = sanitize_text_field($_POST['jlad_dislike_count']);
                update_post_meta($post_id, 'jlad_like_count', $jlad_like_count);
                update_post_meta($post_id, 'jlad_dislike_count', $jlad_dislike_count);
            } else {
                return;
            }
        }

    }

    new JLAD_Admin();
}
