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
		'submit-an-event'    => array( 'Submit an Event', 'page-submit-an-event' ),
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

	nerna_demo_events();

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	flush_rewrite_rules();
}

/**
 * Mayo Events Manager: point it at the NERNA meeting server and add sample
 * events. Dates are counted from the day the demo is opened, so they are
 * always upcoming.
 */
function nerna_demo_events() {
	if ( ! post_type_exists( 'mayo_event' ) ) {
		return;
	}
	$settings                     = get_option( 'mayo_settings', array() );
	$settings['bmlt_root_server'] = 'https://nerna.org/main_server';
	update_option( 'mayo_settings', $settings );

	// Clear earlier demo events so a re-run doesn't double them.
	foreach ( get_posts( array( 'post_type' => 'mayo_event', 'post_status' => 'any', 'numberposts' => -1, 'meta_key' => '_nerna_demo', 'fields' => 'ids' ) ) as $old ) {
		wp_delete_post( $old, true );
	}

	// days ahead, title, type, service body id, start, end, place, address, description
	$events = array(
		array( 6, 'Gratitude Speaker Jam', 'Activity', '4', '13:00:00', '17:00:00', 'Greendale People\'s Church', '25 Francis St, Worcester, MA', 'Speakers sharing their experience, strength and hope. Food and fellowship.' ),
		array( 11, 'Thanksgiving Marathon Meeting', 'Celebration', '1', '08:00:00', '22:00:00', 'Online and in person', 'Zoom details on the flyer', 'Meetings all day long. Drop in any time.' ),
		array( 20, 'South Shore Area Service Committee', 'Service', '14', '14:30:00', '16:30:00', 'First Congregational Church', '639 High St, Hanson, MA', 'Monthly area service meeting. GSRs and anyone interested in service are welcome.' ),
		array( 27, 'Regional Weekend: Subcommittees', 'Service', '1', '11:00:00', '15:00:00', 'Host area to be announced', '', 'H&I, PR, Policy, Website and other regional subcommittees meet.' ),
		array( 28, 'Regional Service Committee', 'Service', '1', '12:00:00', '17:00:00', 'Host area to be announced', '', 'The full New England Regional Service Committee. Zoom available.' ),
		array( 46, 'New Year\'s Eve Dance', 'Celebration', '6', '20:00:00', '23:59:00', 'Beneficent Congregational Church', '300 Weybosset St, Providence, RI', 'Ring in the new year clean. DJ, food and fellowship.' ),
		array( 62, 'Service Learning Day', 'Service', '1', '10:00:00', '15:00:00', 'Location to be announced', '', 'Workshops on GSR basics, H&I, PR and the Twelve Concepts.' ),
		array( 70, 'CAR Workshop', 'Service', '1', '13:00:00', '16:00:00', 'Online', 'Zoom details on the flyer', 'Go through the Conference Agenda Report together before group conscience.' ),
	);
	$tz = 'America/New_York';
	foreach ( $events as $e ) {
		$date = wp_date( 'Y-m-d', strtotime( '+' . $e[0] . ' days' ), new DateTimeZone( $tz ) );
		wp_insert_post(
			array(
				'post_type'    => 'mayo_event',
				'post_status'  => 'publish',
				'post_title'   => $e[1],
				'post_content' => $e[8],
				'meta_input'   => array(
					'event_type'       => $e[2],
					'service_body'     => $e[3],
					'event_start_date' => $date,
					'event_end_date'   => $date,
					'event_start_time' => $e[4],
					'event_end_time'   => $e[5],
					'timezone'         => $tz,
					'location_name'    => $e[6],
					'location_address' => $e[7],
					'_nerna_demo'      => '1',
				),
			)
		);
	}
}
