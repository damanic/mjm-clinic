=== MJM Clinic ===
Contributors: damanic
Donate link: http://mjman.net
Tags: clinic, therapy, services, listings, health, conditions
Requires at least: 4.0
Tested up to: 4.0
Stable tag: 1.0.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A tool for clinic health care websites to present their services with relations
to common health conditions, health indications/symptoms and related products.

== Description ==

The MJM Clinic plugin allows you to

* Create numerous Clinic/Service locations, with contact details, address and map info.
* Create hierarchical service categories
* Create Service/Therapy listings, assign them to one or more locations, one or more categories and one or more indication/symptom tags.
* Create Patient feedback entries and assign them to a service and/or health condition.
* Create Case Studies and assign them to a health condition and/or service.
* Create related products that can be displayed on various pages through tag or direct relation. These products can be set up to link to an online shop.
* Create Indication and Contraindication tags to link services, conditions, patient feedback, case studies, products etc.
* Set up a service/advice disclaimer.
* Enable/Disable combinations of the above features.
* Enable/Disable comments on your listings.


Numerous sidebar widgets have been included to help show off your services, health conditions info, clinic locations etc.

There are a number of helper functions that can be used in your theme, which are found in `inc/func.php` and Theme developers can customize the way the listings display, by creating the following files in their theme:

* `single-mjm-clinic-condition.php`
* `single-mjm-clinic-casestudy.php`
* `single-mjm-clinic-feedback.php`
* `single-mjm-clinic-service.php`
* `taxonomy-mjm_clinic_service_category.php`
* `taxonomy-mjm_clinic_indication.php`
* `taxonomy-mjm_clinic_contraindication.php`

All widget generated output includes an abundance of css classes and id's all of which use plug-in prefixes to prevent conflicts with any theme.

The front end widgets include markers for the [fontawesome icon font](http://fontawesome.com). To enable these icons add fontawesome to your theme, or enable the demo CSS in the plugin settings.

The helper functions and widgets will also make use of taxonomy images if you have the taxonomy-images plugin installed.


= About this plugin =

This plugin was created for clinics to promote services and products in a way that inter-relates with information on health conditions and symptoms.

== Shortcodes & Shortcode Parameters ==

Work in progress `[mjm-clinic-service]`

== Installation ==

1. Upload `mjm-clinic.zip` to the `/wp-content/plugins/` directory or use the built-in plugin installer on the WordPress Plugin Dashboard page.
3. Activate the plugin through the 'Plugins' menu in WordPress
3. Have a look at the plugin settings, thats it!
4. Optional: Install the taxonomy-images plugin if you would like images for any of your categories/taxonomies.

== Frequently Asked Questions ==

[Ask some]

== Screenshots ==

1. Description


== Upgrade Notice ==
None

== Changelog ==

= 1.0.1 =
* initial release