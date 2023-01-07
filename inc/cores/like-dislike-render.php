<?php

defined('ABSPATH') or die('No script kiddies please!!');
$jlad_settings = $this->jlad_settings;

if (empty($shortcode)) {
    global $post;
    if (empty($post)) {
        return $content;
    }
    $checked_post_types = (!empty($jlad_settings['basic_settings']['post_types'])) ? $jlad_settings['basic_settings']['post_types'] : array();
    if (in_array($post->post_type, $checked_post_types)) {
        return $content;
    }
}

/**
 * Don't implement on admin section
 *
 * @since 1.0.0
 */
if (is_admin() && !wp_doing_ajax()) {
    return $content;
}

/**
 * Don't implement on embeded requests
 *
 * @since 2.0.0
 */
if(array_key_exists('embed', $_REQUEST) ) {
    return $content;
}

ob_start();

/**
 * Fires while generating the like dislike html
 *
 * @param type string $content
 *
 * @since 1.0.0
 */
$shortcode = (!empty($shortcode)) ? $shortcode : false;
$atts = (!empty($atts))?$atts:[];
do_action('jlad_post_like_dislike_output', $content, $shortcode, $atts);

$like_dislike_html = ob_get_contents();
ob_end_clean();

if ($jlad_settings['basic_settings']['like_dislike_position'] == 'after') {
    $content .= $like_dislike_html;
} else {
    $content = $like_dislike_html . $content;
}
