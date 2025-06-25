<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */
?>

<div class="top-bar" id="top-bar-menu">
	<div class="top-bar-left float-left">
		<ul class="menu">
			<<li><?php the_custom_logo();?></li> 
		</ul>
	</div>
	<div class="top-bar-right show-for-medium">
		<?php joints_top_nav(); ?>	
	</div>
	<div class="top-bar-right float-right show-for-small-only">
		<ul class="menu">
			<button class="mobile-menu" data-toggle="off-canvas" class="caret open" aria-label="open/close filter section">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu.svg" />
			</button>
		</ul>
	</div>
</div>