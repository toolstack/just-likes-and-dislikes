<?php

defined('ABSPATH') or die('No script kiddies please!!');
$jlad_settings = $this->jlad_settings;

/**
 * Don't implement on admin section
 *
 * @since 1.0.0
 */
if (is_admin() && !wp_doing_ajax()) {
return $content;
}

/**
 * Don't implement on embeded requests
 *
 * @since 2.0.0
 */
if(array_key_exists('embed', $_REQUEST) ) {
return $content;
}

/**
 * Three parameters should exists:
 * 1: $type      - The type of table we're generating, aka "jlad_like_count" or "jlad_dislike_count".
 * 2: $post_type - The post type we're generating for.
 * 3: $options   - The table options:
 *                     count            - The number of posts to show in the table.
 *                     show_likes       - If likes should be shown (unused in this function).
 *                     show_dislikes    - If dislikes should be shown (unused in this function).
 *                     types            - Post types to show (unused in this function).
 *                     show_table_title - If the table title should be shown.
 *                     show_row_number  - If the table row numbers should be shown.
 */

// Get the human readable, translated type name we're displaying.
$type_name = __('Likes', 'just-likes-and-dislikes');
if( $type != $this->like_column_name ) { $type_name = __('Dislike', 'just-likes-and-dislikes'); }

// Build the like/dislike icon based on the current design settings.
$like_title = isset($this->jlad_settings['basic_settings']['like_hover_text']) ? esc_attr($this->jlad_settings['basic_settings']['like_hover_text']) : __('Like', 'just-likes-and-dislikes');
$dislike_title = isset($this->jlad_settings['basic_settings']['dislike_hover_text']) ? esc_attr($this->jlad_settings['basic_settings']['dislike_hover_text']) : __('Dislike', 'just-likes-and-dislikes');

list( $like_icon, $dislike_icon ) = $this->get_template_icon($this->jlad_settings['design_settings']['template']);

// We only need one icon for the title, so pick the right one now.
$type_title = $like_icon;
if( $type == $this->dislike_column_name ) { $type_title = $dislike_icon; }

// Get the posts we're going to display.
$posts = get_posts( array(
    'numberposts' => $options['count'],
    'meta_key' => $type,
    'post_type' => $post_type,
    'orderby' => 'meta_value_num',
        )
    );

// Get the post type object for the human readable version of the post type name.
$type_obj = get_post_type_object( $post_type );

// Create an output buffer.
$content = '';

// Show the title if enabled.
if( $options['show_table_title'] == true ) {
    $content .= '<h2>' . sprintf( __( '%s for %s', 'just-likes-and-dislikes' ), esc_html( $type_name ), esc_html( $type_obj->label ) ) . '</h2>' . PHP_EOL;
}

// Create the main table tag.
$content .= "<table class='table jlad_shortcode_table'>" . PHP_EOL;

// Create the table header row.
$content .= "\t<thead>" . PHP_EOL;
$content .= "\t\t<tr>" . PHP_EOL;
if( $options['show_row_numbers' ] ) { $content .= "\t\t\t<th class=\"jlad_table_row_numbers_column\">&nbsp;</td>" . PHP_EOL; }
$content .= "\t\t\t<th class=\"jlad_table_title_column\">" . sprintf( __( '%s Title', 'just-likes-and-dislikes' ) , esc_html( $type_obj->labels->singular_name ) ) . '</td>' . PHP_EOL;
$content .= "\t\t\t<th class=\"jlad_table_likes_column\">$type_title</td>" . PHP_EOL;
$content .= "\t\t</tr>" . PHP_EOL;
$content .= "\t</thead>" . PHP_EOL;

// A counter to keep track of the total number of likes.
$count = 0;

// Count the rows.
$row = 1;

// Loop through the posts and output the table row.
foreach( $posts as $post ) {
    // Create a title, if no title use a default.
    $post_title = trim( $post->post_title );
    $post_title = $post_title == '' ? __( '[no title]', 'just-likes-and-dislikes' ) : $post->post_title;

    // Output the row.
    $content .= "\t<tr>" . PHP_EOL;
    if( $options['show_row_numbers' ] ) { $content .= "\t\t<td class=\"jlad_table_row_numbers_column\">" . esc_html( $row ) . "</td>" . PHP_EOL; }
    $content .= "\t\t<td class=\"jlad_table_title_column\"><a href='" . esc_attr( get_post_permalink( $post->ID ) ) . "'>" . esc_html( $post_title ) . '</a>' . "</td>" . PHP_EOL;
    $likes = intval( get_post_meta( $post->ID, $type, true ) );
    $content .= "\t\t<td class=\"jlad_table_likes_column\">" . esc_html( $likes > 0 ? $likes : '—' ) . "</td>" . PHP_EOL;
    $content .= "\t</tr>" . PHP_EOL;

    // Add to the counters.
    $count += $likes;
    $row++;
}

// Output the footer.
$content .= "\t<tfoot>" . PHP_EOL;
$content .= "\t\t<tr>" . PHP_EOL;
if( $options['show_row_numbers' ] ) { $content .= "\t\t\t<td class=\"jlad_table_row_numbers_column\">&nbsp;</td>" . PHP_EOL; }
$content .= "\t\t\t<td class=\"jlad_table_title_column\">" . __( 'Total', 'just-likes-and-dislikes' ) . "</td>" . PHP_EOL;
$content .= "\t\t\t<td class=\"jlad_table_likes_column\">" . esc_html( $count > 0 ? $count : '—' ) . "</td>" . PHP_EOL;
$content .= "\t\t</tr>" . PHP_EOL;
$content .= "\t</tfoot>" . PHP_EOL;

// Close the table.
$content .= "</table>" . PHP_EOL;
