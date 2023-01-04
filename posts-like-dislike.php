<?php

defined('ABSPATH') or die('No script kiddies please');

/*
  Plugin Name: Posts Like Dislike
  Description: A simple plugin to add like dislike for your WordPress Posts
  Version:     2.0
  Author:      WP Happy Coders
  Author URI:  http://wphappycoders.com
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: posts-like-dislike
 */


if (!class_exists('PLD_Comments_Like_Dislike')) {
    class PLD_Comments_Like_Dislike
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
            include_once PLD_PATH . '/inc/classes/pld-library.php';
            include_once PLD_PATH . '/inc/classes/pld-activation.php';
            include_once PLD_PATH . 'inc/classes/pld-init.php';
            include_once PLD_PATH . 'inc/classes/pld-admin.php';
            include_once PLD_PATH . 'inc/classes/pld-enqueue.php';
            include_once PLD_PATH . 'inc/classes/pld-hook.php';
            include_once PLD_PATH . 'inc/classes/pld-ajax.php';
        }

        /**
         * Define necessary constants
         *
         * @since 1.0.0
         */
        public function define_constants()
        {
            if (! defined('PLD_PATH') ) {
                define('PLD_PATH', plugin_dir_path(__FILE__));
            }

            if (! defined('PLD_IMG_DIR') ) {
                define('PLD_IMG_DIR', plugin_dir_url(__FILE__) . 'images');
            }

            if (! defined('PLD_CSS_DIR') ) {
                define('PLD_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
            }

            if (! defined('PLD_JS_DIR') ) {
                define('PLD_JS_DIR', plugin_dir_url(__FILE__) . 'js');
            }

            if (! defined('PLD_VERSION') ) {
                define('PLD_VERSION', '1.0.8');
            }

            if (! defined('PLD_BASENAME') ) {
                define('PLD_BASENAME', plugin_basename(__FILE__));
            }
        }
    }

    $pld_object = new PLD_Comments_Like_Dislike();
}
