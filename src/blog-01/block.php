<?php 
ob_start();

include KENZAP_BLOG.'/src/commonComponents/container/container-cont.php';

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	'post_status'       => 'publish',
	'post_type'         => 'post',
	'category_name'     => $attributes['category'],
	'posts_per_page'    => $attributes['per_page'],
	'paged'             => $paged,
);

if($attributes['ignoreNoImage']){ $args['meta_key'] = '_thumbnail_id'; }
if($attributes['ignoreSticky']){ $args['ignore_sticky_posts'] = 1; }

// block is previed in wp editor
if($attributes['serverSide']){ $kenzapSize="kenzap-sm"; }

//product order sorting
switch ( $attributes['orderby'] ) {
	case 'date/desc':
		$args['orderby'] = array( 'date' => 'DESC' );   
	break;
	case 'date/asc':
		$args['orderby'] = array( 'date' => 'ASC' );   
	break;
	case 'title/desc':
		$args['orderby'] = 'title';  
		$args['order'] = 'DESC';
	break;
	case 'title/asc':
		$args['orderby'] = 'title';  
		$args['order'] = 'ASC';
	break;
}
		
$postCount = 0;
$recentPosts = new WP_Query( $args );

if ( $recentPosts->have_posts() ) : ?>

	<div class="kenzap-blog-1 <?php echo esc_attr($attributes['displayType'])." "; if($attributes['autoPadding']){ echo ' autoPadding '; } if(isset($attributes['className'])) echo esc_attr($attributes['className'])." "; ?>" style="--mc:<?php echo esc_attr($attributes['mainColor']); ?>;--tc:<?php echo esc_attr($attributes['textColor']); ?>; <?php echo ($kenzapStyles);//escaped in src/commonComponents/container/container-cont.php ?>">

		<div class="kenzap-container <?php echo esc_attr($kenzapSize); ?>" style="max-width:<?php echo esc_attr($attributes['containerMaxWidth']);?>px;">
			<div class="kenzap-row">

				<?php while( $recentPosts->have_posts() ) : 
					$recentPosts->the_post();
					$meta = get_post_meta( get_the_ID() ); ?>
	
					<div class="<?php if($attributes['columns']=='large'){ echo 'kenzap-col-4'; }else{ echo 'kenzap-col-5th'; } ?>">
						<div class="blog-item">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="blog-img">
									<a <?php if($attributes['serverSide']){ echo 'target="_blank"'; } ?> href="<?php echo get_the_permalink(); ?>" style="background-image:url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'kenzap-blog-medium', false ); ?>)"></a>
								</div>
							<?php else: ?>
								<div class="blog-img"> 
									<a <?php if($attributes['serverSide']){ echo 'target="_blank"'; } ?> href="<?php echo get_the_permalink(); ?>" ></a>
								</div>
							<?php endif; ?>		
							<div class="blog-info">
								<ul class="blog-meta <?php if(!$attributes['showDate'] && !$attributes['showCategory']) echo 'hidden'; ?>">
									<?php if($attributes['showDate']){ ?>
										<li>
											<a <?php if($attributes['serverSide']){ echo 'target="_blank"'; } ?> href="javascript:;"><?php echo get_the_date(); ?></a>
										</li>
									<?php } ?>
									<?php if($attributes['showCategory']){ 
										$category = get_the_category(); if(isset($category[0])){ ?>
											<li>
												<a <?php if($attributes['serverSide']){ echo 'target="_blank"'; } ?> href="<?php echo get_category_link($category[0]->term_id); ?>"><?php echo esc_html($category[0]->cat_name); ?></a>
											</li>
										<?php }
									} ?>
								</ul>
								<h3 class="blog-title">
									<a <?php if($attributes['serverSide']){ echo 'target="_blank"'; } ?> href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<div class="blog-author"><?php echo esc_html__('by', 'kenzap-blog')." "; the_author_posts_link(); ?></div>
							</div>
						</div>
					</div>

				<?php endwhile; ?>

			</div>
			<?php if( !$attributes['serverSide'] && $attributes['pagination'] ){
		
				$pagenum_link = get_pagenum_link(999999999);
				kenzap_blog_01_pagination( 'kp-blog-pagination', $recentPosts, $pagenum_link ); 
				
			} ?>
		</div>



	</div>
<?php else: ?>

	<?php echo esc_html__('no posts to display', 'kenzap-blog'); ?>			

<?php endif;


$buffer = ob_get_clean();
return $buffer;