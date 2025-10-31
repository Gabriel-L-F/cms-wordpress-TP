<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function () {

    // Charger d'abord le CSS du thème parent
    wp_enqueue_style(
        'rayforce-parent-style',
        get_template_directory_uri() . '/style.css'
    );

    // Puis le CSS du thème enfant
    wp_enqueue_style(
        'rayforce-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [ 'rayforce-parent-style' ], 
        wp_get_theme()->get( 'Version' )
    );
}, 20);


// Remplacement du footer du thème parent
add_action( 'wp', function () {
    remove_action( 'wp_footer', [ rayforce_theme()->get( 'footer' ), 'render' ], 10 );
    add_action( 'wp_footer', 'rayforce_child_custom_footer', 10 );
    
    add_filter( 'render_block', 'rayforce_child_remove_kubio_navigation', 10, 2 );

    add_action( 'wp_head', 'rayforce_child_custom_header', 10 );
});


function rayforce_child_remove_kubio_navigation( $block_content, $block ) {
    if ( isset( $block['blockName'] ) && $block['blockName'] === 'kubio/navigation-section' ) {
        return ''; 
    }
    return $block_content;
}


function rayforce_child_custom_header() { ?>
    
    <header class="child-header">
        <div class="header-container">
          
            <!-- Menu principal -->
            <nav class="main-navigation">
                <ul class="menu">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>">À propos</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
                </ul>
            </nav>

            <!-- Bouton -->
            <div class="header-button">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-header">Nous contacter</a>
            </div>

        </div>
    </header>

<?php
}


function rayforce_child_custom_footer() { ?>
    <footer class="child-footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>À propos</h4>
                <p>Nous créons des sites rapides et accessibles.</p>
            </div>
            <div class="footer-col">
                <h4>Liens</h4>
                <ul>
                    <li><a href="/boutique">Boutique</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/mentions-legales">Mentions légales</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Suivez-nous</h4>
                <p>
                    <a href="https://instagram.com" target="_blank" rel="noopener">Instagram</a> •
                    <a href="https://facebook.com" target="_blank" rel="noopener">Facebook</a>
                </p>
                <p class="copy">© <?php echo date('Y'); ?> — Mon Entreprise</p>
            </div>
        </div>
    </footer>
<?php }
