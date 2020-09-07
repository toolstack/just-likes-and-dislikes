<div class="pld-like-wrap  pld-common-wrap">
    <a href="javascript:void(0);" class="pld-like-trigger pld-like-dislike-trigger <?php echo ($user_ip_check == 1 || isset($_COOKIE['pld_' . $post_id])) ? 'pld-prevent' : ''; ?>" title="<?php echo $like_title; ?>" data-post-id="<?php echo $post_id; ?>" data-trigger-type="like" data-restriction="<?php echo esc_attr($pld_settings['basic_settings']['like_dislike_resistriction']); ?>" data-ip-check="<?php echo $user_ip_check; ?>" data-user-check="<?php echo $user_check; ?>">
        <?php
        $template = $pld_settings['design_settings']['template'];
        switch ($template) {
            case 'template-1':
                ?>
                <i class="fas fa-thumbs-up"></i>
                <?php
                break;
            case 'template-2':
                ?>
                <i class="fas fa-heart"></i>
                <?php
                break;
            case 'template-3':
                ?>
                <i class="fas fa-check"></i>
                <?php
                break;
            case 'template-4':
                ?>
                <i class="far fa-smile"></i>
                <?php
                break;
            case 'custom':
                if ($pld_settings['design_settings']['like_icon'] != '') {
                    ?>
                    <img src="<?php echo esc_url($pld_settings['design_settings']['like_icon']); ?>" alt="<?php echo esc_attr($like_title); ?>"/>
                    <?php
                }
                break;
        }
        /**
         * Fires when template is being loaded
         *
         * @param array $pld_settings
         *
         * @since 1.0.0
         */
        do_action('pld_like_template', $pld_settings);
        ?>
    </a>
    <span class="pld-like-count-wrap pld-count-wrap"><?php echo esc_html($like_count); ?>
    </span>
</div>