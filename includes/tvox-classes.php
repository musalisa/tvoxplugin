<?php

class Tvox_BD_Media_Walker extends Walker {
	var $tree_type = 'category';
	var $db_fields = array( 'id' => 'term_id', 'parent' => 'parent' );

	function start_el( &$output, $term, $depth, $args ) {
		$url = get_term_link( $term, $term->taxonomy );

		$indent = str_repeat( '&nbsp;', $depth * 3 );
		$text = str_repeat( '&nbsp;', 1 ) . $term->name;
		if ( $args['show_count'] ) {
			$text .= '&nbsp;(' . $term->count . ')';
		}

		$class_name = 'level-' . $depth;
		$checked_array = $args->checked;
		if ( in_array( $term->term_id, $args['checked'] ) )
		{
			$checked = 'checked';
		}
		else
		{
			$checked = '';
		}

		$output .= esc_html( $indent ) . '<input type="checkbox" name="tvox_medialib_' . $term->term_id . '" value="'.$term->term_id . '"  class="tvox_bd_term_check" ' . $checked . ' />' . esc_html( $text ) . '<br />';
	}
}

class Tvox_BD_Library extends BuddyDrive_Item
{
	public function get_by_term( $term_id ) {
 		$query_args = array(
				'post_type' => 'buddydrive-file',
				'tax_query' => array(
						array(
								'taxonomy' => 'media',
								'field'    => 'id',
								'terms'    => $term_id,
						),
				),
				'meta_query' => array(
						//'relation' => 'OR',
						array(
								'key'     => '_buddydrive_sharing_option',
								'value'   => 'public',
								'compare' => '=',
						),
				),
		);
		$this->query = new WP_Query( $query_args );
	}
 }
