<?php
namespace WeDocs\Elementor_Integration\Widget;

use \Elementor\Widget_Base;

class Breadcrumbs extends Widget_Base {

	public function get_name() {
		return 'wedocs-breadcrumbs';
	}

	public function get_title() {
		return __( 'Wedocs Breadcrumbs', 'plugin-name' );
	}

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function render() {
		wedocs_breadcrumbs();
	}
}
