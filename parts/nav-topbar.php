<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/responsive-navigation/
 */
?>

<div class="top-bar" id="main-menu">
	<div class="top-bar-left">
		<ul class="menu">
			<li><?php the_custom_logo();?></li>
		</ul>
	</div>
	<div class="top-bar-right">
		<?php joints_top_nav(); ?>
	</div>
</div>