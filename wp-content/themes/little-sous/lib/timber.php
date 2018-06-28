<?php
use Roots\Sage\Setup;

/**
 * Timber
 */

class TwigSageTheme extends TimberSite {
    function __construct() {
        add_filter( 'timber_context', array( $this, 'add_to_context' ) );
        parent::__construct();
    }
    function add_to_context( $context ) {

        /* Menu */
        $context['menu'] = new TimberMenu('primary_navigation');
        $context['menu_posts'] = new TimberMenu('posts_navigation');
        $context['menu_footer'] = new TimberMenu('footer_navigation');

        $context['current_year'] = date('Y');

        $context['options'] = get_fields('options');

        /* Site info */
        $context['site'] = $this;


        return $context;

    }
}
new TwigSageTheme();

/**
 * Timber
 *
 * Check if Timber is activated
 */

if ( ! class_exists( 'Timber' ) ) {

    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
    return;

}



/**
 * Disable timber cache while debugging
 *
 * @since 1.0
 * 
 */
if ( WP_DEBUG ) {
    add_filter( 'timber/cache/mode', function () {
        return 'none';
    } );
}