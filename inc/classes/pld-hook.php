<?php

if (!class_exists('PLD_Hooks')) {
    class PLD_Hooks extends PLD_Library
    {
        protected $like_column_name     = 'pld_like_count';
        protected $dislike_column_name  = 'pld_dislike_count';
        protected $likes_enabled        = true;
        protected $dislikes_enabled     = true;

        private $filter_pattern = '\<\!\-\- \#\#\#START\#\#\# Post Like Dislike Content \-\-\>*.\<\!\-\- \#\#\#END\#\#\# Post Like Dislike Content \-\-\>';

        public function __construct()
        {
            parent::__construct();

            // Figure out if we're displaying likes, dislikes or both and set the class variables appropriately.
            if($this->pld_settings == 'both' || $this->pld_settings == 'like_only' )    { $this->likes_enabled = true; }
            if($this->pld_settings == 'both' || $this->pld_settings == 'dislike_only' ) { $this->dislikes_enabled = true; }
            if($this->pld_settings == 'like_only' )     { $this->dislikes_enabled = false; }
            if($this->pld_settings == 'dislike_only' )  { $this->likes_enabled = false; }

            add_filter('the_content', array($this, 'posts_like_dislike'), 200); // hook to add html for like dislike
            add_action('pld_like_dislike_output', array($this, 'generate_like_dislike_html'), 10, 3);
            add_action('wp_head', array($this, 'custom_styles'));
            add_shortcode('posts_like_dislike', array($this, 'render_pld_shortcode'));

            // Add filter to exclude copying the like/dislike counts when using Yoast Duplicate Posts.
            add_filter('duplicate_post_excludelist_filter', array($this, 'duplicate_post_excludelist_filter'));

            // Filter out the like/dislike counts on excerpts.
            add_filter('get_the_excerpt', array( $this, 'the_excerpt_filter'));

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

        public function the_excerpt_filter($excerpt)
	{
            return preg_replace( $this->filter_pattern, '', $excerpt );
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
            // Build the like/dislike icon based on the current design settings.
            $like_title = isset($pld_settings['basic_settings']['like_hover_text']) ? esc_attr($pld_settings['basic_settings']['like_hover_text']) : __('Like', PLD_TD);
            $dislike_title = isset($pld_settings['basic_settings']['dislike_hover_text']) ? esc_attr($pld_settings['basic_settings']['dislike_hover_text']) : __('Dislike', PLD_TD);

            switch ($this->pld_settings['design_settings']['template'])
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
                    if ($this->pld_settings['design_settings']['like_icon'] != '')
                    {
                        $like_icon = '<img src="' . esc_url($this->pld_settings['design_settings']['like_icon']) . '" alt="' . esc_attr($like_title) . '"/>';
                        $dislike_icon = '<img src="' . esc_url($this->pld_settings['design_settings']['dislike_icon']) . '" alt="' . esc_attr($dislike_title) . '"/>';
                    }
                    break;
            }

            // Add a span infront of them to make them look right in the screen options pulldown.
            $like_icon = '<span><span class="vers" title="' . __( 'Like', PLD_TD ) . '" aria-hidden="true"></span><span class="screen-reader-text">' . __( 'Like', PLD_TD ) . '</span></span>' . $like_icon;
            $dislike_icon = '<span><span class="vers" title="' . __( 'Dislike', PLD_TD ) . '" aria-hidden="true"></span><span class="screen-reader-text">' . __( 'Dislike', PLD_TD ) . '</span></span>' . $dislike_icon;

            // Loop through and create a new array, adding in our column at the right spot.
            foreach( $columns as $key => $value )
            {
                $new_columns[$key] = $value;

                if( $key == 'comments' )
                {
                    // Setup placeholders to set later.
                    if($this->likes_enabled) { $new_columns[ $this->like_column_name ] = '';}
                    if($this->dislikes_enabled) {$new_columns[ $this->dislike_column_name ] = '';}
                }
            }

            // Now actually set the new column values, if they weren't added in the above loop, they will be added to the end now.
            if($this->likes_enabled) { $new_columns[ $this->like_column_name ] = $like_icon;}
            if($this->dislikes_enabled) {$new_columns[ $this->dislike_column_name ] = $dislike_icon;}

            return $new_columns;
        }

        public function manage_post_posts_custom_column($column_key, $post_id)
        {
            if ($column_key == $this->like_column_name || $column_key == $this->dislike_column_name)
            {
                $pld_settings = $this->pld_settings;
                $like_count = intval( get_post_meta( $post_id, 'pld_like_count', true ) );
                $dislike_count = intval( get_post_meta( $post_id, 'pld_dislike_count', true ) );

                if ($column_key == $this->like_column_name )
                {
                    echo $like_count > 0 ? $like_count : '—';
                }

                if( $column_key == $this->dislike_column_name)
                {
                    echo $dislike_count > 0 ? $dislike_count : '—';
                }
            }
        }

        public function manage_post_posts_sortable_columns($columns)
        {
            $columns['pld_like_count']      = 'pld_like_count';
            $columns['pld_dislike_count']   = 'pld_dislike_count';

            return $columns;
        }

        public function pre_get_posts($query)
        {
            global $wpdb;

            // Only filter in the admin
            if( ! is_admin() )
                return;

            $orderby = $query->get( 'orderby');

            // Filter if orderby is set to 'pld_like_count'
            if( $this->like_column_name == $orderby )
            {
                $query->set('meta_key',$this->like_column_name);
                $query->set('orderby',$this->like_column_name);
            }

            // Filter if orderby is set to 'pld_dislike_count'
            if( $this->like_discolumn_name == $orderby )
            {
                $query->set('meta_key',$this->like_discolumn_name);
                $query->set('orderby',$this->like_discolumn_name);
            }
        }
    }

    new PLD_Hooks();
}
