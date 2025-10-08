<footer class="site-footer">
    <section id="widgets-container">

        
        <?php if ( get_theme_mod( 'show_footer_newsletter', true ) ) : ?>
            <div class="footer-widget footer-newsletter">
                <h3 class="footer-widget-title">Subscribe to Our Newsletter</h3>
                <form class="footer-subscribe-form" action="#" method="post">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'enable_footer_widgets', true ) ) : ?>
                
                <div class="footer-widgets-container" id="widgets-container">
                    <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                        <?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
                            <div class="footer-widget-area footer-widget-<?php echo $i; ?>">
                                <img class="footer-widget-img" src="<?php echo esc_url( get_theme_mod( 'footer_widget_') ); ?>" 
                                alt="<?php echo esc_attr( get_theme_mod( 'footer_widget_' . $i . '_image_alt' ) ); ?>">
                                <?php dynamic_sidebar( 'footer-' . $i ); ?>
                            </div>
                            <?php endif; ?>
                            <?php endfor; ?>
                        </div>
            <?php endif; ?>


                        <?php if ( get_theme_mod( 'show_footer_social', true ) ) : ?>
                        <div class="footer-widget footer-social">
                            <h3 class="footer-widget-title">Follow Us</h3>
                            <div class="footer-social-links">
                                <?php
                                $socials = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube' );
                                foreach ( $socials as $social ) :
                                    $url = get_theme_mod( "footer_{$social}_url" );
                                    if ( $url ) : ?>
                                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" aria-label="<?php echo ucfirst( $social ); ?>">
                                            <i class="fab fa-<?php echo esc_attr( $social ); ?>"></i>
                                        </a>
                                    <?php endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </section>
                    
    <span class="rights-section">ALL RIGTHS RESERVED &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></span>
</footer>

<?php wp_footer(); ?>
</body>
</html>
