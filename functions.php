<?php
function my_theme_css() {
   wp_enqueue_style(
    "denisses-theme-style",
    get_template_directory_uri() . '/style.css',
    array(),
    wp_get_theme()->get('Version')
);
    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
        array(),
        '6.5.2'
    );
}
add_action('wp_enqueue_scripts', 'my_theme_css');

/* ---------------------------------------------------------header-------------------------------------------------------------- */
add_theme_support( 'custom-logo', array(
    'height'      => 100,
    'width'       => 100,
    'flex-height' => true,
    'flex-width'  => true,
) );



/* ---------------------------------------------------------scripts--------------------------------------------------------- */
function my_theme_scripts() {
    wp_enqueue_script( 'dark-mode-script', get_template_directory_uri() . '/scripts/dark-mode.js',   array(),
        null,
        true // Load in footer
    );
    
    wp_enqueue_script( 'slider-hero-script', get_template_directory_uri() . '/scripts/slider-hero.js', array(),
       null,
       true
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );


/* -----------------------------------------------------post types HERO----------------------------------------------------------- */
function hero (){
    register_post_type('hero', // this is the name of the post type
    array(
        'public' => true,
        'label' => 'Hero Slides',
        'labels' => array(
            'singular_name' => 'Hero Slide',
            'add_new_item' => 'Add New Slide',
            'edit_item' => 'Edit Slide',
            'all_items' => 'All Slides'
        ),
        'exclude_from_search' => true,
        'supports' => array('title', 'editor', 'thumbnail')
        )
    );
}
add_action('init', 'hero'); // this is a hook and will appear in the admin panel in wp 

function slider() {
    $the_query = new WP_Query(
        array(
            'post_type' => 'hero', 
            'order'     => 'ASC',
        )
    );

    if ($the_query->have_posts()) {
        echo "<section class='slider-wrapper'>";
        echo "<button class='slide-arrow' id='slide-arrow-prev'>&#8249;</button>";
        echo "<button class='slide-arrow' id='slide-arrow-next'>&#8250;</button>";
        echo "<ul class='slides-container' id='slides-container'>";

       while ($the_query->have_posts()) {
            $the_query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'hero'); // 'hero' is a custom image size
            echo "<li class='slide'>";
            echo "<span class='slide-title'>" . get_the_title() . "</span>";
            echo "<img src='{$image_url}' alt='".get_the_title()."' class='slide-image' />";
            echo "<script>console.log('hero img src: ' + " . json_encode($image_url) . ");</script>";
            echo "</li>";
        }

        echo "</ul>";
        echo "</section>";
    }

    wp_reset_postdata();
}

add_shortcode('slider', 'slider');
add_image_size('hero', 1200, 300, true);
add_theme_support('post-thumbnails');


/* -----------------------------------------------------footer------------------------------------------------------------ */