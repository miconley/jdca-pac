<?php

// echo "<pre>"; print_r($args); echo "</pre>";

foreach($args as $arg) {
    switch($arg['name']) {
        case "block_title":
            $block_title = get_field('block_title');
            break;
        
        case "candidates":
            $candidates = get_field('candidates');
            break;
    }
}
// echo "<pre>"; print_r($candidates[0]['candidate']->ID);
?>

<div class="small-12 medium-6 large-6 center home-page-container">
    <h1 class="page-title center accent">
        <?php echo $block_title; ?>
    </h1>
    <div class="small-12 medium-6 large-6 candidates-container">
        
        <?php foreach($candidates as $candidate) {
            // echo "<pre>"; print_r($candidates);
            get_template_part( 'parts/loop', 'homepage-candidate', $candidate ); 
        }?>
    </div>
    <a class="candidates-cta button white-red" href="/candidates">See All Candidates</a>

    
</div>
