<?php

defined('ABSPATH') or die('No script kiddies please');

/*
  Plugin Name: Just Likes and Dislikes
  Description: A simple plugin to add like dislike to WordPress.
  Version:     2.0
  Author:      GregRoss
  Author URI:  http://toolstack.com
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: just-likes-and-dislikes
 */


if (!class_exists('JLAD_Comments_Like_Dislike')) {
    class JLAD_Comments_Like_Dislike
    {
        public function __construct()
        {
            $this->define_constants();
            $this->includes();
        }

        /**
         * Include all the necessary files
         *
         * @since 1.0.0
         */
        public function includes()
        {
            include_once JLAD_PATH . '/inc/classes/jlad-library.php';
            include_once JLAD_PATH . '/inc/classes/jlad-activation.php';
            include_once JLAD_PATH . 'inc/classes/jlad-init.php';
            include_once JLAD_PATH . 'inc/classes/jlad-admin.php';
            include_once JLAD_PATH . 'inc/classes/jlad-enqueue.php';
            include_once JLAD_PATH . 'inc/classes/jlad-hook.php';
            include_once JLAD_PATH . 'inc/classes/jlad-ajax.php';
        }

        /**
         * Define necessary constants
         *
         * @since 1.0.0
         */
        public function define_constants()
        {
            if (! defined('JLAD_PATH') ) {
                define('JLAD_PATH', plugin_dir_path(__FILE__));
            }

            if (! defined('JLAD_IMG_DIR') ) {
                define('JLAD_IMG_DIR', plugin_dir_url(__FILE__) . 'images');
            }

            if (! defined('JLAD_CSS_DIR') ) {
                define('JLAD_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
            }

            if (! defined('JLAD_JS_DIR') ) {
                define('JLAD_JS_DIR', plugin_dir_url(__FILE__) . 'js');
            }

            if (! defined('JLAD_VERSION') ) {
                define('JLAD_VERSION', '1.0.8');
            }

            if (! defined('JLAD_BASENAME') ) {
                define('JLAD_BASENAME', plugin_basename(__FILE__));
            }
        }
    }

    $jlad_object = new JLAD_Comments_Like_Dislike();
}
