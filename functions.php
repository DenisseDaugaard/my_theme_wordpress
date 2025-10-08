<?php
function my_theme_css() {
   wp_enqueue_style(
    "denisses-theme-style",
    get_template_directory_uri() . '/style.css',
    array(),
    wp_get_theme()->get('Version'),
    'all'
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
       true //chab
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
            echo "<h1 class='slide-title'>" . get_the_title() . "</h1>";
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

function footer_widgets(){

    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => 'Footer Widget Area ' . $i,
            'id'            => 'footer-' . $i,
            'before_widget' => '<section class="footer-widget">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        ) );
     }

}
add_action('widgets_init', 'footer_widgets');

/* ---------------------------------------------customized widget -------------------------------------------------------- */
// === Footer Settings for Customizer ===
function mytheme_footer_customizer( $wp_customize ) {

    // Add a Footer section
    $wp_customize->add_section( 'footer_settings_section', array(
        'title'    => __( 'Footer Settings', 'mytheme' ),
        'priority' => 130,
    ) );

    // --- Enable Footer Widgets ---
    $wp_customize->add_setting( 'enable_footer_widgets', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'enable_footer_widgets', array(
        'label'    => __( 'Display Footer Widgets', 'mytheme' ),
        'section'  => 'footer_settings_section',
        'type'     => 'checkbox',
    ) );

    // --- Show/Hide Social Icons ---
    $wp_customize->add_setting( 'show_footer_social', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'show_footer_social', array(
        'label'    => __( 'Show Social Media Links', 'mytheme' ),
        'section'  => 'footer_settings_section',
        'type'     => 'checkbox',
    ) );

    // --- Show/Hide Newsletter ---
    $wp_customize->add_setting( 'show_footer_newsletter', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'show_footer_newsletter', array(
        'label'    => __( 'Show Newsletter Form', 'mytheme' ),
        'section'  => 'footer_settings_section',
        'type'     => 'checkbox',
    ) );

    // --- Optional: Add URL fields for each social network ---
    $socials = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube' );
    foreach ( $socials as $social ) {
        $wp_customize->add_setting( "footer_{$social}_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( "footer_{$social}_url", array(
            'label'   => sprintf( __( '%s URL', 'mytheme' ), ucfirst( $social ) ),
            'section' => 'footer_settings_section',
            'type'    => 'url',
        ) );
    }
}
add_action( 'customize_register', 'mytheme_footer_customizer' );

