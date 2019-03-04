<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define("KENZAP_BLOG_PATH", plugins_url( 'dist/', dirname( __FILE__ ) ));

function kenzap_blog_list_init() {
    $locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
    $locale = apply_filters( 'plugin_locale', $locale, 'kenzap-blog' );

    unload_textdomain( 'kenzap-blog' );
    load_textdomain( 'kenzap-blog', __DIR__ . '/languages/kenzap-blog-' . $locale . '.mo' );
    load_plugin_textdomain( 'kenzap-blog', false, __DIR__ . '/languages' );
}
add_action( 'init', 'kenzap_blog_list_init' );

//Load body class
function kenzap_blog_list_body_class( $classes ) {

	if ( is_array($classes) ){ $classes[] = 'kenzap'; }else{ $classes.=' kenzap'; }
	return $classes;
}
add_filter( 'body_class', 'kenzap_blog_list_body_class' );
add_filter( 'admin_body_class', 'kenzap_blog_list_body_class' );

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * `wp-blocks`: includes block type registration and related functions.
 *
 * @since 1.0.0
 */
function kenzap_blog_list_block_assets() {
	// Styles.
	wp_enqueue_style(
		'kenzap_blog_list_style-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array()
	);
}

// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'kenzap_blog_list_block_assets' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * `wp-blocks`: includes block type registration and related functions.
 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
 * `wp-i18n`: To internationalize the block's text.
 *
 * @since 1.0.0
 */
function kenzap_blog_list_editor_assets() {
	// Scripts.
	wp_enqueue_script(
		'kenzap-blog', // Handle.
		plugins_url( 'dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ), // Dependencies, defined above.
        // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Styles.
	wp_enqueue_style(
		'kenzap-blog', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: filemtime — Gets file modification time.
    );
    
    // This is only available in WP5.
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'kenzap-blog', 'kenzap-blog', KENZAP_BLOG . '/languages/' );
	}

    wp_add_inline_script( 'wp-blocks', 'var kenzap_blog_gutenberg_path = "' .KENZAP_BLOG_PATH.'"', 'before');
} // End function kenzap_feature_list_cgb_editor_assets().

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'kenzap_blog_list_editor_assets' );

// kenzap blog add specific features
function kenzap_blog_add_specific_features( $post_object ) {
    if(!function_exists('has_blocks') || !function_exists('parse_blocks'))
        return;

    if ( has_blocks( $post_object ) ) {
		
        $blocks = parse_blocks( $post_object ->post_content );
        foreach ($blocks as $block) {

            if ($block['blockName'] == 'kenzap/blog-03') {
                wp_register_script( 'masonry', KENZAP_BLOG_PATH . 'packery-mode.pkgd.min.js');
                wp_enqueue_script( 'masonry' );
                wp_enqueue_script( 'kenzap/blog-03', plugins_url( 'blog-03/script.js', __FILE__ ), array('jquery') );
			}
			
			if ($block['blockName'] == 'kenzap/blog-05') {
                wp_register_script( 'owl-carousel', KENZAP_BLOG_PATH . 'owl-carousel/owl.carousel.min.js');
				wp_enqueue_script( 'owl-carousel' );
		    	wp_register_style('owl-carousel', KENZAP_BLOG_PATH.'owl-carousel/owl.carousel.css');
            	wp_enqueue_style( 'owl-carousel');
                wp_enqueue_script( 'kenzap/blog-05', plugins_url( 'blog-05/script.js', __FILE__ ), array('jquery') );
            }
        }
    }
}
add_action( 'the_post', 'kenzap_blog_add_specific_features' );

// Universal pagination method for all blocks
if ( ! function_exists( 'kenzap_blog_01_pagination' ) ) :

	function kenzap_blog_01_pagination($class, $recentPosts, $pagenum_link){
	
		echo '<div class="'.esc_attr( $class ).'">';
		$big = 999999999; // need an unlikely integer
		$pagination = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( $pagenum_link ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $recentPosts->max_num_pages,
			'type' => 'array',
			'prev_next'  => TRUE,
			'prev_text'     => '<span aria-hidden="true"> '.esc_html__( 'Previous', 'kenzap-blog' ).'</span>',
			'next_text'     => '<span aria-hidden="true">'.esc_html__( 'Next', 'kenzap-blog' ).' </span>'
			) );
			
			if( is_array( $pagination ) ) {
				$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
				echo '<ul>';
				foreach ( $pagination as $page ) {
					echo "<li>$page</li>";
				}
				echo '</ul>';
			}
	
		echo '</div>';
	}
	
endif;

//register blocks
require_once 'blog-01/init.php';
require_once 'blog-02/init.php';
require_once 'blog-03/init.php';
require_once 'blog-04/init.php';
require_once 'blog-05/init.php';
require_once 'blog-06/init.php';