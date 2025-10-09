<?php get_header();?>
<main class="wrap">
  <section class="content-area content-full-width page">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <article class="post">
            <header>
              <h2><?php the_title(); ?></h2>
              <!-- By: <?php the_author(); ?> -->
            </header>
<?php
if ( is_page('news') ) {
    custom_news();
} else {
    the_content();
}

 ?>
            <small class="post-date">
                <?php the_date(); ?> 
            </small>
          </article>
    <?php endwhile; else : ?>
      <article>
        <p>Sorry, no post was found!</p>
      </article>
<?php endif; ?>
  </section>
</main>
<?php get_footer(); ?>

