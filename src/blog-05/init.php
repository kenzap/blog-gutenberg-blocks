<?php 

function kenzap_blog_listing_05() {

	require KENZAP_BLOG.'/src/commonComponents/container/container-var.php';

	$attributes = array(
		'serverSide'    => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'displayType' => array(
			'type'    => 'string',
			'default' => 'kp-horizontal',
		),
		'columns' => array(
			'type'    => 'number',
			'default' => 5,
		),
		'ignoreNoImage'    => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'showSticky'    => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'showCategory'    => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'showDate'    => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'showComments'    => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'showTags'    => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'category' => array(
			'type'    => 'string',
			'default' => "",
		),
		'per_page' => array(
			'type'    => 'number',
			'default' => 5,
		),
		'textColor' => array(
			'type' => 'string',	
			'default' => '#333'
		),
		'orderby' => array(
			'type' => 'string',	
			'default' => 'date/desc'
		),
		'pagination' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'mainColor' => array(
			'type' => 'string',	
			'default' => '#ff6600'
		),
	);

	// Register block PHP
	register_block_type( 'kenzap/blog-05', array(
		'attributes'      => array_merge($contAttributes, $attributes),
		'render_callback' => 'kenzap_blog_rendering_05',
	) );

    //backend rendering function
    function kenzap_blog_rendering_05( $attributes ) {

        return require_once 'block.php';
	}
}
add_action( 'init', 'kenzap_blog_listing_05' );

?>