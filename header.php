<!DOCTYPE html>
<html lang="<?php echo get_locale(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body>

<header class="site-header">
    <div class="site-searchbar">
        <form role="search" method="get" id="searchform" class="searchform" action="http://localhost/my_theme/">
				<div>
					<label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" name="s" id="s">
					<!-- <input type="submit" id="searchsubmit" value="Search"> -->
                     <button type="submit" id="searchsubmit"><i class="fa-solid fa-magnifying-glass"></i></button>
				</div>
		</form>
    </div>
    <div class="site-branding">
        <?php
        if (function_exists('the_custom_logo')) {
            the_custom_logo();
        }
        ?>
        <h3 class="site-title"><?php bloginfo('name'); ?></h3>
        <p><?php bloginfo('description'); ?></p>
    </div>

    <nav class="site-navigation">
        <?php wp_nav_menu(); ?>
       <button id="dark-mode-toggle">T</button>

</header>
