<?php
/**
 * Custom widget for displaying Recent Posts with enhanced options
 * Supports custom post types, thumbnails, and excerpts.
 */


// Creates the widget
 class Widget_Whiteberry_Featured_Posts extends WP_Widget {

	// Register widget with WordPress.
	public function __construct() {
		//global $wid, $wname;
		parent::__construct(
	 		'wberry_featured_posts', // Base ID
			'Haven: Featured Posts', // Name
			array( 'description' => __( 'Displays featured posts based on selected criteria.', 'haven' ), ) // Args
		);
	}

	// Front-end display of widget.
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$numposts = $instance['num_posts'];
		$post_type = $instance['post_type'];
		$date_format = $instance['date_format'];
		$layout = $instance['layout'];
		$criteria = $instance['criteria'];

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;


		if ( $criteria == 'latest' ) {

			$featuredquery = new WP_Query(array ('post_type' => $post_type, "post__not_in" =>get_option("sticky_posts"), 'posts_per_page' => $numposts));

		} elseif ( $criteria == 'popular' ) {

			$featuredquery = new WP_Query(array ('post_type' => $post_type, "post__not_in" =>get_option("sticky_posts"), 'posts_per_page' => $numposts, 'orderby' => 'comment_count'));

		}

		$counter = 0;

			if ( $layout == 'wberry-layout-slideshow' ) { ?>
				<div class="wberry-post-slider cycle-slideshow" data-cycle-fx="fade" data-cycle-pause-on-hover="true" data-cycle-slides="> .wberry-post">
			<?php }

			while ($featuredquery->have_posts() ) : $featuredquery->the_post();
			$counter += 1;
			?>

			<div class="wberry-post wberry-post-<?php echo $counter; ?> <?php echo $layout; ?>">


				<div class="wberry-thumb wow fadeIn">
					<a href="<?php the_permalink(); ?>">
						<?php if ( $layout != 'none' && $layout == 'wberry-layout-list' ) { 
							the_post_thumbnail('thumbnail');
						} else {
							the_post_thumbnail('featured');
						} ?>
					</a>
				</div>
				
				<div class="wberry-content">
					<?php if ( $date_format != 'none' && $date_format != '' ) { ?>

						<div class="wberry-date">
							<?php the_time($date_format); ?>
							<?php if ( $criteria == 'popular' ) {
								echo '<a href="'.get_the_permalink().'/#comments" class="comment-count">&middot; ';
								comments_number( '0', '1', '%' );
								echo '</a>';
							} ?>
						</div>

					<?php } ?>

					<h4 class="wberry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>	
				</div>

				
			</div>

			<?php endwhile; ?>
			<?php wp_reset_query();

			if ( $layout == 'wberry-layout-slideshow' ) { ?>
				</div><!-- /wberry-post-slider -->
			<?php }

		echo $after_widget;
	}

	// Sanitize widget form values as they are saved.
	public function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array( );
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['num_posts'] = intval($new_instance['num_posts']);
		$instance['date_format'] = strip_tags($new_instance['date_format']);
		$instance['layout'] = strip_tags($new_instance['layout']);
		$instance['criteria'] = strip_tags($new_instance['criteria']);

		return $instance;
	}

	// Back-end widget form.
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( ) );
		if ( isset($instance['title']) )
			$title = esc_attr( $instance['title'] );
		else
			$title = '';

		if ( isset($instance['criteria']) )
			$criteria = esc_attr( $instance['criteria'] );
		else
			$criteria = 'latest';

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'haven'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Select Post Type:', 'haven'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
			<option value="post">Posts (default)</option>

			<?php

			$args=array(
				  '_builtin' => false
			); 
			$post_types = get_post_types( $args ); // get all CPTs

			foreach ( $post_types as $post_type ) {
				$obj = get_post_type_object($post_type);
				$post_type_id = $obj->name;
				$post_type_name = $obj->labels->name;
				echo '<option value="' . $post_type_id . '"'
					. (  $post_type_id == $instance['post_type'] ? ' selected="selected"' : '' )
					. '>' . $post_type_name . "</option>\n";
			}
			?>
			</select>
		</p>  


		<p>
			<label for="<?php echo $this->get_field_id('criteria'); ?>"><?php _e('Criteria:', 'haven'); ?></label>

			<select class="widefat" id="wberry-criteria-field" name="<?php echo $this->get_field_name('criteria'); ?>">
			
				<?php
				$options = array(
					'latest' => 'Latest Posts', 
					'popular' => 'Most Discussed Posts', 
					);
				
				foreach ($options as $a => $b) {
					echo '<option value="' . $a . '"'
						. ( $a == $instance['criteria'] ? ' selected="selected"' : '' )
						. '>' . $b . "</option>\n";
				}
				
				?>
			</select>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('# of Posts:', 'haven'); ?></label>
			<select class="widefat" id="wberry-num-posts" name="<?php echo $this->get_field_name('num_posts'); ?>">

			<?php
			for ($i = 1; $i <= 10; $i++) {

				echo '<option value="' . intval($i) . '"'
					. ( $i == $instance['num_posts'] ? ' selected="selected"' : '' )
					. '>' . $i . "</option>\n";
			}
			?>
			</select>
		</p> 

		<p>
			<label for="<?php echo $this->get_field_id('date_format'); ?>"><?php _e('Date Format:', 'haven'); ?></label>

			<select class="widefat" id="wberry-date-format" name="<?php echo $this->get_field_name('date_format'); ?>">
			
				<option value="none">(no date)</option>

				<?php
				$dates = array(
					'F j, Y' => 'June 1, 2012',
					'M j, Y' => 'Jun 1, 2012', 
					'F j' => 'June 1', 
					'm/d/Y' => '6/1/2012', 
					'm/d/y' => '6/1/12'
					);
				
				foreach ($dates as $k => $v) {
					echo '<option value="' . $k . '"'
						. ( $k == $instance['date_format'] ? ' selected="selected"' : '' )
						. '>' . $v . "</option>\n";
				}
				
				?>
			</select>
		</p> 

		<p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout:', 'haven'); ?></label>

			<select class="widefat" id="wberry-layout-field" name="<?php echo $this->get_field_name('layout'); ?>">
			
				<?php
				$layouts = array(
					'wberry-layout-list' => 'List', 
					'wberry-layout-slideshow' => 'Slideshow', 
					'wberry-layout-bigthumb' => 'Big Thumbnail'
					);
				
				foreach ($layouts as $a => $b) {
					echo '<option value="' . $a . '"'
						. ( $a == $instance['layout'] ? ' selected="selected"' : '' )
						. '>' . $b . "</option>\n";
				}
				
				?>
			</select>
		</p> 

	<?php
	}

}

// Register the widget
add_action( 'widgets_init', create_function( '', "register_widget( 'Widget_Whiteberry_Featured_Posts' );" ) );