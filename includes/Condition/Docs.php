<?php
namespace EleDocs\Condition;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;
use ElementorPro\Modules\QueryControl\Module as QueryModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Docs extends ThemeBuilder\Conditions\Condition_Base {

	private $post_type = 'docs';

	public static function get_type() {
		return 'all_docs';
	}

	public function get_name() {
		return $this->post_type;
	}

	public function get_label() {
		return __( 'Doc / Section / Article', 'elementor-pro' );
	}

	public function get_all_label() {
		return __( 'All Doc / Section / Article', 'elementor-pro' );
	}

	public function register_sub_conditions() {
		$section = new Doc();
		$this->register_sub_condition( $section );
	}

	protected function _register_controls() {
		$this->add_control(
			'post_id',
			[
				'section' => 'settings',
				'type' => QueryModule::QUERY_CONTROL_ID,
				'select2options' => [
					'dropdownCssClass' => 'elementor-conditions-select2-dropdown',
				],
				'autocomplete' => [
					'object' => QueryModule::QUERY_OBJECT_POST,
					'query' => [
						'post_type' => $this->get_name(),
					],
				],
			]
		);
	}

	public function check( $args ) {
		if ( isset( $args['id'] ) ) {
			$id = (int) $args['id'];
			if ( $id ) {
				return is_singular( 'docs' ) && get_queried_object_id() === $id;
			}
		}

		return is_singular( 'docs' );
	}
}
