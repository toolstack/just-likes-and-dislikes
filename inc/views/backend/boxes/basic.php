<div class="jlad-settings-section" data-settings-ref="basic">
    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Enabled:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <label class="jlad-switch">
                <input type="checkbox" name="jlad_settings[basic_settings][status]" class="jlad-form-field" value="1" <?php checked($jlad_settings['basic_settings']['status'], '1'); ?>/>
                <span class="jlad-slider jlad-round"></span>
            </label>
            <p class="description"><?php esc_html_e('(toggle to enable/disable the plug-in functionality)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Disable on post types:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <?php
            $post_types = get_post_types(array('public' => true), 'object');
            $checked_post_types = (!empty($jlad_settings['basic_settings']['post_types'])) ? $jlad_settings['basic_settings']['post_types'] : array();
            foreach ($post_types as $post_type_name => $post_type_object) {
                ?>
                <div class="jlad-switch-block">
                    <label class="jlad-switch">
                        <input type="checkbox" name="jlad_settings[basic_settings][post_types][]" value="<?php echo esc_attr($post_type_name); ?>" <?php checked(in_array($post_type_name, $checked_post_types), true); ?> class="jlad-form-field" />
                        <span class="jlad-slider jlad-round"></span>
                    </label>
                    <span class="jlad-switch-text"><?php echo esc_html($post_type_object->label); ?><br></span>
                </div>
                <?php
            }
            ?>
            <p class="description"><?php esc_html_e('(toggle to disable like/dislike display for a selected post type)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Display position:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][like_dislike_position]" class="jlad-form-field">
                <option value="after" <?php selected($jlad_settings['basic_settings']['like_dislike_position'], 'after'); ?>><?php esc_html_e('After Post/Commnet', 'just-likes-and-dislikes'); ?></option>
                <option value="before" <?php selected($jlad_settings['basic_settings']['like_dislike_position'], 'before'); ?>><?php esc_html_e('Before Post/Comment', 'just-likes-and-dislikes'); ?></option>
            </select>
            <p class="description"><?php esc_html_e('(where you want to display the like/dislike buttons)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Display likes or dislikes:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][like_dislike_display]" class="jlad-form-field">
                <option value="both" <?php selected($jlad_settings['basic_settings']['like_dislike_display'], 'both'); ?>><?php esc_html_e('Display Both', 'just-likes-and-dislikes'); ?></option>
                <option value="like_only" <?php selected($jlad_settings['basic_settings']['like_dislike_display'], 'like_only'); ?>><?php esc_html_e('Display Like Only', 'just-likes-and-dislikes'); ?></option>
                <option value="dislike_only" <?php selected($jlad_settings['basic_settings']['like_dislike_display'], 'dislike_only'); ?>><?php esc_html_e('Display Dislike Only', 'just-likes-and-dislikes'); ?></option>
            </select>
            <p class="description"><?php esc_html_e('(display like, dislike or both)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('User restriction mode:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][like_dislike_resistriction]" class="jlad-form-field jlad-toggle-trigger" data-toggle-class="jlad-login-link">
                <option value="cookie" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'cookie'); ?>><?php esc_html_e('Cookie Restriction', 'just-likes-and-dislikes'); ?></option>
                <option value="ip" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'ip'); ?>><?php esc_html_e('IP Restriction', 'just-likes-and-dislikes'); ?></option>
                <option value="user" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'user'); ?>><?php esc_html_e('Logged In User Restriction', 'just-likes-and-dislikes'); ?></option>
                <option value="no" <?php selected($jlad_settings['basic_settings']['like_dislike_resistriction'], 'no'); ?>><?php esc_html_e('No Restriction', 'just-likes-and-dislikes'); ?></option>
            </select>
            <p class="description"><?php esc_html_e('(how users are restricted from multiple like/dislike entries)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap jlad-login-link" data-toggle-value="user" <?php $this->display_none($jlad_settings['basic_settings']['like_dislike_resistriction'], 'user'); ?>>
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Login link:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <input type="text" name="jlad_settings[basic_settings][login_link]" class="jlad-form-field" value="<?php echo (!empty($jlad_settings['basic_settings']['login_link'])) ? esc_attr($jlad_settings['basic_settings']['login_link']) : ''; ?>"/>
            <p class="description"><?php esc_html_e('Please enter the login link where users will be redirected while trying to like or dislike without logging in. Please leave blank if you don\'t want to redirect users to login page.', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Display order:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <select name="jlad_settings[basic_settings][display_order]" class="jlad-form-field">
                <option value="like-dislike" <?php selected($jlad_settings['basic_settings']['display_order'], 'like-dislike'); ?>><?php esc_html_e('Like Dislike', 'just-likes-and-dislikes'); ?></option>
                <option value="dislike-like" <?php selected($jlad_settings['basic_settings']['display_order'], 'dislike-like'); ?>><?php esc_html_e('Dislike Like', 'just-likes-and-dislikes'); ?></option>
            </select>
            <p class="description"><?php esc_html_e('(which order the like/dislike icons should be displayed in)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Like hover text:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <input type="text" name="jlad_settings[basic_settings][like_hover_text]" class="jlad-form-field" value="<?php echo isset($jlad_settings['basic_settings']['like_hover_text']) ? esc_attr($jlad_settings['basic_settings']['like_hover_text']) : ''; ?>" placeholder="<?php esc_attr_e('Like', 'just-likes-and-dislikes'); ?>"/>
            <p class="description"><?php esc_html_e('(the text to display when the user hovers over the like icon)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Dislike hover text:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <input type="text" name="jlad_settings[basic_settings][dislike_hover_text]" class="jlad-form-field" value="<?php echo isset($jlad_settings['basic_settings']['dislike_hover_text']) ? esc_attr($jlad_settings['basic_settings']['dislike_hover_text']) : ''; ?>" placeholder="<?php esc_attr_e('Dislike', 'just-likes-and-dislikes'); ?>"/>
            <p class="description"><?php esc_html_e('(the text to display when the user hovers over the dislike icon)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Display zeros on posts with no likes/dislikes:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <label class="jlad-switch">
                <input type="checkbox" name="jlad_settings[basic_settings][display_zero]" class="jlad-form-field" value="1" <?php checked($jlad_settings['basic_settings']['display_zero'], '1'); ?>/>
                <span class="jlad-slider jlad-round"></span>
            </label>
            <p class="description"><?php esc_html_e('(toggle if you want to show zeros beside the icons for posts with no likes and dislikes yet)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Hide like/dislike info metabox:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <label class="jlad-switch">
                <input type="checkbox" name="jlad_settings[basic_settings][hide_counter_info_metabox]" class="jlad-form-field" value="1" <?php checked($jlad_settings['basic_settings']['hide_counter_info_metabox'], '1'); ?>/>
                <span class="jlad-slider jlad-round"></span>
            </label>
            <p class="description"><?php esc_html_e('(toggle if you want to hide the counter info metabox in the post edit screen)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

    <div class="jlad-field-wrap">
        <div class="jlad-field-description">
            <label class="jlad-field-label"><?php esc_html_e('Hide like/dislike columns in admin screens:', 'just-likes-and-dislikes'); ?></label>
        </div>
        <div class="jlad-field">
            <label class="jlad-switch">
                <input type="checkbox" name="jlad_settings[basic_settings][hide_like_dislike_admin]" class="jlad-form-field" value="1" <?php checked($jlad_settings['basic_settings']['hide_like_dislike_admin'], '1'); ?>/>
                <span class="jlad-slider jlad-round"></span>
            </label>
            <p class="description"><?php esc_html_e('(toggle if you want to hide the like/dislike columns in the posts and other admin pages)', 'just-likes-and-dislikes'); ?></p>
        </div>
    </div>

</div>