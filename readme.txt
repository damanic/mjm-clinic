=== MJM Clinic ===
Contributors: damanic
Donate link: http://mjman.net
Tags: clinic, cms, therapy, services, listings, health, conditions
Requires at least: 4.0
Tested up to: 5.2
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A handy plugin to help promote health clinics and services using Wordpress CMS.

== Description ==
For health clinic and related websites, this plugin extends the WordPress CMS to allow for the addition of many clinic related features including service pages with booking forms, related health conditions, clinic locations, staff/doctor pages, client feedback and more.

= The MJM Clinic plugin allows you to =

* Create numerous Clinic/Service locations, with their own contact details/forms, address, maps.
* Booking Forms are easily added for any service/location using shortcodes and widgets.
* Organise your services in hierarchical categories
* Create Service/Therapy listings, assign them to one or more locations, one or more categories and one or more indication/symptom tags.
* Create Staff Member pages for Doctors and Therapists.
* Relate Doctors/Therapist with Services
* Create Patient feedback entries and assign them to a service and/or health condition.
* Create Case Studies and assign them to a health condition and/or service.
* Create Indication tags to link services, conditions, patient feedback, case studies, products etc.
* Enable/Disable combinations of the above features.
* Enable/Disable comments on your service listings.

= In the pipeline =
* More shortcodes, functions and widgets to facilitate data access.
* Related products that can be displayed on various pages through tags or direct relation. Products can be set up to link to an online shop.
* Contraindication Tags
* Official Parent Theme

= Front end control of design =
* All shortcode/widget output has been given a thoughtful set of classes and id's to allow you to fully control and customise the design.
* CSS/JS/HTML can easily be overridden by creating a folder in your theme: {YOUR-THEME-DIR}/mjm-clinic/.


= Spam protection =
All contact forms added by this plugin work with the Askismet WordPress plugin to protect from spam.


= Widgets =
Numerous sidebar widgets have been included to help show off your services, health conditions info, clinic locations etc.

* Assigned Case Studies - can be assigned to feature on a specific service or a health condition page
* Assigned Condition - Health conditions can be assigned to feature on any number of specified service listings
* Assigned Patient Feedback - can be assigned to feature on a specific service or a health condition page
* Assigned Services - Displays a list of services that were specifically assigned to a health condition, patient feedback or case study
* Clinic Locations - Displays clinic locations where a service/therapy is available
    * TO OVERRIDE THE HTML copy {MJM-CLINIC-PLUGIN-DIR}/views/templates/widget-service-locations.php to {YOUR-THEME-DIR}/mjm-clinic/
* Indication Tags - Displays a list of indication tags for service, condition, feedback and case study single posts
* Location Map - Displays a map on a location taxonomy page
* Related Casestudy - Displays casestudy on single tax and post pages that share indications
* Related Feedback - Displays feedback on single tax and post pages that share indications
* Related Health Conditions - Displays conditions on single tax and post pages that share indications
* Related Services - Displays services on single tax and post pages that share indications
* Service Categories - A list or dropdown menu of clinic service categories.
* Service Session Info - Displays a services session info, price
    * TO OVERRIDE THE HTML copy {MJM-CLINIC-PLUGIN-DIR}/views/templates/widget-service-session-info.php to {YOUR-THEME-DIR}/mjm-clinic/
* Shared Symptoms - Displays other conditions that share symptoms (indication tags)
* Conditions List/Menu - Displays links to conditions



= Shortcodes =

`[mjm-clinic-booking-form]`
Output an ajax form, can have more than one per page without conflicts.
Optional attributes = ['service', 'location', 'no_service_select', 'no_location_select']

Example Usage:
[mjm-clinic-booking-form service='cold-flu' location='my-clinic' no_service_select=1 no_location_select=1]
The above will generate a form for the given service and location (slugs), and hide/disable the options for the user to select/change the service or location.

Without any attributes the form will show drop downs for location and services, and detects the most relevent
form state for the page.

`[mjm-clinic-location-map]`
Outputs a google map for a given location.
Optional attributes = ['location', 'id', 'height', 'width']

