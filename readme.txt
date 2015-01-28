=== Plugin Name ===
Contributors: rbevanrestdevelopercom
Donate link: https://www.restdeveloper.com
Tags: sucuri,flush,caching
Requires at least: 4.0.1
Tested up to: 4.0.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

When updating a page or post, this plugin will make a http call for the purpose of flushing a 3rd party, hosted cache. Specific to Sucuri as their system requires no HTTP authentication, but this could be adapted to fix other caching services.

== Description ==

When updating a page or post, this plugin will make a http call for the purpose of flushing a 3rd party, hosted cache. Specific to Sucuri as their system requires no HTTP authentication, but this could be adapted to fix other caching services.

*	Triggered using the WordPress "save_post" hook
*	Uses the wp_remote_get() to call any URL (Sucuri for example)
*	Could be altered to use HTTP auth on request


== Installation ==

1. Upload `sucuri-flush.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= I have a bug =

Please use the support page on the WordPress plugins page or contact me via https://www.restdeveloper.com


== Screenshots ==

1. The settings page

== Changelog ==

= 1.0 =
* Inital upload
