<?php

// echo "<pre>"; print_r($args); echo "</pre>";

foreach($args as $arg) {
    switch($arg['name']) {
        case "section_title":
            $block_title = get_field('section_title');
            break;
        
        case "ads":
            $ads = get_field('ads');
            break;
    }
}
?>

<div class="small-12 medium-6 large-6 center  home-page-container">
    <h1 class="page-title center accent">
        <?php echo $block_title; ?>
    </h1>
    <div class="ads-container">
        
        <?php foreach($ads as $ad) {
            get_template_part( 'parts/loop', 'homepage-ad', $ad ); 
        }?>
    </div>
    <a class="candidates-cta button dark-blue-white" href="/ads">See All Ads</a>

    
</div>
