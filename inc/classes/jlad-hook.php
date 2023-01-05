<?php

if (!class_exists('JLAD_Hooks')) {
    class JLAD_Hooks extends JLAD_Library
    {
        protected $like_column_name     = 'jlad_like_count';
        protected $dislike_column_name  = 'jlad_dislike_count';
        protected $likes_enabled        = true;
        protected $dislikes_enabled     = true;

        private $before_filter_pattern = '/^[\s*\d+]+/';
        private $after_filter_pattern = '/[\s*\d+]+$/';

        public function __construct()
        {
            parent::__construct();

            $display_type = $this->jlad_settings['basic_settings']['like_dislike_display'];

            // Figure out if we're displaying likes, dislikes or both and set the class variables appropriately.
            if($display_type == 'both' || $display_type == 'like_only' ) {
                $this->likes_enabled = true;
            }

            if($display_type == 'both' || $display_type == 'dislike_only' ) {
                $this->dislikes_enabled = true;
            }

            if($display_type == 'like_only' ) {
                $this->dislikes_enabled = false;
            }

            if($display_type == 'dislike_only' ) {
                $this->likes_enabled = false;
            }

            add_filter('the_content', array($this, 'posts_like_dislike'), 200); // hook to add html for like dislike
            add_action('jlad_like_dislike_output', array($this, 'generate_like_dislike_html'), 10, 3);
            add_action('wp_head', array($this, 'custom_styles'));
            add_shortcode('posts_like_dislike', array($this, 'render_jlad_shortcode'));

            // Add filter to exclude copying the like/dislike counts when using Yoast Duplicate Posts.
            add_filter('duplicate_post_excludelist_filter', array($this, 'duplicate_post_excludelist_filter'));

            // Filter out the like/dislike counts on excerpts.
            add_filter('get_the_excerpt', array( $this, 'the_excerpt_filter'));

            if( ! $this->jlad_settings['basic_settings']['hide_like_dislike_admin'] ) {
                // Add an admin column for like/dislikes
                add_action('pre_get_posts', array($this,'pre_get_posts'));
                $available_post_types = get_post_types(array(), 'names');

                foreach( $available_post_types as $type )
                {
                    add_filter('manage_edit-' . $type . '_sortable_columns', array($this, 'manage_post_posts_sortable_columns' ));
                    add_filter('manage_' . $type . '_posts_columns', array($this, 'manage_post_posts_columns'));
                    add_action('manage_' . $type . '_posts_custom_column', array($this,'manage_post_posts_custom_column'), 10, 2);
                }
            }
        }

        public function the_excerpt_filter($excerpt)
        {
            if ($this->jlad_settings['basic_settings']['like_dislike_position'] == 'before') {
                $new_excerpt = preg_replace($this->before_filter_pattern, '', $excerpt);
            }

            if ($this->jlad_settings['basic_settings']['like_dislike_position'] == 'after') {
                $new_excerpt = preg_replace($this->after_filter_pattern, '', $excerpt);
            }

            // Make sure we got a string back, otherwise something went wrong and just return the old except.
            if(is_string($new_excerpt) ) { $excerpt = $new_excerpt;
            }

            return $excerpt;
        }

        public function posts_like_dislike($content)
        {
            include JLAD_PATH . '/inc/cores/like-dislike-render.php';
            return $content;
        }

        public function duplicate_post_excludelist_filter($meta_excludelist)
        {
            // Merges the defaults array with our own array of custom fields.
            return array_merge($meta_excludelist, ['jlad_like_count', 'jlad_dislike_count']);
        }

        public function render_jlad_shortcode($atts)
        {
            $content = '';
            $shortcode = true;
            include JLAD_PATH . '/inc/cores/like-dislike-render.php';
            return $content;
        }

        public function generate_like_dislike_html($content, $shortcode, $atts)
        {
            include JLAD_PATH . '/inc/views/frontend/like-dislike-html.php';
        }

        public function custom_styles()
        {
            $jlad_settings = $this->jlad_settings;

            echo "<style>";
            if ($jlad_settings['design_settings']['icon_color'] != '') {
                echo 'a.jlad-like-dislike-trigger {color: ' . esc_attr($jlad_settings['design_settings']['icon_color']) . ';}';
            }
            if ($jlad_settings['design_settings']['count_color'] != '') {
                echo 'span.jlad-count-wrap {color: ' . esc_attr($jlad_settings['design_settings']['count_color']) . ';}';
            }
            echo "</style>";
        }

        public function manage_post_posts_columns($columns)
        {
            // Build the like/dislike icon based on the current design settings.
            $like_title = isset($jlad_settings['basic_settings']['like_hover_text']) ? esc_attr($jlad_settings['basic_settings']['like_hover_text']) : __('Like', 'just-likes-and-dislikes');
            $dislike_title = isset($jlad_settings['basic_settings']['dislike_hover_text']) ? esc_attr($jlad_settings['basic_settings']['dislike_hover_text']) : __('Dislike', 'just-likes-and-dislikes');

            switch ($this->jlad_settings['design_settings']['template'])
            {
            case 'template-1':
                $like_icon      = '<i class="fas fa-thumbs-up"></i>';
                $dislike_icon   = '<i class="fas fa-thumbs-down"></i>';
                break;
            case 'template-2':
                $like_icon      = '<i class="fas fa-heart"></i>';
                $dislike_icon   = '<i class="fa fa-heartbeat"></i>';
                break;
            case 'template-3':
                $like_icon      = '<i class="fas fa-check"></i>';
                $dislike_icon   = '<i class="fas fa-times"></i>';
                break;
            case 'template-4':
                $like_icon      = '<i class="far fa-smile"></i>';
                $dislike_icon   = '<i class="far fa-frown"></i>';
                break;
            case 'custom':
                if ($this->jlad_settings['design_settings']['like_icon'] != '') {
                    $like_icon = '<img src="' . esc_url($this->jlad_settings['design_settings']['like_icon']) . '" alt="' . esc_attr($like_title) . '"/>';
                    $dislike_icon = '<img src="' . esc_url($this->jlad_settings['design_settings']['dislike_icon']) . '" alt="' . esc_attr($dislike_title) . '"/>';
                }
                break;
            }

            // Add a span infront of them to make them look right in the screen options pulldown.
            $like_icon = '<span><span class="vers" title="' . __('Like', 'just-likes-and-dislikes') . '" aria-hidden="true"></span><span class="screen-reader-text">' . __('Like', 'just-likes-and-dislikes') . '</span></span>' . $like_icon;
            $dislike_icon = '<span><span class="vers" title="' . __('Dislike', 'just-likes-and-dislikes') . '" aria-hidden="true"></span><span class="screen-reader-text">' . __('Dislike', 'just-likes-and-dislikes') . '</span></span>' . $dislike_icon;

            // Loop through and create a new array, adding in our column at the right spot.
            foreach( $columns as $key => $value )
            {
                $new_columns[$key] = $value;

                if($key == 'comments' ) {
                    // Setup placeholders to set later.
                    if($this->likes_enabled) { $new_columns[ $this->like_column_name ] = '';
                    }
                    if($this->dislikes_enabled) {$new_columns[ $this->dislike_column_name ] = '';
                    }
                }
            }

            // Now actually set the new column values, if they weren't added in the above loop, they will be added to the end now.
            if($this->likes_enabled) { $new_columns[ $this->like_column_name ] = $like_icon;
            }
            if($this->dislikes_enabled) {$new_columns[ $this->dislike_column_name ] = $dislike_icon;
            }

            return $new_columns;
        }

        public function manage_post_posts_custom_column($column_key, $post_id)
        {
            if ($column_key == $this->like_column_name || $column_key == $this->dislike_column_name) {
                $jlad_settings = $this->jlad_settings;
                $like_count = intval(get_post_meta($post_id, 'jlad_like_count', true));
                $dislike_count = intval(get_post_meta($post_id, 'jlad_dislike_count', true));

                if ($column_key == $this->like_column_name ) {
                    echo $like_count > 0 ? $like_count : '—';
                }

                if($column_key == $this->dislike_column_name) {
                    echo $dislike_count > 0 ? $dislike_count : '—';
                }
            }
        }

        public function manage_post_posts_sortable_columns($columns)
        {
            $columns['jlad_like_count']      = 'jlad_like_count';
            $columns['jlad_dislike_count']   = 'jlad_dislike_count';

            return $columns;
        }

        public function pre_get_posts($query)
        {
            global $wpdb;

            // Only filter in the admin
            if(! is_admin() ) {
                return;
            }

            $orderby = $query->get('orderby');

            // Filter if orderby is set to 'jlad_like_count'
            if($this->like_column_name == $orderby ) {
                $query->set('meta_key', $this->like_column_name);
                $query->set('orderby', $this->like_column_name);
            }

            // Filter if orderby is set to 'jlad_dislike_count'
            if($this->dislike_column_name == $orderby ) {
                $query->set('meta_key', $this->dislike_column_name);
                $query->set('orderby', $this->dislike_column_name);
            }
        }
    }

    new JLAD_Hooks();
}
