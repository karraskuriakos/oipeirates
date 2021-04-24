Extension Name: Infinity Cache
Extension URI: http://www.wptouch.com/extensions/infinity-cache
Author: BraveNewCode Inc.
Description: A lightweight page caching module designed specifically for WPtouch. Includes Desktop caching (optional).
Version: 1.3.1
Depends-on: 4.0

== Long Description ==

Infinity Cache adds true mobile caching to your WPtouch powered mobile site. Infinity Cache loads mobile pages up to 5x faster than responsive or desktop themes. Infinity Cache can be used alongside other solutions like WP Super Cache or W3 Total Cache. Infinity Cache can also be used to provide a substantial decrease in loading time for your desktop site as well.

== Changelog ==

= Version 1.3.1 =

* Updated: Suppress cache when new-style comment author cookies are used (using cookie hash)

= Version 1.3 =

* Updated: Compatible with WPtouch 4

= Version 1.2.2 =

* Fixed: Infinity Cache now handles password protected pages
* Changed: Automatically flush the cache when updating the WPtouch Pro plugin

= Version 1.2.1 =

* Fixed: Issue with URLs without explicit protocol reference (i.e. // vs http://)

= Version 1.2 =

* Changed: Fixed issue where CSS files weren’t switched to CDNs
* Changed: Replaced CDN regex code for improved performance

= Version 1.1.1 =

* Changed: Now removing the WP admin bar quick link to clearing the cache when Infinity Cache is disabled

= Version 1.1 =

* Changed: Automatically flush cache when WPtouch Pro settings are updated
* Changed: Extension settings layout

= Version 1.0.7 =

* Fixed: Escape add_query_arg

= Version 1.0.6 =

* Fixed: Ignore blank lines in ignored-urls list

= Version 1.0.5 =

* Changed: Caching a page can now be prevented via the wptouch_addon_cache_current_page filter

= Version 1.0.4 =

* Fixed: Removed filemtime warnings

= Version 1.0.3 =

* Changed: Moved settings to accommodate multi-ads add-on

= Version 1.0.2 =

* Fixed: An issue with desktop caching on servers with high load

= Version 1.0.1 =

* Fixed: Caching issue with comment forms
