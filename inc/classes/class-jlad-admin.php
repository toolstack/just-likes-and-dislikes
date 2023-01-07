<?php

defined('ABSPATH') or die('No script kiddies please!!');

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
             * Settings save action
             */
            add_action('wp_ajax_jlad_settings_save_action', array($this, 'save_settings'));
            add_action('wp_ajax_nopriv_jlad_settings_save_action', array($this, 'no_permission'));

            /**
             * Settings restore action
             */
            add_action('wp_ajax_jlad_settings_restore_action', array($this, 'restore_settings'));
            add_action('wp_ajax_nopriv_jlad_settings_restore_action', array($this, 'no_permission'));

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
            add_options_page(__('Just Likes and Dislikes', 'just-likes-and-dislikes'), __('Just Likes and Dislikes', 'just-likes-and-dislikes'), 'manage_options', 'just-likes-and-dislikes', array($this, 'jlad_settings'));
        }

        function jlad_settings()
        {
            include JLAD_PATH . 'inc/views/backend/settings.php';
        }

        function save_settings()
        {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'jlad-backend-ajax-nonce')) {
                $_POST = stripslashes_deep($_POST);
                parse_str($_POST['settings_data'], $settings_data);
                $settings_data = $this->sanitize_array($settings_data);
                $jlad_settings = $settings_data['jlad_settings'];
                /**
                 * Fires before storing the settings array into database
                 *
                 * @param type array $settings_data - before sanitization
                 * @param type array $jlad_settings - after sanitization
                 *
                 * @since 1.0.0
                 */
                do_action('jlad_before_save_settings', $settings_data, $jlad_settings);

                /**
                 * Filters the settings stored in the database
                 *
                 * @param type array $jlad_settings
                 *
                 * @since 1.0.0
                 */
                update_option('jlad_settings', apply_filters('jlad_settings', $jlad_settings));
                die(__('Settings saved successfully', 'just-likes-and-dislikes'));
            } else {
                die('No script kiddies please!!');
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

            $post_types = (!empty($jlad_settings['basic_settings']['post_types'])) ? $jlad_settings['basic_settings']['post_types'] : array();

            if (empty($jlad_settings['basic_settings']['hide_counter_info_metabox']) && !empty($post_types)) {
                add_meta_box('jlad-count-info', esc_html__('Just Likes and Dislikes', 'just-likes-and-dislikes'), array($this, 'render_posts_count_info_html'), $post_types, 'normal');
            }
        }

        function render_count_info_metabox_comments()
        {
            if (empty($this->jlad_settings['basic_settings']['hide_counter_info_metabox'])) {
                add_meta_box('jlad-count-info', esc_html__('Just Likes and Dislikes', 'just-likes-and-dislikes'), array($this, 'render_comments_count_info_html'), 'comment', 'normal');
            }
        }

        function render_posts_count_info_html($post)
        {
            $post_id = $post->ID;
            $like_count = get_post_meta($post_id, 'jlad_like_count', true);
            $dislike_count = get_post_meta($post_id, 'jlad_dislike_count', true);
            include JLAD_PATH . '/inc/views/backend/jlad-metabox.php';
        }

        function render_comments_count_info_html($comment)
        {
            $comment_id = $comment->comment_ID;
            $like_count = get_comment_meta($comment_id, 'jlad_like_count', true);
            $dislike_count = get_comment_meta($comment_id, 'jlad_dislike_count', true);
            include JLAD_PATH . '/inc/views/backend/jlad-metabox.php';
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
