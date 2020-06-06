<?php
namespace EleDocs\Widget;

class Docs extends Parent_Child_Grid {

	public function get_name() {
		return 'eledocs-docs';
	}

	public function get_title() {
		return __( 'Docs', 'eledocs' );
	}

	public function get_icon() {
		return 'fa fa-file-alt';
	}

	public function get_categories() {
		return [ 'eledocs' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'docs' ];
	}

	protected function get_control_label( $key ) {
		$labels = [
			'show_children' => __( 'Show Sections?', 'eledocs' ),
			'children_limit' => __( 'Sections per Doc?', 'eledocs' ),
			'parent_plural' => __( 'Docs', 'eledocs' ),
			'parent_singular' => __( 'Doc', 'eledocs' ),
			'parent_title' => __( 'Doc Title', 'eledocs' ),
			'child_plural' => __( 'Sections', 'eledocs' ),
			'child_singular' => __( 'Section', 'eledocs' ),
		];

		if ( isset( $labels[ $key ] ) ) {
			return $labels[ $key ];
		}

		return __( 'Nothing', 'eledocs' );
	}

	protected function get_control_description( $key ) {
		$descriptions = [
			'children_limit' => __( 'Number of Sections to display per Doc?', 'eledocs' )
		];

		if ( isset( $descriptions[ $key ] ) ) {
			return $descriptions[ $key ];
		}

		return __( 'Nothing', 'eledocs' );
	}

	public function get_parent_items() {
        $docs_args = [
            'post_type'   => 'docs',
            'parent'      => 0,
            'sort_column' => 'menu_order',
        ];

        return get_pages( $docs_args );
	}

	public function get_children_items( $parent_id, $limit = 20 ) {
		return get_children( [
			'post_parent'    => $parent_id,
			'post_type'      => 'docs',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => (int) $limit,
		] );
	}
}
