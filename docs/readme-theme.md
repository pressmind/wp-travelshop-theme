# Travelshop theme

## The whole concept
This theme is an example theme for building an enterprise ready travelshop.
It is just a basic boilerplate for creating awesome travelshops based 
on the pressmind® PIM-System. 

## Booking engine 
A booking engine is not included in the theme, but there are two different ways to include a booking engine:

1. Integrate your own booking engine.
2. Use the pressmind® IB3 Booking Engine to connect many customer reservation systems 
(mostly based on the german market, like Kuschick, Bewotec, Blank, turista).
3. If you need a simple booking solution, have a look on the pressmind IB3 Engine. It can also handle 
bookings without a connected crs system in your backoffice.


## The template concept

Speed fst:
1. All WordPress related overload is removed:
(disabled functions: rest_output_link_wp_head, wp_oembed_add_discovery_links, 
rest_output_link_header, rsd_link,wlwmanifest_link, wp_shortlink_wp_head,wp_generator, emojis, etc.)

2. SASS Style, splitted in granular components to build critical path css on a smart way

3. Bootstrap

4. Less JS Frameworks, more pure JS

5. All JS is loaded in the footer

6. WEBP Support

7. Theme for Pros. Less WordPress admin pages, all settings are configured in config files.

## High availability (HA)
It is possible to use this theme for high traffic and availability setups (e.g. AWS, Google, Kubernetes). 
Ask your pressmind team for further information.
(Do not use wordpress plugins - please contact us for further questions.)
 
## Caching
The theme is ready for redis object caching (based on PECL phpredis). It is also possible to use
the pressmind `advanced_cache.php` dropin. For further information ask your pressmind integration manager.
Do not use an other page cache (They are not able to handle pressmind product pages.)

## Amazon S3 
It is possible to store all assets (WordPress media library and the pressmind product images on Amazon S3 storage).
Use the `pressmind S3 Stateless` Plugin for this case.
Do not use an other S3 plugin (They are not able to handle pressmind product pages.)

## SEO Topics

### Headings
Heading hierachy is on most pages present, but please check this based on real world content and modify it by yourself.

### Metadata for product descriptions
All pressmind® media object related pages have title and meta descriptions.
Each title and description can modified directly in the pressmind® PIM application.

**How to edit the generation pattern?**

For **media object detail pages**, see:
```text
config-routing.php:ts_detail_hook()
````

For **media media object default routes**, see:
```text
config-routing.php:ts_search_hook()
````

### Metadata for WordPress posttypes
There is a simple meta description feature included. It's just a sample. See
themes/travelshop/functions/add_meta.php how it works.


### Sitemap
Since 5.5, WordPress has a build in sitemap feature, so
no additional plugins are needed.
The travelshop theme removes unrelated sitemaps like users, categories and 
adds a sitemap for each pressmind related media object type.


### Custom url generation for products
The url generation pattern is based on a defined list of media object values.

See pm-config.php for configuration:
````php
 'media_types_pretty_url' => [
    607 => [
        'prefix' => '/travel/',
        'separator' => '-',
        'fields' => [
            'name',
            'id',
            'destination_default'
        ],
        'strategy' => 'unique',
        'suffix' => '/',
    ],
 ],
 
// generates this: https://www.domain/travel/special-roundtrip-12345-italy/
````


## The template files
* pm-config.php (the pressmind web-core sdk config, look here for database credentials, pressmind api settings or image sizes)
* assets
    * /img (example pictures, do not use in production)
        * img.jpg 
        * logo.svg 
        * slide.jpg|webp
    * /js
        * ajax.js (ajax related functions, used for searching and filtering)
        * autocomplete.min.js (thirdparty framework, used for the autocomplete feature in the searchbar)
        * bootstrap.min.js (thirdparty framework)
        * ion.rangeSlider.min.js (thirdparty framework, used for price and duration slider in filter or searchbar)
        * jquery-3.5.1.min.js (thirdparty framework)
        * moment.min.jsv (thirdparty framework, date formats)
        * search.js (search related stuff, logic for searchfields)
        * ui.js (ui related stuff, like nice animations and so on)
    * /scss (the style)
        * /abstracts
        * /base
        * /components
        * /layout
        * /pages
        * /themes
        * /utils
        * /vendors
        * app.critical.scss
           * app.critical.css (the critical path css, loaded inline in the header)
        * app.scss
            * app.css (the whole css file)
