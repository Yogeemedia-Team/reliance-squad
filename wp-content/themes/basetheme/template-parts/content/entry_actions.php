<?php
/**
 * Template part for displaying a post's comment and edit links
 *
 * @package thebase
 */

namespace TheBase;

$slug             = ( is_search() ? 'search' : get_post_type() );
$readmore_element = thebase()->option( $slug . '_archive_element_readmore', array(
	'enabled' => true,
	'label'   => esc_html__( 'Read More', 'basetheme' ),
) );
if ( isset( $readmore_element ) && is_array( $readmore_element ) && true === $readmore_element['enabled'] ) {
	?>
	<div class="entry-actions">
		<p class="more-link-wrap">
			<a href="<?php the_permalink(); ?>" class="post-more-link">
				<?php
					echo esc_html( isset( $readmore_element['label'] ) && ! empty( $readmore_element['label'] ) ? $readmore_element['label'] : __( 'Read More', 'basetheme' ) );
					echo wp_kses(
						'<span class="screen-reader-text"> ' . get_the_title() . '</span>',
						array(
							'span' => array(
								'class' => array(),
							),
						)
					);
					thebase()->print_icon( 'arrow-right-alt' );
				?>
			</a>
		</p>
	</div><!-- .entry-actions -->
	<?php
}
