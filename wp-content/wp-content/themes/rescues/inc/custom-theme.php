<?php
/**
 * Class for the Custom Theme
 *
 * @package thebase
 */

namespace TheBase\Custom_Theme;


use TheBase\Theme_Customizer;
use function TheBase\thebase;
use TheBase_Blocks_Frontend;
use TheBase\Component_Interface;
use TheBase\Templating_Component_Interface;
use TheBase\TheBase_CSS;
use LearnDash_Settings_Section;
use function TheBase\get_webfont_url;
use function TheBase\print_webfont_preload;
use function add_action;
use function add_filter;
use function wp_enqueue_style;
use function wp_register_style;
use function wp_style_add_data;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_styles;
use function esc_attr;
use function esc_url;
use function wp_style_is;
use function _doing_it_wrong;
use function wp_print_styles;
use function post_password_required;
use function is_singular;
use function comments_open;
use function get_comments_number;
use function apply_filters;
use function add_query_arg;
use function wp_add_inline_style;
/**
 * Main plugin class
 */
class Custom_Theme {
	/**
	 * Instance Control
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * Holds theme array sections.
	 *
	 * @var the theme settings sections.
	 */
	private $update_options = array();

	/**
	 * Instance Control.
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning instances of the class is Forbidden', 'templatemela' ), '1.0' );
	}

	/**
	 * Disable un-serializing of the class.
	 *
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing instances of the class is forbidden', 'templatemela' ), '1.0' );
	}

	/**
	 * Constructor function.
	 */
	public function __construct() {
		
		add_filter( 'thebase_theme_options_defaults', array( $this, 'add_option_defaults' ), 10 );
		add_filter( 'thebase_addons_theme_options_defaults', array( $this, 'add_addon_option_defaults' ), 10 );		
		add_action( 'thebase_hero_header', array( $this, 'shop_filter' ), 5 );
		add_action( 'thebase_before_sidebar', array( $this, 'close_shop_filter' ), 5);
        add_filter( 'thebase_global_palette_defaults', array( $this,'add_color_option_defaults' ), 50 );
		add_filter( 'thebase_dynamic_css', array( $this, 'child_dynamic_css' ), 30 );
	}
	public function child_dynamic_css( $css ) {
$generated_css = $this->generate_child_css();
if ( ! empty( $generated_css ) ) {
$css .= "\n/* Base Pro Header CSS */\n" . $generated_css;
}
return $css;
}
public function generate_child_css () {
$css = new TheBase_CSS();
$css->set_selector( '.main-navigation .primary-menu-container > ul > li.menu-item.open > a' );
$css->add_property( 'color', $css->render_color( thebase()->sub_option( 'primary_navigation_color', 'hover' ) ) );
$css->add_property( 'background', $css->render_color( thebase()->sub_option( 'primary_navigation_background', 'hover' ) ) );

$css->set_selector( '.home.blog.transparent-header #wrapper #masthead' );
$css->render_background( thebase()->sub_option( 'transparent_header_background', 'desktop' ), $css );
$css->add_property( 'border-bottom', $css->render_border( thebase()->sub_option( 'transparent_header_bottom_border', 'desktop' ) ) );
$css->start_media_query( ( thebase()->sub_option( 'header_mobile_switch', 'size' ) ? '(max-width: ' . thebase()->sub_option( 'header_mobile_switch', 'size' ) . 'px)' : $media_query['tablet'] ) );
$css->set_selector( '.home.blog..transparent-header #wrapper #masthead' );
$css->render_background( thebase()->sub_option( 'transparent_header_background', 'tablet' ), $css );
$css->add_property( 'border-bottom', $css->render_border( thebase()->sub_option( 'transparent_header_bottom_border', 'tablet' ) ) );
$css->stop_media_query();
$css->start_media_query( $media_query['mobile'] );
$css->set_selector( '.home.blog..transparent-header #wrapper #masthead' );
$css->render_background( thebase()->sub_option( 'transparent_header_background', 'mobile' ), $css );

// $css->set_selector( '.primary-sidebar.widget-area .widget-title, .widget_block h2,.widget_block .widgettitle,.widget_block .widgettitle' );
// $css->render_font( thebase()->option( 'sidebar_widget_title' ), $css );
return $css->css_output();
}
	/**
 	* set child theme Default color.
	 */
	public function add_color_option_defaults( $defaults ) {
	if ( is_null( $default_palette ) ) {
	$default_palette = '{"palette":[{"color":"#D30F16","slug":"palette1","name":"Palette Color 1"},{"color":"#D30F16","slug":"palette2","name":"Palette Color 2"},{"color":"#1c1c1c","slug":"palette3","name":"Palette Color 3"},{"color":"#666666","slug":"palette4","name":"Palette Color 4"},{"color":"#222222","slug":"palette5","name":"Palette Color 5"},{"color":"#cccccc","slug":"palette6","name":"Palette Color 6"},{"color":"#F5F5F5","slug":"palette7","name":"Palette Color 7"},{"color":"#e5e5e5","slug":"palette8","name":"Palette Color 8"},{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"}],"active":"palette"}';
	}
	return $default_palette;
	}
	/**
	 * Shop Filter
	 */
	public function shop_filter() {
		if (  thebase()->has_sidebar() ) {				
		echo '<div class="thebase-show-sidebar-btn thebase-action-btn thebase-style-text">';
		echo '<span class="drawer-overlay" data-drawer-target-string="#mobile-drawer"></span>';
		echo '<span class="menu-toggle-icon">'.thebase()->print_icon( 'menu', '', false ).'</span>';
		echo '</div>';
		}
	}
	/**
	 * Shop Filter Close
	 */
	public function close_shop_filter($sale) {
		if (  thebase()->has_sidebar() ) {	
		echo '<div class="thebase-hide-sidebar-btn">';
		echo '<span class="menu-toggle-icon">'.thebase()->print_icon( 'close', '', false ).'</span>';
		echo '</div>';
		}
	}