- 'location' can be a clinic location id or slug.
- 'id' can be set to a unique value if you ever find conflicts with other maps on the same page.
- 'height' for map display, eg. 200px or 50%
- 'width' for map display, eg. 200px or 50%

`[mjm-clinic-condition-list]`
Outputs a searchable list of conditions
Attribute values:

*  - searchable_title : 1 or 0 (default: 1)
*  - searchable_excerpt: 1 or 0 (default: 0)
*  - searchable_tags: 1 of 0 (default: 1)
*  - show_excerpt:  1 or 0 (default: 1)
*  - show_indication_tags:  1 or 0 (default: 1)
*  - show_image: 1 or 0 (default: 0)
*  - paginate: integer (default: 200) , amount of conditions to show per page. 0 = no pagination


`[mjm-clinic-service-box-links]`
Outputs a presentation of categories and services. Use this on your services page.
Attribute values:
     *  - category : slug or term_ID , optional parent , if none given the top level category/services will be shown.

`[mjm-clinic-disclaimer]`
Outputs the disclaimer text, editable in the settings admin area. Uses overidable template 'shortcode-disclaimer
.php'

`[mjm-clinic-staff]`
Outputs a list of staff (doctors, therapists etc).
Optional attribute values:

* - staff_types: one or more id/slug for staff type taxonomy. Separated by commas if more than one.
* - locations: one or more id/slug for clinic location. Separated by commas if more than one.
* - services: one or more id/slug for service. Separated by commas if more than one.

Example usage [mjm-clinic-staff staff_types="'doctor',241" locations="matts-house,15" services="detox-programme,2745"]
The above will output all staff of either specified staff_type who work at any of the two specified locations and who provide either of the two services specified.
Without any attributes, all staff will be output.

= Helper Functions =
There are a number of helper functions that can be used in your theme, which are found in `inc/func.php`.


= Theme Integration =
All plugin generated output includes an abundance of css classes and id's all of which use mjm-clinic prefixes to prevent conflicts with any other plugins or themes.
MJM Clinic works out of the box, but theme developers can easily over-ride the default presentation styles and templates.

TO OVERRIDE THE DEFAULT CSS
Copy the following files from {MJM-CLINIC-PLUGIN-DIR}/css/ to {YOUR-THEME-DIR}/mjm-clinic/ . Customise away.

* `public.css`

TO OVERRIDE THE BOOKING FORM JS
Copy the following files from {MJM-CLINIC-PLUGIN-DIR}/js/ to {YOUR-THEME-DIR}/mjm-clinic/ . Customise away.

* `booking_form.js`

TO OVERRIDE THE BOOKING FORM HTML
Copy the following files from {MJM-CLINIC-PLUGIN-DIR}/views/templates/ to {YOUR-THEME-DIR}/mjm-clinic/ . Customise away.

* `shortcode-booking-form.php`

TO OVERRIDE THE [mjm-clinic-service-box-links] HTML
Copy the following files from {MJM-CLINIC-PLUGIN-DIR}/views/templates/ to {YOUR-THEME-DIR}/mjm-clinic/ . Customise away.

* `shortcode-boxlinks-service.php`
* `shortcode-boxlinks-service-category.php`

TO OVERRIDE THE [mjm-clinic-condition-list] SEARCHABLE CONDITIONS HTML
Copy the following files from {MJM-CLINIC-PLUGIN-DIR}/views/templates/ to {YOUR-THEME-DIR}/mjm-clinic/ . Customise away.

* `shortcode-condition-list.php`

TO OVERRIDE THE [mjm-clinic-staff] HTML
Copy the following files from {MJM-CLINIC-PLUGIN-DIR}/views/templates/ to {YOUR-THEME-DIR}/mjm-clinic/ . Customise away.

* `shortcode-staff-list.php`


TO CUSTOMIZE THE CATEGORY PAGES
Copy the following files from {MJM-CLINIC-PLUGIN-DIR}/views/templates/ and place them in the root of your theme folder. Customise away.

* `taxonomy-mjm_clinic_service_category.php`
* `taxonomy-mjm_clinic_location.php`
* `taxonomy-mjm_clinic_indication.php`

