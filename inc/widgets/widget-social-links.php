<?php
/**
 * Custom widget for displaying author information.
 * Supports default and/or author of current page/post.
 */


// Creates the widget
class Haven_Social_Widget extends WP_Widget {

	// Register widget with WordPress.
	public function __construct() {
		//global $wid, $wname;
		parent::__construct(
	 		'haven_social_widget', // Base ID
			'Haven: Social Links', // Name
			array( 'description' => __( 'Displays your social icons.', 'haven' ), ) // Args
		);
	}

	// Front-end of thw widget
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$googleplus = $instance['googleplus'];
		$instagram = $instance['instagram'];
		$bloglovin = $instance['bloglovin'];
		$youtube = $instance['youtube'];
		$tumblr = $instance['tumblr'];
		$pinterest = $instance['pinterest'];
		$rss = $instance['rss'];
		
		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		?>
		
		<div class="widget-social">
			<?php if($facebook) : ?><a href="http://facebook.com/<?php echo get_theme_mod('hvn_facebook'); ?>" target="_blank"><i class="fa fa-facebook"></i></a><?php endif; ?>
			<?php if($twitter) : ?><a href="http://twitter.com/<?php echo get_theme_mod('hvn_twitter'); ?>" target="_blank"><i class="fa fa-twitter"></i></a><?php endif; ?>
			<?php if($instagram) : ?><a href="http://instagram.com/<?php echo get_theme_mod('hvn_instagram'); ?>" target="_blank"><i class="fa fa-instagram"></i></a><?php endif; ?>
			<?php if($pinterest) : ?><a href="http://pinterest.com/<?php echo get_theme_mod('hvn_pinterest'); ?>" target="_blank"><i class="fa fa-pinterest"></i></a><?php endif; ?>
			<?php if($bloglovin) : ?><a href="http://bloglovin.com/<?php echo get_theme_mod('hvn_bloglovin'); ?>" target="_blank"><i class="fa fa-heart"></i></a><?php endif; ?>
			<?php if($googleplus) : ?><a href="http://plus.google.com/<?php echo get_theme_mod('hvn_google'); ?>" target="_blank"><i class="fa fa-google-plus"></i></a><?php endif; ?>
			<?php if($tumblr) : ?><a href="http://<?php echo get_theme_mod('hvn_tumblr'); ?>.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i></a><?php endif; ?>
			<?php if($youtube) : ?><a href="http://youtube.com/<?php echo get_theme_mod('hvn_youtube'); ?>" target="_blank"><i class="fa fa-youtube-play"></i></a><?php endif; ?>
			<?php if($rss) : ?><a href="<?php echo get_theme_mod('hvn_rss'); ?>" target="_blank"><i class="fa fa-rss"></i></a><?php endif; ?>
		</div>
			
			
		<?php

		echo $after_widget;
	}


	// Update widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['bloglovin'] = strip_tags( $new_instance['bloglovin'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['rss'] = strip_tags( $new_instance['rss'] );

		return $instance;
	}

	// Back-end widget form.
	function form( $instance ) {

		$defaults = array( 
			'title' => 'Subscribe & Follow', 
			'facebook' => 'on', 
			'twitter' => 'on', 
			'googleplus' => '', 
			'instagram' => 'on', 
			'bloglovin' => '', 
			'youtube' => '', 
			'tumblr' => '', 
			'pinterest' => '', 
			'rss' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<p>Note: Set your social links in the <a href="<?php echo admin_url( 'customize.php' ); ?>">Customizer</a></p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" <?php checked( (bool) $instance['facebook'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Show Facebook</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" <?php checked( (bool) $instance['twitter'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Show Twitter</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" <?php checked( (bool) $instance['instagram'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>">Show Instagram</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" <?php checked( (bool) $instance['pinterest'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>">Show Pinterest</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'bloglovin' ); ?>" name="<?php echo $this->get_field_name( 'bloglovin' ); ?>" <?php checked( (bool) $instance['bloglovin'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'bloglovin' ); ?>">Show Bloglovin</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name( 'googleplus' ); ?>" <?php checked( (bool) $instance['googleplus'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'googleplus' ); ?>">Show Google Plus</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" <?php checked( (bool) $instance['tumblr'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>">Show Tumblr</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" <?php checked( (bool) $instance['youtube'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>">Show Youtube</label>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" <?php checked( (bool) $instance['rss'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>">Show RSS</label>
		</p>


	<?php
	}
}

// Register the widget
add_action( 'widgets_init', create_function( '', "register_widget( 'Haven_Social_Widget' );" ) );

?>