<div class="jlad-settings-section" data-settings-ref="basic">
    <div class="jlad-field-wrap">
        <label><?php _e('Enabled', 'just-likes-and-dislikes'); ?>:</label>
        <div class="jlad-field">
            <input type="checkbox" name="jlad_settings[basic_settings][status]" class="jlad-form-field" value="1" <?php checked( $jlad_settings['basic_settings']['status'], '1'); ?>/>
            <p class="description"><?php _e('Please check to enable like/dislike display', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php esc_html_e('Post Types', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <?php
            $post_types = get_post_types(array('public' => true), 'object');
            $checked_post_types = (!empty($jlad_settings['basic_settings']['post_types'])) ? $jlad_settings['basic_settings']['post_types'] : array();
            foreach ($post_types as $post_type_name => $post_type_object) {
                ?>
                <label class="jlad-checkbox-label"><input type="checkbox" name="jlad_settings[basic_settings][post_types][]" value="<?php echo esc_attr($post_type_name); ?>" <?php checked( in_array($post_type_name, $checked_post_types), true ); ?> class="jlad-form-field"/><?php echo esc_attr($post_type_object->label); ?></label>
                <?php
            }
            ?>
            <p class="description"><?php esc_html_e('Please uncheck all of these if you are wiling to generate the like dislike icon through custom function.', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php _e('Like Dislike Positiion', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][like_dislike_position]" class="jlad-form-field">
                <option value="after" <?php selected($jlad_settings['basic_settings']['like_dislike_position'], 'after'); ?>><?php _e('After Post', 'just-likes-and-dislikes'); ?></option>
                <option value="before" <?php selected($jlad_settings['basic_settings']['like_dislike_position'], 'before'); ?>><?php _e('Before Post', 'just-likes-and-dislikes'); ?></option>
            </select>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php _e('Like Dislike Display', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][like_dislike_display]" class="jlad-form-field">
                <option value="both" <?php selected($jlad_settings['basic_settings']['like_dislike_display'], 'both'); ?>><?php _e('Display Both', 'just-likes-and-dislikes'); ?></option>
                <option value="like_only" <?php selected($jlad_settings['basic_settings']['like_dislike_display'], 'like_only'); ?>><?php _e('Display Like Only', 'just-likes-and-dislikes'); ?></option>
                <option value="dislike_only" <?php selected($jlad_settings['basic_settings']['like_dislike_display'], 'dislike_only'); ?>><?php _e('Display Dislike Only', 'just-likes-and-dislikes'); ?></option>
            </select>
            <p class="description"><?php _e('Please choose where you want to display the like dislike buttons', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php _e('Like Dislike Restriction', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][like_dislike_resistriction]" class="jlad-form-field jlad-toggle-trigger" data-toggle-class="jlad-login-link">
                <option value="cookie" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'cookie'); ?>><?php _e('Cookie Restriction', 'just-likes-and-dislikes'); ?></option>
                <option value="ip" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'ip'); ?>><?php _e('IP Restriction', 'just-likes-and-dislikes'); ?></option>
                <option value="user" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'user'); ?>><?php _e('Logged In User Restriction', 'just-likes-and-dislikes'); ?></option>
                <option value="no" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'no'); ?>><?php _e('No Restriction', 'just-likes-and-dislikes'); ?></option>
            </select>
            <p class="description"><?php _e('Please choose the restriction you want to assign to likers and dislikers', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>
    <div class="jlad-field-wrap jlad-login-link" data-toggle-value="user" <?php $this->display_none($jlad_settings['basic_settings']['like_dislike_resistriction'], 'user'); ?>>
        <label><?php _e('Login Link', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <input type="text" name="jlad_settings[basic_settings][login_link]" class="jlad-form-field" value="<?php echo (!empty($jlad_settings['basic_settings']['login_link'])) ? esc_url($jlad_settings['basic_settings']['login_link']) : ''; ?>"/>
            <p class="description"><?php esc_html_e('Please enter the login link where users will be redirected while trying to like or dislike without logging in. Please leave blank if you don\'t want to redirect users to login page.', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php _e('Like Dislike Display Order', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][display_order]" class="jlad-form-field">
                <option value="like-dislike" <?php selected($jlad_settings['basic_settings']['display_order'], 'like-dislike'); ?>><?php _e('Like Dislike', 'just-likes-and-dislikes'); ?></option>
                <option value="dislike-like" <?php selected($jlad_settings['basic_settings']['display_order'], 'dislike-like'); ?>><?php _e('Dislike Like', 'just-likes-and-dislikes'); ?></option>
            </select>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php _e("Like hover text", 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <input type="text" name="jlad_settings[basic_settings][like_hover_text]" class="jlad-form-field" value="<?php echo isset($jlad_settings['basic_settings']['like_hover_text']) ? esc_attr($jlad_settings['basic_settings']['like_hover_text']) : ''; ?>" placeholder="<?php _e("Like", 'just-likes-and-dislikes'); ?>"/>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php _e("Dislike hover text", 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <input type="text" name="jlad_settings[basic_settings][dislike_hover_text]" class="jlad-form-field" value="<?php echo isset($jlad_settings['basic_settings']['dislike_hover_text']) ? esc_attr($jlad_settings['basic_settings']['dislike_hover_text']) : ''; ?>" placeholder="<?php _e('Dislike', 'just-likes-and-dislikes'); ?>"/>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php esc_html_e('Display 0(zero) by default', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <input type="checkbox" name="jlad_settings[basic_settings][display_zero]" class="jlad-form-field" value="1" <?php checked( $jlad_settings['basic_settings']['display_zero'], '1'); ?>/>
            <p class="description"><?php _e('Please check if you want to show 0 for no likes and dislikes', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>
    <div class="jlad-field-wrap">
        <label><?php esc_html_e('Hide Counter Info Metabox', 'just-likes-and-dislikes'); ?></label>
        <div class="jlad-field">
            <input type="checkbox" name="jlad_settings[basic_settings][hide_counter_info_metabox]" class="jlad-form-field" value="1" <?php checked( $jlad_settings['basic_settings']['hide_counter_info_metabox'], '1' ); ?>/>
            <p class="description"><?php _e('Please check if you want to hide the counter info metabox in the post edit screen. ', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>
</div>