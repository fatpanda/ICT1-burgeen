<?php
/**
 * WiseLoop Web Grabber Plugin Engine class definition<br/>
 * Static class used to instantiate and run the grabber engine
 * @author WiseLoop
 */
class wlWgPluginEngine
{
    const ATTR_TITLE = 'title';
    const ATTR_URL = 'url';
    const ATTR_TAG = 'tag';
    const ATTR_CACHE = 'cache';
    const ATTR_REMOVE_TAG = 'rtag';
    const ATTR_STRIP_TAG = 'stag';
    const ATTR_SEARCH_STR = 'srch';
    const ATTR_REPLACE_STR = 'repl';

    /**
     * Tests if the given parameter is a recognized attribute type and returns that type
     * @param string $attrName
     * @return string
     */
    public static function getAttrType($attrName) {
        if (substr($attrName, 0, strlen(self::ATTR_URL)) == self::ATTR_URL)
            return self::ATTR_URL;
        elseif (substr($attrName, 0, strlen(self::ATTR_TITLE)) == self::ATTR_TITLE)
            return self::ATTR_TITLE;
        elseif (substr($attrName, 0, strlen(self::ATTR_TAG)) == self::ATTR_TAG)
            return self::ATTR_TAG;
        elseif (substr($attrName, 0, strlen(self::ATTR_CACHE)) == self::ATTR_CACHE)
            return self::ATTR_CACHE;
        elseif (substr($attrName, 0, strlen(self::ATTR_REMOVE_TAG)) == self::ATTR_REMOVE_TAG)
            return self::ATTR_REMOVE_TAG;
        elseif (substr($attrName, 0, strlen(self::ATTR_STRIP_TAG)) == self::ATTR_STRIP_TAG)
            return self::ATTR_STRIP_TAG;
        elseif (substr($attrName, 0, strlen(self::ATTR_SEARCH_STR)) == self::ATTR_SEARCH_STR)
            return self::ATTR_SEARCH_STR;
        elseif (substr($attrName, 0, strlen(self::ATTR_REPLACE_STR)) == self::ATTR_REPLACE_STR)
            return self::ATTR_REPLACE_STR;
    }

    /**
     * Creates a web grabber object, runs it and returns the extracted contents
     * @param string $url the real target url to be parsed, scanned and processed
     * @param string $tag the tag to extract
     * @param int $cache cache time
     * @param array $replaceStrings an array consisting of two variables (stored in keys "search" and "replace") used by str_replace function on the search result
     * @param array $removeTags tags to be removed completely from the result
     * @param array $stripTags tags to be stripped inside the resulted content
     * @return string the extracted and processed content
     */
    public static function runEngine($url, $tag, $cache, $replaceStrings, $removeTags, $stripTags) {
        if ($url) {
            require_once dirname(__FILE__) . "/bin/wlWg.php";
            if (null === $cache)
                $cache = wlWgConfig::DEFAULT_CACHE_TIME;

            $wg = new wlWgProcessor(
                $url,
                new wlWgParam($tag, $replaceStrings, $removeTags, $stripTags),
                $cache
            );
            $wg = $wg->get();
            return $wg[0];
        }
        return '';
    }

    /**
     * Executes a shortcode or a widget
     * @param array $array an array that can contain shortcode attributes or an instance of a widget
     * @return string the extracted and processed content
     */
    public static function runEngineArray($array) {
        $url = null;
        $tag = null;
        $cache = null;
        $removeTags = array();
        $stripTags = array();
        $replaceStrings = array(
            'search' => array(),
            'replace' => array()
        );

        foreach ($array as $attrName => $attrValue)
        {
            $attrType = self::getAttrType($attrName);
            if ($attrType == self::ATTR_URL)
                $url = $attrValue;
            elseif ($attrType == self::ATTR_TAG)
                $tag = $attrValue;
            elseif ($attrType == self::ATTR_CACHE)
                $cache = intval($attrValue);
            elseif ($attrType == self::ATTR_REMOVE_TAG)
                $removeTags[] = $attrValue;
            elseif ($attrType == self::ATTR_STRIP_TAG)
                $stripTags[] = $attrValue;
            elseif ($attrType == self::ATTR_SEARCH_STR)
                $replaceStrings['search'][] = $attrValue;
            elseif ($attrType == self::ATTR_REPLACE_STR)
                $replaceStrings['replace'][] = $attrValue;
        }

        return self::runEngine($url, $tag, $cache, $replaceStrings, $removeTags, $stripTags);
    }
}
?>