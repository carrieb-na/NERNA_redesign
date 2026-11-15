<?php
/**
 * NERNA theme setup.
 *
 * Everything a volunteer needs is chosen in the editor:
 * - Page header looks are "styles" on the Group block (Basic Text, Living Clean, ...).
 * - Card looks are styles on the Group block too.
 * - Outline, script and light lettering are buttons in the text toolbar.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NERNA_VERSION', '0.1.0' );

/** Google Fonts used by the book looks. (Can be self-hosted later.) */
function nerna_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&family=Lora:ital,wght@0,500;0,600;1,500&family=Marcellus+SC&family=Oswald:wght@500;600&family=Parisienne&display=swap';
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'editor-styles' );
	add_editor_style( array( nerna_fonts_url(), 'assets/css/nerna.css' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'nerna-fonts', nerna_fonts_url(), array(), null );
	wp_enqueue_style( 'nerna', get_theme_file_uri( 'assets/css/nerna.css' ), array(), NERNA_VERSION );
} );

/** Text toolbar buttons: Outline, Script, Light, Sample tag. */
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_script(
		'nerna-formats',
		get_theme_file_uri( 'assets/js/formats.js' ),
		array( 'wp-rich-text', 'wp-block-editor', 'wp-element', 'wp-i18n' ),
		NERNA_VERSION,
		true
	);
} );

/** Pattern category so all NERNA layouts are together in the inserter. */
add_action( 'init', function () {
	register_block_pattern_category( 'nerna-headers', array( 'label' => __( 'NERNA: Page headers', 'nerna' ) ) );
	register_block_pattern_category( 'nerna-pages', array( 'label' => __( 'NERNA: Full pages', 'nerna' ) ) );
	register_block_pattern_category( 'nerna-parts', array( 'label' => __( 'NERNA: Cards and sections', 'nerna' ) ) );
} );

/** Block styles volunteers pick from the sidebar. */
add_action( 'init', function () {
	$group_styles = array(
		'nerna-basic-text'   => 'Header: Basic Text (blue)',
		'nerna-living-clean' => 'Header: Living Clean (sky blue)',
		'nerna-spiritual'    => 'Header: Spiritual Principle a Day (cream)',
		'nerna-guiding'      => 'Header: Guiding Principles (teal)',
		'nerna-it-works'     => 'Header: It Works (green and gold)',
		'nerna-card'         => 'Card',
		'nerna-card-blue'    => 'Card: blue top',
		'nerna-card-gold'    => 'Card: It Works',
		'nerna-card-teal'    => 'Card: Guiding Principles',
		'nerna-card-cream'   => 'Card: Spiritual Principle',
		'nerna-door-lc'      => 'Big link: Living Clean',
		'nerna-door-iw'      => 'Big link: It Works',
		'nerna-door-gp'      => 'Big link: Guiding Principles',
		'nerna-paper'        => 'Section: cream paper',
		'nerna-callout'      => 'Callout box',
		'nerna-event'        => 'Event',
	);
	foreach ( $group_styles as $name => $label ) {
		register_block_style( 'core/group', array( 'name' => $name, 'label' => $label ) );
	}
	$p_styles = array(
		'nerna-eyebrow' => 'Small label',
		'nerna-lead'    => 'Intro text',
		'nerna-date'    => 'Date badge',
		'nerna-note'    => 'Note',
		'nerna-arrow'   => 'Arrow link',
	);
	foreach ( $p_styles as $name => $label ) {
		register_block_style( 'core/paragraph', array( 'name' => $name, 'label' => $label ) );
	}
	register_block_style( 'core/heading', array( 'name' => 'nerna-subtitle', 'label' => 'Subtitle (italic)' ) );
} );

/** Allow the theme's image folder to be used in pattern markup. */
function nerna_img( $file ) {
	return esc_url( get_theme_file_uri( 'assets/img/' . $file ) );
}

/**
 * Switchable views on one page (used by Online Meetings: "In our region" / "Worldwide").
 *
 * How it works for editors:
 * - Put each view in a Group block and give it the extra CSS class "nerna-view-NAME"
 *   (add "nerna-view-default" to the one shown first).
 * - Add buttons with the class "nerna-toggle-NAME" linking to "?view=NAME".
 * Only the chosen view is built, so two meeting lists never load on the same page.
 */
function nerna_current_view() {
	return isset( $_GET['view'] ) ? sanitize_key( wp_unslash( $_GET['view'] ) ) : '';
}

add_filter( 'pre_render_block', function ( $pre, $block ) {
	$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( ! preg_match( '/\bnerna-view-(?!default\b)([a-z0-9-]+)/', $class, $m ) ) {
		return $pre;
	}
	$view       = nerna_current_view();
	$is_default = (bool) preg_match( '/\bnerna-view-default\b/', $class );
	$show       = '' === $view ? $is_default : ( $view === $m[1] );
	return $show ? $pre : '';
}, 10, 2 );

add_filter( 'render_block', function ( $content, $block ) {
	$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( 'core/button' !== $block['blockName'] || ! preg_match( '/\bnerna-toggle-([a-z0-9-]+)/', $class, $m ) ) {
		return $content;
	}
	$view = nerna_current_view();
	if ( '' === $view ) {
		$view = 'region';
	}
	if ( $view === $m[1] ) {
		$content = preg_replace( '/class="wp-block-button /', 'class="wp-block-button is-active ', $content, 1 );
		$content = str_replace( '<a class="wp-block-button__link', '<a aria-current="true" class="wp-block-button__link', $content );
	}
	return $content;
}, 10, 2 );
