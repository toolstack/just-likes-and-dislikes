<?php

if (!class_exists('PLD_Hooks')) {
    class PLD_Hooks extends PLD_Library
    {
        public function __construct()
        {
            parent::__construct();
            add_filter('the_content', array($this, 'posts_like_dislike'), 200); // hook to add html for like dislike
            add_action('pld_like_dislike_output', array($this, 'generate_like_dislike_html'), 10, 3);
            add_action('wp_head', array($this, 'custom_styles'));
            add_shortcode('posts_like_dislike', array($this, 'render_pld_shortcode'));

            // Add filter to exclude copying the like/dislike counts when using Yoast Duplicate Posts.
            add_filter('duplicate_post_excludelist_filter', array($this, 'duplicate_post_excludelist_filter'));

            // Add an admit column for like/dislikes
            add_filter('manage_post_posts_columns', array($this, 'manage_post_posts_columns'));
            add_action('manage_post_posts_custom_column', array($this,'manage_post_posts_custom_column'), 10, 2);

        }

        public function posts_like_dislike($content)
        {
            include(PLD_PATH . '/inc/cores/like-dislike-render.php');
            return $content;
        }

        public function duplicate_post_excludelist_filter($meta_excludelist)
        {
            // Merges the defaults array with our own array of custom fields.
            return array_merge($meta_excludelist, ['pld_like_count', 'pld_dislike_count']);
        }

        public function render_pld_shortcode($atts)
        {
            $content = '';
            $shortcode = true;
            include(PLD_PATH . '/inc/cores/like-dislike-render.php');
            return $content;
        }

        public function generate_like_dislike_html($content, $shortcode, $atts)
        {
            include(PLD_PATH . '/inc/views/frontend/like-dislike-html.php');
        }

        public function custom_styles()
        {
            $pld_settings = $this->pld_settings;
            echo "<style>";
            if ($pld_settings['design_settings']['icon_color'] != '') {
                echo 'a.pld-like-dislike-trigger {color: ' . esc_attr($pld_settings['design_settings']['icon_color']) . ';}';
            }
            if ($pld_settings['design_settings']['count_color'] != '') {
                echo 'span.pld-count-wrap {color: ' . esc_attr($pld_settings['design_settings']['count_color']) . ';}';
            }
            echo "</style>";
        }

        public function manage_post_posts_columns($columns)
        {
            $new_column_name = 'like_dislike';

            // Loop through and create a new array, adding in our column at the right spot.
            foreach( $columns as $key => $value )
            {
                $new_columns[$key] = $value;

                if( $key == 'comments' )
                {
                    $new_columns[ $new_column_name ] = __( 'Like/Dislike', 'posts-like-dislike' );
                }
            }

            // Make sure our column has been added, if not, add it to the end.
            if( ! array_key_exists( $new_column_name, $new_columns ) )
            {
                    $new_columns[ $new_column_name ] = __( 'Like/Dislike', 'posts-like-dislike' );
            }

            return $new_columns;
        }

        public function manage_post_posts_custom_column($column_key, $post_id)
        {
            $new_column_name = 'like_dislike';

            if( $column_key == $new_column_name )
            {
                $pld_settings = $this->pld_settings;
                $like_count = get_post_meta( $post_id, 'pld_like_count', true );
                $dislike_count = get_post_meta( $post_id, 'pld_dislike_count', true );

                if( $like_count > 0 )
                {
                    $like_title = isset( $pld_settings['basic_settings']['like_hover_text']) ? esc_attr( $pld_settings['basic_settings']['like_hover_text'] ) : __( 'Like', PLD_TD );

                    switch( $pld_settings['design_settings']['template'] )
                    {
                        case 'template-1':
                            echo '<i class="dashicons dashicons-thumbs-up"></i>';
                            break;
                        case 'template-2':
                            echo '<i class="dashicons dashicons-heart"></i>';
                            break;
                        case 'template-3':
                            echo '<i class="dashicons dashicons-yes"></i>';
                            break;
                        case 'template-4':
                            echo '<i class="dashicons dashicons-smiley"></i>';
                        case 'custom':
                        if ($pld_settings['design_settings']['like_icon'] != '')
                        {
                            echo '<img src="' . esc_url( $pld_settings['design_settings']['like_icon'] ) . '" alt="' . esc_attr( $like_title ) . '"/>';
                        }
                        break;
                    }

                    echo "<span class='pld-like-count-wrap pld-count-wrap'>$like_count</span>";
                }

                if( $dislike_count > 0 )
                {
                    $dislike_title = isset( $pld_settings['basic_settings']['dislike_hover_text']) ? esc_attr( $pld_settings['basic_settings']['dislike_hover_text'] ) : __( 'Dislike', PLD_TD );

                    switch( $pld_settings['design_settings']['template'] )
                    {
                        case 'template-1':
                            echo '<i class="dashicons dashicons-thumbs-down"></i>';
                            break;
                        case 'template-2':
                            echo '<i class="dashicons dashicons-dismiss"></i>';
                            break;
                        case 'template-3':
                            echo '<i class="dashicons dashicons-no"></i>';
                            break;
                        case 'template-4':
                            echo '<i class="dashicons dashicons-dismiss"></i>';
                        case 'custom':
                        if ($pld_settings['design_settings']['like_icon'] != '')
                        {
                            echo '<img src="' . esc_url( $pld_settings['design_settings']['dislike_icon'] ) . '" alt="' . esc_attr( $dislike_title ) . '"/>';
                        }
                        break;
                    }

                    echo "<span class='pld-like-count-wrap pld-count-wrap'>$dislike_count</span>";
                }
            }
        }
    }

    new PLD_Hooks();
}
