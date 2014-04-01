<?php
/*
Plugin Name: WiseLoop Web Grabber
Plugin URI: http://wiseloop.com/phpwebgrabber
Description: Allows grabbing, extracting and inserting web contents in your blog
Version: 1.2.2
Author: WiseLoop
Author URI: http://wiseloop.com
*/

/**
 * @page changelog Changelog
 * @section v122 Version 1.2.2, released on 2011-05-07
 * Initial release
 *  @section v141 Version 1.4.1, released on 2011-05-17
 * - added custom fields support: you can use the <em>webgrab</em> shortcode in within a custom field to grab and fill with web contents any custom field you have; 
 * - grabber engine updated: smarter cURL - opening and parsing urls is done now with a real internet browser signature;
 * - documentation update.
 */

/**
 * @mainpage WiseLoop Web Grabber WordPress Plugin
 * If you want to embed various contents from public web sites into your WordPress blog, then the Web Grabber WordPress Plugin is the perfect tool that will help you do that.<br/>
 * No frames or iframes involved! Real HTML content, grabbed form the web and displayed in whithin your blog just like you wrote it by yourself.
 *
 * @section description Plugin Description
 * WiseLoop Web Grabber WordPress Plugin is designed to extract HTML content form the web and then, display them in within your blog.<br/>
 * This WordPress plugin allows complex content extraction and embedding in a very flexible manner, by using WordPress <strong>shortcodes</strong> or <strong>widgets</strong>.
 * The extraction can be made from any web URL or local file; the desired content to be grabbed can be a full web page or a tag that can even have incomplete specifications.<br/>
 * Shortcode and widget can setup the grabbing engine to perform some additional after-extraction processing:
 * - tags removal from the raw grabbed contents, so you can get rid of any unwanted tags and their contents;
 * - tags stripping of the raw grabbed contents, so you can leave only their inner contents;
 * - string replacement (just like the str_replace function) in the raw grabbed contents, so you can alter the results in a personalized manner;
 * 
 * These after-extraction capabilities can enhance the results, saves storage space, enhances speed and really can help to fullfill the terms of usage of the web page that is grabbed.<br/>
 * The caching feature improves speed, saves bandwidth, prevents useless parsing and procesing of the grabbed web pages, by storing in the cache the resulting processed contents for a given URL and set of tags and after-extraction settings.<br/>
 * The choosen programming model allows the development of a personalized widget library based on its simple, but yet smart tag HTML DOM parser and processor.
 *
 * @section features Main Features
 * - <strong>WordPress shortcode</strong> provided to embed extracted web contents in within pages, posts or custom fields;
 * - <strong>WordPress Widget</strong> provided to configure and embed extracted web contents in within sidebars;
 * - grab any resource having HTML content (web or local);
 * - smart grabbing engine;
 * - tag based search and extraction (incompete tags accepted);
 * - tag autocomplete based on the full extracted HTML content from the parsed URL;
 * - tags removal from the raw grabbed content capability;
 * - tags striping of the raw grabbed content capability;
 * - string replacement on the raw grabbed content capability;
 * - smart caching for fast processing;
 * - technical documentation for the grabbing engine provided also;
 * - easy development and extension of the personalized widget library (sample widgets included: Google and Yahoo Search);
 * - lightweight and easy to use;
 *
 * @section shortguide Short Guide
 * @subsection shortcode Using the shortcode feature
 * - Example 1: Very simple grabbing of first paragraph from the WordPress website<br/>
 * @code[webgrab url='http://wordpress.org/about/' tag='<p class="intro">']@endcode
 * - Example 2: A little more complex grabbing with some tags removal<br/>
 * @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rtag4='<div class="templatedaily">']@endcode
 * You can add unlimited number of tags to be removed from the output: use shortcode attributes that starts with <em>rtag</em>
 * - Example 3: Grabbing with some tags removal and ssome tags stripping<br/>
 * @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rag4='<div class="templatedaily">' stag1='<a' stag2='<span class="title">']@endcode
 * You can add unlimited number of tags to be stripped of the output: use shortcode attributes that starts with <em>stag</em>
 * - Example 4: Grabbing with tags removal, tags stripping and string replacements<br/>
 * @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rtag4='<div class="templatedaily">' stag1='<a' stag2='<span class="title">' srch1='class="ss"' repl1='style="display:block;"' srch2='class="title"' repl2='style="display:block;"']@endcode
 * You can add unlimited number of search/replace pairs to be passed to processor: for needle, use shortcode attributes that starts with <em>srch</em>, and for replace, use shortcode attributes that starts with <em>repl</em>
 * - Example 5: Grabbing with tags removal, tags stripping and string replacements - advanced custom own design formatting<br/>
 * @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rtag4='<div style="clear:' rtag5='<div class="clear">' rtag6='<div style="margin-left:31px;display:block;">' rtag7='<div class="templatedaily">' srch1='class="title"' repl1='style="display:block;font-size:16px;font-weight:bold;margin-bottom:5px;background-color:#dedede;padding:2px;border:1px solid #ababab;"' srch2='class="ss"' repl2='style="display:block;margin-bottom:10px;"' srch3='class="download"' repl3='style="margin-top:17px;padding:5px;font-weight:bold;text-decoration:none;border:1px solid #ababab;background-color:#dedede;color:#000000;"' srch4='class="preview"' repl4='style="margin-top:17px;padding:5px;font-weight:bold;text-decoration:none;border:1px solid #ababab;background-color:#dedede;color:#000000;"' srch5='class="getwix"' repl5='style="margin-top:17px;padding:5px;font-weight:bold;text-decoration:none;border:1px solid #ababab;background-color:#dedede;color:#000000;"' srch6='class="templateleft"' repl6='style="padding:10px 0 10px 0;border-bottom:1px solid #ababab;"' srch7='class="templateright"' repl7='style="padding:10px 0 10px 0;border-bottom:1px solid #ababab;"'/]@endcode
 *
 * @subsection widget Using the widget feature
 * Basicly, the <strong>widget</strong> feature offers a simple interface to setup a grabber engine, and then, it diplays the grabbed content into the blog sidebar.<br/>
 * Also, the package contains two sample widgets in order to demonstrate the powerfull extension capabilities of WiseLoop Web Grabber WordPress Plugin.<br/>
 * You can extend this library with more widgets that handles web grabbed content; your imagination is the limit.
 *
 * @section requirements Requirements
 * - WordPress 3.0 or newer
 *
 * @section installation Installation Instructions
 * - Step 1: make a folder named /webgrabber-wordpress-plugin under the /wp-content/plugins directory;
 * - Step 2: copy entire archive contens to the new created /wp-content/plugins/webgrabber-wordpress-plugin folder;
 * - Step 3: make sure that the /wp-content/plugins/webgrabber-wordpress-plugin/engine/cache directory is writable;
 * - Step 4: activate the plugin through the 'Plugins' menu in WordPress administration page;
 * - Step 5: use [webgrab] short code into posts/pages editor, or drag and configure a widget under the 'Appearance/Widgets' section  
 *
 * @section info Information
 * - Project Name: WiseLoop Web Grabber WordPress Plugin
 * - Project Website: http://wiseloop.com/product/webgrabber-wordpress-plugin
 * - Online Tutorial: http://wiseloop.com/tutorial/webgrabber-wordpress-plugin
 * - Online Demonstration: http://wiseloop.com/wordpress-plugins/webgrabber
 * - Author: WiseLoop, http://www.wiseloop.com/contact/webgrabber-wordpress-plugin
 * - Tags: web grabber wordpress plugin, web extractor wordpress plugin, web scrapper wordpress plugin, web harvester wordpress plugin, web ripper wordpress plugin, web processor wordpress plugin, html processor wordpress plugin, html grabber wordpress plugin, html extractor wordpress plugin, html ripper wordpress plugin, tag extractor wordpress plugin, tag ripper wordpress plugin, tag processor wordpress plugin, HTML DOM parser wordpress plugin
 *
 * @subsection Note
 * WiseLoop assumes no responsibility for any abusive use of this software product and/or violation of any terms of usage of the grabbed web pages.<br/>
 * If you decide to use this software product, do it with responsibility and make sure that you are allowed to display the grabbed HTML contents from the desired web page by checking its terms of usage.<br/>
 */

