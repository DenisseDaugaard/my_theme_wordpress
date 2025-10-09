<?php
get_header(); // Loads header.php
?>

<main class="wrap" id="site-content">
    <section class="page">
        <h2>Search Results for: <?php echo get_search_query(); ?></h2>
    
        <?php if (have_posts()) : ?>
            <ul class="search-results">
                <?php while (have_posts()) : the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <p><?php the_excerpt(); ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p>No results found. Try another search!</p>
        <?php endif; ?>
    </section>
</main>

<?php
get_footer(); // Loads footer.php
?>
