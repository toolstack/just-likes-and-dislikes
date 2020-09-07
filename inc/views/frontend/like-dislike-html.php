<?php
global $post;
$post_id = $post->ID;
$like_count = get_post_meta($post_id, 'pld_like_count', true);
$dislike_count = get_post_meta($post_id, 'pld_dislike_count', true);
$post_id = get_the_ID();
$pld_settings = get_option('pld_settings');

if (!empty($pld_settings['basic_settings']['display_zero'])) {
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
$like_count = apply_filters('pld_like_count', $like_count, $post_id);

/**
 * Filters dislike count
 *
 * @param type int $dislike_count
 * @param type int $post_id
 *
 * @since 1.0.0
 */
$dislike_count = apply_filters('pld_dislike_count', $dislike_count, $post_id);
if ($pld_settings['basic_settings']['status'] != 1) {
    // if posts like dislike is disabled from backend
    return;
}
$liked_ips = get_post_meta($post_id, 'pld_ips', true);
$user_ip = $this->get_user_IP();
if (empty($liked_ips)) {
    $liked_ips = array();
}
if (is_user_logged_in()) {
    $liked_users = get_post_meta($post_id, 'pld_users', true);
    $liked_users = (empty($liked_users)) ? array() : $liked_users;
    $current_user_id = get_current_user_id();
    if (in_array($current_user_id, $liked_users)) {
        $user_check = 1;
    } else {
        $user_check = 0;
    }
} else {
    $user_check = 1;
}

// $this->print_array($liked_ips);
$user_ip_check = (in_array($user_ip, $liked_ips)) ? 1 : 0;
$like_title = isset($pld_settings['basic_settings']['like_hover_text']) ? esc_attr($pld_settings['basic_settings']['like_hover_text']) : __('Like', PLD_TD);
$dislike_title = isset($pld_settings['basic_settings']['dislike_hover_text']) ? esc_attr($pld_settings['basic_settings']['dislike_hover_text']) : __('Dislike', PLD_TD);

//$this->print_array( $pld_settings );
?>
<div class="pld-like-dislike-wrap pld-<?php echo esc_attr($pld_settings['design_settings']['template']); ?>">
    <?php
    /**
     * Like Dislike Order
     */
    if ($pld_settings['basic_settings']['display_order'] == 'like-dislike') {
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'dislike_only') {
            include(PLD_PATH . 'inc/views/frontend/like.php');
        }
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'like_only') {
            include(PLD_PATH . 'inc/views/frontend/dislike.php');
        }
    } else {
        /**
         * Dislike Like Order
         */
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'like_only') {
            include(PLD_PATH . 'inc/views/frontend/dislike.php');
        }
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'dislike_only') {
            include(PLD_PATH . 'inc/views/frontend/like.php');
        }
    }
    ?>
</div>
