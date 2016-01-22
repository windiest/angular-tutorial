=== WP-Syntax ===
Contributors: shazahm1@hotmail.com
Donate link: http://wp-syntax.com/send-donation/
Tags: syntax highlighting, syntax, highlight, code, formatting, code, CSS, html, php, sourcecode
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.0

WP-Syntax provides clean syntax highlighting for embedding source code within pages or posts.

== Description ==

WP-Syntax provides clean syntax highlighting using
[GeSHi](http://qbnz.com/highlighter/) -- supporting a wide range of popular
languages.  It supports highlighting with or without line numbers and maintains formatting while copying snippets of code
from the browser.

It avoids conflicts with other 3rd party plugins by running an early
pre-filter and a late post-filter that substitutes and pulls the code snippets
out first and then pushes them back in with highlighting at the end.  The
result is source code formatted and highlighted the way you intended.

Usage, Supported Languages, Styling Guidelines, and Release Notes are availabe
in the [Other Notes](http://wordpress.org/extend/plugins/wp-syntax/other_notes/) section.

Want to contribute? WP-Sytax can be found on Github. Fork and submit your pull requests today!

= Basic Usage =

Wrap code blocks with `<pre lang="LANGUAGE" line="1">` and `</pre>` where **"LANGUAGE"**
is a [GeSHi](http://qbnz.com/highlighter/) supported language syntax.
The `line` attribute is optional. [More usage examples](http://wordpress.org/extend/plugins/wp-syntax/other_notes/)

== Installation ==

1. Upload wp-syntax.zip to your Wordpress plugins directory, usually `wp-content/plugins/` and unzip the file.  It will create a `wp-content/plugins/wp-syntax/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Create a post/page that contains a code snippet following the [proper usage syntax](http://wordpress.org/extend/plugins/wp-syntax/other_notes/).

== Frequently Asked Questions ==

= Why is the plugin generating unexpected output? =

Try editing code snippets without the visual editor.  To turn off the visual
editor for all your edits, uncheck the visual editor checkbox in your profile.
Depending on what type of code you're trying to display, you might also need
to disable WordPress' corrections of invalidly nested XMTML (under Options ->
Writing).

= Why can I, as an admin, post code snippets, but my authors cannot? =

By default, WordPress filters HTML for particular user roles, and this affects
WP-Syntax's input.  As a workaround, install the [Role Manager](http://www.im-web-gefunden.de/wordpress-plugins/role-manager/)
plugin, and check "unfiltered HTML" for the roles that would like to post code snippets.

== Screenshots ==

1. PHP, no line numbers.
2. Java, with line numbers.
3. Ruby, with line numbers starting at 18.

== Usage ==

Wrap code blocks with `<pre lang="LANGUAGE" line="1">` and `</pre>` where **"LANGUAGE"** is a [GeSHi](http://qbnz.com/highlighter/) supported
language syntax. See below for a full list of supported languages.
The `line` attribute is optional.

**Example 1: PHP, no line numbers**

    <pre lang="php">
    <div id="foo">
    <?php
      function foo() {
        echo "Hello World!\\n";
      }
    ?>
    </div>
    </pre>


**Example 2: Java, with line numbers**

    <pre lang="java" line="1">
    public class Hello {
      public static void main(String[] args) {
        System.out.println("Hello World!");
      }
    }
    </pre>

**Example 3: Ruby, with line numbers starting at 18**

    <pre lang="ruby" line="18">
    class Example
      def example(arg1)
        return "Hello: " + arg1.to_s
      end
    end
    </pre>

**Example 4: If your code already has html entities escaped, use `escaped="true"` as an option**

    <pre lang="xml" escaped="true">
    &lt;xml&gt;Hello&lt;/xml&gt;
    </pre>

**Example 5: PHP, with line numbers and highlighting a specific line**

    <pre lang="php" line="1" highlight="3">
    <div id="foo">
    <?php
      function foo() {
        echo "Hello World!\\n";
      }
    ?>
    </div>
    </pre>

**Example 6: PHP, with a caption (file and/or file path of the source file)**

    <pre lang="php" src"https://github.com/shazahm1/Connections/blob/master/connections.php">
    <div id="foo">
    <?php
      function foo() {
        echo "Hello World!\\n";
      }
    ?>
    </div>
    </pre>

== Supported Languages ==

The following languages are most supported in the `lang` attribute:

abap, actionscript, actionscript3, ada, apache, applescript, apt_sources, asm,
**asp**, autoit, avisynth, **bash**, bf, bibtex, blitzbasic, bnf, boo, **c**,
c_mac, caddcl, cadlisp, cil, cfdg, cfm, cmake, cobol, cpp-qt, **cpp**,
**csharp**, **css**, d, dcs, delphi, diff, div, dos, dot, eiffel, email, erlang,
fo, fortran, freebasic, genero, gettext, glsl, gml, bnuplot, groovy, haskell,
hq9plus, **html4strict**, idl, ini, inno, intercal, io, **java**, **java5**,
**javascript**, kixtart, klonec, klonecpp, latex, **lisp**, locobasic, lolcode
lotusformulas, lotusscript, lscript, lsl2, lua, m68k, make, matlab, mirc,
modula3, mpasm, mxml, **mysql**, nsis, oberon2, **objc**, ocaml-brief, ocaml,
oobas, **oracle11**, oracle8, pascal, per, pic16, pixelbender, **perl**,
php-brief, **php**, plsql, povray, powershell, progress, prolog, properties,
providex, **python**, qbasic, **rails**, rebol, reg, robots, **ruby**, sas,
scala, scheme, scilab, sdlbasic, smalltalk, smarty, **sql**, tcl, teraterm,
text, thinbasic, tsql, typoscript, **vb**, **vbnet**, verilog, vhdl, vim,
visualfoxpro, visualprolog, whitespace, whois, winbatch, **xml**, xorg_conf,
xpp, z80

See the [GeSHi Documentation](http://qbnz.com/highlighter/geshi-doc.html)
for a full list of supported languages.

(Bold languages just highlight the more popular ones.)

== Styling Guidelines ==

WP-Syntax colors code using the default GeSHi colors.  It also uses inline
styling to make sure that code highlights still work in RSS feeds.  It uses a
default `wp-syntax.css` stylesheet for basic layout.  To customize your styling,
copy the default `wp-content/plugins/wp-syntax/wp-syntax.css` to your theme's
template directory and modify it.  If a file named `wp-syntax.css` exists in
your theme's template directory, this stylesheet is used instead of the default.
This allows theme authors to add their own customizations as they see fit.

== Advanced Customization ==

WP-Syntax supports a `wp_syntax_init_geshi` action hook to customize GeSHi
initialization settings.  Blog owners can handle the hook in a hand-made plugin
or somewhere else like this:

    <?php
    add_action('wp_syntax_init_geshi', 'my_custom_geshi_styles');

    function my_custom_geshi_styles(&$geshi)
    {
        $geshi->set_brackets_style('color: #000;');
        $geshi->set_keyword_group_style(1, 'color: #22f;');
    }
    ?>

This allows for a great possibility of different customizations. Be sure to
review the [GeSHi Documentation](http://qbnz.com/highlighter/geshi-doc.html).

== Changelog ==

= 1.0 02/09/2013 =
* NEW: CSS3 for alternating background lines for easier reading.
* OTHER: Completely refactor code to utilize current best practices for plugin development which will provide a solid foundation for further development.
* OTHER: Remove GeSHi contrib and test folders.
* OTHER: Move CSS to `css` subfolder.
* OTHER: Move JavaScript to `js` subfolder.
* OTHER: CSS fixes to keep theme from breaking output formatting.

= 0.9.13 09/01/12 =
* FEATURE: Added a new "src" shortcode option to allow reference of the source filename. Props: Steffen Vogel
* BUG: Properly enqueue the CSS file.
* BUG: Updated TinyMCE whitelist to allows required tags. Props: Steffen Vogel
* OTHER: Updated GeSHi to 1.0.8.11
* OTHER: Remove old unused code.
* OTHER: Imporved line highlighting. Props: Steffen Vogel
* OTHER: Added some additional CSS styles to help keep theme's from breaking the presentation of the code.

**0.9.12** : Fixed a range bug in the new highlight feature.

**0.9.11** : Added line highlighting support. User submitted patch. [Thanks Flynsarmy && Chimo](http://www.flynsarmy.com/2011/06/how-to-add-line-highlight-support-to-wp-syntax/)

**0.9.10** : Fix for security vulnerability when register_globals in php is enabled.

**0.9.9** : Fix to support child theme's. WP-Syntax now requires WP >= 3.0.
  Credit to [OddOneOut](http://wordpress.org/support/topic/wp-syntax-css-with-twenty-ten-child-theme)
  Updated to use 1.0.8.9.

**0.9.8** : Fix for optional line attributes; Tested on WP 2.8

**0.9.7** : Reverted GeSHi v1.0.8.3 to avoid a slew of issues;

**0.9.6** : Updated to use GeSHi v1.0.8.4;

**0.9.5** : Minor style override to prevent themes from mangling code structure

**0.9.4** : Updated to use GeSHi v1.0.8.3;

**0.9.3** : Fixed hard-coded plugin path
  ([#964](http://plugins.trac.wordpress.org/ticket/964));

**0.9.2** : Updated to use GeSHi v1.0.8.2; Added optional `escaped="true"`
  support in case code snippets are already escaped with html entities.

**0.9.1** : Updated to use GeSHi v1.0.8; Improved the FAQ;

**0.9** : Added support for anonymous subscribers to use pre tags in their
  comments allowing for their own colored code snippets [Fernando Briano];

**0.8** : Updated to use GeSHi v1.0.7.22 (this normally would be a revision
  release, but colors changed and there are 9 new languages supported); Added a
  font-size setting in the default css to thwart complaints about small sizes
  caused by other default WP themes;

**0.7** : Automaticaly included common styles without requiring manual theme
  customization [Christian Heim]; Added support for adding a custom
  wp-syntax.css stylesheet to a theme;

**0.6.1** : Updated to use GeSHi v1.0.7.21; Updated the WP compatibility version;

**0.6** : Support init hook for geshi settings (`wp_syntax_init_geshi`);
  ([#667](http://dev.wp-plugins.org/ticket/667))
  [[reedom](http://wordpress.org/support/topic/125127?replies=1#post-586215)]

**0.5.4** : Updated to use GeSHi v1.0.7.20;

**0.5.3** : Fixed styling guideline issue that affected IE 6 [kimuraco];

**0.5.2** : Updated to use GeSHi v1.0.7.19;

**0.5.1** : Switched `geshi` directory export to utilize
  [piston](http://piston.rubyforge.org/) instead of `svn:externals` properties;

**0.5** : Added support for single quoted attributes;
  ([#624](http://dev.wp-plugins.org/ticket/624))

**0.4** : Cleanup and documentation for WordPress.org [plugin
  listings](http://wordpress.org/extend/plugins/);

**0.3** : First official public release; Added line number support; Uses GeSHi v1.0.7.18;
([#532](http://dev.wp-plugins.org/ticket/532))

**0.2** : Internal release; Adds "before and after" filter support to avoid
conflicts with other plugins;
([#531](http://dev.wp-plugins.org/ticket/531))

**0.1** : First internal release; Uses GeSHi v1.0.7.16;

== Upgrade Notice ==

= 0.9.10 =
Fixes a security vulnerability. Upgrade immediately.

= 0.9.9 =
Compatible with WP >= 3.0 and latest GeSHi
