<?php

defined('ABSPATH') or die('No script kiddies please!!');
if (!class_exists('JLAD_Activation') ) {

    class JLAD_Activation extends JLAD_Library
    {

        /**
         * Includes all the activation tasks
         *
         * @since 1.0.0
         */
        function __construct()
        {
            register_activation_hook(JLAD_PATH . 'just-likes-and-dislikes.php', array( $this, 'activation_tasks' ));
        }

        /**
         * Store default settings in database on activation
         *
         * @since 1.0.0
         */
        function activation_tasks()
        {
            $default_settings = $this->get_default_settings();

            if(!get_option('jlad_settings')) {
                update_option('jlad_settings', $default_settings);
            }

            register_post_meta('posts', 'jlad_like_count', array('default' => 0));
            register_post_meta('posts', 'jlad_dislike_count', array('default' => 0));
        }



    }

    new JLAD_Activation();
}