<?php
/**
 * Displays archive pages if a speicifc template is not set. 
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header(); ?>
			
	<div class="content">
	
		<div class="inner-content grid-x grid-margin-x grid-padding-x">
		
		    <main class="main small-12 medium-8 large-8 margin-auto" role="main">
			    
		    	<header>
		    		<h1 class="page-title center accent">Our Ads</h1>
		    	</header>
                <div class="ads-container">
		    	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<!-- To see additional archive styles, visit the /parts directory -->
					<?php get_template_part( 'parts/loop', 'archive-ad' ); ?>
				    
				<?php endwhile; ?>	
                </div>
					<?php joints_page_navi(); ?>
					
				<?php endif; ?>
		
			</main> <!-- end #main -->
	    
	    </div> <!-- end #inner-content -->
	    
	</div> <!-- end #content -->

<?php get_footer(); ?>