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
        <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/'));?>">
				<div class="searchbar-container">
					<input class="search-input" type="text" value="" name="s" id="search-input" placeholder="Search...">
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

         <div className="relative">
    <div
        class="ham-menu"
      >
        <span></span>
        <span></span>
        <span></span>
      </div>

    
    <?php wp_nav_menu(); ?>

    
    </div>
        <button class="dark-mode-btn" id="dark-mode-toggle"></button>
    </nav>
    
</header>