	/**
	 * Add Defaults
	 *
	 * @access public
	 * @param array $defaults registered option defaults with templatemela theme.
	 * @return array
	 */
	public function add_option_defaults( $defaults ) {
		

		$update_options = array(
			'page_layout'             => 'normal',
			'page_title'              => true,
			'page_content_style'      => 'unboxed',
			//content_width
			'content_width'   => array(
				'size' => 1448,
				'unit' => 'px',
			),
			'content_narrow_width'   => array(
				'size' => 1248,
				'unit' => 'px',
			),
			'site_background'                => array(
				'desktop' => array(
					'color' => 'palette9',
				),
			),
			// Logo.
			'logo_width'                     => array(
				'size' => array(
					'mobile'  => 150,
					'tablet'  => '',
					'desktop' => 210,
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'logo_layout'     => array(
				'include' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => 'logo_only',
				),
			),
			// Buttons.
			'buttons_color'                     => array(
				'color'  => 'palette9',
				'hover'  => 'palette9',
			),
			'buttons_background' => array(
				'color'  => 'palette2',
				'hover'  => 'palette2',
			),
			'buttons_typography'    => array(
				'size' => array(
					'desktop' => '16',
				),
				'lineHeight' => array(
					'desktop' => '24',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'desktop' => '0.3',
				),
				'spacingType'=> 'px',
				'transform' => 'capitalize',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
			),
			'buttons_padding'        => array(
				'size'   => array(
					'mobile' => array( '10', '10', '10', '10' ),
					'tablet' => array( '20', '51', '20', '51' ),
					'desktop' => array( '13', '51', '13', '51' ),
				),
				'unit'   => array(
					'desktop' => 'px',
				),
				'locked' => array(
					'desktop' => false,
				),
			),
			'buttons_border_radius' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '0',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			// Header.
			'header_desktop_items'       => array(
				'top' => array(
					'top_left'         => array(),
					'top_left_center'  => array(),
					'top_center'       => array('contact'),
					'top_right_center' => array(),
					'top_right'        => array(),
				),
				'main' => array(
					'main_left' => array( 'logo' ),
					'main_center' => array('navigation'),
					'main_right' => array( 'html' ),
				),
				'bottom' => array(
					'bottom_left'         => array(),
					'bottom_left_center'  => array(),
					'bottom_center'       => array(),
					'bottom_right_center' => array(),
					'bottom_right'        => array(),
				),
			),
			
			// Header HTML.
			'header_html_content'    => __( '<div class="contact-main">
			<img class="alignnone size-full wp-image-8041" src="' . get_template_directory_uri() . '/assets/images/Call_01.svg" alt="" width="64" height="64" />
			<div class="contact-contain"><span class="title">Tel: (123) 456-7890</span>
			<a style="font-size: 18px; font-weight: 300; font-family: Roboto Condensed" href="tel:#" target="_self">For Emergency!</a></div>
			</div>', 'coderplace' ),
			'header_html_typography' => array(
				'size' => array(
					'desktop' => '25',
				),
				'lineHeight' => array(
					'desktop' => '1.3',
				),
				'family'  => 'Big Shoulders Display',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
				'color'   => 'palette9',
			),
			'header_html_link_style' => 'plain',
			'header_html_link_color'              => array(
				'color' => 'palette9',
				'hover' => 'palette9',
			),
			// Transparent Header.
			'transparent_header_enable' => true,
			'transparent_header_archive'    => false,
			'transparent_header_page'       => false,
			'transparent_header_post'       => false,
			'transparent_header_product'    => false,
			//header-top-row
			'header_top_trans_background'    => array(
				'desktop' => array(
					'color' => 'palette5',
				),
			),
			// Header Main.
			'header_main_height' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '80',
					'desktop' => '0',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			
			// Sticky Header.
			'header_sticky_background'                => array(
				'desktop' => array(
					'color' => 'palette5',
				),
			),
					'header_sticky'             => 'main',
					'header_reveal_scroll_up'   => false,
					'header_sticky_shrink'      => false,
					'header_sticky_main_shrink' => array(
						'size' => 60,
						'unit' => 'px',
			),
			'mobile_header_sticky'             => 'main',
					'mobile_header_sticky_shrink'      => false,
					'mobile_header_reveal_scroll_up'   => false,
					'mobile_header_sticky_main_shrink' => array(
						'size' => 60,
						'unit' => 'px',
					),
			// Header Top.
			'header_top_height'       => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => 44,
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			// Mobile Header.
			'mobile_navigation_typography'            => array(
				'size' => array(
					'desktop' => 18,
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '700',
				'variant' => '700',
			),
			'mobile_trigger_color'              => array(
				'color' => 'palette9',
				'hover' => 'palette2',
			),
			'mobile_trigger_icon_size'   => array(
				'size' => 1.8,
				'unit' => 'em',
			),
			'header_mobile_items' => array(
				'popup' => array(
					'popup_content' => array( 'mobile-navigation' ),
				),
				'top' => array(
					'top_left'   => array(),
					'top_center' => array(),
					'top_right'  => array(),
				),
				'main' => array(
					'main_left'   => array( 'mobile-logo' ),
					'main_center' => array(),
					'main_right'  => array( 'popup-toggle'),
				),
				'bottom' => array(
					'bottom_left'   => array(),
					'bottom_center' => array(),
					'bottom_right'  => array(),
				),
			),
			'buttons_shadow' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 0,
				'blur'    => 0,
				'spread'  => 0,
				'inset'   => false,
			),
			'buttons_shadow_hover' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 0,
				'blur'    => 0,
				'spread'  => 0,
				'inset'   => false,
			),

			// Header Mobile Contact.
			'header_mobile_contact_items' => array(
				'items' => array(
					array(
						'id'      => 'location',
						'enabled' => true,
						'source'  => 'icon',
						'url'     => '',
						'imageid' => '',
						'width'   => 20,
						'link'     => '',
						'icon'    => 'location',
						'label'   => '670 Lafayette Ave, Brooklyn, NY 11216',
					),
					array(
					'id'      => 'phone',
					'enabled' => true,
					'source'  => 'icon',
					'url'     => '',
					'imageid' => '',
					'width'   => 24,
					'link'     => '',
					'icon'    => 'phoneAlt2',
					'label'   => '444-546-8765',
					),								
					array(
						'id'      => 'hours',
						'enabled' => true,
						'source'  => 'icon',
						'url'     => '',
						'imageid' => '',
						'width'   => 24,
						'link'     => '',
						'icon'    => 'hours',
						'label'   => 'Everyday 24 Hours',
					),				
				),
			),


			// Navigation.
			'primary_navigation_typography'            => array(
				'transform' => 'uppercase',
				'weight' =>'700'
			),
			'primary_navigation_vertical_spacing'   => array(
						'size' => 2.6,
						'unit' => 'em',
			),
			'primary_navigation_color'   => array(
				'color'  => 'palette9',
				'hover'  => 'palette2',
				'active' => 'palette2',
			),
			'primary_navigation_spacing'            => array(
				'size' => 2,
				'unit' => 'em',
			),
			'dropdown_navigation_color'              => array(
				'color'  => 'palette9',
				'hover'  => 'palette2',
			),
			'dropdown_navigation_background'              => array(
				'color'  => 'palette3',
				'hover'  => 'palette3',
			),
			'dropdown_navigation_typography'            => array(
				'size' => array(
					'desktop' => 14,
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '',
				'variant' => '',
			),
			// Typography.
			'base_font' => array(
				'size' => array(
					'desktop' => 18,
				),
				'lineHeight' => array(
					'desktop' => 1.6,
				),
				'letterSpacing' => array(
					'desktop' => '0.3',
				),
				// 'family'  => '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"',
				'google'  => true,
				'family' => 'Roboto Condensed',
				'weight'  => '300',
				'variant' => 'regular',
				'color'   => 'palette4',
				'spacingType'=> 'px',
			),
			'load_fonts_local'    => false,
			'heading_font'        => array(
				// 'family'  => '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"',
				'google'  => true,
				'family' => 'Big Shoulders Display',
				'weight'  => '800',
				'variant' => '800',
			),
			'h1_font' => array(
				'size' => array(
					'desktop' => 53,
				),
				'lineHeight' => array(
					'desktop' => 1.3,
				),
				'lineType' =>  'em',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
				'color'   => 'palette3',
				'transform' => 'uppercase'
			),
			'h2_font' => array(
				'size' => array(
					'desktop' => 50,
				),
				'lineHeight' => array(
					'desktop' => 1.5,
				),
				'lineType' =>  'em',
				'letterSpacing' => array(
					'desktop' => '1.3',
				),
				'spacingType'=> 'px',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
				'color'   => 'palette3',
			),
			'h3_font' => array(
				'size' => array(
					'desktop' => 25,
				),
				'lineHeight' => array(
					'desktop' => 1.3,
				),
				'letterSpacing' => array(
					'desktop' => '0.8',
				),
				'spacingType'=> 'px',	
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
				'color'   => 'palette3',
			),
			'h4_font' => array(
				'size' => array(
					'desktop' => 20,
				),
				'lineHeight' => array(
					'desktop' => 1.5,
				),
				'letterSpacing' => array(
					'desktop' => '0.5',
				),
				'spacingType'=> 'px',	
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '700',
				'variant' => '700',
				'color'   => 'palette3',
			),
			'h5_font' => array(
				'size' => array(
					'desktop' => 20,
				),
				'lineHeight' => array(
					'desktop' => 1.5,
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '700',
				'variant' => '700',
				'color'   => 'palette4',
			),
			'h6_font' => array(
				'size' => array(
					'desktop' => 20,
				),
				'lineHeight' => array(
					'desktop' => 1.5,
				),
				'letterSpacing' => array(
					'desktop' => '1.3',
				),
				'lineType' =>  'px',
				'spacingType'=> 'px',
				'family'  => 'inherit',
				'google'  => true,
				'weight'  => '700',
				'variant' => '700',
				'color'   => 'palette1',
				'transform' => 'uppercase'
			),
			'title_above_breadcrumb_font' => array(
				'size' => array(
					'desktop' => '20',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'lineType' =>  'px',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '',
				),
				'spacingType'=> 'px',
				'transform' => 'none',
				'google'  => false,
				'weight'  => '',
				'variant' => '',
				'color'   => 'palette3',
			),
			// Post Archive.
			'post_related_background' => array(
				'desktop' => array(
					'color' => 'palette9',
				),
			),
			'boxed_grid_spacing'   => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => 0,
				),
				'unit' => array(
					'mobile'  => 'rem',
					'tablet'  => 'rem',
					'desktop' => 'rem',
				),
			),
			'boxed_grid_shadow' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 0,
				'blur'    => 0,
				'spread'  => 0,
				'inset'   => false,
			),
			'boxed_shadow' => array(
				'color'   => 'rgba(0,0,0,0)',
				'hOffset' => 0,
				'vOffset' => 0,
				'blur'    => 0,
				'spread'  => 0,
				'inset'   => false,
			),
			'boxed_spacing'   => array(
				'size' => array(
					'mobile'  => 1.5,
					'tablet'  => 2,
					'desktop' => 2,
				),
				'unit' => array(
					'mobile'  => 'rem',
					'tablet'  => 'rem',
					'desktop' => 'rem',
				),
			),
			'post_title_background'    => array(
				'desktop' => array(
				'type' => 'image',
				'image' => array(
				'url' => get_stylesheet_directory_uri() .'/assets/images/breadcrumb.jpg',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attachment' => 'scroll',
				),
				),
			),
			'post_title_font'   => array(
				'size' => array(
					'mobile'  => '33',
					'tablet'  => '40',
					'desktop' => '53',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '',
				'variant' => '',
				'color'   => 'palette9',
				'transform' => '',
			),
			'post_title_meta_color' => array(
				'color' => 'palette9',
				'hover' => 'palette2',
			),
			'post_title_meta_font'   => array(
				'size' => array(
					'desktop' => '20',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'inherit',
				'google'  => false,
				'transform' => '',
				'weight'  => '300',
				'variant' => '300',
			),
			'post_layout'             => 'normal',
			'post_content_style'      => 'unboxed',
			'post_feature_position'   => 'above',
			'post_title_layout'       => 'above',
			'post_archive_item_meta_color' => array(
				'color' => 'palette2',
				'hover' => 'palette2',
			),
			'post_archive_item_meta_font'   => array(
				'size' => array(
					'desktop' => '15',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '400',
				'variant' => '400',
			),
			'post_archive_item_title_font'   => array(
				'size' => array(
					'desktop' => '25',
				),
				'lineHeight' => array(
					'desktop' => '1.5',
				),
				'family'  => '',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
			),
			'post_archive_elements'             => array( 'meta','feature','title', 'excerpt', 'readmore' ),
			'post_archive_content_style'        => 'unboxed',
			'post_archive_element_categories'   => array(
				'enabled' => false,
			),
			'post_archive_element_meta' => array(
				'id'                     => 'meta',
				'enabled'                => true,
				'divider'                => 'vline',
				'author'                 => true,
				'authorLink'             => false,
				'authorImage'            => false,
				'authorImageSize'        => 25,
				'authorEnableLabel'      => true,
				'authorLabel'            => '',
				'date'                   => true,
				'dateEnableLabel'        => false,
				'dateLabel'              => '',
				'dateUpdated'            => false,
				'dateUpdatedEnableLabel' => true,
				'dateUpdatedLabel'       => '',
				'categories'             => false,
				'categoriesEnableLabel'  => true,
				'categoriesLabel'        => '',
				'comments'               => false,
			),
			'search_archive_title_color' => array(
				'color' => 'palette9',
			),
			'search_archive_title_background'   => array(
				'desktop' => array(
				'type' => 'image',
				'image' => array(
				'url' => get_stylesheet_directory_uri() .'/assets/images/breadcrumb.jpg',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attachment' => 'scroll',
				),
				),
			),
			'search_archive_title_layout'       => 'above',
			'search_archive_content_style'        => 'unboxed',
			'search_archive_item_title_font'   => array(
						'size' => array(
							'desktop' => '25',
						),
						'lineHeight' => array(
							'desktop' => '1.5',
						),
						'family'  => '',
						'google'  => false,
						'weight'  => '800',
						'variant' => '800',
					),
			'post_archive_element_excerpt' => array(
				'enabled'     => true,
				'words'       => 12,
				'fullContent' => false,
			),
			'post_archive_element_feature' => array(
				'enabled'   => true,
				'ratio'     => '2-3',
				'size'      => 'medium_large',
				'imageLink' => true,
			),
			'post_archive_element_excerpt' => array(
				'enabled'     => true,
				'words'       => 18,
				'fullContent' => false,
			),
			'post_archive_element_readmore' => array(
				'enabled' => false,
				'label'   => '',
			),
			'post_title_element_categories' => array(
				'enabled' => false,
			),
			'product_above_layout'       => 'title',
			'product_above_category_font'   => array(
				'size' => array(
					'mobile'  => '33',
					'tablet'  => '40',
					'desktop' => '53',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'Big Shoulders Display',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
				'color'   => 'palette9',
			),
			'product_title_background' => array(
				'desktop' => array(
				'type' => 'image',
				'image' => array(
				'url' => get_stylesheet_directory_uri() .'/assets/images/breadcrumb.jpg',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attachment' => 'scroll',
				),
				),
			),
			'product_title_font'   => array(
				'size' => array(
					'mobile'  => '24',
					'tablet'  => '30',
					'desktop' => '34',
				),
				'lineHeight' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '1',
				),
				'lineType' =>  '',
				'letterSpacing' => array(
					'mobile'  => '0',
					'tablet'  => '0',
					'desktop' => '0',
				),
				'spacingType'=> 'px',
				'transform' => '',
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
				'color'   => '',
			),
			'product_archive_title_color' => array(
				'color' => 'palette9',
			),
			'product_archive_title_breadcrumb_color' => array(
				'color' => 'palette9',
				'hover' => 'palette2',
			),
			'product_archive_title_background'  => array(
				'desktop' => array(
				'type' => 'image',
				'image' => array(
				'url' => get_stylesheet_directory_uri() .'/assets/images/breadcrumb.jpg',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attachment' => 'scroll',
				),
				),
			),
			'product_archive_title_font'   => array(
				'size' => array(
					'desktop' => '23',
				),
				'lineHeight' => array(
					'desktop' => '1.5',
				),
				'lineType' =>  'em',
				'letterSpacing' => array(
					'mobile' => '',
					'tablet' => '',
					'desktop' => '0.3',
				),
				'spacingType'=> 'px',
				'transform' => 'inherit',
				'family'  => 'inherit' ,
				'google'  => false,
				'weight'  => '500',
				'variant' => '500',
				'color'   => 'palette3',
			),
			'page_title_elements'      => array(  'title','breadcrumb', 'meta' ),
					'page_title_element_title' => array(
						'enabled' => true,
					),
					'page_title_element_breadcrumb' => array(
						'enabled' => true,
						'show_title' => true,
					),
			'page_title_background'  => array(
				'desktop' => array(
				'type' => 'image',
				'image' => array(
				'url' => get_stylesheet_directory_uri() .'/assets/images/breadcrumb.jpg',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attachment' => 'scroll',
				),
				),
			),
			'page_title_breadcrumb_color' => array(
				'color' => 'palette9',
				'hover' => 'palette2',
			),
			'page_title_font'   => array(
				'size' => array(
					'mobile'  => '33',
					'tablet'  => '40',
					'desktop' => '53',
				),
				'lineHeight' => array(
					'desktop' => '',
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '',
				'variant' => '',
				'color'   => 'palette9',
			),
			// Scroll To Top.
		'scroll_up'               => true,
		'scroll_up_side'          => 'right',
		'scroll_up_icon'          => 'arrow-up',
		'scroll_up_icon_size'   => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 1.3,
			),
			'unit' => array(
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			),
		),
		'scroll_up_side_offset'   => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 30,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'scroll_up_bottom_offset'   => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 30,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'scroll_up_visiblity' => array(
			'desktop' => true,
			'tablet'  => true,
			'mobile'  => false,
		),
		'scroll_up_style' => 'outline',
		'scroll_up_padding' => array(
			'size'   => array( 
				'desktop' => array( 0.4, 0.4, 0.4, 0.4 ),
			),
			'unit'   => array(
				'desktop' => 'em',
			),
			'locked' => array(
				'desktop' => true,
			),
		),
		'scroll_up_color'   => array(
			'color'  => 'palette2',
			'hover'  => 'palette2',
		),
		'scroll_up_background'  => array(
			'color'  => '',
			'hover'  => '',
		),
		'scroll_up_border_colors'  => array(
			'color'  => 'palette2',
			'hover'  => 'palette2',
		),
		'scroll_up_border'  => array(
			'width' => '2',
			'unit' => 'px',
			'style'=> 'solid',
			'color'  => 'palette2',
			'hover'  => 'palette2',
		),
		'scroll_up_radius' => array(
			'size'   => array( 50, 50, 50, 50 ),
			'unit'   => 'px',
			'locked' => true,
		),
			// Footer.
			'footer_middle_link_style' => 'noline',
				'footer_items'       => array(
					'top' => array(
						'top_1' => array(),
						'top_2' => array(),
						'top_3' => array(),
						'top_4' => array(),
						'top_5' => array(),
					),
					'middle' => array(
						'middle_1' => array('footer-widget1','footer-social'),
						'middle_2' => array('footer-widget2'),
						'middle_3' => array('footer-widget3'),
						'middle_4' => array('footer-widget6'),
						'middle_5' => array(),
					),
					'bottom' => array(
						'bottom_1' => array( 'footer-html' ),
						'bottom_2' => array(),
						'bottom_3' => array(),
						'bottom_4' => array(),
						'bottom_5' => array(),
					),
				),
			'footer_middle_widget_title'  => array(
						'size' => array(
							'desktop' => '',
						),
						'lineHeight' => array(
							'desktop' => '',
						),
						'family'  => 'inherit',
						'google'  => false,
						'weight'  => '',
						'variant' => '',
						'color'   => 'palette9',
					),
			'footer_middle_collapse' => 'normal',
					'footer_middle_columns' => '4',
					'footer_middle_layout'  => array(
						'mobile'  => 'row',
						'tablet'  => '',
						'desktop' => 'left-forty',
					),
					'footer_middle_direction'         => array(
						'mobile'  => '',
						'tablet'  => '',
						'desktop' => 'column',
					),
					'footer_middle_link_colors' => array(
						'color' => 'palette6',
						'hover' => 'palette2',
					),
					'footer_middle_widget_content' => array(
						'size' => array(
							'desktop' => '',
						),
						'lineHeight' => array(
							'desktop' => '',
						),
						'family'  => 'inherit',
						'google'  => false,
						'weight'  => '',
						'variant' => '',
						'color'   => 'palette6',
					),
					'footer_middle_column_spacing' => array(
						'size' => array(
							'mobile'  => '20',
							'tablet'  => '20',
							'desktop' => '60',
						),
						'unit' => array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
					),
			'footer_wrap_background' => array(
				'desktop' => array(
					'color' => 'palette3',
				),
				'footer_top_widget_spacing' => array(
					'size' => array(
						'mobile'  => '10',
						'tablet'  => '20',
						'desktop' => '30',
					),
					'unit' => array(
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					),
				),
			),
			// Footer Middle.
			'footer_middle_height' => array(
				'size' => array(
					'mobile'  => '',
					'tablet'  => '',
					'desktop' => '',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			// Footer HTML.
				'footer_html_content'    => ' {copyright} {year} All Rights Reserved. Developed By CoderPlace',
			'footer_middle_top_spacing' => array(
				'size' => array(
					'mobile'  => '40',
					'tablet'  => '40',
					'desktop' => '120',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'footer_middle_bottom_spacing' => array(
				'size' => array(
					'mobile'  => '40',
					'tablet'  => '40',
					'desktop' => '130',
				),
				'unit' => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
			),
			'footer_social_style'=> 'outline',
			'footer_social_items' => array(
				'items' => array(
					array(
						'id'      => 'facebook',
						'enabled' => true,
						'source'  => 'icon',
						'url'     => '',
						'imageid' => '',
						'width'   => 24,
						'icon'    => 'facebookAlt2',
						'label'   => 'Facebook',
					),
					array(
						'id'      => 'twitter',
						'enabled' => true,
						'source'  => 'icon',
						'url'     => '',
						'imageid' => '',
						'width'   => 24,
						'icon'    => 'twitter',
						'label'   => 'Twitter',
					),
					array(
						'id'      => 'instagram',
						'enabled' => true,
						'source'  => 'icon',
						'url'     => '',
						'imageid' => '',
						'width'   => 24,
						'icon'    => 'instagramAlt',
						'label'   => 'Instagram',
					),
				),
			),
			
			'footer_bottom_top_border'    => array(
				'desktop' => array(
					'width' => 1,
					'unit'  => 'px',
					'style' => 'solid',
					'color'  => '#2b2b4f',
			),
			
			'footer_social_icon_size' => array(
				'size' => 1,
				'unit' => 'em',
			),
			'footer_social_background' => array(
				'color' => 'transparent',
				'hover' => '',
			),
			'footer_social_border_radius' => array(
				'size' => 0,
				'unit' => 'px',
			),
			'footer_social_margin' => array(
				'size'   => array( '20', '', '30', '' ),
				'unit'   => 'px',
				'locked' => false,
			),	
			),
			'post_archive_layout'               => 'normal',
			'post_archive_columns'              => '3',

			'product_archive_title_elements'      => array( 'title', 'breadcrumb', 'description' ),
			'product_archive_title_element_breadcrumb' => array(
				'enabled' => true,
				'show_title' => true,
			),
			'product_archive_layout'             => 'left',
			'product_archive_content_style'      => 'unboxed',
			'product_archive_sidebar_id'         => 'sidebar-secondary',
			'sidebar_widget_title' => array(
				'size' => array(
					'desktop' => 25,
				),
				'lineHeight' => array(
					'desktop' => 1.5,
				),
				'family'  => 'inherit',
				'google'  => false,
				'weight'  => '800',
				'variant' => '800',
				'color'   => 'palette3',
				'transform' => 'capitalize',
			),
			'post_archive_title_background'   => array(
				'desktop' => array(
				'type' => 'image',
				'image' => array(
				'url' => get_stylesheet_directory_uri() .'/assets/images/breadcrumb.jpg',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attachment' => 'scroll',
				),
				),
			),
			'post_archive_title_color' => array(
				'color' => 'palette9',
			),
			'post_archive_title_breadcrumb_color' => array(
				'color' => 'palette9',
				'hover' => 'palette2'
			),
			'post_archive_title_elements'      => array( 'title','breadcrumb', 'description' ),
			'post_archive_title_element_title' => array(
				'enabled' => true,
			),
			'post_archive_title_element_breadcrumb' => array(
				'enabled' => true,
				'show_title' => true,
			),
			
			// Sidebar.
			'sidebar_width'   => array(
				'size' => '22',
				'unit' => '%',
			),
			'sidebar_link_style' => 'plain',
			'sidebar_padding'        => array(
				'size'   => array( 
					'desktop' => array( '', '1.5', '1.5', '1.5' ),
					'tablet' =>array('','','',''),
					'mobile' =>array('','','',''),

				),
				'unit'   => array(
					'desktop' => 'em',
				),
				'locked' => array(
					'desktop' => false,
				),
			),
			// Product Controls.
			'custom_quantity'                => true,


		);
		$defaults = array_merge(
			$defaults,
			$update_options
		);
		return $defaults;
		
	}

	public function add_addon_option_defaults( $defaults ) {
		$addon_update_options = array(
				// Header Contact.
				'header_contact_items' => array(
					'items' => array(
						array(
							'id'      => 'location',
							'enabled' => true,
							'source'  => 'icon',
							'url'     => '',
							'imageid' => '',
							'width'   => 20,
							'link'     => '',
							'icon'    => 'location',
							'label'   => '670 Lafayette Ave, Brooklyn, NY 11216',
						),
						array(
						'id'      => 'phone',
						'enabled' => true,
						'source'  => 'icon',
						'url'     => '',
						'imageid' => '',
						'width'   => 24,
						'link'     => '',
						'icon'    => 'phoneAlt2',
						'label'   => '444-546-8765',
					    ),								
						array(
							'id'      => 'hours',
							'enabled' => true,
							'source'  => 'icon',
							'url'     => '',
							'imageid' => '',
							'width'   => 24,
							'link'     => '',
							'icon'    => 'hours',
							'label'   => 'Everyday 24 Hours',
						),				
					),
				),
			'header_contact_item_spacing'=> array(
				'size' => 1.2,
				'unit' => 'em',
			),
			'header_contact_icon_size' => array(
				'size' => 1,
				'unit' => 'em',
			),
			'header_contact_color' => array(
				'color'  => 'palette9',
			),
			'header_contact_icon_color' => array(
				'color'  => 'palette2',
				'hover' => 'palette2',
			),
		);
		$defaults = array_merge(
		$defaults,
		$addon_update_options
		);
		return $defaults;
		}
		

}

Custom_Theme::get_instance();