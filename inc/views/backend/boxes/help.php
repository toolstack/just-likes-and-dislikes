<div class="jlad-settings-section" data-settings-ref="help" style="display:none">

    <h3><?php esc_html_e('Shortcode', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><input type="text" class="jlad-fake-text" onfocus="this.select();" value="[just_likes_and_dislikes id=post_id]" /></p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Custom Function', 'just-likes-and-dislikes'); ?>
    </h3>
    <p>
    <pre>&lt;?php echo do_shortcode('[just_likes_and_dislikes id=post_id]');?&gt;</pre>
    <span class="description"><?php esc_html_e('Replace post_id with the id of the post for which you want to get the like and dislike icon, or remove it to use the current global $post object', 'just-likes-and-dislikes');?></span>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Available Filters', 'just-likes-and-dislikes'); ?>
    </h3>

    <div>
        <pre>
/**
 * Filters template name list
 *
 * @param int
 *
 * @since 2.0.0
 */
$template_names = apply_filters('jlad_template_names', $template_names);
        </pre>

        <pre>
/**
 * Filters template icons
 *
 * @param int
 *
 * @since 2.0.0
 */
$icons = apply_filters('jlad_template_icons', $icons);
        </pre>

    </div>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Available Actions', 'just-likes-and-dislikes'); ?>
    </h3>

    <div>
        <pre>
/**
 * Fires while generating the like dislike html
 *
 * @param type string $post_text
 * @param type array $post
 *
 * @since 1.0.0
 */
do_action( 'jlad_post_like_dislike_output', $post_text, $post );
        </pre>

        <pre>
/**
 * Fires when Init hook is fired through plugin
 *
 * @since 1.0.0
 */
do_action('jlad_init');
        </pre>

    </div>
</div>