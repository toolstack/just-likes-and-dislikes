<?php
$jlad_settings = get_option('jlad_settings');
if ($jlad_settings['basic_settings']['status'] != 1) {
    // if comments like dislike is disabled from backend
    return;
}
if (isset($comment)) {
    $comment_id = $comment->comment_ID;
    $data_id = $comment_id;
}

$already_liked = 0;
$href = 'javascript:void(0)';

/**
 * Cookie Validation
 */
if ($jlad_settings['basic_settings']['like_dislike_resistriction'] == 'cookie' && isset($_COOKIE['jlad_' . $comment_id])) {
    $already_liked = 1;
}
/**
 * IP Validation
 */
if ($jlad_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
    $user_ip = $this->get_user_IP();
    $liked_ips = get_comment_meta($comment_id, 'jlad_ips', true);
    if (empty($liked_ips)) {
        $liked_ips = array();
    }
    if ((in_array($user_ip, $liked_ips))) {
        $already_liked = 1;
    }
}

/**
 * User Logged in validation
 */
if ($jlad_settings['basic_settings']['like_dislike_resistriction'] == 'user') {
    if (is_user_logged_in()) {
        $liked_users = get_comment_meta($comment_id, 'jlad_users', true);
        $liked_users = (empty($liked_users)) ? array() : $liked_users;
        $current_user_id = get_current_user_id();
        if (in_array($current_user_id, $liked_users)) {
            $already_liked = 1;
        }
        $href = 'javascript:void(0)';
    } else {
        if (!empty($jlad_settings['basic_settings']['login_link'])) {
            $href = $jlad_settings['basic_settings']['login_link'];
        } else {
            $href = 'javascript:void(0)';
        }
    }
}

$like_title = isset($jlad_settings['basic_settings']['like_hover_text']) ? esc_attr($jlad_settings['basic_settings']['like_hover_text']) : __('Like', jlad_TD);
$dislike_title = isset($jlad_settings['basic_settings']['dislike_hover_text']) ? esc_attr($jlad_settings['basic_settings']['dislike_hover_text']) : __('Dislike', jlad_TD);
$like_count = get_comment_meta($comment_id, 'jlad_like_count', true);
$dislike_count = get_comment_meta($comment_id, 'jlad_dislike_count', true);

if (!empty($jlad_settings['basic_settings']['display_zero'])) {
    $like_count = (empty($like_count)) ? 0 : $like_count;
    $dislike_count = (empty($dislike_count)) ? 0 : $dislike_count;
}
?>
<div class="jlad-like-dislike-wrap jlad-<?php echo esc_attr($jlad_settings['design_settings']['template']); ?>">
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
