=== WP Security Login Notification ===
Contributors: Neoptin
Donate link: http://neoptin.com/donate/
Tags: alert, email, login, notification, notify, security, brute force attacks, authentication
Tested up to: 3.5.1
Stable tag: 1.0.0
Requires at least: 3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sends an email with useful data to the administrator each time a user successfully logs in or fails to connect.

== Description ==

The purpose of this plugin consists in improving the security of a WordPress website.
It sends send an email for each of the following event:

*   **When a user logs in successfully** the plugin sends an email to the administrator with the date, user name, user email, IP address, user agent and HTTP referrer.
*   **When someone fails to login** the plugin sends an email to the administrator with date, login used when trying to connect, IP address, user agent and HTTP referrer.


Moreover, the "datetime", the IP adress and the user agent of the last login are saved into the database for each user. If something occurs the information was saved in the database.

Plugin developed by <a href="http://neoptin.com">Neoptin</a>. Need <a href="http://neoptin.com/wordpress/"> WordPress Services</a>?


== Installation ==

1. Upload the full directory into your wp-content/plugins/ directory
2. Activate the plugin at the plugin administration page
3. That's it ! That was easy, isn't it ?

== Other notes ==

= How to uninstall this plugin? =
To uninstall WP Security Login Notification, just de-activate it from the plugin list, on your admin page.



== Frequently Asked Questions ==

= I don't receive any email? =
Please be sure you have a correct email adress set in Settings > General. Also, be sure to check into your spam folder.

= Someone tried to hack my website, what should I do? =
If you're not sure, contact a professionnal.

== Changelog ==

= v1.0 =
* Plugin deployment