* /cli
    * regenerate-images.php (run, to regenerate WordPress Image Derivates, if you haved changed them)
    * ...
    * import.php (importer for pressmind data)
    * install.php (installs the pressmind data model)
    * integrity_check.php (check/sync the datamodell with the pressmind® PIM)
    
* /functions
    * cleanup_meta_includes.php (removes unnecessary stuff from WordPress)
    * disable_emojis.php (removes unnessary emojis)
    * http_header.php (configures the http header)
    * image-sizes.php (defines the WordPress images sizes)
    * menus.php (menu related stuff)
    * the_breadcrumb.php (a nice breadcrumb function, with pressmind category tree support)
    * theme_support.php (enables some theme features)
    
* /src
    * AdminPage.php (themes admin page)
    * BuildSearch.php (abstracts get parameter for the complex pressmind, see section GET-Requests/Deeplinks)
    * PluginActivation.php 
    * Route.php (part of routing)
    * RouteProcessor.php (part of routing)
    * Router.php (part of routing)
    * Shortcodes.php (enables the shortcode feature for pressmind search query)
    * WPFunctions.php
    
* /template-parts
    * /content (post-type specific templates)
        * content.php
        * content-page.php
        * content-post.php
        * content-single.php
    * /layout-blocks
        * 404.php
        * icon-teaser.php
        * image-teaser.php
        * info-teaser.php
        * jumbotron.php
        * product-teaser.php
        * search-header.php
    * /pm-search (search & filter related templates)
        * /filter 
            * category-tree.php
            * order.php
            * price-range.php
        * /search
            * category-tree-dropdown.php
            * date-picker.php
            * string-search.php
        * filter-vertical.php
        * result.php
        * result-pagination.php
        * search-bar.php
    * /pm-views (pressmind views, you need a view for each pressmind media_object type)
        *   Reise_Detail1.php (Media Object Type "Reise" Detailview)
        *   Reise_Teaser1.php (Media Object Type "Reise" view as teaser, in use on the start page or as search result)
        *   *_Example.php (during installation pressmind web-core sdk is creating some fullblown examples, named by *_Example.php)
    * /wp-views (wordpress views)
        *   image-teaser-view.php 
        *   info-teaser-view.php
* /vendor (home of the pressmind web-core sdk)
    * ...
    * /pressmind
                
* 404.php
* composer.json
* config-routing.php (setup a custom routing here)
* config-theme.php (some theme related settings, do not put the constant to the wp-config.php, this file is also used for a WordPressless Bootstrap in some file, like the pm-ajax-endpoint.php)
* footer.php
* functions.php (the main theme bootstrap)
* header.php 
* index.php (startpage)
* install.php (called from composer.json on post install, you can delete it in the production enviroment)
* pm-ajax-endpoint.php (the ajax endpoint is for pressmind data only, currently it is mostly in use for the ajax base product search)
* pm-detail.php (the product page, the url/base route is configured in config-routing.php, you can setup a special page for each pressmind media object type)
* pm-preview.php (this url is called from pressmind PIM, it is just a redirect to preview the detailpage - do not edit this file)
* pm-search.php (the search site, the url is configured in config-routing.php)
* readme.md
* readme-theme.md
* singular.php
* style.css (only a theme description, will not be loaded)

## Icons
Icons are currently used from https://tablericons.com/ (SVG only - no icon fonts).
                
        
        
     
        








