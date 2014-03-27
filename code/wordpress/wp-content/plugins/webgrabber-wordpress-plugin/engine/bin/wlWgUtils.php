<?php
/**
 * WiseLoop Web Grabber Utils class definition<br/>
 * The Utils static class provides a set of methods and constants used in WiseLoop Web Grabber package.<br/>
 * @author WiseLoop
 */
class wlWgUtils {
    /**
     * Checks if the current platform supports the WiseLoop Web Grabber package.
     * @return bool if the current platform supports the WiseLoop Web Grabber package
     */
    public static function checkPlatform() {
        if (!(version_compare(phpversion(), "5.0.0") >= 0))
            throw new Exception("You PHP version is " . phpversion() . ". You need PHP 5.0.0 or above.");
        return true;
    }

    /**
     * Searches through $array using indexes given in $indexes and returns first value founded.<br/>
     * If nothing is found, returns $default.
     * @param array $array the haystack array
     * @param array|string|int $indexes the indexes
     * @param mixed $default the return value if the $array does not have an index from $indexes array
     * @return mixed
     */
    public static function getArrayValue($array, $indexes, $default = null) {
        if (!isset($array))
            return null;

        if (!is_array($array))
            return null;

        if (!isset($indexes))
            return null;

        if (is_array($indexes)) {
            foreach ($indexes as $index)
                if (isset($array[$index]))
                    return $array[$index];
        } else
            if (isset($array[$indexes]))
                return $array[$indexes];

        return $default;
    }
}

?>