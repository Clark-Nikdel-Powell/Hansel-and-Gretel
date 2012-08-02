# Hansel & Gretel #
_A WordPress Breadcrumb Generator Plugin_

> #### NOTE ####
> This plugin is still in active development and __SHOULD NOT__ be used in production.
> Watch this repo to see when this plugin is ready for the real world!

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
Upload the plugin, activate via the WordPress admin, and drop the function where you want the breadcrumbs to appear in your template. Done! [Read on](#) for the juicy details.

+ __Fine-Tuned Control__  
H&G works right out of the box, but oftentimes we want custom control. Nearly every aspect of the breadcrumbs rendering can be changed a'la the [myriad of options](#) available, either at the function call or via the provided admin menu (coming soon).

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
__Actually Tested Versions__ 3.3.2, 3.4.1

If you find it non-operational on your particular flavor of WP, please let us know. 

### Instructions ###

1. Download the [zip archive](https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel/zipball/master) and extract the contents. Alternatively, you could clone this repo to your local machine and always have an up-to-date version.

2. Make sure you're running Wordpress 3.1.0 or better. It won't work with older versions.

3. Upload the `Hansel-and-Gretel` folder to your plugins directory (`/wp-content/plugins/Hansel-and-Gretel`).

4. Activate the plugin through the Plugins page on the WordPress admin.

5. Add the following snippet to your theme file(s) outside [The Loop](http://codex.wordpress.org/the_loop) where you want the breadcrumbs to appear:  
```php
  <?php if (function_exists('HAG_Breadcrumbs')) { HAG_Breadcrumbs(); } ?>
```
 
6. Profit!

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
	'prefix' => 'You are here: ',
	'last_link'  => true,
	'separator'  => '|',
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

The above example sets the prefix for the breadcrumbs to `You are here: `, adds the link to the last crumb, and changes the separator to the pipe (`|`). When on a `gizmo` post-type page, the last crumb is set not to show and the taxonomy crumbs will be categories. Likewise, on a `whatzit` post-type page, The separator has been overriden to show `&raquo;` (&raquo;) instead.

### Debug ###

### Wrapper ###

### Crumbs ###

### The Home Crumb ###

### Taxonomies ###

### The Last Crumb ###

### Post Types ###

## Development ##

### Release History ###

### Upcoming Features ###

### Want to Help? ###

## Many Thanks! ##

## License ##
