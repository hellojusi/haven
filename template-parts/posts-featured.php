<?php 

$pIDs = get_theme_mod('hvn_slider_posts', '');

$args = array(
	'post_type' => 'post',
	'post__in' => $pIDs,
	'post__not_in' => get_option('sticky_posts'),
	'order' => 'ASC'
);

$featured_posts = new WP_Query( $args );
if ( $pIDs && $featured_posts->have_posts() ) :

$pause = (get_theme_mod('hvn_enable_slider_pause', true) == '1') ? 'true' : 'false'; ?>

<div class="featured-posts cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-slides="> div.featured-item" data-cycle-timeout="<?php echo get_theme_mod('hvn_slider_timeout', '5000'); ?>" data-cycle-pause-on-hover="<?php echo $pause; ?>">

	<?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post();
		$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
 	?>

		<div class="featured-item" style="background-image:url('<?php echo $featured_image[0]; ?>');">
			<div class="featured-intro">
				<div class="entry-header">
					<span class="cat"><?php the_category(', '); ?></span>
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
					<?php haven_posted_on(); ?>
				</div>
			</div>
		</div>

 	<?php endwhile; ?>

 	<div class="cycle-pager"></div>

</div>

<?php endif; wp_reset_postdata(); ?>