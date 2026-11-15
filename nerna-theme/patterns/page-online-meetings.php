<?php
/**
 * Title: Full page: Online Meetings
 * Slug: nerna/page-online-meetings
 * Categories: nerna-pages
 * Block Types: core/post-content
 * Post Types: page
 * Viewport Width: 1400
 */
?>
<!-- wp:group {"align":"full","className":"is-style-nerna-basic-text nerna-short","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-nerna-basic-text nerna-short"><!-- wp:group {"className":"nerna-inner","layout":{"type":"default"}} -->
<div class="wp-block-group nerna-inner"><!-- wp:paragraph {"className":"is-style-nerna-eyebrow"} -->
<p class="is-style-nerna-eyebrow">Meetings</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Online <span class="nerna-outline">meetings</span></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-nerna-lead"} -->
<p class="is-style-nerna-lead">Join an NA meeting by video or phone from anywhere. Choose meetings in our region, or online meetings from all over the world.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- wp:group {"className":"nerna-section","layout":{"type":"default"}} -->
<div class="wp-block-group nerna-section"><!-- wp:buttons {"className":"nerna-toggle","anchor":"meetings-list"} -->
<div class="wp-block-buttons nerna-toggle" id="meetings-list"><!-- wp:button {"className":"nerna-toggle-region"} -->
<div class="wp-block-button nerna-toggle-region"><a class="wp-block-button__link wp-element-button" href="?view=region#meetings-list">In our region</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"nerna-toggle-worldwide"} -->
<div class="wp-block-button nerna-toggle-worldwide"><a class="wp-block-button__link wp-element-button" href="?view=worldwide#meetings-list">Worldwide</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- wp:group {"className":"nerna-view-region nerna-view-default","layout":{"type":"default"}} -->
<div class="wp-block-group nerna-view-region nerna-view-default"><!-- wp:heading -->
<h2 class="wp-block-heading">Online meetings in our region</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Online and hybrid meetings in Massachusetts and Rhode Island.</p>
<!-- /wp:paragraph -->
<!-- wp:shortcode -->
[bmlt_tabs root_server="https://nerna.org/main_server" include_city_button="0" has_zip_codes="0" has_cities="0" has_locations="0" custom_query="&formats%5B%5D=50&formats%5B%5D=55&formats_comparison_operator=OR&services=1&recursive=1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
<!-- wp:group {"className":"nerna-view-worldwide","layout":{"type":"default"}} -->
<div class="wp-block-group nerna-view-worldwide"><!-- wp:heading -->
<h2 class="wp-block-heading">Online NA meetings worldwide</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Meetings are always shown in your own time zone.</p>
<!-- /wp:paragraph -->
<!-- wp:shortcode -->
[bmlt_tabs root_server="https://bmlt.virtual-na.org/main_server/" include_city_button="0" service_body_parent="4" has_zip_codes="0" has_cities="0" has_locations="0" has_languages="1" custom_query="&formats=47" has_areas="0" base_tz="UTC" auto_tz_adjust="true"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
<!-- wp:paragraph {"className":"is-style-nerna-arrow"} -->
<p class="is-style-nerna-arrow"><a href="/meetings/">All meetings in the region, in person and online</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
