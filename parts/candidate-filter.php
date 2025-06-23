<?php
/**
 * Template part for displaying posts
 *
 * Used for single, index, archive, search.
 */
?>

<div class="candidate_filter">
	<?php
	// Get all taxonomies for the 'candidate' post type
	$taxonomies = get_object_taxonomies('candidate', 'objects');
	
	// Loop through each taxonomy
	foreach ($taxonomies as $taxonomy) {
		// Skip built-in taxonomies if desired (uncomment the next line)
		// if (in_array($taxonomy->name, ['category', 'post_tag'])) continue;
		
		// Get terms for this taxonomy
		$terms = get_terms([
			'taxonomy' => $taxonomy->name,
			'hide_empty' => false,
		]);
		
		// Only display if there are terms
		if (!empty($terms) && !is_wp_error($terms)) {
			?>
			<div class="taxonomy-section" data-taxonomy="<?php echo esc_attr($taxonomy->name); ?>">
				<h3 class="taxonomy-title"><?php echo esc_html($taxonomy->labels->name); ?></h3>
				<ul class="taxonomy-terms">
					<?php foreach ($terms as $term) { ?>
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
</div>
