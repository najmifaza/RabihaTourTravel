=== Heartbeat Controller ===
Contributors: devabdurrahman
Donate link: https://www.buymeacoffee.com/devabdurrahman
Tags: heartbeat, heartbeat api, performance, autosave, admin-ajax.php
Requires at least: 5.2
Tested up to: 6.8
Requires PHP: 7.2
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Control WordPress Heartbeat API to reduce load. Allow, disable, or set custom frequency for Dashboard, Post Editor, and Frontend.

== Description ==

“Heartbeat Controller” helps you reduce server load by managing WordPress's built-in Heartbeat API. WordPress uses the Heartbeat API to make frequent background requests to `admin-ajax.php`, which can overwhelm your server especially on shared or VPS hosting.

This plugin provides a clean, user-friendly interface that lets you:
- ✅ Enable or disable Heartbeat API
- ✅ Adjust Heartbeat frequency (interval in seconds)
- ✅ Control behavior per section: Dashboard, Post Editor, Frontend
- ✅ Instantly apply changes without code

Ideal for performance-conscious site owners and developers.

🛠 No need to write a single line of code. Everything is controllable through the WordPress admin.

== Features ==

- Control WordPress Heartbeat activity from the admin panel
- Apply settings independently for:
  - Admin Dashboard
  - Post/Page Editor
  - Frontend (theme side)
- Choose from:
  - Allow (default WordPress behavior)
  - Disallow (disable AJAX polling)
  - Modify frequency (set custom interval, e.g., 60 seconds)
- Built-in protection to prevent unsafe frequency (minimum 15s)
- Lightweight and developer-friendly
- Clean UI that follows WordPress standards

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the “Plugins” menu in WordPress.
3. Go to “Settings > Heartbeat Control” to configure options.

== Frequently Asked Questions ==

= What is the Heartbeat API? =
The Heartbeat API is used by WordPress to send periodic requests (every 15–60 seconds) to `admin-ajax.php` for tasks like auto-saving posts, syncing data, and showing logged-in user activity.

= Why should I control it? =
Frequent AJAX calls from the Heartbeat API can cause high CPU usage and slow down your site, especially if you or your users keep multiple admin tabs open.

= Is it safe to disable the Heartbeat API? =
Yes, but some features like autosave or post locking won’t work. For most sites, it's safe to disable or reduce the frequency in the Dashboard or Frontend.

= Will this plugin work with caching plugins? =
Yes! This plugin complements performance optimization tools like WP Rocket, W3 Total Cache, or LiteSpeed Cache.

== Screenshots ==

1. Heartbeat Control Settings Panel

== Changelog ==

= 1.0 =
* Initial release
* Allows full control over Heartbeat API in Dashboard, Post Editor, and Frontend

== Upgrade Notice ==

= 1.0 =
First release. You can now easily control WordPress Heartbeat behavior to reduce server load.

== About the Developer ==

Created and maintained by “Abdur Rahman”, a WordPress developer passionate about performance, custom plugins, and helping businesses scale through fast and secure websites.

🔗 [Visit My Portfolio](https://devabdurrahman.com)

Need a custom plugin? Reach out for collaborations or freelance projects!