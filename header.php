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
				<div class="searchbar-container">
					<!-- <label class="screen-reader-text" for="search-input">Search for:</label> -->
					<input class="search-input" type="text" value="" name="s" id="search-input" placeholder="Search...">
					<!-- <input type="submit" id="searchsubmit" value="Search"> -->
                     <button class="search-btn" type="submit" id="searchsubmit"><i class="fa-solid fa-magnifying-glass"></i></button>
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
        <button class="dark-mode-btn" id="dark-mode-toggle"></button>
    </nav>
    
</header>

