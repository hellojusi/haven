<?php
/**
 * Custom widget for displaying author information.
 * Supports default and/or author of current page/post.
 */


// Creates the widget
class Widget_Whiteberry_Author extends WP_Widget {

	// Register widget with WordPress.
	public function __construct() {
		//global $wid, $wname;
		parent::__construct(
	 		'wberry_featured_author', // Base ID
			'Haven: Featured Author', // Name
			array( 'description' => __( 'Displays featured author box based on selected criteria.', 'haven' ), ) // Args
		);
	}

	// Front-end display of widget.
	public function widget( $args, $instance ) {
		extract( $args );
		$author = $instance['author'];
		$display_bio = $instance['display_bio'] ? 'true' : 'false';
		$display_social = $instance['display_social'] ? 'true' : 'false';


		echo $before_widget;
		
			$user = get_user_by('id', $author); 
			?>

			<div class="wberry-author-box">

				<a href="<?php echo get_author_posts_url( $author ); ?>"><?php echo get_avatar( $author, 128 ); ?></a>
				<h6><a href="<?php echo get_author_posts_url( $author ); ?>"><?php echo $user->display_name; ?></a></h6>

				<?php if('on' == $instance['display_bio'] ) { ?>

				<div class="wberry-author-bio">
					<?php echo $user->description; ?>
				</div>

				<?php } ?>

				<?php if('on' == $instance['display_social'] ) { ?>
					
				<div class="author-social-links">
					<?php if(get_the_author_meta('facebook', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('facebook', $author); ?>"><i class="fa fa-facebook"></i></a><?php endif; ?>
					<?php if(get_the_author_meta('twitter', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('twitter', $author); ?>"><i class="fa fa-twitter"></i></a><?php endif; ?>
					<?php if(get_the_author_meta('instagram', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('instagram', $author); ?>"><i class="fa fa-instagram"></i></a><?php endif; ?>
					<?php if(get_the_author_meta('google', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('google', $author); ?>?rel=author"><i class="fa fa-google-plus"></i></a><?php endif; ?>
					<?php if(get_the_author_meta('pinterest', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('pinterest', $author); ?>"><i class="fa fa-pinterest"></i></a><?php endif; ?>
					<?php if(get_the_author_meta('tumblr', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('tumblr', $author); ?>"><i class="fa fa-tumblr"></i></a><?php endif; ?>
					<?php if(get_the_author_meta('youtube', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('youtube', $author); ?>"><i class="fa fa-youtube-play"></i></a><?php endif; ?>
					<?php if(get_the_author_meta('bloglovin', $author)) : ?><a target="_blank" class="author-social" href="<?php echo get_the_author_meta('bloglovin', $author); ?>"><i class="fa fa-heart"></i></a><?php endif; ?>
				</div>

				<?php } ?>

			</div><!-- /wberry-author-box -->

		<?php echo $after_widget;
	}

	// Sanitize widget form values as they are saved.
	public function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array( );
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
		$instance['author'] = intval($new_instance['author']);

		$instance['display_bio'] = strip_tags($new_instance['display_bio']);
		$instance['display_social'] = strip_tags($new_instance['display_social']);		

		return $instance;
	}

	// Back-end widget form.
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( ) );

		if ( isset($instance['display_bio']) )
			$display_bio = esc_attr( $instance['display_bio'] );
		else
			$display_bio = '';

		if ( isset($instance['display_social']) )
			$display_social = esc_attr( $instance['display_social'] );
		else
			$display_social = '';
		?>
		

		<p>
			<label for="<?php echo $this->get_field_id('author'); ?>"><?php _e('Select Author:', 'haven'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>">

			<?php

			global $wpdb;
			$order = 'user_nicename';
			$user_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users ORDER BY $order");

			foreach($user_ids as $user_id) {
				$user = get_userdata($user_id);
				echo '<option value="' . $user_id . '"'
					. ( $user_id == $instance['author'] ? ' selected="selected"' : '' )
					. '>' . $user->display_name . "</option>\n";
			}
			?>
			</select>
		</p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('display_bio'); ?>" name="<?php echo $this->get_field_name('display_bio'); ?>" <?php checked($display_bio, 'on'); ?>>
			<label for="<?php echo $this->get_field_id('display_bio'); ?>"><?php _e('Display author bio', 'haven'); ?></label> 
		
		<br />

			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('display_social'); ?>" name="<?php echo $this->get_field_name('display_social'); ?>" <?php checked($display_social, 'on'); ?>>
			<label for="<?php echo $this->get_field_id('display_social'); ?>"><?php _e('Display social links', 'haven'); ?></label> 
		</p>


	<?php
	}

}

// Register the widget
add_action( 'widgets_init', create_function( '', "register_widget( 'Widget_Whiteberry_Author' );" ) );