=== A3H Pono Rez Reservation Interface for WordPress ===
Contributors: arnesonium
Tags: a3h, vacation, pono rez, rentals, reservations, booking calendar, booking, booking plugin, reservation calendar, booking system
Requires at least: 4.0
Tested up to: 4.4.1
Stable tag: v1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add A3H Pono Rez interfaces, reservations, and tours to your WordPress site.

== Description ==

[Pono Rez](http://ponorez.com/) is a web based Central Reservation System (CRS) targeting
Tours & Attractions. The system comes equipped with a slick Ecommerce
solution, customization tools and API messaging. In addition to the
scheduling of Tours, Retail Store, Gift Certificates & Transportation
are standard modules. The system complies with Payment Card Industry
data security standards & credit card standards.

This plugin allows Pono Rez users to integrate information about
activities into their WordPress websites using templates and
shortcodes. It requires an active Pono Rez account to use properly.

The Pono Rez system provides a SOAP interface, which is hosted on
https://www.hawaiifun.org/. The interface is documented on the Pono
Rez website at
http://www.ponorez.com/Agency%20Service%20Specifications.pdf. 

== Installation ==

To install this plugin, follow these directions:

1. Download the latest zip file.
1. Next, load up your WordPress blog’s dashboard, and go to **Plugins > Add New**.
1. Upload the zip file.
1. Click **Activate**.
1. Go to the **A3H Pono Rez for WordPress** admin panel.
1. Enter your Pono Rez username and password.
1. Click **Save Changes**.

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==
= 1.1 =
* Provide more information about SOAP service hosting.
* Include all JavaScript, CSS, and image files in the plugin.
* Use WordPress transients to cache activity templates.

= 1.0 =
* First public release.

= 0.1 =
* Development pre-release.

== Upgrade Notice ==

== Usage ==

Templates should be added to the `templates` subdirectory in this
plugin. They can contain shortcodes.

These two shortcodes load an activity from the Pono Rez database.

* **\[pr_activity id=XXX\]** - Load activity id XXX and use it to fill out the default template.
* **\[pr_load_activity id=XXX\]** - Used to load activity XXX without filling out and using a template.

These shortcodes are used to request specific attributes for the
currently loaded activity.

* **\[pr_activity_name\]**
* **\[pr_activity_description\]**
* **\[pr_datepicker\]**
* **\[pr_guest_type_list\]**
* **\[pr_guest_type\]**
* **\[pr_hotel_select\]**
* **\[pr_hotel_room\]**
* **\[pr_check_availability\]** - Print out the "Check Availability" button.



