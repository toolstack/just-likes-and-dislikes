<?php

if (!class_exists('JLAD_Ajax')) {

    class JLAD_Ajax extends JLAD_Library
    {

        function __construct()
        {
            parent::__construct();

            // Add ajax actions for posts.
            add_action('wp_ajax_jlad_post_ajax_action', array($this, 'like_dislike_post_action'));
            add_action('wp_ajax_nopriv_jlad_post_ajax_action', array($this, 'like_dislike_post_action'));

            // Add ajax actions for comments.
            add_action('wp_ajax_jlad_comment_ajax_action', array($this, 'like_dislike_comment_action'));
            add_action('wp_ajax_nopriv_jlad_comment_ajax_action', array($this, 'like_dislike_comment_action'));
        }

        // Validate if the user is restricted to liking/disliking this post/comment.
        function validate_restrictions( $cookie_name, $liked_users, $liked_ips ) {
            /**
             * Cookie Validation
             */
            if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'cookie' && isset($_COOKIE[$cookie_name])) {
                $response_array = array('success' => false, 'message' => 'Invalid action');
                echo json_encode($response_array);
                die();
            }
            /**
             * IP Validation
             */
            if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
                $user_ip = $this->get_user_IP();

                if (empty($liked_ips)) {
                    $liked_ips = array();
                }
                if ((in_array($user_ip, $liked_ips))) {
                    $response_array = array('success' => false, 'message' => 'Invalid action');
                    echo json_encode($response_array);
                    die();
                }
            }
            /**
             * User Logged in validation
             */
            if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'user') {
                if (is_user_logged_in()) {
                    $liked_users = (empty($liked_users)) ? array() : $liked_users;
                    $current_user_id = get_current_user_id();

                    if (in_array($current_user_id, $liked_users)) {
                        $response_array = array('success' => false, 'message' => 'Invalid action');
                        echo json_encode($response_array);
                        die();
                    }
                } else {
                    $response_array = array('success' => false, 'message' => 'Invalid action');
                    echo json_encode($response_array);
                    die();
                }
            }

        }

        function like_dislike_comment_action() {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'jlad-ajax-nonce')) {
                $comment_id = sanitize_text_field($_POST['data_id']);
                $cookie_name = 'jlad_comment_' . $comment_id;

                /**
                 * Action jlad_before_ajax_process
                 *
                 * @param type int $comment_id
                 *
                 * @since 1.0.7
                 */
                do_action('jlad_before_ajax_process', $comment_id);

                $type = sanitize_text_field($_POST['type']);

                validate_restrictions( $cookie_name, get_comment_meta($comment_id, 'jlad_users', true), get_comment_meta($comment_id, 'jlad_ips', true) );

                if ($type == 'like') {
                    $like_count = get_comment_meta($comment_id, 'jlad_like_count', true);
                    if (empty($like_count)) {
                        $like_count = 0;
                    }
                    $like_count = $like_count + 1;
                    $check = update_comment_meta($comment_id, 'jlad_like_count', $like_count);

                    if ($check) {
                        $response_array = array('success' => true, 'latest_count' => $like_count, 'comment_id' => $comment_id );
                    } else {
                        $response_array = array('success' => false, 'latest_count' => $like_count);
                    }
                } else {
                    $dislike_count = get_comment_meta($comment_id, 'jlad_dislike_count', true);
                    if (empty($dislike_count)) {
                        $dislike_count = 0;
                    }
                    $dislike_count = $dislike_count + 1;
                    $check = update_comment_meta($comment_id, 'jlad_dislike_count', $dislike_count);
                    if ($check) {
                        $response_array = array('success' => true, 'latest_count' => $dislike_count);
                    } else {
                        $response_array = array('success' => false, 'latest_count' => $dislike_count);
                    }
                }

                if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'cookie') {
                    $cookie_name = 'jlad_comment_' . $comment_id;
                    setcookie($cookie_name, 1, time() + 3600 * 24 * 365, '/');
                }
                /**
                 * Check the liked ips and insert the user ips for future checking
                 *
                 */
                if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
                    $liked_ips = get_comment_meta($comment_id, 'jlad_ips', true);
                    $liked_ips = (empty($liked_ips)) ? array() : $liked_ips;
                    if (!in_array($user_ip, $liked_ips)) {
                        $liked_ips[] = $user_ip;
                    }
                    update_comment_meta($comment_id, 'jlad_ips', $liked_ips);
                }
                /**
                 * Check if user is logged in to check user login for like dislike action
                 */
                if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'user') {
                    if (is_user_logged_in()) {

                        $liked_users = get_comment_meta($comment_id, 'jlad_users', true);
                        $liked_users = (empty($liked_users)) ? array() : $liked_users;
                        $current_user_id = get_current_user_id();
                        if (!in_array($current_user_id, $liked_users)) {
                            $liked_users[] = $current_user_id;
                        }
                        update_comment_meta($comment_id, 'jlad_users', $liked_users);
                    }
                }
                /**
                 * Action jlad_after_ajax_process
                 *
                 * @param type int $comment_id
                 *
                 * @since 1.0.7
                 */
                do_action('jlad_after_ajax_process', $comment_id);
                echo json_encode($response_array);

                die();
            } else {
                die('No script kiddies please!');
            }
        }

        function like_dislike_post_action()
        {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'jlad-ajax-nonce')) {
                $post_id = sanitize_text_field($_POST['data_id']);
                $cookie_name = 'jlad_post_' . $post_id;

                /**
                 * Action jlad_before_ajax_process
                 *
                 * @param type int $post_id
                 *
                 * @since 1.0.0
                 */
                do_action('jlad_before_ajax_process', $post_id);

                validate_restrictions( $cookie_name, get_post_meta($post_id, 'jlad_users', true), get_post_meta($post_id, 'jlad_ips', true) );

                $type = sanitize_text_field($_POST['type']);

                if ($type == 'like') {
                    $like_count = get_post_meta($post_id, 'jlad_like_count', true);
                    if (empty($like_count)) {
                        $like_count = 0;
                    }
                    $like_count = $like_count + 1;
                    $check = update_post_meta($post_id, 'jlad_like_count', $like_count);

                    if ($check) {

                        $response_array = array('success' => true, 'latest_count' => $like_count);
                    } else {
                        $response_array = array('success' => false, 'latest_count' => $like_count);
                    }
                } else {
                    $dislike_count = get_post_meta($post_id, 'jlad_dislike_count', true);
                    if (empty($dislike_count)) {
                        $dislike_count = 0;
                    }
                    $dislike_count = $dislike_count + 1;
                    $check = update_post_meta($post_id, 'jlad_dislike_count', $dislike_count);
                    if ($check) {
                        $response_array = array('success' => true, 'latest_count' => $dislike_count);
                    } else {
                        $response_array = array('success' => false, 'latest_count' => $dislike_count);
                    }
                }
                if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'cookie') {
                    setcookie($cookie_name, 1, time() + 365 * 24 * 60 * 60, '/');
                }

                /**
                 * Check the liked ips and insert the user ips for future checking
                 */
                if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
                    $liked_ips = get_post_meta($post_id, 'jlad_ips', true);
                    $liked_ips = (empty($liked_ips)) ? array() : $liked_ips;
                    if (!in_array($user_ip, $liked_ips)) {
                        $liked_ips[] = $user_ip;
                    }
                    update_post_meta($post_id, 'jlad_ips', $liked_ips);
                }
                /**
                 * Check if user is logged in to check user login for like dislike action
                 */
                if ($this->jlad_settings['basic_settings']['like_dislike_resistriction'] == 'user') {
                    if (is_user_logged_in()) {

                        $liked_users = get_post_meta($post_id, 'jlad_users', true);
                        $liked_users = (empty($liked_users)) ? array() : $liked_users;
                        $current_user_id = get_current_user_id();
                        if (!in_array($current_user_id, $liked_users)) {
                            $liked_users[] = $current_user_id;
                        }
                        update_post_meta($post_id, 'jlad_users', $liked_users);
                    }
                }

                /**
                 * Action jlad_after_ajax_process
                 *
                 * @param type int $post_id
                 *
                 * @since 1.0.0
                 */
                do_action('jlad_after_ajax_process', $post_id);
                echo json_encode($response_array);

                die();
            } else {
                die('No script kiddies please!');
            }
        }

    }

    new JLAD_Ajax();
}
