<?php
/**
 * The template for displaying archive pages
 *
 * @package maksimer
 */

get_header();
?>

	<main role="main" id="main-content" class="main-content-wrap">

		<?php
		if ( have_posts() ) {

			the_archive_title( '<h1>', '</h1>' );
			the_archive_description();

			while ( have_posts() ) :
				the_post();
				get_template_part( 'loop', 'single' );
			endwhile;

			the_posts_navigation();

		} else {

			echo '<h1>' . esc_attr__( 'No post found!', 'maksimer-lang' ) . '</h1>';

		}
		?>

	</main>

<?php get_footer(); ?>
