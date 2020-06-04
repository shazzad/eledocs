<?php
namespace WeDocs\Elementor_Integration\Widget;

use \Elementor\Widget_Base;

class Single_Doc_Sidebar extends Widget_Base {

	public function get_name() {
		return 'wedocs-ei-single-doc-sidebar';
	}

	public function get_title() {
		return __( 'Wedocs Single Doc Sidebar', 'plugin-name' );
	}

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function render() {
		global $post;
		?>
		<div class="wedocs-sidebar" style="width: 100%;">
		<?php
		$ancestors = [];
		$root      = $parent = false;

		if ( $post->post_parent ) {
		    $ancestors = get_post_ancestors( $post->ID );
		    $root      = count( $ancestors ) - 1;
		    $parent    = $ancestors[$root];
		} else {
		    $parent = $post->ID;
		}

		// var_dump( $parent, $ancestors, $root );
		$walker   = new \WeDevs\WeDocs\Walker();
		$children = wp_list_pages( [
		    'title_li'  => '',
		    'order'     => 'menu_order',
		    'child_of'  => $parent,
		    'echo'      => false,
		    'post_type' => 'docs',
		    'walker'    => $walker,
		] );
		?>

		<?php if ( $children ) { ?>
		    <ul class="doc-nav-list">
		        <?php echo $children; ?>
		    </ul>
		<?php } ?>
		</div>
		<?php
	}
}
