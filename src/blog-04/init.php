<?php 

function kenzap_blog_listing_04() {

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
			'type'    => 'string',
			'default' => '4',
		),
		'ignoreNoImage'    => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'ignoreSticky'    => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'showCategory'    => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'showDate'    => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'showComments'    => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'showTags'    => array(
			'type'    => 'boolean',
			'default' => false,
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
	register_block_type( 'kenzap/blog-04', array(
		'attributes'      => array_merge($contAttributes, $attributes),
		'render_callback' => 'kenzap_blog_rendering_04',
	) );

    //backend rendering function
    function kenzap_blog_rendering_04( $attributes ) {

        return require_once 'block.php';
	}
}
add_action( 'init', 'kenzap_blog_listing_04' );

?>