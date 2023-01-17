<div class="jlad-like-wrap  jlad-common-wrap">
    <a href="<?php echo esc_attr($href); ?>"
       class="jlad-like-trigger jlad-like-dislike-trigger <?php echo ($already_liked == 1) ? 'jlad-prevent' : ''; ?>"
       title="<?php echo esc_attr($like_title); ?>"
       data-id="<?php echo intval($data_id); ?>"
       data-trigger-type="like"
       data-restriction="<?php echo esc_attr($jlad_settings['basic_settings']['like_dislike_resistriction']); ?>"
       data-already-liked="<?php echo esc_attr($already_liked); ?>">
           <?php
            $template = $jlad_settings['design_settings']['template'];
            list( $like_icon, $dislike_icon ) = $this->get_template_icon($template);

            echo wp_kses( $like_icon, 'post' );
            ?>
    </a>
    <span class="jlad-like-count-wrap jlad-count-wrap"><?php echo esc_html($like_count); ?>
    </span>
</div>