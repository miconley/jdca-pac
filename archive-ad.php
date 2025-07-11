<?php
/**
 * Displays archive pages if a speicifc template is not set. 
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header(); ?>
			
	<div class="content">
	
		<div class="inner-content grid-x grid-margin-x grid-padding-x">
		
		    <main class="main small-12 medium-12 large-8 margin-auto ads-wrapper" role="main">
			    
		    	<header>
		    		<h1 class="page-title center accent">Our Ads</h1>
		    	</header>
                
		    	<?php 
				// Get all ads grouped by election year
				$ads_query = new WP_Query([
					'post_type' => 'ad',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC'
				]);
				
				if ($ads_query->have_posts()) :
					$ads_by_year = [];
					
					// Group ads by election year
					while ($ads_query->have_posts()) : $ads_query->the_post();
						$election_years = wp_get_post_terms(get_the_ID(), 'election_year');
						$year = !empty($election_years) ? $election_years[0]->name : 'No Year';
						
						if (!isset($ads_by_year[$year])) {
							$ads_by_year[$year] = [];
						}
						$ads_by_year[$year][] = get_post();
					endwhile;
					
					// Sort years in descending order
					krsort($ads_by_year);
					
					// Display ads grouped by year
					foreach ($ads_by_year as $year => $ads) : ?>
						<div class="year-group">
							<div class="election-year-heading"><h2><?php echo esc_html($year); ?></h2></div>
							<div class="ads-container">
								<?php foreach ($ads as $ad) : 
									// Set up post data for template part
									$GLOBALS['post'] = $ad;
									setup_postdata($ad);
									?>
									<?php get_template_part( 'parts/loop', 'archive-ad' ); ?>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach;
					
					wp_reset_postdata();
				endif; ?>

		
			</main> <!-- end #main -->
	    
	    </div> <!-- end #inner-content -->
	    
	</div> <!-- end #content -->

<?php get_footer(); ?>