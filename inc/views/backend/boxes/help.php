<div class="jlad-settings-section" data-settings-ref="help" style="display:none">

    <h3><?php esc_html_e('Shortcode', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><input type="text" class="jlad-fake-text" onfocus="this.select();" value="[posts_like_dislike id=post_id]" /></p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Custom Function', 'just-likes-and-dislikes'); ?>
    </h3>
    <p>
    <pre>&lt;?php echo do_shortcode('[posts_like_dislike id=post_id]');?&gt;</pre>
    <span class="description"><?php esc_html_e('Replace post_id with the id of the post for which you want to get the like and dislike icon, or remove it to use the current global $post object', 'just-likes-and-dislikes');?></span>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Available Filters', 'just-likes-and-dislikes'); ?>
    </h3>
    <div>

        <pre>
/**
 * Filters the tabs
 *
 * @since 1.0.0
 *
 * @param array $jlad_tabs
 */
$jlad_tabs = apply_filters( 'jlad_admin_tabs', $jlad_tabs );
    </pre>

        <pre>
/**
 * Filters total number or templates
 *
 * @param int
 *
 * @since 1.0.0
 */
$jlad_total_templates = apply_filters( 'jlad_total_templates', 4 );
    </pre>
        <pre>
/**
 * Filters the array stored in the database
 *
 * @param type array $jlad_settings
 *
 * @since 1.0.0
 */
update_option( 'jlad_settings', apply_filters( 'jlad_settings', $jlad_settings ) );
    </pre>
        <pre>
/**
* Filters Like Dislike HTML
*
* @param string $like_dislike_html
* @param array $jlad_settings
*
* @since 1.0.0
*/
$post_text .= apply_filters( 'jlad_like_dislike_html', $like_dislike_html, $jlad_settings );
    </pre>
        <pre>
/**
 * Filters deault settings
 *
 * @param type array $default_settings
 *
 * @since 1.0.0
 */
return apply_filters( 'jlad_default_settings', $default_settings );
    </pre>
        <pre>
/**
 * Filters like count
 *
 * @param type int $like_count
 * @param type int $post_id
 *
 * @since 1.0.0
 */
$like_count = apply_filters( 'jlad_like_count', $like_count, $post_id );
    </pre>
        <pre>
/**
 * Filters dislike count
 *
 * @param type int $dislike_count
 * @param type int $post_id
 *
 * @since 1.0.0
 */
$dislike_count = apply_filters( 'jlad_dislike_count', $dislike_count, $post_id );
    </pre>
    </div>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Available Actions', 'just-likes-and-dislikes'); ?>
    </h3>
    <div>
        <pre>
/**
 * Fires before storing the settings array into database
 *
 * @param type array $settings_data - before sanitization
 * @param type array $jlad_settings - after sanitization
 *
 * @since 1.0.0
 */
 do_action( 'jlad_before_save_settings', $settings_data, $jlad_settings );
    </pre>
        <pre>
/**
 * Fires while generating the like dislike html
 *
 * @param type string $post_text
 * @param type array $post
 *
 * @since 1.0.0
 */
do_action( 'jlad_like_dislike_output', $post_text, $post );
    </pre>
        <pre>
/**
 * Fires when Init hook is fired through plugin
 *
 * @since 1.0.0
 */
do_action('jlad_init');
    </pre>
        <pre>
/**
 * Fires on backend template preview* Fires on backend template preview
 *
 * Useful to add additional templates in backend
 * Fires on backend template preview* Fires on backend template preview*
 * @param array $jlad_settings
 *
 * @since 1.0.0
 *
 */
do_action( 'jlad_template_previews' );
    </pre>
        <pre>
/**
 * Fires when displaying the tabs section
 *
 * @param array $jlad_settings
 *
 * @since 1.0.0
 */
do_action( 'jlad_admin_tab_section', $jlad_settings );
    </pre>
        <pre>
/**
 * Fires when template is being loaded
 *
 * @param array $jlad_settings
 *
 * @since 1.0.0
 */
do_action( 'jlad_dislike_template', $jlad_settings );
    </pre>
        <pre>
/**
 * Fires when template is being loaded
 *
 * @param array $jlad_settings
 *
 * @since 1.0.0
 */
do_action( 'jlad_like_template', $jlad_settings );
    </pre>
        <pre>
/**
 * Action jlad_before_ajax_process
 *
 * Fires just before processing the ajax request when like or dislike button is clicked
 *
 * @param type int $post_id
 *
 * @since 1.0.0
 */
 do_action( 'jlad_before_ajax_process', $post_id );
    </pre>
        <pre>
/**
 * Action jlad_after_ajax_process
 *
 * Fires after the ajax process is complete when like or dislike button is clicked just before printing the response
 *
 * @param type int $post_id
 *
 * @since 1.0.0
 */
do_action( 'jlad_after_ajax_process', $post_id );
    </pre>
    </div>
</div>