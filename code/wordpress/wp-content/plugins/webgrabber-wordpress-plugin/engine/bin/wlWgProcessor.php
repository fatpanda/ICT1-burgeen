<?php
/**
 * WiseLoop Web Grabber Processor class definition<br/>
 * This class is designed to retreive various tag contents from an url and stores them in the $_result variable.<br/>
 * Also, it is capable to do some processing (string replacements and tags removal) on the extracted contents.<br/>
 * The information needed to extract and process must be provided into one array consisting of a list of wlWgParam objects.
 * @note WiseLoop takes no responsibility if the targeted url changes its tag structure or its HTML DOM tree, resulting in unexpected data retrieval;
 * this will not be considered as malfunction or bug, and you should check the targeted url's HTML DOM tree for changes and modify the code that instatiates this class or any inherited classes.<br/>
 * Also, WiseLoop assumes no responsibility for any abusive use of this class and/or violation of terms of usage of the target url.
 * @see wlWgParam
 * @author WiseLoop
 */
class wlWgProcessor {
    /**
     * String used as a separator when writting to cache the different grabbed contents extracted from the same url
     */
    const DELIMITER = "<!--WLWG-->";

    /**
     * @var wlCurl the real target url to be parsed, scanned and processed
     */
    private $_curl;

    /**
     * @var array|wlWgParam the parameters that contains the information to extract and process the full grabbed content of the $_targetUrl
     */
    private $_params;

    /**
     * @var int caching time expressed in minutes
     * @see wlWgConfig
     */
    private $_cacheTime;

    /**
     * @var array the resulting processed grabed contents
     */
    private $_result;

    /**
     * Constructor.<br/>
     * Creates a wlWgProcessor object.
     * @param string $targetUrl real target url to be parsed, scanned and processed
     * @param array|wlWgParam $params the parameters that contains the information to extract and process the full grabbed content of the $_targetUrl
     * @param int $cacheTime
     * @return void
     */
    public function __construct($targetUrl, $params = null, $cacheTime = wlWgConfig::DEFAULT_CACHE_TIME) {
        $this->setUrl($targetUrl);
        if (is_array($params)) {
            $this->_params = $params;
        }else {
            $this->_params = array($params);
        }
        $this->_cacheTime = $cacheTime;
        $this->_result = null;
    }

    /**
     * Sets the target url to be parsed, scanned and processed
     * @param string $targetUrl real target url to be parsed, scanned and processed
     * @return void
     */
    public function setUrl($targetUrl) {
        if(!isset($this->_curl)) {
            $this->_curl = new wlCurl($targetUrl);
        }
        $this->_curl->setUrl($targetUrl);
    }

    /**
     * Returns the target url string to be parsed, scanned and processed
     * @return string
     */
    public function getUrl() {
        return $this->_curl->getUrl();
    }

    /**
     * Sets the caching time
     * @param int $cacheTime the new caching time expressed in minutes
     * @return void
     */
    public function setCacheTime($cacheTime) {
        $this->_cacheTime = $cacheTime;
    }

    /**
     * Returns the caching time
     * @return int the cache time
     */
    public function getCacheTime() {
        return $this->_cacheTime;
    }

    /**
     * Appends a wlWgParam object to the $_params list
     * @param wlWgParam $param
     * @return void
     */
    public function addParam($param) {
        $this->_params[] = $param;
    }

    /**
     * Removes all the wlWgParam objects from parameters list
     * @return void
     */
    public function removeParams() {
        unset($this->_params);
        $this->_params = null;
    }

