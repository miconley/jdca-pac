<?php
/**
 * Template part for displaying posts
 *
 * Used for single, index, archive, search.
 */
$id = $args['candidate']->ID;
$region = get_field('district_region', $id);
$headshot = get_field('headshot', $id);

$override = get_field('override_title', $id);
$donation_link = get_field('donation_link', $id);
$name_override = get_field('name_override', $id);
// Get name from title
$name = explode(" ", get_the_title());
$first_name = $name[0];
$middle_name = '';
// If middle name appears, account for it
if(count($name) > 2) {
	$middle_name = $name[1];
	$last_name = $name[2];
} else {
	$last_name = $name[1];
}

// Show override if selected
if($override = get_field('override_title', $id)) {
	$first_name = $name_override['first_name'];
	$middle_name = $name_override['middle_name'];
	$last_name = $name_override['last_name'];
}

?>

<div class="candidate">		
	<?php 
	// Get designation terms for this candidate
	$designations = get_the_terms($id, 'designations');
	if ($designations && !is_wp_error($designations)) {
		foreach ($designations as $designation) {
			?>
			<span class="designation"><?php echo esc_html($designation->name); ?></span>
			<?php
		}
	}
	?>		
	<div class="headshot">
		<img src="<?php echo $headshot['sizes']['headshot'];?>" alt="<?php echo get_the_title();?>" />
	</div>
	<?php if ($region) { ?>
		<span class="region"> 
			<?php echo $region;	?>
		</span>
	<?php } ?>
	<div class="title">
	<?php if ($first_name) { ?>
		<span> 
			<?php echo $first_name;	?>
		</span>
	<?php } ?>
	<?php if ($middle_name) { ?>
		<span> 
			<?php echo $middle_name;	?>
		</span>
	<?php } ?>
	<?php if ($last_name) { ?>
		<span> 
			<?php echo $last_name;	?>
		</span>
	<?php } ?>
	</div>
	<?php if ($donation_link) { ?>
		<span> 
			<a class="button red" href="<?php echo $donation_link;	?>">Donate</a>
		</span>
	<?php } ?>
</div>
