<?php
/**
 * Demo content for WordPress Playground.
 *
 * Creates the site's pages from the theme's full-page patterns, sets the
 * home page and pretty links. Only runs when the Playground blueprint calls
 * nerna_demo_setup(); it never runs on a live site by itself.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nerna_demo_setup() {
	// Keep the demo forms' HTML exactly as written.
	kses_remove_filters();

	update_option( 'blogname', 'New England Region of Narcotics Anonymous' );
	update_option( 'blogdescription', 'Narcotics Anonymous in most of Massachusetts, Rhode Island, Martha\'s Vineyard and Nantucket' );
	update_option( 'permalink_structure', '/%postname%/' );

	// Remove WordPress's sample content.
	foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
		$p = get_page_by_path( $slug, OBJECT, $type );
		if ( $p ) {
			wp_delete_post( $p->ID, true );
		}
	}

	$pages = array(
		'home'               => array( 'Home', 'page-home' ),
		'meetings'           => array( 'Meetings', 'page-meetings' ),
		'online-meetings'    => array( 'Online Meetings', 'page-online-meetings' ),
		'new-to-na'          => array( 'New to NA', 'page-new-to-na' ),
		'events'             => array( 'Events', 'page-events' ),
		'areas'              => array( 'Areas', 'page-areas' ),
		'service'            => array( 'Service', 'page-service' ),
		'professionals'      => array( 'Professionals', 'page-professionals' ),
		'recovery-resources' => array( 'Recovery Resources', 'page-recovery' ),
		'contribute'         => array( 'Contribute', 'page-contribute' ),
		'forms'              => array( 'Forms', 'page-forms' ),
		'contact'            => array( 'Contact', 'page-contact' ),
	);

	$registry = WP_Block_Patterns_Registry::get_instance();
	$home_id  = 0;
	foreach ( $pages as $slug => $info ) {
		$pattern = $registry->get_registered( 'nerna/' . $info[1] );
		$content = $pattern ? $pattern['content'] : '';
		$existing = get_page_by_path( $slug );
		$args = array(
			'post_title'   => $info[0],
			'post_name'    => $slug,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_content' => $content,
		);
		if ( $existing ) {
			$args['ID'] = $existing->ID;
			$id = wp_update_post( wp_slash( $args ) );
		} else {
			$id = wp_insert_post( wp_slash( $args ) );
		}
		if ( 'home' === $slug ) {
			$home_id = $id;
		}
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	flush_rewrite_rules();
}
