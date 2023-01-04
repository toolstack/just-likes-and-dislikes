<?php
$post_id = (!empty($atts['id']))?intval($atts['id']):get_the_ID();
$like_count = get_post_meta($post_id, 'jlad_like_count', true);
$dislike_count = get_post_meta($post_id, 'jlad_dislike_count', true);

$jlad_settings = get_option('jlad_settings');

if (empty($jlad_settings['basic_settings']['status']) && empty($shortcode)) {
    // if posts like dislike is disabled from backend
    return;
}
$already_liked = 0;
$href = 'javascript:void(0)';

/**
 * Cookie Restriction Validation
 */
if ($jlad_settings['basic_settings']['like_dislike_resistriction'] == 'cookie' && isset($_COOKIE['jlad_' . $post_id])) {
    $already_liked = 1;
}

/**
 * IP Restriction Validation
 */
if ($jlad_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
    $liked_ips = get_post_meta($post_id, 'jlad_ips', true);
    $user_ip = $this->get_user_IP();
    if (empty($liked_ips)) {
        $liked_ips = array();
    }
    if (in_array($user_ip, $liked_ips)) {
        $already_liked = 1;
    }
}

/**
 * User Logged In validation
 */
if ($jlad_settings['basic_settings']['like_dislike_resistriction'] == 'user') {
    if (is_user_logged_in()) {
        $liked_users = get_post_meta($post_id, 'jlad_users', true);
        $liked_users = (empty($liked_users)) ? array() : $liked_users;
        $current_user_id = get_current_user_id();
        if (in_array($current_user_id, $liked_users)) {
            $already_liked = 1;
        }
    } else {
        $current_page_url = $this->get_current_page_url();
        $href = (!empty($jlad_settings['basic_settings']['login_link'])) ? $jlad_settings['basic_settings']['login_link'] : admin_url() . '/wp-login.php?redirect=' . $current_page_url;
    }
}

if (!empty($jlad_settings['basic_settings']['display_zero'])) {
    if (empty($like_count)) {
        $like_count = 0;
    }
    if (empty($dislike_count)) {
        $dislike_count = 0;
    }
}
/**
 * Filters like count
 *
 * @param type int $like_count
 * @param type int $post_id
 *
 * @since 1.0.0
 */
$like_count = apply_filters('jlad_like_count', $like_count, $post_id);

/**
 * Filters dislike count
 *
 * @param type int $dislike_count
 * @param type int $post_id
 *
 * @since 1.0.0
 */
$dislike_count = apply_filters('jlad_dislike_count', $dislike_count, $post_id);

$like_title = isset($jlad_settings['basic_settings']['like_hover_text']) ? esc_attr($jlad_settings['basic_settings']['like_hover_text']) : __('Like', 'just-likes-and-dislikes');
$dislike_title = isset($jlad_settings['basic_settings']['dislike_hover_text']) ? esc_attr($jlad_settings['basic_settings']['dislike_hover_text']) : __('Dislike', 'just-likes-and-dislikes');

//$this->print_array( $jlad_settings );
?>
<div
    class="jlad-like-dislike-wrap jlad-<?php echo esc_attr($jlad_settings['design_settings']['template']); ?>">
    <?php
    /**
     * Like Dislike Order
     */
    if ($jlad_settings['basic_settings']['display_order'] == 'like-dislike') {
        if ($jlad_settings['basic_settings']['like_dislike_display'] != 'dislike_only') {
            include JLAD_PATH . 'inc/views/frontend/like.php';
        }
        if ($jlad_settings['basic_settings']['like_dislike_display'] != 'like_only') {
            include JLAD_PATH . 'inc/views/frontend/dislike.php';
        }
    } else {
        /**
         * Dislike Like Order
         */
        if ($jlad_settings['basic_settings']['like_dislike_display'] != 'like_only') {
            include JLAD_PATH . 'inc/views/frontend/dislike.php';
        }
        if ($jlad_settings['basic_settings']['like_dislike_display'] != 'dislike_only') {
            include JLAD_PATH . 'inc/views/frontend/like.php';
        }
    }
    ?>
</div>