/**
 * @page tutorial1 Quick Guide
 * @section installation Instalation
 * - Step 1: make a folder named /webgrabber-wordpress-plugin under the /wp-content/plugins directory;
 * - Step 2: copy entire archive contens to the new created /wp-content/plugins/webgrabber-wordpress-plugin folder;
 * - Step 3: make sure that the /wp-content/plugins/webgrabber-wordpress-plugin/engine/cache directory is writable;
 * - Step 4: activate the plugin through the 'Plugins' menu in WordPress administration page;
 * @image html wlwg-wpp-install.jpg "Activate the plugin through the Plugins menu in WordPress administration;
 * - Step 5: use [webgrab] short code into posts/pages editor, or drag and configure a widget under the 'Appearance/Widgets' section
 *
 * @section shortcode Using the shortcode feature
 * The sortcode feature allows insertion of web grabbed contents into your posts or pages.<br/>
 * Here are some sample usages:
 * @subsection example1 Example 1: Very simple grabbing of first paragraph from the WordPress website
 * The shortcode: @code[webgrab url='http://wordpress.org/about/' tag='<p class="intro">']@endcode
 * The result: @image html wlwg-wpp-example1.jpg "[webgrab] shortcode sample: simple web grabbing"
 * @subsection example2 Example 2: A little more complex grabbing with some tags removal
 * The shortcode: @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rtag4='<div class="templatedaily">']@endcode
 * You can add unlimited number of tags to be removed from the output: use shortcode attributes that starts with <em>rtag</em>.<br/>
 * The result: @image html wlwg-wpp-example2.jpg "[webgrab] shortcode sample: web grabbing with tag removals"
 * @subsection example3 Example 3: Grabbing with some tags removal and some tags stripping
 * The shortcode: @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rag4='<div class="templatedaily">' stag1='<a' stag2='<span class="title">']@endcode
 * You can add unlimited number of tags to be stripped of the output: use shortcode attributes that starts with <em>stag</em>.<br/>
 * The result: @image html wlwg-wpp-example3.jpg "[webgrab] shortcode sample: web grabbing with tag removals and tag striping"
 * @subsection example4 Example 4: Grabbing with tags removal, tags stripping and string replacements
 * The shortcode: @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rtag4='<div class="templatedaily">' stag1='<a' stag2='<span class="title">' srch1='class="ss"' repl1='style="display:block;"' srch2='class="title"' repl2='style="display:block;"']@endcode
 * You can add unlimited number of search/replace pairs to be passed to processor: for needle, use shortcode attributes that starts with <em>srch</em>, and for replace, use shortcode attributes that starts with <em>repl</em>.<br/>
 * The result: @image html wlwg-wpp-example4.jpg "[webgrab] shortcode sample: web grabbing with tag removals, tag striping and string processing"
 * @subsection example5 Example 5: Grabbing with tags removal, tags stripping and string replacements - advanced
 * The shortcode: @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='h1' rtag2='<div class="pages"' rtag3='<div class="about">' rtag4='<div style="clear:' rtag5='<div class="clear">' rtag6='<div style="margin-left:31px;display:block;">' rtag7='<div class="templatedaily">' srch2='class="ss"' repl2='style="display:block;"'/]@endcode
 * The result: @image html wlwg-wpp-example5.jpg "[webgrab] shortcode sample: web grabbing with tag removals, tag striping and string processing"
 * @subsection example6 Example 6: Advanced grabbing with tags removal, tags stripping and string replacements - applying custom own design formatting
 * The shortcode: @code[webgrab url='http://www.freewebsitetemplates.com' tag='<div id="leftside">' rtag1='<h1>' rtag2='<div class="pages"' rtag3='<div class="about">' rtag4='<div style="clear:' rtag5='<div class="clear">' rtag6='<div style="margin-left:31px;display:block;">' rtag7='<div class="templatedaily">' srch1='class="title"' repl1='style="display:block;font-size:16px;font-weight:bold;margin-bottom:5px;background-color:#dedede;padding:2px;border:1px solid #ababab;"' srch2='class="ss"' repl2='style="display:block;margin-bottom:10px;"' srch3='class="download"' repl3='style="margin-top:17px;padding:5px;font-weight:bold;text-decoration:none;border:1px solid #ababab;background-color:#dedede;color:#000000;"' srch4='class="preview"' repl4='style="margin-top:17px;padding:5px;font-weight:bold;text-decoration:none;border:1px solid #ababab;background-color:#dedede;color:#000000;"' srch5='class="getwix"' repl5='style="margin-top:17px;padding:5px;font-weight:bold;text-decoration:none;border:1px solid #ababab;background-color:#dedede;color:#000000;"' srch6='class="templateleft"' repl6='style="padding:10px 0 10px 0;border-bottom:1px solid #ababab;"' srch7='class="templateright"' repl7='style="padding:10px 0 10px 0;border-bottom:1px solid #ababab;"'/]@endcode
 * The result: @image html wlwg-wpp-example6.jpg "[webgrab] shortcode sample: web grabbing with tag removals, tag striping and string processing"
 * @note Please observe the incomplete tag specifications in examples above; they behave like some kind of markers that selects the tags that contains in their definitions that specifications
 *
 * @section widget Using the widget feature
 * Basicly, the <strong>widget</strong> feature offers a simple interface to setup a grabber engine.
 * @subsection Example: Advanced grabbing from freewebsitetemplates.com with costom own formatting style attributes
 * <table border="0"><tr>
 * <td>@image html wlwg-wpp-widget-grabber-setup.jpg "WiseLoop Web Grabber WordPress Widget admin screenshot"</td>
 * <td>@image html wlwg-wpp-widget-grabber-run.jpg "WiseLoop Web Grabber WordPress Widget running screenshot"</td>
 * </tr></table>
 * @note Please observe the incomplete tag specifications in examples above; they behave like some kind of markers that selects the tags that contains in their definitions that specifications
 *
 * @section library The included sample widget library
 * The package contains also two sample widgets in order to demonstrate the powerfull extension capabilities of WiseLoop Web Grabber WordPress Plugin.<br/>
 * You can extend this library with more widgets that handles web grabbed content; your imagination is the limit.
 * @image html wlwg-wpp-widget-search-engine-setup.jpg "Google Search and Yahoo Search sample widgets - admin area"
 * <table border="0"><tr>
 * <td>@image html wlwg-wpp-google-run.jpg "Google search widget - at runtine"</td>
 * <td>@image html wlwg-wpp-yahoo-run.jpg "Yahoo search widget - at runtine"</td>
 * </tr></table>
 */
