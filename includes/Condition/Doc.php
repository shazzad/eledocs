<?php
namespace EleDocs\Condition;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;
use ElementorPro\Modules\QueryControl\Module as QueryModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Doc extends ThemeBuilder\Conditions\Condition_Base {

	private $post_type = 'docs';

	public static function get_type() {
		return 'eledocs_doc';
	}

	public function get_name() {
		return 'eledocs_doc';
	}

	public static function get_priority() {
		return 30;
	}

	public function get_label() {
		return __( 'Doc', 'eledocs' );
	}

	public function get_all_label() {
		return __( 'All Doc', 'eledocs' );
	}

	public function register_sub_conditions() {
		$doc_single = new ThemeBuilder\Conditions\Post( [
			'post_type' => $this->post_type,
			'post_parent' => 0
		] );

		$this->register_sub_condition( $doc_single );
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
						'post_type' => $this->post_type,
						'post_parent' => 0
					],
				],
			]
		);
	}

	public function check( $args ) {
		if ( isset( $args['id'] ) ) {
			$id = (int) $args['id'];
			if ( $id ) {
				return is_singular( $this->post_type ) && get_queried_object_id() === $id;
			}
		}

		return is_singular( $this->post_type ) && get_post_field( 'post_parent' ) === 0;
	}
}
