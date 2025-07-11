<?php
/** 
 * For more info: https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */			
	
// Theme support options
require_once(get_template_directory().'/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/functions/page-navi.php'); 

// Adds support for multiple languages
require_once(get_template_directory().'/functions/translation/translation.php'); 

// Adds site styles to the WordPress editor
// require_once(get_template_directory().'/functions/editor-styles.php'); 

// Remove Emoji Support
require_once(get_template_directory().'/functions/disable-emoji.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/functions/related-posts.php'); 

// Use this as a template for custom post types
require_once(get_template_directory().'/functions/custom-post-type.php');

// Customize the WordPress login menu
// require_once(get_template_directory().'/functions/login.php'); 

// Customize the WordPress admin
// require_once(get_template_directory().'/functions/admin.php'); 

add_image_size( 'video_thumb', 600, 340, true ); 
add_image_size( 'headshot', 300, 300, true ); 
add_image_size( 'header_image', 1600); 

add_action('init', 'rem_editor_from_post_type');
function rem_editor_from_post_type() {
    remove_post_type_support('candidate', 'editor' );
    remove_post_type_support('ad', 'editor' );
}

// Add query vars for candidate filtering
function add_candidate_filter_query_vars($vars) {
    // Get all candidate taxonomies
    $candidate_taxonomies = get_object_taxonomies('candidate');
    
    // Add each taxonomy as a query var
    foreach ($candidate_taxonomies as $taxonomy) {
        $vars[] = $taxonomy;
    }
    
    return $vars;
}
add_filter('query_vars', 'add_candidate_filter_query_vars');

// Handle candidate archive filtering
function handle_candidate_archive_query($query) {
    // Only modify the main query on the candidate archive page
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('candidate')) {
        $candidate_taxonomies = get_object_taxonomies('candidate');
        $tax_query = array('relation' => 'AND');
        $has_filters = false;
        
        foreach ($candidate_taxonomies as $taxonomy) {
            $terms = get_query_var($taxonomy);
            
            if (!empty($terms)) {
                $has_filters = true;
                
                // Handle both array and string formats
                if (!is_array($terms)) {
                    $terms = array($terms);
                }
                
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $terms,
                    'operator' => 'IN'
                );
            }
        }
        
        if ($has_filters) {
            $query->set('tax_query', $tax_query);
        }
    }
}
add_action('pre_get_posts', 'handle_candidate_archive_query');

// Generate sort order for candidates
function calculate_candidate_sort_order($post_id) {
    $election_years = wp_get_post_terms($post_id, 'election_year');
    $offices = wp_get_post_terms($post_id, 'office');
    $post_title = get_post_field('post_title', $post_id);
    
    // Extract last name from title for sorting
    $name_parts = explode(' ', trim($post_title));
    $last_name = end($name_parts);
    
    // Default values
    $year_sort = 9999; // Default for posts without election year
    $office_sort = 999; // Default for posts without office
    
    // Election year sorting (newer years first, so invert)
    if (!empty($election_years)) {
        $year = intval($election_years[0]->name);
        $year_sort = 3000 - $year; // Invert so 2024 becomes smaller number than 2022
    }
    
    // Office sorting: Senate=1, House=2, Governor=3
    if (!empty($offices)) {
        $office_name = strtolower($offices[0]->name);
        if (strpos($office_name, 'senate') !== false) {
            $office_sort = 1;
        } elseif (strpos($office_name, 'house') !== false) {
            $office_sort = 2;
        } elseif (strpos($office_name, 'governor') !== false) {
            $office_sort = 3;
        }
    }
    
    // Create composite sort key: YYYY|O|LastName
    // Pad numbers with zeros for proper string sorting
    $sort_order = sprintf('%04d%03d%s', $year_sort, $office_sort, strtolower($last_name));
    
    update_post_meta($post_id, 'candidate_sort_order', $sort_order);
    
    return $sort_order;
}

// Update sort order when candidate is saved
function update_candidate_sort_order($post_id) {
    if (get_post_type($post_id) !== 'candidate') {
        return;
    }
    
    // Avoid infinite loops
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    calculate_candidate_sort_order($post_id);
}
add_action('save_post', 'update_candidate_sort_order');

// Bulk update all existing candidates
function bulk_update_candidate_sort_orders() {
    $candidates = get_posts([
        'post_type' => 'candidate',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ]);
    
    foreach ($candidates as $candidate) {
        calculate_candidate_sort_order($candidate->ID);
    }
}

// Update main query sorting for candidate archives
function set_candidate_archive_sort_order($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('candidate')) {
        // Ensure all candidates have sort order calculated
        bulk_update_candidate_sort_orders();
        
        $query->set('meta_key', 'candidate_sort_order');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'set_candidate_archive_sort_order', 20);
