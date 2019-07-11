<?php
/**
 * Plugin Name: Kenzap Blog
 * Plugin URI: https://github.com/kenzap/kenzap-blog-gutenberg-blocks/
 * Description: Easily create and customize blog section on your website
 * Author: Kenzap
 * Author URI: https://kenzap.com
 * Version: 1.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: kenzap-blog
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define("KENZAP_BLOG", __DIR__);

function kenzap_blog_load_textdomain() {

    $locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
    $locale = apply_filters( 'plugin_locale', $locale, 'kenzap-blog' );

    unload_textdomain( 'kenzap-blog' );
    load_textdomain( 'kenzap-blog', __DIR__ . '/languages/kenzap-blog-' . $locale . '.mo' );
    load_plugin_textdomain( 'kenzap-blog', false, __DIR__ . '/languages' );
}
add_action( 'init', 'kenzap_blog_load_textdomain' );

//Load body class
function kenzap_blog_body_class( $classes ) {

	if ( is_array($classes) ){ $classes[] = 'kenzap'; }else{ $classes.=' kenzap'; }
	return $classes;
}
add_filter( 'body_class', 'kenzap_blog_body_class' );
add_filter( 'admin_body_class', 'kenzap_blog_body_class' );

//Check plugin requirements
if (version_compare(PHP_VERSION, '5.6', '<')) {
    if (! function_exists('kenzap_blog_disable_plugin')) {
        /**
         * Disable plugin
         *
         * @return void
         */
        function kenzap_blog_disable_plugin(){

            if (current_user_can('activate_plugins') && is_plugin_active(plugin_basename(__FILE__))) {
                deactivate_plugins(__FILE__);
                unset($_GET['activate']);
            }
        }
    }

    if (! function_exists('kenzap_blog_show_error')) {
        /**
         * Show error
         *
         * @return void
         */
        function kenzap_blog_show_error(){

            echo '<div class="error"><p><strong>Kenzap Blog Gutenberg Blocks</strong> need at least PHP 5.6 version, please update php before installing the plugin.</p></div>';
        }
    }

    //Add actions
    add_action('admin_init', 'kenzap_blog_disable_plugin');
    add_action('admin_notices', 'kenzap_blog_show_error');

    //Do not load anything more
    return;
}

// add_image_size( 'kenzap-blog-medium', 550, 0, false );
// add_image_size( 'kenzap-blog-large', 950, 0, false );

add_image_size("kp_banner", 1200);
add_image_size("kp_l", 600);

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

