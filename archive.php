<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Haven
 */

get_header(); ?>

	<header class="page-header">
		<h1 class="archive-title">
			<?php
				if ( is_day() ) :
					printf( __( '<span>Daily Archives</span> %s', 'haven' ), get_the_date() );
				elseif ( is_month() ) :
					printf( __( '<span>Monthly Archives</span> %s', 'haven' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'haven' ) ) );
				elseif ( is_year() ) :
					printf( __( '<span>Yearly Archives</span> %s', 'haven' ), get_the_date( _x( 'Y', 'yearly archives date format', 'haven' ) ) );
				elseif ( is_author() ) :
					printf( __( '<span>Articles by</span> %s', 'haven' ), get_userdata( get_query_var('author') )->display_name );
				elseif ( is_category() ) :
					$cat = get_query_var('cat'); 
					printf( __( '<span>Browsing Category</span> %s', 'haven' ), get_cat_name($cat) );
				elseif ( is_tag() ) :
					$cat = get_query_var('cat'); 
					single_term_title('<span>Browsing Tag</span> ');
				else :
					_e( 'Archives', 'haven' );
				endif;
			?>
		</h1>
	</header><!-- .page-header -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : 
			
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			haven_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
