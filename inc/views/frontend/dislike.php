<div class="pld-dislike-wrap  pld-common-wrap">
    <a href="javascript:void(0);" class="pld-dislike-trigger pld-like-dislike-trigger <?php echo ($user_ip_check == 1 || isset($_COOKIE['pld_' . $post_id])) ? 'pld-prevent' : ''; ?>" title="<?php echo $dislike_title; ?>" data-post-id="<?php echo $post_id; ?>" data-trigger-type="dislike" data-ip-check="<?php echo $user_ip_check; ?>" data-restriction="<?php echo esc_attr($pld_settings['basic_settings']['like_dislike_resistriction']); ?>" data-user-check="<?php echo $user_check; ?>">
        <?php
        $template = esc_attr($pld_settings['design_settings']['template']);
        switch ($template) {
            case 'template-1':
                ?>
                <i class="fas fa-thumbs-down"></i>
                <?php
                break;
            case 'template-2':
                ?>
                <i class="fa fa-heartbeat"></i>
                <?php
                break;
            case 'template-3':
                ?>
                <i class="fas fa-times"></i>
                <?php
                break;
            case 'template-4':
                ?>
                <i class="far fa-frown"></i>
                <?php
                break;
            case 'custom':
                if ($pld_settings['design_settings']['dislike_icon'] != '') {
                    ?>
                    <img src="<?php echo esc_url($pld_settings['design_settings']['dislike_icon']); ?>" alt="<?php echo esc_attr($dislike_title); ?>"/>
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
        do_action('pld_dislike_template', $pld_settings);
        ?>
    </a>
    <span class="pld-dislike-count-wrap pld-count-wrap"><?php echo esc_html($dislike_count); ?></span>
</div>