TO CREATE YOUR OWN SERVICE, CONDITION, FEEDBACK AND CASE STUDY TEMPLATES
Create the following files in your themes root directory. Use your themes single.php as reference for setting up a single post template.

* `single-mjm_clinic_service.php`
* `single-mjm_clinic_condition.php`
* `single-mjm_clinic_feedback.php`
* `single-mjm_clinic_casestudy.php`



= About this plugin =
This plugin was created for clinics to promote services and products in a way that inter-relates with information on health conditions and symptoms.



== Installation ==

1. Upload `mjm-clinic.zip` to the `/wp-content/plugins/` directory or use the built-in plugin installer on the WordPress Plugin Dashboard page.
3. Activate the plugin through the 'Plugins' menu in WordPress
3. Have a look at the plugin settings, thats it!
4. Optional: Install the taxonomy-images plugin if you would like images for any of your categories/taxonomies.

== Frequently Asked Questions ==

[Ask some]

== Screenshots ==

1. Admin View
2. TwentyFourteen Clean Install, widgets only.
3. Form Validation and date selection
4. Location Page
5. Searchable Health Conditions
6. Default service box output

== Upgrade Notice ==
None

== Changelog ==

= 1.0.1 =
* initial release

= 1.0.2 =
* updated readme.txt

= 1.0.3 =
* small bugfix with single templates look up.

= 1.0.4 =
* fixed issue where some queries using get_posts did not make proper use of 'posts_per_page' parameter.

= 1.0.5 =
* fixed issue with custom taxonomy template looks ups

= 1.0.6 =
* fixed issue with inbuilt booking forms not using the locations email address.
* updated custom field `session_info` to HTML WYSIWYG input, for services.
* updated session info widget to display html.

= 1.0.7 =
* fixed template name issue: `taxonomy-mjm_clinic_service_location` change to `taxonomy-mjm_clinic_location`

= 1.0.8 =
* removed reference to old akismet check

= 1.0.9 =
* removed all php short_open_tags in case compatibility issues

= 1.0.10 =
* removed `menu_position` on clinic menu entry, to avoid possible conflicts with other plugins

= 1.0.11 =
* fixed service location map widget output,  was not being output to screen after recent switch from php short_open_tags to full. `<?= to <?php echo`.

= 1.1 =
* added staff member listings to allow for doctor/therapist pages.
* added staff type/role taxonomy for grouping staff into roles. Eg: Doctor, Therapist.
* added staff member multi relation to services. Allows you to show doctors that provide the service.
* some minor fixes for Wordpress 4.2+

= 1.1.1 =
* Restored the disclaimer on/off toggle option in settings
* Added shortcode `mjm-clinic-disclaimer`
* Tested on Wordpress 4.3+

= 1.1.2 =
* Added hierarchy level control to service category navigation widget
* Removed PHP4 Widget constructors for future compatibility

= 1.1.3 =
* Booking form date validation requirements reduced to allow more date formats.
* Condition list now available as widget
* fixed issue with condition list container ID duplication
* fixed issue with condition list showing slug instead of title

= 1.1.4 =
* Location map widget can now show on any page by setting a location slug
* Set width, height for location map widget

= 1.1.5 =
* Added widget container class
* Added widget button class
* Added booking form anchor for moving to success msg

= 1.1.6 =
* Added more widget container classes

= 1.1.7 =
* Added shortcode for staff list (see docs)

= 1.1.8 =
* Assigned services widget now works on staff/doctor pages
* Enabled custom fields on service posts

= 1.1.9 =
* Enabled custom field support for feedback, casestudy, condition and staff posts

= 1.1.10 =
* Allowed for service location widget html overide.

= 1.1.11 =
* mjm_clinic_get_staff() now uses menu order instead of order by title ASC

= 1.1.12 =
* Removed warning when no attributes given to shortcode [mjm-clinic-staff]

= 1.1.13 =
* Fixed Walker_CategoryDropdown compatibility warning

= 1.1.14 =
* 4.9.8 compat

= 1.1.16 =
* v5 compatible

= 1.1.17 =
* Minor updates to booking form processor

= 1.1.18 =
* Theme template can now override the service session info widget

= 1.1.19 =
* Adds new action hook on booking form submit `mjm-clinic_booking_form_sent`