require_once dirname(__FILE__).'/engine/wlWgPluginEngine.php';

/**
 * WiseLoop Web Grabber WordPress Plugin class definition<br/>
 * This class registers the grabbing WordPress widgets, the WordPress <em>"webgrab"</em> shortcode and the plugin itself
 * @author WiseLoop
 */
class wlWgPlugin {
    /**
     * The constructor.
     * @return void
     */
    public function __construct() {
        add_shortcode('webgrab', array($this, 'shortcode'));
        add_filter('the_meta_key', array($this, 'meta'));
    }

    /**
     * Runs the engine with the shortcode attributes
     * @param array $attrs
     * @return void
     */
    public function shortcode($attrs) {
        return wlWgPluginEngine::runEngineArray($attrs);
    }

    /**
     * Runs the engine over the custom fields contents
     * @param string $metas
     * @return string
     */
    public function meta($metas) {
        return do_shortcode($metas);
    }
}

/**
 * Plugin regisration
 * @return void
 */
function registerWlWgPlugin() {
    global $wlWgHandler;

    $wlWgHandler = new wlWgPlugin();
}

/**
 * Widget library registration
 * @return void
 */
function registerWlWgWidgets() {
    $dh = @opendir(dirname(__FILE__).'/widget');
    if ($dh) {
        while (false !== ($file = readdir($dh))) {
            if ('.' !== $file && '..' !== $file && 'wlWgWidget' == substr($file, 0, 10)) {
                require_once dirname(__FILE__) . '/widget/'.$file;
                register_widget(str_ireplace('.php', '', $file));
            }
        }
        @closedir($dh);
    }
}

add_action('init', 'registerWlWgPlugin');
add_action('widgets_init', 'registerWlWgWidgets');

?>
