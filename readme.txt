=== Plugin Name ===
Contributors: udssl
Donate link: http://udssl.com/donate/
Tags: time tracker, time management, payment tracking, time, payments, tracking
Requires at least: 5.0
Requires PHP: 5.6
Tested up to: 5.8.1
Stable tag: 1.0.2
Text Domain: udssl 
Domain Path: /languages
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

UDSSL Time Tracker helps you to precisely track your time. Charts allows you to visualize how your time is spent and helps you to be more productive.

== Description ==

UDSSL Time Tracker helps you to track your time easily with an intuitive interface. You can easily track your time with a few clicks. Using presets you can track frequent tasks instantly.  Once you setup your tasks, projects and categories, you only have to enter an optional description on how a particular time period is spent.

= Payment Tracker =

Payment Tracker allows you to keep a record of your earnings. Once the payment is assigned to a task, that particular task is removed from time tracker interface select boxes. You can't record time for a paid task. You should start a new task for new work.

= JSON API =

UDSSL Time Tracker front interface is built as a Backbone JS application. Backbone app uses the JSON API to manage your time data. The JSON API is restricted to logged-in users by default. You can use the API in any other custom plugin as a logged in user. Further, you can make the API public and use it remotely if required.

= Extra Information =

UDSSL site contains additional information about this plugin. Visit UDSSL Time Tracker website for more information.

Visit [UDSSL Time Tracker](http://udssl.com/udssl-time-tracker/) Website.

== Installation ==

1. Upload the "UDSSL Time Tracker" plugin to the `/wp-content/plugins/` directory
2. Activate the "UDSSL Time Tracker" through the 'Plugins' menu in WordPress
3. Visit 'your-site.com/time-tracker/' to start tracking your time.

== Frequently Asked Questions ==

= Does UDSSL Time Tracker come with sample data to get started? =

Yes, sample data is automatically installed on plugin activation.  Sample data installation is done after automatic table creation on activation.

= What can be done with collected time data? =

You can visualize your time data by charting them with UDSSL Time Tracker. It'll help you to better understand how your time is precisely spent. You may even decide use the collected data in another application.

= I've heard that UDSSL Time Tracker can track payments as well. Is that true? =

True. UDSSL Time Tracker can be used to record your payments. You can track your time along with the payments you receive for your time. Use the Payment Tracking page to enter your payments and start tracking.

= Can the JSON API be accessed as a visitor? =

No, you should be logged in to use the JSON API. You may decide to open your time data to the world by allowing public access to JSON API through administration settings. You can use available hooks to fine tune access permissions.

= How may hooks are available in UDSSL Time Tracker? =

There are many. If you are a developer, please browse through the source files to discover the hooks. You may guess the relevant files and see whether there exists a hook that you can use to get done what you want.

= Can you add a new feature that should be in any Time Tracker? =

Yes, please let us know what you need to have in the next UDSSL Time Tracker version. We'll try to add the feature you required.

= Can this time tracker interface be translated to my language? =

Please contact UDSSL for discuss the possibility of translating this plugin to your language. UDSSL Time Tracker currently supports Sinhalese and Tamil in addition to default English language.

== Screenshots ==

1. UDSSL Time Tracker Front Interface
2. UDSSL Time Tracker Admin Backend
3. UDSSL Time Tracker Sinhala Language
4. UDSSL Time Tracker Tamil Language

== Changelog ==

= 1.0.2 =

* Using sanitization functions in db class and other inputs.

* Removed calling chartjs remotely.
* Using chartjs in SVN.

* Moment js files deleted from SVN.
* Using WordPress packaged 'moment'.

* Using wp_kses() to echo html.

= 1.0.1 =

* Removed 'Highcharts' from SVN.
* Included ChartJs(v3.5.1) inside plugin.
* Using 'wp_enqueue_script' for all enqueues. 
* Moment Js Updated (v2.1.0 -> v2.29.1)
* Bootstrap Updated (v2.3.2 -> v5.1.1)
* Using esc_*() functions for output.
* Using esc_sql in db class.
* Improved santization and escaping throught the plugin.
* Tested with: 5.8.1
* Stable tag: 1.0.1

= 1.0.0 =

Enhancements:

* Using chart.js to graph time data.
* Upgraded to bootstrap v5.1.1.

Bugfixes:

* Fixed table not deleting on uninstall.
* Fixed backbone.js template errors.
* Fixed styling issues.

= 0.2 =

* Fixed plugin action links application to all plugin entries.
* Time slot preset administration interface was improved for usability.

= 0.1 =

Initial Release Date: November 3rd, 2013

* UDSSL Time Tracker Initial Release.

== Upgrade Notice ==

= 0.1 =

* UDSSL Time Tracker Initial Release.
