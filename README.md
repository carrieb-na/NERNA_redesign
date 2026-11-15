# NERNA website redesign

A new WordPress theme for **nerna.org**, the website of the New England Region of Narcotics Anonymous.

## See the demo

**[Open the demo site](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/carrieb-na/NERNA_redesign/main/blueprint.json)**

The link builds a complete WordPress site in your web browser, using WordPress Playground (official WordPress software). It takes about a minute to load the first time. Nothing is installed on your computer, nothing touches nerna.org, and each person who opens the link gets their own private copy to click around in. You're logged in as an administrator, so you can also open any page in the editor to see how volunteers would update it.

The demo always uses the newest version of the theme in this repository.

## The design

Each part of the site borrows the look of an NA book, with the NA symbols where they appear on the covers:

| Book | Used for |
| --- | --- |
| Basic Text | Home, Meetings, Professionals, Contact, Forms, Contribute: royal blue, a white rule with the NA logo sitting on it, bold and outlined lettering |
| Living Clean | New to NA: sky-blue ribbons with orange and gold streaks, "welcome" in many languages |
| Spiritual Principle a Day | Events: cream paper, a mid-century burst with the NA logo at its center |
| Guiding Principles | Service: overlapping teal and green circles with the service symbol |
| It Works: How and Why | Areas and Recovery Resources: ochre band over forest green, gold lettering, the NA logo on the band |

Events, minutes, motions, area concerns and "last checked" dates marked **SAMPLE** are placeholders.

## How volunteers update it

No code is needed for everyday changes. In the WordPress editor:

- **Page header looks** are styles on the Group block: select a header and choose *Header: Basic Text*, *Header: Living Clean* and so on in the sidebar. Ready-made headers are also in the inserter under **NERNA: Page headers**.
- **Cards** (area cards, event cards, info boxes) are Group block styles too, and ready-made ones are under **NERNA: Cards and sections**.
- **Special lettering** (outlined, script, light, teal) is a button in the text toolbar.
- **New pages** can start from any of the full-page layouts under **NERNA: Full pages**.

## What's in this repository

- `nerna-theme/`: the WordPress theme. This folder is what gets installed on nerna.org.
  - `assets/img/`: the region logo, NA logo and service symbol in each book's colors, and the cover-style artwork
  - `patterns/`: full-page layouts, page headers and cards
  - `templates/`, `parts/`: page templates, header and footer
  - `demo/setup.php`: builds the demo pages; only runs from the demo link
- `blueprint.json`: tells WordPress Playground how to build the demo

## Still to do before going live

- Meeting search: confirm the crouton settings for the NERNA meeting server (the demo points it at `https://nerna.org/main_server`)
- Events: connect the events plugin
- Forms and contributions: choose a form tool and connect the region's payment page (the demo forms don't send anything)
- Self-host the web fonts instead of loading them from Google
- Region logo: a larger PNG or an SVG would look sharper on high-resolution screens
- Move content from the current site and point old links to their new pages

Narcotics Anonymous® and the NA logos are registered trademarks of Narcotics Anonymous World Services, Inc.
