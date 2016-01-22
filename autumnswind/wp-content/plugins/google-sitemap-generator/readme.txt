=== Google XML Sitemaps ===
Contributors: arnee
Donate link: http://www.arnebrachhold.de/redir/sitemap-paypal
Tags: seo, google, sitemaps, google sitemaps, yahoo, msn, ask, live, xml sitemap, xml
Requires at least: 2.9
Tested up to: 3.3
Stable tag: 3.2.4

This plugin will generate a special XML sitemap which will help search engines to better index your blog.

== Description ==

This plugin will generate a special XML sitemap which will help search engines like Google, Bing, Yahoo and Ask.com to better index your blog. With such a sitemap, it's much easier for the crawlers to see the complete structure of your site and retrieve it more efficiently. The plugin supports all kinds of WordPress generated pages as well as custom URLs. Additionally it notifies all major search engines every time you create a post about the new content.

Related Links:

* <a href="http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/" title="Google XML Sitemaps Plugin for WordPress">Plugin Homepage</a>
* <a href="http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/changelog/" title="Changelog of the Google XML Sitemaps Plugin for WordPress">Changelog</a>
* <a href="http://www.arnebrachhold.de/2006/04/07/google-sitemaps-faq-sitemap-issues-errors-and-problems/" title="Google Sitemaps FAQ">Plugin and sitemaps FAQ</a>
* <a href="http://wordpress.org/tags/google-sitemap-generator?forum_id=10">Support Forum</a>

*This release is compatible with all WordPress versions since 2.9. If you are still using an older one, please see the [Google Sitemaps Plugin Homepage](http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/ "Google (XML) Sitemap Generator Plugin Homepage") for older versions.*

== Installation ==

1. Upload the full directory into your wp-content/plugins directory
2. Activate the plugin at the plugin administration page
3. Open the plugin configuration page, which is located under Settings -> XML-Sitemap and customize settings like priorities and change frequencies. 
4. The plugin will automatically update your sitemap of you publish a post, so theres nothing more to do :)

== Frequently Asked Questions == 

= Do I have to create a sitemap.xml and sitemap.xml.gz by myself? =

No. Since version 4, these files are dynamically generated. **There must be no sitemap.xml or sitemap.xml.gz in your blog directory anymore!*** The plugin will try to rename them to sitemap.xml.bak if they still exists.

= Does this plugin use static files? =

No. Since version 4, these files are dynamically generated. **There must be no sitemap.xml or sitemap.xml.gz in your blog directory anymore!*** The plugin will try to rename them to sitemap.xml.bak if they still exists.

= There are no comments yet (or I've disabled them) and all my postings have a priority of zero! =

Please disable automatic priority calculation and define a static priority for posts.

= So much configuration options... Do I need to change them? =

No, only if you want to. Default values are ok for most sites.

= Does this plugin work with all WordPress versions? =

This version works with WordPress 2.9 and better. If you're using an older version, please check the [Google Sitemaps Plugin Homepage](http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/ "Google (XML) Sitemap Generator Plugin Homepage") for the legacy releases. There is a working release for every WordPress version since 1.5.

= My question isn't answered here =

Most of the plugin options are described at the [plugin homepage](http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/) as well as the dedicated [Google Sitemaps FAQ](http://www.arnebrachhold.de/2006/04/07/google-sitemaps-faq-sitemap-issues-errors-and-problems/ "List of common questions / problems regarding Google (XML) Sitemaps").

= My question isn't even answered there =

Please post your question at the [WordPress support forum](http://wordpress.org/tags/google-sitemap-generator?forum_id=10) and tag your post with "google-sitemap-generator".

= What's new in the latest version? =

The changelog is maintained on [here](http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/changelog/ "Google (XML) Sitemap Generator Plugin Changelog")

== Changelog ==

Until it appears here, the changelog is maintained on [the plugin website](http://www.arnebrachhold.de/projects/wordpress-plugins/google-xml-sitemaps-generator/changelog/ "Google (XML) Sitemap Generator Plugin Changelog")

== Screenshots ==

1. Administration interface in WordPress 2.7
2. Administration interface in WordPress 2.5
3. Administration interface in WordPress 2.0

== License ==

Good news, this plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial blog. But if you enjoy this plugin, you can thank me and leave a [small donation](http://www.arnebrachhold.de/redir/sitemap-paypal "Donate with PayPal") for the time I've spent writing and supporting this plugin. And I really don't want to know how many hours of my life this plugin has already eaten ;)

== Translations ==

The plugin comes with various translations, please refer to the [WordPress Codex](http://codex.wordpress.org/Installing_WordPress_in_Your_Language "Installing WordPress in Your Language") for more information about activating the translation. If you want to help to translate the plugin to your language, please have a look at the sitemap.pot file which contains all definitions and may be used with a [gettext](http://www.gnu.org/software/gettext/) editor like [Poedit](http://www.poedit.net/) (Windows).