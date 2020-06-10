<?php
namespace EleDocs\Document;

use Elementor\Controls_Manager;
use ElementorPro\Modules\ThemeBuilder\Documents\Single;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Doc extends Single {

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['location'] = 'single';
		$properties['condition_type'] = 'docs';

		return $properties;
	}

	public function get_name() {
		return 'docs';
	}

	public static function get_title() {
		return __( 'Single Docs', 'elementor-pro' );
	}

	protected static function get_editor_panel_categories() {
		$categories = [
			// Move to top as active.
			'eledocs' => [
				'title' => __( 'EleDocs', 'elementor-pro' ),
				'active' => true,
			],
		];

		$categories += parent::get_editor_panel_categories();

		return $categories;
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->update_control(
			'preview_type',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'single/docs',
			]
		);

		$latest_posts = get_posts( [
			'posts_per_page' => 1,
			'post_type' => 'docs',
			'post_parent' => 0
		] );

		if ( ! empty( $latest_posts ) ) {
			$this->update_control(
				'preview_id',
				[
					'default' => $latest_posts[0]->ID,
				]
			);
		}
	}
}
