<?php
defined('ABSPATH') or die('No script kiddies please!!');
wp_nonce_field('jlad_metabox_nonce', 'jlad_metabox_nonce_field');
?>
<div class="jlad-field-wrap">
    <label><?php esc_html_e('Like Count', 'just-likes-and-dislikes'); ?></label>
    <div class="jlad-field">
        <input type="text" name="jlad_like_count" value="<?php echo esc_attr($like_count); ?>"/>
    </div>
</div>
<div class="jlad-field-wrap">
    <label><?php esc_html_e('Dislike Count', 'just-likes-and-dislikes'); ?></label>
    <div class="jlad-field">
        <input type="text" name="jlad_dislike_count" value="<?php echo esc_attr($dislike_count); ?>"/>
    </div>
</div>