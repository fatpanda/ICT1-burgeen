<?php
/**
 * WiseLoop Web Grabber Configuration class
 * @author WiseLoop
 */
class wlWgConfig
{
    /**
     * Default cache time expressed in minutes<br/>
     * The default cache time is the time duration of how long the stored cache of a grabbed content is considered to be fresh,
     * so that when a new request with the same parameters (url, desired extraction tags, string post processing) is made,
     * the HTML stored in the cache will be loaded instead of reloading and processing it from the real targeted url;
     * in this way the speed will be much faster and the request number to the real targeted server will be kept at minimum. 
     */
    const DEFAULT_CACHE_TIME = 1440;//1 day = 60 min * 24 hrs;

    const CACHE_TIME_1_DAY = 1440;
    const CACHE_TIME_1_WEEK = 10080;
    const CACHE_TIME_1_MONTH = 40320;
    const CACHE_TIME_1_YEAR = 483840;
}
?>
