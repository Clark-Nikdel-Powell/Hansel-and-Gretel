=== Hansel & Gretel: Fine-Tuned Breadcrumb Generator ===
Contributors: rodaine, taylor_CNP
Tags: breadcrumbs, breadcrumb, crumb, microdata, hierarchy, simple
Requires at least: 3.1.0
Tested up to: 3.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple microdata-enabled breadcrumbs generator

== Description ==

### For Full Documentation & The Latest Updates ###

[Watch us on GitHub!](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel)

### Where The Heck Am I? ###

Let's face it: breadcrumbs are an integral part of websites these days. They give an immediate sense of hierarchy to your visitors and allow users to backtrack through your site to (hopefully) find more content. WordPress simplifies structuring sites how ever it seems reasonable, but it takes a bit more effort to generate breadcrumbs for all the different types of posts, and pages, and taxonomies, and archives, and ... you get the idea.

### But there are already plugins for that, aren't there? ###

Sure! And a lot of them work really well for simple sites with simple hierarchies, but many of them fall short in one way or the other:

> __Want to use the new semantic `<nav>` element?__  
> Nope sorry, all they have are `<p>`'s or `<ul>`'s. 

> __Need to control the classes or IDs of the crumbs?__  
> Yep, nope; their wrapper has a fixed class of `breadcrumbs` though...I hope that's all you need.

> __Uh...okay what about custom taxonomies?__  
> You already know the answer to this question...

> __And custom post types?__  
> Better hope they're hierarchical!

> __Should I even bother mentioning rich snippets/microdata?__  
> Haven't found one yet.

### Okay fine, but what makes you think yours is any better? ###

It might be obvious (considering the previous section) that this plugin seeks to address all the customizability problems with the existing breadcrumb plugin environment while still keeping it as easy to use as possible (read: `HAG_Breadcrumbs();`, done!). It's as simple as that. Hopefully it can live up to your expectations!

## Features ##

_The following features are currently available unless otherwise specifed._

+ __Simple Installation__  
Upload the plugin, activate via the WordPress admin, and drop the function where you want the breadcrumbs to appear in your template. Done!

+ __Fine-Tuned Control__  
H&G works right out of the box, but oftentimes we want custom control. Nearly every aspect of the breadcrumbs rendering can be changed a'la the [myriad of options](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel#options) available.

+ __Microdata Integration__  
H&G by default includes the microdata format for a [WebPage's breadcrumbs](http://schema.org/WebPage), a format that is jointly supported by [Bing](http://www.bing.com/community/site_blogs/b/search/archive/2011/06/02/bing-google-and-yahoo-unite-to-build-the-web-of-objects.aspx), [Google](http://support.google.com/webmasters/bin/answer.py?hl=en&answer=1211158), [Yahoo!](http://developer.yahoo.com/blogs/ydn/posts/2011/06/introducing-schema-org-a-collaboration-on-structured-data/) and [Yandex](http://help.yandex.ru/webmaster/?id=1122752).

+ __Full Markup Control__  
Choose any element to wrap your breadcrumbs, including optional class(es) or ID attributes. Likewise, you can include prefix and suffix content right inside the wrapper element tags for further control.

+ __Template Hierarchy Based Rendering__  
H&G utilizes the [WordPress Template Hierarchy](http://codex.wordpress.org/Template_Hierarchy) to determine which crumbs to show, including that elusive Comments Popup Window everybody (read: nobody) uses! This means, regardless of your theme, Hansel & Gretel will follow WP's lead about the content on the page.

+ __Custom Post Types & Taxonomies__  
Never worry about how breadcrumbs behave across your fancy new post types and taxonomies. H&G accounts for hierarchical and non-hierarchical types, whether or not they have an archive page, and also provides options to override breadcrumb display for individual post types if desired.

+ __Home & Last Crumbs__  
H&G allows full control in showing home breadcrumbs and even allows for customized Front Page versus Blog Home Page templates. Likewise, the last, current page crumb has equal control depending on the needs of your theme.

+ __Made for Theme Developers__  
Hansel and Gretel was made by theme developers for theme developers. The default options and degree of customizability were all considered by our team of experienced WP developers to make sense right out of the box, with as little further customization as possible. Give it a try and let us know what you think. We all want H&G to be the simplest and smartest breadcrumb plugin you'll ever use! To contribute to the development of this plugin, [fork our repo](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel) over on GitHub.

== Installation ==

_Installing Hansel & Gretel is easy-peasy, but of course there's a bit of administrative work on the front end you'll need to take care of._

### Requirements & Compatibility ###

__Minimum (theoretical) Wordpress Version Required:__ 3.1.0  
__Actually Tested Versions__ 3.3.2, 3.4.X, 3.5

If you find it non-operational on your particular flavor of WP, please let us know. 

### Instructions ###

0. Make sure WordPress 3.1.0 or better is running on your site. It will not work with older versions.

1. Get the plugin onto your site, in one of many ways:
    * Use the Plugin Manager via the WordPress admin to install the plugin (via Add New). Search for "Hansel & Gretel" and click install on this plugin.
    * Download the [stable zip archive](http://downloads.wordpress.org/plugin/hansel-gretel.zip) from the WordPress Plugin Repository and extract the contents.
    * Download the [bleeding-edge zip archive](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel/zipball/master) from GitHub and extract the contents.
    * Clone the [GitHub Repository](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel) to your local machine (or even your remote server on some hosting providers!) and always have an up-to-date version available to you.

2. If you didn't use the Plugin Manager to install H&G, upload the `hansel-gretel` folder to your plugins directory (`/wp-content/plugins/hansel-gretel/`).

3. Activate the plugin through the Plugins page on the WordPress admin.

4. Add the following snippet to your theme file(s) outside [The Loop](http://codex.wordpress.org/the_loop) where you want the breadcrumbs to appear: `<?php if (function_exists('HAG_Breadcrumbs')) { HAG_Breadcrumbs(); } ?>`
 
6. **Profit!**

== Frequently Asked Questions ==

= Where can I learn more about this plugin? =

Checkout the [GitHub Repository](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel) for this Plugin!

== Screenshots ==

1. Breadcrumbs for the custom Books post-type including the genre taxonomy for Memoirs of a Geisha
2. Breadcrumbs for the default Post post-type including the categories taxonomy

== Changelog ==

Checkout the [GitHub Repository](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel#development) for the full changelog!

== Upgrade Notice ==

Checkout the [GitHub Repository](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel#development) for any upgrade notices!
