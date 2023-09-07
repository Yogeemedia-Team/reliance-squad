<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package thebase
 */

namespace TheBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js" <?php thebase()->print_microdata( 'html' ); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
/**
 * TheBase before wrapper hook.
 */
do_action( 'thebase_before_wrapper' );
?>
<div id="wrapper" class="site">
	<?php
	/**
	 * TheBase before header hook.
	 *
	 * @hooked thebase_do_skip_to_content_link - 2
	 */
	do_action( 'thebase_before_header' );

	/**
	 * TheBase header hook.
	 *
	 * @hooked TheBase/header_markup - 10
	 */
	do_action( 'thebase_header' );

	do_action( 'thebase_after_header' );
	?>

	<div id="inner-wrap" class="wrap hfeed tb-clear">
		<?php
		/**
		 * Hook for top of inner wrap.
		 */
		do_action( 'thebase_before_content' );
		?>
