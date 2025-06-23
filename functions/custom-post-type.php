<?php
/* joints Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

*/


// let's create the function for the custom type
function candidate_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'candidate', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array(
			'labels' => [
				'menu_name'          => esc_html__( 'Candidates', 'candidate' ),
				'name_admin_bar'     => esc_html__( 'Candidate', 'candidate' ),
				'add_new'            => esc_html__( 'Add Candidate', 'candidate' ),
				'add_new_item'       => esc_html__( 'Add new Candidate', 'candidate' ),
				'new_item'           => esc_html__( 'New Candidate', 'candidate' ),
				'edit_item'          => esc_html__( 'Edit Candidate', 'candidate' ),
				'view_item'          => esc_html__( 'View Candidate', 'candidate' ),
				'update_item'        => esc_html__( 'View Candidate', 'candidate' ),
				'all_items'          => esc_html__( 'All Candidates', 'candidate' ),
				'search_items'       => esc_html__( 'Search Candidates', 'candidate' ),
				'parent_item_colon'  => esc_html__( 'Parent Candidate', 'candidate' ),
				'not_found'          => esc_html__( 'No Candidates found', 'candidate' ),
				'not_found_in_trash' => esc_html__( 'No Candidates found in Trash', 'candidate' ),
				'name'               => esc_html__( 'Candidates', 'candidate' ),
				'singular_name'      => esc_html__( 'Candidate', 'candidate' ),
			],
			'description' => __( 'This is the example custom post type', 'designations' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-admin-users', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'candidates', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'candidates', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
				'revisions',
				'page-attributes',
			],
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	// register_taxonomy_for_object_type('category', 'candidate');
	
} 

	// adding the function to the Wordpress init
add_action( 'init', 'candidate_post_type');
	
// let's create the function for the custom type
function ad_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'ad', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array(
			'labels' => [
				'menu_name'          => esc_html__( 'Ads', 'ad' ),
				'name_admin_bar'     => esc_html__( 'Ad', 'ad' ),
				'add_new'            => esc_html__( 'Add Ad', 'ad' ),
				'add_new_item'       => esc_html__( 'Add new Ad', 'ad' ),
				'new_item'           => esc_html__( 'New Ad', 'ad' ),
				'edit_item'          => esc_html__( 'Edit Ad', 'ad' ),
				'view_item'          => esc_html__( 'View Ad', 'ad' ),
				'update_item'        => esc_html__( 'View Ad', 'ad' ),
				'all_items'          => esc_html__( 'All Ads', 'ad' ),
				'search_items'       => esc_html__( 'Search Ads', 'ad' ),
				'parent_item_colon'  => esc_html__( 'Parent Ad', 'ad' ),
				'not_found'          => esc_html__( 'No Ads found', 'ad' ),
				'not_found_in_trash' => esc_html__( 'No Ads found in Trash', 'ad' ),
				'name'               => esc_html__( 'Ads', 'ad' ),
				'singular_name'      => esc_html__( 'Ad', 'ad' ),
			],
			'description' => __( 'This is the example custom post type', 'designations' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon'           => 'dashicons-megaphone', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'ad', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'ad', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
				'revisions',
				'page-attributes',
			],
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	// register_taxonomy_for_object_type('category', 'ad');
	
} 

	// adding the function to the Wordpress init
add_action( 'init', 'ad_post_type');
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/

	// Custom taxonomies for candidate post type
function designation_taxonomy() {
		// now let's add custom categories (these act like categories)
	register_taxonomy( 'designations', 
		array('candidate'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */             
			'labels' => array(
				'name' => __( 'Designations', 'designations' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Designation', 'designations' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Designations', 'designations' ), /* search title for taxomony */
				'all_items' => __( 'All Designations', 'designations' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Designation', 'designations' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Designation:', 'designations' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Designation', 'designations' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Designation', 'designations' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Designation', 'designations' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Designation Name', 'designations' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'designations' ),
		)
	);   
}

add_action( 'init', 'designation_taxonomy');

function election_year_taxonomy() {
		// now let's add custom categories (these act like categories)
	register_taxonomy( 'election_year', 
		array('candidate', 'ad'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */             
			'labels' => array(
				'name' => __( 'Election Years', 'election_year' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Election Year', 'election_year' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Election Years', 'election_year' ), /* search title for taxomony */
				'all_items' => __( 'All Election Years', 'election_year' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Election Year', 'election_year' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Election Year:', 'election_year' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Election Year', 'election_year' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Election Year', 'election_year' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Election Year', 'election_year' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Election Year Name', 'election_year' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'election_year' ),
		)
	);   
}

add_action( 'init', 'election_year_taxonomy');

function office_taxonomy() {
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'office', 
	array('candidate'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */             
			'labels' => array(
				'name' => __( 'Offices', 'office' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Office', 'office' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Offices', 'office' ), /* search title for taxomony */
				'all_items' => __( 'All Offices', 'office' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Office', 'office' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Office:', 'office' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Office', 'office' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Office', 'office' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Office', 'office' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Office Name', 'office' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'office' ),
		)
	);   
}

add_action( 'init', 'office_taxonomy');

function candidate_type_taxonomy() {
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'candidate_type', 
	array('candidate'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */             
			'labels' => array(
				'name' => __( 'Types', 'candidate_type' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Type', 'candidate_type' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Types', 'candidate_type' ), /* search title for taxomony */
				'all_items' => __( 'All Types', 'candidate_type' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Type', 'candidate_type' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Type:', 'candidate_type' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Type', 'candidate_type' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Type', 'candidate_type' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Type', 'candidate_type' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Type Name', 'candidate_type' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'candidate_type' ),
		)
	);   
}

add_action( 'init', 'candidate_type_taxonomy');

function state_taxonomy() {
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'state', 
	array('candidate'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */             
			'labels' => array(
				'name' => __( 'States', 'state' ), /* name of the custom taxonomy */
				'singular_name' => __( 'State', 'state' ), /* single taxonomy name */
				'search_items' =>  __( 'Search States', 'state' ), /* search title for taxomony */
				'all_items' => __( 'All States', 'state' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent State', 'state' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent State:', 'state' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit State', 'state' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update State', 'state' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New State', 'state' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New State Name', 'state' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'state' ),
		)
	);   
}

add_action( 'init', 'state_taxonomy');