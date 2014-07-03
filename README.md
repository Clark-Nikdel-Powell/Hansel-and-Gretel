# Hansel & Gretel #
_A WordPress Breadcrumb Generator Plugin_

## Where The Heck Am I? ##

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
Upload the plugin, activate via the WordPress admin, and drop the function where you want the breadcrumbs to appear in your template. Done! [Read on](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel#installation) for the juicy details.

+ __Fine-Tuned Control__  
H&G works right out of the box, but oftentimes we want custom control. Nearly every aspect of the breadcrumbs rendering can be changed a'la the [myriad of options](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel#options) available, either at the function call or via the provided admin menu (coming soon).

+ __Microdata Integration__  
H&G by default includes the microdata format for a [WebPage's breadcrumbs](http://schema.org/WebPage), a format that is jointly supported by [Bing](http://www.bing.com/community/site_blogs/b/search/archive/2011/06/02/bing-google-and-yahoo-unite-to-build-the-web-of-objects.aspx), [Google](http://support.google.com/webmasters/bin/answer.py?hl=en&answer=1211158), [Yahoo!](http://developer.yahoo.com/blogs/ydn/posts/2011/06/introducing-schema-org-a-collaboration-on-structured-data/) and [Yandex](http://help.yandex.ru/webmaster/?id=1122752).

+ __Full Markup Control__  
Choose any element to wrap your breadcrumbs, including optional class(es) or id attributes. Likewise, you can include prefix and suffix content right inside the wrapper element tags for further control.

+ __Template Hierarchy Based Rendering__  
H&G utilizes the [WordPress Template Hierarchy](http://codex.wordpress.org/Template_Hierarchy) to determine which crumbs to show, including that elusive Comments Popup Window everybody (read: nobody) uses! This means, regardless of your theme, Hansel & Gretel will follow WP's lead about the content on the page.

+ __Custom Post Types & Taxonomies__  
Never worry about how breadcrumbs behave across your fancy new post types and taxonomies. H&G accounts for hierarchical and non-hierarchical types, whether or not they have an archive page, and also provides options to override breadcrumb display for individual post types if desired.

+ __Home & Last Crumbs__  
H&G allows full control in showing home breadcrumbs and even allows for customized Front Page versus Blog Home Page templates. Likewise, the last, current page crumb has equal control depending on the needs of your theme.

+ __Made for Theme Developers__  
Hansel and Gretel was made by theme developers for theme developers. The default options and degree of customizability were all considered by our team of experienced WP developers to make sense right out of the box, with as little further customization as possible. Give it a try and let us know what you think. We all want H&G to be the simplest and smartest breadcrumb plugin you'll ever use!

## Installation ##

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

4. Add the following snippet to your theme file(s) outside [The Loop](http://codex.wordpress.org/the_loop) where you want the breadcrumbs to appear:  
```php
  <?php if (function_exists('HAG_Breadcrumbs')) { HAG_Breadcrumbs(); } ?>
```
 
6. **Profit!**

## Options ##

### Wow there are a lot...I thought you said this was simple?! ###

It is! Even though there are 30+ options that you can set on H&G, you don't need to set a single one to make it work out of the box. These options are available to fine-tune how you wish the breadcrumbs to appear and are completely...well, _optional_.

### How are options prioritized? ###

There are many ways to set the options for this plugin, so knowing how the options are prioritized is important if you're wondering why the changes you just made aren't showing up. Below is the list of options from lowest to highest priority; higher priority options override matching lower priority ones.

1. __Plugin Defaults__  
These are the out-of-the-box default options set by the plugin. They provide the base for the behavior of the H&G.

2. __Admin-Set Defaults__ (coming soon)  
These are the options set for the plugin from the settings page in the WordPress Admin. These are a subset of the available options, but include the most widely used ones.

3. __Admin-Set Post Type Defaults__ (coming soon)  
These are post-type specific overrides to the global defaults set in the admin (#2). Want your Gizmo post-type breadcrumbs to show up differently? This is where you'd want to set it.

4. __Function-Set Options__  
When calling `HAG_Breadcrumbs();` in your template file, providing an array of options and their desired values will override all admin defaults. All options can be set from this method. See below for the format.

5. __Function-Set Post Type Options__  
Like the admin-set equivalent, these post-type specific options will override the global function-set ones (#4).

### Using The Function-Set Options ###

Theme developers will be familiar with this pattern of providing settings to a function in WordPress. Below is an example of setting some common options, and providing some post-type specific overrides:

```php
<?php if (function_exists('HAG_Breadcrumbs')) { HAG_Breadcrumbs(array(
  'prefix'     => 'You are here: ',
  'last_link'  => true,
  'separator'  => '|',
  'excluded_taxonomies' => array(
  	'post_format'
  ),
  'taxonomy_excluded_terms' => array(
  	'category' => array('uncategorized')
  ),
  'post_types' => array(
    'gizmo' => array(
      'last_show'          => false,
      'taxonomy_preferred' => 'category'
    ),
    'whatzit' => array(
      'separator' => '&raquo;'
    )
  )
)); } ?>
```

The above example sets the prefix for the breadcrumbs to `You are here: `, adds the link to the last crumb, and changes the separator to the pipe (`|`). Also, the theme-generated `post_format` taxonomy is excluded from the breadcrumbs, and the term `uncategorized (Uncategorized)` is never displayed on a post page. When on a `gizmo` post-type page, the last crumb is set not to show and the taxonomy crumbs will be categories. Likewise, on a `whatzit` post-type page, the separator has been overriden to show `&raquo;` (&raquo;) instead.

### Debug Options ###

#### `debug_show (bool | Default: false)` ####

Whether or not debug information for the plugin should be printed to the output.

#### `debug_comment (bool | Default: true)` ####

Whether or not the debug information should be printed in an HTML comment. Otherwise, the debug information will be output in a `<pre>` element.

### Wrapper Options ###

#### `wrapper_element (string | Default: 'p')` ####

The HTML element that wraps the entire breadcrumbs list. Any valid element name will be accepted; so use whatever makes semantic sense for your theme!

#### `wrapper_class (string | Default: '')` ####

The class(es) applied to the wrapper element. May be left blank for no class(es) to be added.

#### `wrapper_id (string | Default: 'breadcrumbs')` ####

The ID applied to the wrapper element. May be left blank for no ID to be added.

#### `microdata (bool | Default: true)` ####

Whether or not to include microdata on the breadcrumbs. Adds `itemprop="breadcrumb"` to the wrapper element per [Schema.org](http://schema.org/WebPage).

#### `prefix (string | Default: '')` ####

The content and/or markup to be added immediately after the opening of the breadcrumbs wrapper. May be left blank for no content to be added.

#### `suffix (string | Default: '')` ####

The content and/or markup to be added immediately before the closing of the breadcrumbs wrapper. May be left blank for no content to be added.

### Crumb Options ###

#### `separator (string | Default: '&raquo;')` ####

The content and/or markup to be added between crumbs. The separator is padded on both sides by a single space before rendering. May be left blank for no separator to be added.

#### `crumb_element (string | Default: '')` ####

The HTML element that wraps each breadcrumb. May be left blank for no element to be applied.

#### `crumb_class (string | Default: '')` ####

The class(es) applied to the crumb element or crumb link if it exists. May be left blank for no class(es) to be added.

#### `crumb_link (bool | Default: true)` ####

Whether or not the crumbs should link to their associated pages in the hierarchy.

#### `link_class (string | Default: '')` ####

The class(es) applied to the crumb link if it exists. May be left blank for no class(es) to be added.

### The Home Crumb Options ###

#### `home_show (bool | Default: true)` ####

Whether or not a root crumb for the site home page should be shown.

#### `home_link (bool | Default: true)` ####

Whether or not the root crumb should be linked ot the site home page.

#### `home_label (string | Default: 'Home')` ####

The label for the root crumb if it is included.

#### `home_class (string | Default: '')` ####

The class(es) applied to the root crumb if it is included. May be left blank for no class(es) to be added.

#### `home_id (string | Default: '')` ####

The ID applied to the root crumb if it is included. May be left blank for no ID to be added.

### Taxonomy Options ###

#### `taxonomy_show (bool | Default: true | Version: 0.0.4+)` ####

Whether or not taxonomy breadcrumbs should be included for the current location. This is only applicable on singular, non-archive pages for non-hierarchical post types (e.g., posts).

#### `taxonomy_ancestors_show (bool | Default: true)` ####

Whether or not to show the ancestors of a hierarchical term in a taxonomic archive. For a singular post page, whether or not to include taxonomic crumbs in the breadcrumbs.

#### `taxonomy_preferred (string | Default: '')` ####

By default, the breadcrumbs will choose the most popular taxonomy associated with the post if multiple are assigned. Choosing a preferred taxonomy will attempt to choose the assigned taxonomy before falling back to the default method. Will only be applicable on posts that have assigned taxonomies.

#### `excluded_taxonomies (array | Default: array() | Version: 0.0.4+)` ####

An array of taxonomies (names/slugs) that should be excluded from the breadcrumbs. Will only be applicable on singular, non-archive pages for non-hierarchical post types.

#### `taxonomy_excluded_terms (array | Default: array() | Version: 0.0.4+)` ####

An associative array of `'{taxonomy-name}' => array(...)` including the term slugs of that taxonomy that should not be included in the breadcrumbs. This is only applicable on singular, non-archive pages for non-hierarchical post types. See the [above example](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel#using-the-function-set-options) for usage.

### The Last Crumb Options ###

#### `last_show (bool | Default: true)` ####

Whether or not to show the last crumb (the current page) in the breadcrumbs.

#### `last_link (bool | Default: false)` ####

Whether or not the last crumb (the current page) is linked.

#### `last_class (string | Default: 'current')` ####

The class(es) applied to the last crumb if it is shown. May be left blank for no class(es) to be added.

#### `last_id (string | Default: '')` ####

The ID applied to the last crumb if it is shown. May be left blank for no ID to be added.

### The Other Crumb Options ###

#### `404_label (string | Default: 'Page Not Found')` ####

The label for the 404 crumb if `last_show` is true.

#### `search_label (string | Default: 'Search Results')` ####

The label for search results pages if `last_show` is true and `search_query` is false.

#### `search_query (bool | Default: false)` ####

Whether or not to include the search term as a crumb if `last_show` is true. The query string is escaped prior to output via WordPress's `get_search_query()`.

### Post Type Options ###

#### `post_type_show (bool | Default: true)` ####

Whether or not a crumb should be included for the post type of the current page. Will only be applicable on post types where an archive exists.

#### `post_types (array | Default: array())` ####

An associative array of `'{post-type}' => array(...)` including the same options as above, overriding for the keyed post type. These post-type-specific settings override any predefined defaults for the breadcrumbs. See the [above example](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel#using-the-function-set-options) for usage.

## Development ##

### Release History ###

+ [X.X.X](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel) _The Bleeding Edge..._

+ [0.0.5](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel/tree/v0.0.5) _January 4, 2013,_ Updates for WP 3.5 and some minor fixes:

  - Errors related to 'attachment' post type objects & the `get_object_taxonomies()` corrected
  - Excluded custom blog home page crumb for search results and 404 pages
  - Addition of WordPress Repository Plugin files for posterity/convenience

+ [0.0.4](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel/tree/v0.0.4) _October 1, 2012,_ Ability to control and limit which (if any) taxonomies are shown for non-hierarchical post types.

  - Ability to show or hide taxonomy terms on singular non-hierarchical post pages
  - Ability to exclude certain taxonomies from the breadcrumbs
  - Ability to exclude specific terms from the breadcrumbs
  - Can now hide parent terms for taxonomy crumbs on singular post pages
  - Other small bug/formatting fixes...
  
+ [0.0.3](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel/tree/v0.0.3) _August 2, 2012,_ First stable version release.

+ [0.0.2](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel/tree/v0.0.2) _July 31, 2012,_ Refactored to split out Crumb and Wrapper logic into separate classes.

+ [0.0.1](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel/tree/v0.0.1) _July 27, 2012,_ Finished basic breadcrumb generation.

### Upcoming Features ###

+ Admin Menu for end-user friendly customization
+ WP Hook/Filter integration for intercepting the various steps of the breadcrumb generation, for the truly masochistic.
+ Globalization support.

### Want to Help? ###

We'd love to see anything you've got that will improve Hansel & Gretel. Remember, the goal is to make it work for most cases right out of the box! Please be consistent with the project's coding style with your additions.

## Many Thanks! ##

__Plugin Development & Testing:__ [Chris Roche](https://github.com/rodaine)  
__Plugin Development & Testing:__ [Glenn Welser](https://github.com/gwelser)  
__Preliminary Development & Review:__ [Taylor Gorman](https://github.com/taylorgorman)  
__SEO Consultation:__ [Seth Wilson](http://nikdel.com/)  

## License ##

```
Copyright 2012-2013  Clark Nikdel Powell  (email : wordpress@clarknikdelpowell.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
```
