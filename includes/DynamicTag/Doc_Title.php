<?php
namespace EleDocs\DynamicTag;

use \Elementor\Controls_Manager;
use \Elementor\Modules\DynamicTags\Module;
use \Elementor\Core\DynamicTags\Tag;

class Doc_Title extends Tag {

	public function get_name() {
		return 'eledocs-doc-title';
	}

	public function get_title() {
		return __( 'Doc Title', 'wedocs-elementor-integration' );
	}

	public function get_group() {
		return [ 'eledocs' ];
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		global $post;

		if ( isset( $post ) && $post->post_type === 'docs' ) {
			if ( $post->post_parent ) {
				$ancestors = get_post_ancestors( $post->ID );
				$root      = count( $ancestors ) - 1;
				$parent_id = $ancestors[$root];
			} else {
				$parent_id = $post->ID;
			}

			$enable_link = 'yes' === $this->get_settings( 'enable_link' );

			if ( $enable_link ) {
				printf(
					'<a href="%s">%s</a>',
					get_permalink( $parent_id ),
					get_post_field( 'post_title', $parent_id )
				);
			} else {
				echo get_post_field( 'post_title', $parent_id );
			}
		}
	}

	protected function _register_controls() {
		$this->add_control(
			'enable_link',
			[
				'label' => __( 'Link Title?', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
	}
}
