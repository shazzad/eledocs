<?php

namespace EleDocs;

/**
 * Frontend Handler Class
 */
class Frontend {

    /**
     * Class Constructor
     */
    function __construct() {

        // Loads frontend scripts and styles
        # add_filter( 'wedocs_breadcrumbs_html', [ $this, 'breadcrumbs_html' ], 20  );

        // override the theme template
        add_filter( 'template_include', [ $this, 'template_loader' ], 21 );
    }

    /**
     * Enqueue admin scripts.
     *
     * Allows plugin assets to be loaded.
     *
     * @uses wp_enqueue_script()
     * @uses wp_localize_script()
     * @uses wp_enqueue_style
     */
    public function breadcrumbs_html( $html ) {
        return str_replace( 'class="wedocs-breadcrumb"', 'class="wdei-breadcrumb"', $html );
    }

    /**
     * If the theme doesn't have any single doc handler, load that from
     * the plugin.
     *
     * @param string $template
     *
     * @return string
     */
    public function template_loader( $template ) {
        if ( is_single() && get_post_type() == 'docs' && elementor_location_exits( 'single', true ) ) {
			$template = eledocs()->template_path() . 'single-docs.php';
        }

        return $template;
    }
}
