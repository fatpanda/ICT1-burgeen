<?php
/**
 * WiseLoop Web Grabber Parameter class definition<br/>
 * Objects of this type holds the information needed by wlWgProcessor object
 * to search and process the HTML content loaded from the web<br/>
 * @see wlWgProcessor
 * @author WiseLoop
 */
class wlWgParam {
    /**
     * @var string the tag to be searched by the wlWgProcessor object;
     * wlWgProcessor will return the contents of the tag specified here;
     * an incomplete tag can be specified also, the tag will autocomplete depending on the searched HTML content
     */
    public $tagSlice;

    /**
     * @var array an array consisting of two variables (stored in keys "search" and "replace") used by str_replace function on the search result;
     * use this if you want to get rid of, or replace any unwanted strings from the grabbed content;
     */
    public $replaceStrings;

    /**
     * @var array tags to be removed completely from the result;
     * wlWgProcessor will remove these tags and their contents from the result;
     * incomplete tags can be specified also, the tags will autocomplete depending on the contextual HTML content;<br/>
     * Use this if you want to get rid of any unwanted tags from the result (ie. following some targeted site terms of usage conditions).
     * For example, there are sites that allow to use their text contents in other sites, but does not allow to unse 'in-line' image reffering,
     * that is, you cannot display images hosted on the target site on your site by using in your site tags like this: &lt;img src='target_site.com/image.jpg'/&gt; wich can exists in the grabbed content.<br/>
     * If you live the grabbed content like this, you will break targeted site terms of usage conditions.<br/>
     * To avoid this, you should load a sliced tag definition in $removeTags array like this: array('<img src='target_site.com/'),
     * this will ensure that all the images hosted on the target site will not be used and displayed on your site and so, you will not break any terms of usage conditions.
     */
    public $removeTags;

    /**
     * @var array tags to be stripped inside the resulted content;
     * wlWgProcessor will strip these tags and leave only their inner contents
     * incomplete tags can be specified also, the tags will autocomplete depending on the contextual HTML content
     */
    public $stripTags;

    /**
     * Constructor.<br/>
     * Creates a wlWgParam object
     * @param string $tagSlice the tag to be searched by wlGwProcessor object
     * @param array $replaceStrings an array consisting of two variables (stored in keys "search" and "replace") used by str_replace function on the search result
     * @param array $removeTags tags to be removed completely from the grabbed content;
     * wlWgProcessor will remove these tags and their contents from the result;
     * incomplete tags can be specified also, the tags will autocomplete depending on the HTML content;<br/>
     * Use this if you want to get rid of any unwanted tags from the result (ie. following some targeted site terms of usage conditions).
     * For example, there are sites that allow to use their text contents in other sites, but does not allow to unse 'in-line' image reffering,
     * that is, you cannot display images hosted on the target site on your site by using in your site tags like this: &lt;img src='target_site.com/image.jpg'/&gt; wich can exists in the grabbed content.<br/>
     * If you live the grabbed content like this, you will break targeted site terms of usage conditions.<br/>
     * To avoid this, you should load a sliced tag definition in $removeTags array like this: array('<img src='target_site.com/'),
     * this will ensure that all the images hosted on the target site will not be used and displayed on your site and so, you will not break any terms of usage conditions.
     * @param array $stripTags tags to be stripped inside the result;
     * wlWgProcessor will strip these tags and leave only their inner contents;<br/>
     * incomplete tags can be specified also, the tags will autocomplete depending on the contextual HTML content
     * @return void
     */
    public function __construct($tagSlice = null, $replaceStrings = null, $removeTags = null, $stripTags = null) {
        $this->setTag($tagSlice);
        $this->replaceStrings = $replaceStrings;
        $this->setRemoveTags($removeTags);
        $this->setStripTags($stripTags);
    }

    /**
     * Sets the tag to be searched by wlWgProcessor object
     * @param string $tagSlice the tag to be searched by wlGwProcessor object
     * @return void
     */
    public function setTag($tagSlice = null) {
        if(!$tagSlice)
            $tagSlice = '<body';
        $this->tagSlice = wlHtmlDom::cleanTag($tagSlice);
    }

    /**
     * Returns the tag to be searched by wlWgProcessor object
     * @return string
     */
    public function getTag() {
        return $this->tagSlice;
    }

    /**
     * Sets tags array to be removed completely from the result;
     * wlWgProcessor will remove these tags and their contents from the result
     * @param array|string $removeTags
     * @return void
     */
    public function setRemoveTags($removeTags) {
        if(isset($removeTags))
        {
            if(is_array($removeTags))
                foreach($removeTags as $removeTag)
                    $this->addTagToRemove($removeTag);
            elseif(is_string($removeTags))
                $this->addTagToRemove($removeTags);
        }
    }

    /**
     * Sets tags array to be stripped inside the resulted content;
     * wlWgProcessor will strip these tags and leave only their inner contents
     * @param array|string $stripTags
     * @return void
     */
    public function setStripTags($stripTags) {
        if(isset($stripTags))
        {
            if(is_array($stripTags))
                foreach($stripTags as $stripTag)
                    $this->addTagToStrip($stripTag);
            elseif(is_string($stripTags))
                $this->addTagToStrip($stripTags);
        }
    }

    /**
     * Appends a tag to $removeTags list; incomplete tag can be specified also, the tag will autocomplete depending on the contextual HTML content
     * @param string $tagSlice
     * @return void
     */
    public function addTagToRemove($tagSlice) {
        if(!$this->removeTags)
            $this->removeTags = array();
        $this->removeTags[] = wlHtmlDom::cleanTag($tagSlice);
    }

    /**
     * Appends a tag to $stripTags list; incomplete tag can be specified also, the tag will autocomplete depending on the contextual HTML content
     * @param string $tagSlice
     * @return void
     */
    public function addTagToStrip($tagSlice) {
        if(!$this->stripTags)
            $this->stripTags = array();
        $this->stripTags[] = wlHtmlDom::cleanTag($tagSlice);
    }

    /**
     * Appends a search/replace pair values to $replaceStrings list
     * @param string $search
     * @param string $replace
     * @return void
     */
    public function addStringReplacement($search, $replace) {
        if(!$this->replaceStrings)
            $this->replaceStrings = array(
                "search" => array(),
                "replace" => array()
            );
        $this->replaceStrings["search"][] = $search;
        $this->replaceStrings["replace"][] = $replace;
    }
}
?>