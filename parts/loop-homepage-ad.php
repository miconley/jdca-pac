<?php
/**
 * Template part for displaying posts
 *
 * Used for single, index, archive, search.
 */

$id = $args['ad']->ID;
$image = get_field('thumbnail', $id);
$title = $args['ad']->post_title;
?>

<div class="ad">		
	<div class="image">
		<img src="<?php echo $image['sizes']['video_thumb'];?>" alt="<?php echo $title;?>" />
	</div>
    <span class="ad-text">AD</span>
	<span class="title"> 
		<?php echo $title;	?>
	</span>
    <button class="play white" data-url="<?php echo get_field('video_url', $id);?>">Watch</button>
</div>
