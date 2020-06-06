<?php
namespace EleDocs\Widget;

class Sections extends Parent_Child_Grid {

	public function get_name() {
		return 'eledocs-sections';
	}

	public function get_title() {
		return __( 'Sections', 'eledocs' );
	}

	public function get_icon() {
		return 'fa fa-file-alt';
	}

	public function get_categories() {
		return [ 'eledocs' ];
	}

	public function get_keywords() {
		return [ 'wedocs', 'sections' ];
	}

	protected function get_control_label( $key ) {
		$labels = [
			'show_children' => __( 'Show Articles?', 'eledocs' ),
			'children_limit' => __( 'Articles per Section?', 'eledocs' ),
			'parent_plural' => __( 'Sections', 'eledocs' ),
			'parent_singular' => __( 'Section', 'eledocs' ),
			'parent_title' => __( 'Section Title', 'eledocs' ),
			'child_plural' => __( 'Articles', 'eledocs' ),
			'child_singular' => __( 'Article', 'eledocs' ),
		];

		if ( isset( $labels[ $key ] ) ) {
			return $labels[ $key ];
		}

		return __( 'Nothing', 'eledocs' );
	}

	protected function get_control_description( $key ) {
		$descriptions = [
			'children_limit' => __( 'Number of Articles to display per Section?', 'eledocs' )
		];

		if ( isset( $descriptions[ $key ] ) ) {
			return $descriptions[ $key ];
		}

		return __( 'Nothing', 'eledocs' );
	}

	public function get_parent_items() {
		global $post;

		if ( $post->post_parent ) {
			$ancestors = get_post_ancestors( $post->ID );
			$root      = count( $ancestors ) - 1;
			$parent_id = $ancestors[$root];
		} else {
			$parent_id = $post->ID;
		}

        $parents_args = [
            'post_type'   => 'docs',
            'parent'      => $parent_id,
            'sort_column' => 'menu_order',
        ];

        return get_pages( $parents_args );
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
