<div class="jlad-like-wrap  jlad-common-wrap">
    <a href="<?php echo esc_attr($href); ?>"
       class="jlad-like-trigger jlad-like-dislike-trigger <?php echo ($already_liked == 1) ? 'jlad-prevent' : ''; ?>"
       title="<?php echo esc_attr($like_title); ?>"
       data-post-id="<?php echo intval($post_id); ?>"
       data-trigger-type="like"
       data-restriction="<?php echo esc_attr($jlad_settings['basic_settings']['like_dislike_resistriction']); ?>"
       data-already-liked="<?php echo esc_attr($already_liked); ?>">
           <?php
            $template = $jlad_settings['design_settings']['template'];
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
                if ($jlad_settings['design_settings']['like_icon'] != '') {
                    ?>
                    <img src="<?php echo esc_attr($jlad_settings['design_settings']['like_icon']); ?>" alt="<?php echo esc_attr($like_title); ?>"/>
                    <?php
                }
                break;
            }
            /**
             * Fires when template is being loaded
             *
             * @param array $jlad_settings
             *
             * @since 1.0.0
             */
            do_action('jlad_like_template', $jlad_settings);
            ?>
    </a>
    <span class="jlad-like-count-wrap jlad-count-wrap"><?php echo esc_html($like_count); ?>
    </span>
</div>