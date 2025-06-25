<?php
/**
 * Template part for candidate filtering
 *
 * Used for filtering candidate archive pages.
 */
?>

<aside class="candidate_filter small-12 medium-2 large-2" role="complementary">
	<div class="candidate-filter-header">
		<span class="text">Filters</span>
		<button class="close">x</button>
	</div>
	<form id="candidate-filter-form" method="GET" action="<?php echo esc_url(get_post_type_archive_link('candidate')); ?>">
		<?php
		// Get all taxonomies for the 'candidate' post type
		$taxonomies = get_object_taxonomies('candidate', 'objects');
		
		// Get current filter values from URL
		$current_filters = [];
		foreach ($taxonomies as $taxonomy) {
			if (isset($_GET[$taxonomy->name]) && is_array($_GET[$taxonomy->name])) {
				$current_filters[$taxonomy->name] = array_map('sanitize_text_field', $_GET[$taxonomy->name]);
			}
		}
		
		// Loop through each taxonomy
		foreach ($taxonomies as $taxonomy) {
			// Skip built-in taxonomies if desired (uncomment the next line)
			// if (in_array($taxonomy->name, ['category', 'post_tag'])) continue;
			
			// Get terms for this taxonomy (only show terms that have content)
			$terms = get_terms([
				'taxonomy' => $taxonomy->name,
				'hide_empty' => true,
			]);
			
			// Only display if there are terms with content
			if (!empty($terms) && !is_wp_error($terms)) {
				?>
				<div class="taxonomy-section" data-taxonomy="<?php echo esc_attr($taxonomy->name); ?>">
					<h3 class="taxonomy-title"><?php echo esc_html($taxonomy->labels->name); ?></h3>
					<button class="caret open" aria-label="open/close filter section">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow.svg" />
					</button>
					<ul class="taxonomy-terms">
						<?php foreach ($terms as $term) { 
							// Check if this term is currently selected
							$is_checked = isset($current_filters[$taxonomy->name]) && in_array($term->slug, $current_filters[$taxonomy->name]);
							?>
							<li class="term-item">
								<label for="<?php echo esc_attr($taxonomy->name . '_' . $term->slug); ?>">
									<input 
										type="checkbox" 
										id="<?php echo esc_attr($taxonomy->name . '_' . $term->slug); ?>"
										name="<?php echo esc_attr($taxonomy->name); ?>[]"
										value="<?php echo esc_attr($term->slug); ?>"
										class="term-checkbox"
										data-taxonomy="<?php echo esc_attr($taxonomy->name); ?>"
										data-term="<?php echo esc_attr($term->slug); ?>"
										<?php checked($is_checked); ?>
									>
									<?php echo esc_html($term->name); ?>
								</label>
							</li>
						<?php } ?>
					</ul>
				</div>
				<?php
			}
		}
		?>
		
		<div class="filter-actions">
			<a href="<?php echo esc_url(get_post_type_archive_link('candidate')); ?>" role="button" class="button secondary" id="clear-filters">Clear Filters</a>
		</div>
	</form>
</aside>
