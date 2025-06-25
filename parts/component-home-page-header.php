<?php

// echo "<pre>"; print_r($args); echo "</pre>";

foreach($args as $arg) {
    switch($arg['name']) {
        case "headline":
            $headline = get_field('headline');
            break;
        
        case "subheadline":
            $subheadline = get_field('subheadline');
            break;

        case "cta":
            $cta = get_field('cta');
            $target = $cta['target'] ? $cta['target'] : '_self';
            // Array ( [title] => Donate Here [url] => https://voteblue.org [target] => )
            break;

        case "background_image":
            $header_image = get_field('background_image')['sizes']['header_image'];
            break;
    }
}

?>

<div class="home-page-header">
    <div class="header-background" style="background-image: url('<?php echo $header_image;?>')"></div>
    <div class="header-content">
	    <h1 class="accent"><?php echo $headline; ?></h1>
        <span class="subheadline"> <?php echo $subheadline; ?></span>
        <a class="header-cta button sky-blue" href="<?php echo $cta['url']; ?>" target="<?php echo $target; ?>"><?php echo $cta['title']; ?></a>
    </div>
</div>
