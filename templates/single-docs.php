<?php
if ( function_exists( 'elementor_theme_do_location' ) && elementor_location_exits( 'single' ) ) {
	get_header();
	echo '<div class="wedocs-single-wrap" style="display:block;">';
	elementor_theme_do_location( 'single' );
	echo '</div>';
	get_footer();
} else {
	// echo 'Locate backup file';
	wedocs_get_template( 'single-docs' );
}
