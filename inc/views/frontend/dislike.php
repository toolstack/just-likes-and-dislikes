<div class="jlad-dislike-wrap  jlad-common-wrap">
    <a href="<?php echo esc_attr($href); ?>"
       class="jlad-dislike-trigger jlad-like-dislike-trigger <?php echo ($already_liked == 1) ? 'jlad-prevent' : ''; ?>"
       title="<?php echo esc_attr($dislike_title); ?>"
       data-post-id="<?php echo intval($post_id); ?>"
       data-trigger-type="dislike"
       data-restriction="<?php echo esc_attr($jlad_settings['basic_settings']['like_dislike_resistriction']); ?>"
       data-already-liked="<?php echo esc_attr($already_liked); ?>">
           <?php
            $template = $jlad_settings['design_settings']['template'];
            list( $like_icon, $dislike_icon ) = $this->get_template_icon( $template );

            echo $dislike_icon;

            /**
             * Fires when template is being loaded
             *
             * @param array $jlad_settings
             *
             * @since 1.0.0
             */
            do_action('jlad_dislike_template', $jlad_settings);
            ?>
    </a>
    <span class="jlad-dislike-count-wrap jlad-count-wrap"><?php echo esc_html($dislike_count); ?></span>
</div>