    /**
     * Parses the $_targetUrl contents and fills the $_result with the grabbed contents obtained by processing all the parameters founded in $_params against the $_targetUrl's contents.
     * @return void
     */
    private function process() {
        $ret = array();
        try
        {
            $urlContent = $this->loadUrl();
        } catch (Exception $ex)
        {
            $this->_result = array($ex->getMessage());
            return;
        }

        /**
         * @var wlWgParam $param
         */
        if(isset($this->_params)) {
            foreach ($this->_params as $param) {
                $content = $urlContent;
                if (isset($param->tagSlice)) {
                    $content = wlHtmlDom::getTagContent($content, $param->tagSlice);
                    if (false === $content) {
                        $content = htmlentities(sprintf("Tag %s not found.", $param->tagSlice));
                    }
                    else
                    {
                        if (isset($param->removeTags)) {
                            if (is_array($param->removeTags)) {
                                foreach ($param->removeTags as $rTag) {
                                    $rTagContents = wlHtmlDom::getTagContents($content, $rTag);
                                    $content = str_replace($rTagContents, '', $content);
                                }
                            }
                        }

                        if (isset($param->stripTags)) {
                            if (is_array($param->stripTags)) {
                                foreach ($param->stripTags as $sTag) {
                                    $sTagContentsFull = wlHtmlDom::getTagContents($content, $sTag, false);
                                    $sTagContentsStripped = wlHtmlDom::getTagContents($content, $sTag, true);
                                    $content = str_replace($sTagContentsFull, $sTagContentsStripped, $content);
                                }
                            }
                        }

                        if (isset($param->replaceStrings)) {
                            $search = wlWgUtils::getArrayValue($param->replaceStrings, array("search", 0), "");
                            $replace = wlWgUtils::getArrayValue($param->replaceStrings, array("replace", 0), "");

                            if ('' !== $search) {
                                $content = str_replace($search, $replace, $content);
                            }
                        }
                    }
                    $ret[] = $content;
                }
            }
        }
        $this->_result = $ret;

        if ($this->_cacheTime) {
            $this->saveCache();
        }
    }

    /**
     * Reads an entire content of the $_targetUrl
     * @return string the contens of the $_targetUrl
     */
    private function loadUrl() {
        if (!$this->_curl->getExists()) {
            $msg = '<div class="error">';
            $msg .= 'URL "'.$this->_curl->getUrl().'" does not exist, is not readable or is protected against scraping.<br/>';
            $msg .= 'Check if your IP address "'.$_SERVER["SERVER_ADDR"].'" has access permission to this URL.<br/>';
            if(!wlCurl::isCurlEnabled() || !wlCurl::isFopenEnabled()) {
                $msg .= wlCurl::getUnableMessage();
            }
            $hdrs = $this->_curl->getHeaders();
            if(isset($hdrs)) {
                $msg .= 'Headers received:<br/>';
                $msg .= ('<pre>'.print_r($hdrs, true).'</pre>');
            }
            $msg .= '</div>';

            throw new Exception($msg);
        }

        return $this->_curl->getContents();
    }

    /**
     * Loads the results form the cache.
     * @return void
     */
    private function loadCache() {
        $cache = new wlCurl($this->getCacheFilePath());
        $content = $cache->getContents();
        $this->_result = explode(self::DELIMITER, $content);
    }

    /**
     * Returns the grabbed results.
     * @return array the grabbed results
     */
    public function get() {
        if ($this->_result === null) {
            if ($this->isCacheUpdated()) {
                $this->loadCache();
            }else {
                $this->process();
            }
        }
        return $this->_result;
    }

    /**
     * Prints the grabbed results.
     * @return void
     */
    public function draw() {
        $ret = $this->get();
        foreach ($ret as $item) {
            echo $item;
        }
    }

    /**
     * Saves the grabbed results to the cache.
     * @return bool if the save was sucesfull
     */
    private function saveCache() {
        $cacheFilePath = $this->getCacheFilePath();
        if (!$cacheFilePath) {
            return false;
        }
        $fh = @fopen($cacheFilePath, "w");
        if (!$fh) {
            return false;
        }
        $ret = "";
        foreach ($this->_result as $content) {
            $ret .= ($content . self::DELIMITER);
        }
        if (substr($ret, -1 * strlen(self::DELIMITER)) == self::DELIMITER) {
            $ret = substr($ret, 0, strlen($ret) - strlen(self::DELIMITER));
        }
        fwrite($fh, $ret);
        fclose($fh);
        return true;
    }

    /**
     * Tests if the html cache is up to date.
     * @return bool if html cache is up to date
     */
    private function isCacheUpdated() {
        $cacheFilePath = $this->getCacheFilePath();
        if (!$cacheFilePath) {
            return false;
        }

        if (file_exists($cacheFilePath) && filemtime($cacheFilePath) + ($this->_cacheTime * 60) >= time()) {
            return true;
        }

        return false;
    }

    /**
     * Generates an unique cache file name.
     * @return string the cache file name
     */
    private function getCacheFileName() {
        $ret = $this->_curl->getUrl();
        if (isset($this->_params)) {
            if (is_array($this->_params)) {
                $ret .= serialize($this->_params);
            }
        }
        return md5($ret) . ".html";
    }

    /**
     * Returns the html cache real path.
     * @return string the cache file path
     */
    private function getCacheFilePath() {
        $cacheFileName = $this->getCacheFileName();
        if (!$cacheFileName) {
            return false;
        }
        return dirname(__FILE__) . "/../cache/" . $cacheFileName;
    }
}

?>
