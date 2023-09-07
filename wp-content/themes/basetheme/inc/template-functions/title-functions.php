<?php
/**
 * Calls in content using theme hooks.
 *
 * @package thebase
 */

namespace TheBase;

use function TheBase\thebase;
use function get_template_part;

defined( 'ABSPATH' ) || exit;
/**
 * Hero Title
 */
function hero_title() {
	if ( thebase()->show_hero_title() ) {
		if ( is_singular( get_post_type() ) ) {
			get_template_part( 'template-parts/content/entry_hero' );
		} else {
			get_template_part( 'template-parts/content/archive_hero' );
		}
	}
}
/**
 * Page Title area
 *
 * @param string $item_type the single post type.
 * @param string $area the title area.
 */
function thebase_entry_header( $item_type = 'post', $area = 'normal' ) {
	thebase()->render_title( $item_type, $area );
}

/**
 * Archive Title area
 *
 * @param string $item_type the single post type.
 * @param string $area the title area.
 */
function thebase_entry_archive_header( $item_type = 'post_archive', $area = 'normal' ) {
	thebase()->render_archive_title( $item_type, $area );
}
