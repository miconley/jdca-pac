<?php
/**
 * The template for displaying the footer. 
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */			

$logo = get_field('footer_logo', 'option')['url'];
$contact_info = get_field('contact_info', 'option');
$additional_link = get_field('additional_link', 'option');
$copyright = get_field('copyright', 'option');
$disclaimer = get_field('disclaimer', 'option');
$social_links = get_field('social_links', 'option');
 ?>
					
				<footer class="footer" role="contentinfo">
					
					<div class="inner-footer grid-x grid-margin-x grid-padding-x">
						
						<div class="full-width center">
							<img class="footer-logo" src="<?php echo $logo;?>" />
	    				</div>
						<?php if($contact_info) {
							$target = $contact_info['target'] ? $contact_info['target'] : '_self';
						?>
						<div class="footer-link">
							<a class="footer-cta" href="<?php echo $contact_info['url']; ?>" target="<?php echo $target; ?>"><?php echo $contact_info['title']; ?></a>
						</div>
						<?php } ?>
						<?php if($additional_link) {
							$target = $additional_link['target'] ? $additional_link['target'] : '_self';
						?>
						<div class="footer-link">
							<a class="button white" href="<?php echo $additional_link['url']; ?>" target="<?php echo $target; ?>"><?php echo $additional_link['title']; ?></a>
						</div>
						<?php } ?>
						<?php if($social_links) {
							?>
							<div class="social-links">
						
							<?php foreach ($social_links as $link) { ?>
								<a class="social-link" href="<?php echo $link['link']['url'];?>" title="<?php echo $link['link']['title'];?>" target="_blank"><img src="<?php echo $link['icon']['url'];?>"></a>
							<?php } ?>
							</div>
						<?php } ?>

						<?php if($copyright) { ?>
						<div class="copyright">
							<?php echo $copyright; ?>
						</div>
						<?php } ?>

						<?php if($disclaimer) { ?>
						<div class="disclaimer">
							<?php echo $disclaimer; ?>
						</div>
						<?php } ?>
					
					</div> <!-- end #inner-footer -->
				
				</footer> <!-- end .footer -->
			
			</div>  <!-- end .off-canvas-content -->
					
		</div> <!-- end .off-canvas-wrapper -->
		
		<?php wp_footer(); ?>
		
	</body>
	
</html> <!-- end page -->