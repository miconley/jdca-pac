<?php
/**
 * Displays archive pages for candidates with filtering capability
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header(); 

// Handle filtering
$filtered_query = null;
$active_filters = [];

// Get all candidate taxonomies
$candidate_taxonomies = get_object_taxonomies('candidate');

// Check for filter parameters
$has_filters = false;
$tax_query = ['relation' => 'AND'];

foreach ($candidate_taxonomies as $taxonomy) {
	if (isset($_GET[$taxonomy]) && is_array($_GET[$taxonomy]) && !empty($_GET[$taxonomy])) {
		$has_filters = true;
		$active_filters[$taxonomy] = array_map('sanitize_text_field', $_GET[$taxonomy]);
		
		$tax_query[] = [
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => $active_filters[$taxonomy],
			'operator' => 'IN'
		];
	}
}

// Create custom query if filters are active
if ($has_filters) {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$filtered_query = new WP_Query([
		'post_type' => 'candidate',
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $paged,
		'tax_query' => $tax_query,
		'meta_query' => [],
		'orderby' => 'meta_value_num title',
		'meta_key' => 'candidate_sort_order',
		'order' => 'ASC'
	]);
}
?>
			
	<div class="content">
	
		<div class="inner-content grid-x grid-margin-x grid-padding-x">
			<header class="full-width">
		    		<h1 class="page-title center accent">
						Our Candidates
					</h1>
		    </header>
		    <main class="main small-12 medium-8 large-10 margin-auto flex candidate-wrapper" role="main">
				

		
		    	<?php 
				// Use filtered query if available, otherwise use default
				$query_to_use = $filtered_query ? $filtered_query : $wp_query;
				
				if ($query_to_use->have_posts()) : 
					?>
					<div class="small-12 medium-6 large-6 candidates-container">
					<?php
					while ($query_to_use->have_posts()) : $query_to_use->the_post(); ?>
			 
					<!-- To see additional archive styles, visit the /parts directory -->
					<?php get_template_part( 'parts/loop', 'archive-candidate' ); ?>
				    
				<?php endwhile; ?>	

					<?php 
					// Handle pagination for filtered results
					if ($filtered_query) {
						$big = 999999999;
						echo paginate_links([
							'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
							'format' => '?paged=%#%',
							'current' => max(1, get_query_var('paged')),
							'total' => $filtered_query->max_num_pages,
							'add_args' => $_GET
						]);
					} else {
						joints_page_navi();
					}
					?>
				</div>

				<?php else : ?>
					<div class="small-12 medium-12 large-6 candidates-container">				
					<?php get_template_part( 'parts/content', 'missing' ); ?>
					</div>
				<?php endif; ?>
				
				<?php 
				// Reset post data if using custom query
				if ($filtered_query) {
					wp_reset_postdata();
				}
				?>
				
				<?php get_template_part( 'parts/candidate', 'filter' ); ?>
				<button class="candidate-filter-toggle" aria-label="open/close filter section">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/filters.svg" />
				</button>
			</main> <!-- end #main -->
		    
	    </div> <!-- end #inner-content -->
	    
	</div> <!-- end #content -->

<?php get_footer(); ?>