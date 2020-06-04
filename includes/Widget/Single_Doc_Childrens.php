<?php
namespace WeDocs\Elementor_Integration\Widget;

use \Elementor\Widget_Base;

class Single_Doc_Childrens extends Widget_Base {

	public function get_name() {
		return 'wedocs-single-doc-childrens';
	}

	public function get_title() {
		return __( 'Wedocs Single Doc Childrens', 'plugin-name' );
	}

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function render() {
		global $post;

		$children = wp_list_pages( 'title_li=&order=menu_order&parent=' . $post->ID . '&echo=0&post_type=' . $post->post_type );

		if ( $children ) {
			echo '<div class="article-child well">';
			echo '<ul>';
			echo $children;
			echo '</ul>';
			echo '</div>';
		}
	}
}
