<?php

if ( !class_exists( 'PLD_Hooks' ) ) {

    class PLD_Hooks extends PLD_Library {

        function __construct() {
            parent::__construct();
            add_filter( 'the_content', array( $this, 'posts_like_dislike' ), 200 ); // hook to add html for like dislike
            add_action( 'pld_like_dislike_output', array( $this, 'generate_like_dislike_html' ), 10 );
            add_action( 'wp_head', array( $this, 'custom_styles' ) );
        }

        function posts_like_dislike( $content ) {
            $pld_settings = $this->pld_settings;
            $checked_post_types = (!empty( $pld_settings['basic_settings']['post_types'] )) ? $pld_settings['basic_settings']['post_types'] : array( 'post' );

            global $post;
            if ( empty( $post ) ) {
                return $content;
            }
            if ( !in_array( $post->post_type, $checked_post_types ) ) {
                return $content;
            }
            /**
             * Don't implement on admin section
             *
             * @since 1.0.0
             */
            if ( is_admin() ) {
                return $content;
            }
            ob_start();

            /**
             * Fires while generating the like dislike html
             *
             * @param type string $content
             *
             * @since 1.0.0
             */
            do_action( 'pld_like_dislike_output', $content );

            $like_dislike_html = ob_get_contents();
            ob_end_clean();

            if ( $pld_settings['basic_settings']['like_dislike_position'] == 'after' ) {
                /**
                 * Filters Like Dislike HTML
                 *
                 * @param string $like_dislike_html
                 * @param array $pld_settings
                 *
                 * @since 1.0.0
                 */
                $content .= apply_filters( 'pld_like_dislike_html', $like_dislike_html, $pld_settings );
            } else {
                $content = apply_filters( 'pld_like_dislike_html', $like_dislike_html, $pld_settings ) . $content;
            }
            return $content;
        }

        function generate_like_dislike_html( $content ) {
            include(PLD_PATH . '/inc/views/frontend/like-dislike-html.php');
        }

        function custom_styles() {
            $pld_settings = $this->pld_settings;
            echo "<style>";
            if ( $pld_settings['design_settings']['icon_color'] != '' ) {
                echo 'a.pld-like-dislike-trigger {color: ' . esc_attr( $pld_settings['design_settings']['icon_color'] ) . ';}';
            }
            if ( $pld_settings['design_settings']['count_color'] != '' ) {
                echo 'span.pld-count-wrap {color: ' . esc_attr( $pld_settings['design_settings']['count_color'] ) . ';}';
            }
            echo "</style>";
        }

    }

    new PLD_Hooks();
}
