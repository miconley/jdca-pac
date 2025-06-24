<?php 
/* Template Name: Home Page */

get_header(); ?>
	
	<div class="content">
	
		<div class="inner-content">
	
		    <main class="main small-12 large-8 medium-12" role="main">
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); 

			    // Get the current post ID
                $post_id = get_the_ID();

                // Retrieve all field groups associated with the current post
                $field_groups = acf_get_field_groups(array('post_id' => $post_id));

                // Loop through each field group
                foreach ($field_groups as $field_group) {
                    // Get the field group ID
                    $field_group_id = $field_group['ID'];

                    // Get the fields within the field group
                    $fields = acf_get_fields($field_group_id);
                    $component = strtolower(str_replace(" ", "-", $field_group['title']));

                    get_template_part( 'parts/component', $component, $fields );
                    // // Check if the field group has a specific layout
                    // if ($field_group['layout'] == 'gallery') {
                    //     // Loop through each field and display the gallery layout
                    //     foreach ($fields as $field) {
                    //         if ($field['type'] == 'gallery') {
                    //             // Display the gallery field
                    //             the_field($field['name']);
                    //         }
                    //     }
                    // } elseif ($field_group['layout'] == 'video') {
                    //     // Loop through each field and display the video layout
                    //     foreach ($fields as $field) {
                    //         if ($field['type'] == 'video') {
                    //             // Display the video field
                    //             the_field($field['name']);
                    //         }
                    //     }
                    // }
                }
			    
			    endwhile; endif; ?>							
			    					
			</main> <!-- end #main -->
		    
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>