<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package thebase
 */

namespace TheBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hook for bottom of inner wrap.
 */
do_action( 'thebase_after_content' );
?>
	</div><!-- #inner-wrap -->
	<?php
	do_action( 'thebase_before_footer' );
	/**
	 * TheBase footer hook.
	 *
	 * @hooked TheBase/footer_markup - 10
	 */
	do_action( 'thebase_footer' );

	do_action( 'thebase_after_footer' );
	?>
</div><!-- #wrapper -->
<?php do_action( 'thebase_after_wrapper' ); ?>

<?php wp_footer(); ?>
</body>
</html>
