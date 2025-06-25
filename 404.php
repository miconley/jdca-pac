<?php
/**
 * The template for displaying 404 (page not found) pages.
 *
 * For more info: https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header(); ?>
			
	<div class="content">

		<div class="inner-content grid-x grid-margin-x grid-padding-x">
	
			<main class="main small-12 medium-8 large-8 margin-auto" role="main">

				<article class="content-not-found">
				
					<header class="article-header">
						<h1><?php _e( '404.  Sorry, it appears what your\'re looking for is not here.', 'jointswp' ); ?></h1>
					</header> <!-- end article header -->
			
				</article> <!-- end article -->
	
			</main> <!-- end #main -->

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>