<div class="jlad-settings-section" data-settings-ref="help" style="display:none">
    <h3><?php esc_html_e('Status', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This can be used to enable or disable like dislike in the frontend posts.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>
    <h3><?php esc_html_e('Post Types', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('You can choose the post type for which you want to enable the like dislike buttons.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>
    <h3><?php esc_html_e('Like Dislike Position', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This can be used to control whether like dislike should be shown before.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Like Dislike Display', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This can be used to control whether like or dislike or both should be shown.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Like Dislike Restriction', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This can be used to prevent liking or disliking same posts from same liker or disliker through Cookie or IP.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Like Dislike Display Order', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This can be used control the display order of like and dislike.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Like Hover Text', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('The field is for the hover text of like button.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>
    <h3><?php esc_html_e('Dislike Hover Text', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This field is for the hover text of dislike button.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>
    <h3><?php esc_html_e('Display 0(Zero) by default', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('If you will check this option, the count will show as 0 by default.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>
    <h3><?php esc_html_e('Hide Counter Info Metabox', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('You can check this if you don\'t want to show the like dislike count info in the post edit screen.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Like Dislike Templates', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('There are altogether 5 templates including a custom template. Custom templates can be used to customize the like and dislike display by uploading your own icons.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Icon Color', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This can be used to override the color of icon provided by your active theme.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Count Color', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><?php esc_html_e('This can be used to override the color of count provided by your active theme.', 'just-likes-and-dislikes'); ?>
    </p>

    <div class="jlad-separator"></div>

    <h3><?php esc_html_e('Shortcode', 'just-likes-and-dislikes'); ?>
    </h3>
    <p><input type="text" onfocus="this.select();" value="[posts_like_dislike id=post_id]" /></p>

    <h3><?php esc_html_e('Custom Function', 'just-likes-and-dislikes'); ?>
    </h3>
    <p>
    <pre>&lt;?php echo do_shortcode('[posts_like_dislike id=post_id]');?&gt;</pre>
    <span class="description"><?php esc_html_e('Please replace post_id with the id of the post for which you want to get the like and dislike icon. Please remove id parameter for considering the post id as the id of global $post object', 'just-likes-and-dislikes');?></span>
    </p>
    <h3><?php esc_html_e('Available Filters', 'just-likes-and-dislikes'); ?>
    </h3>
    <div class="jlad-fixed-height">

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
    <div class="jlad-fixed-height">
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