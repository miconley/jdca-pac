<?php
/**
 * Template part for displaying posts
 *
 * Used for single, index, archive, search.
 */
$image = get_field('thumbnail', get_the_ID());
?>

<div class="ad">		
	<div class="image">
		<img src="<?php echo $image['sizes']['video_thumb'];?>" alt="<?php echo get_the_title();?>" />
	</div>
    <span class="ad-text">AD</span>
	<span class="title"> 
		<?php echo get_the_title();	?>
	</span>
    <button class="play white" data-url="<?php echo get_field('video_url', get_the_ID());?>">Watch</button>
</div>
