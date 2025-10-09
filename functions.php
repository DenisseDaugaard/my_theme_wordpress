<?php
/* ---------------------------------------------css------------------------------------------------------------ */
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


function my_theme_fonts() {
    wp_enqueue_style('nunito-font', 'https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap', false);
    wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap', false);
    wp_enqueue_style('playfair-font', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap', false);
    wp_enqueue_style('italiana-font', 'https://fonts.googleapis.com/css2?family=Italiana&display=swap', false);
}
add_action('wp_enqueue_scripts', 'my_theme_fonts');




/* ---------------------------------------------------------header-------------------------------------------------------------- */
add_theme_support( 'custom-logo', array(
    'height'      => 100,
    'width'       => 100,
    'flex-height' => true,
    'flex-width'  => true,
) );



/* ---------------------------------------------------------scripts--------------------------------------------------------- */
function my_theme_scripts() {
    wp_enqueue_script( 'dark-mode-script', get_template_directory_uri() . '/assets/scripts/dark-mode.js',   array(),
        null,
        true // Load in footer
    );
    
    wp_enqueue_script( 'slider-hero-script', get_template_directory_uri() . '/assets/scripts/slider-hero.js', array(),
       null,
       true //
    );

    wp_enqueue_script( 'burger-menu-script', get_template_directory_uri() . '/assets/scripts/burger-menu.js', array(),
       null,
       true //
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );


/* -------------------------------------------------CUSTOM NAVEGATION-------------------------------------- */



function my_theme_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mytheme'),
    ));
}
add_action('after_setup_theme', 'my_theme_register_menus');


function my_theme_create_defaul_menu(){
    $defaul_pages = array(
        'Home'              => 'Welcome to our website.',
        'About'             => 'This is about page.',
        'Privacy Policy'    => 'Here you can read about our privacy policy.',
        'News'              => 'Here you can post news, promotions and more.',
        'Contact'           => 'Get in touch with us!',
    );

    $created_pages = array();
    foreach($created_pages as $title => $content){
        $page_check = get_page_by_title($title);

        if(!$isset($page_check->ID)){
            $new_page_id = wp_insert_post(array(
                 'post_type'    => 'page',
                'post_title'   => $title,
                'post_content' => $content,
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));

         $created_pages[$title] = $new_page_id;
        } else {
                $created_pages[$title] = $page_check->ID;
        }
        
    }

    // set the 'Home page 
    if (isset($created_pages['Home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $created_pages['Home']);
    }

    // Create navigation menu if it doesn’t exist
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        // Add menu items
        foreach ($created_pages as $page_id) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-object-id' => $page_id,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ));
        }

        // Assign menu to theme location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

add_action('after_switch_theme','my_theme_create_defaul_menu');









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






/*  ----------------------------------------------------NEWS ----------------------------------------------------------*/

function register_news_post_type() {
    $labels = array(
        'name'               => 'News',
        'singular_name'      => 'News Item',
        'menu_name'          => 'News',
        'name_admin_bar'     => 'News Item',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New News Item',
        'edit_item'          => 'Edit News Item',
        'new_item'           => 'New News Item',
        'view_item'          => 'View News Item',
        'all_items'          => 'All News',
        'search_items'       => 'Search News',
        'not_found'          => 'No news found',
        'not_found_in_trash' => 'No news found in Trash',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'news'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-media-document', // optional icon 
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'), // severa optional support 
    );

    register_post_type('news', $args);
}
add_action('init', 'register_news_post_type');


function custom_news() {
    $news_query = new WP_Query(array(
        'post_type'      => 'news',
        'posts_per_page' => 5, // Change this number if you want more posts per page
        'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
        'post_status'    => 'publish', // Only show published posts
        // 'order'     => 'ASC',
    ));

    if ($news_query->have_posts()) {
        echo "<section class='news-wrap page'>";

        while ($news_query->have_posts()) {
            $news_query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            echo "<article class='news-item'>";
            echo "<h2 class='news-title'>" . get_the_title() . "</h2>";
            echo "<figure class='news-img-container'><img src='{$image_url}' alt='" . esc_attr(get_the_title()) . "' class='slide-image' /></figure>";
            echo "<small class='news-date'>" . get_the_date() . "</small>";
            echo "<div class='news-excerpt'>" . get_the_excerpt() . "</div>";
            echo "</article>";
        }

        echo "</section>";

    } else {
        echo "<p>No news posts found!</p>";
    }

    wp_reset_postdata();
}

add_shortcode('news', 'custom_news');
add_image_size('medium', 400, 200, true);
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

