<?php
if(class_exists('wlCurl')) {
    return;
}

/**
 * WiseLoop Web Grabber cURL class definition<br/>
 * This class provides a set of handling methods for a certain url.<br/>
 * @author WiseLoop
 */
class wlCurl {

    /**
     * @var string the current url
     */
    private $_url;

    /**
     * @var array the cached headers
     */
    private $_headers;

    /**
     * @var string the cached contents
     */
    private $_contents;


    /**
     * Constructor.<br/>
     * Creates a wlCurl object.
     * @param string $url the url
     * @return void
     */
    public function __construct($url) {
        $this->setUrl($url);
    }

    /**
     * Sets the url for the Curl object.
     * @param string $url
     * @return void
     */
    public function setUrl($url) {
        $this->_url = $url;
        $this->_headers = null;
        $this->_contents = null;
    }

    /**
     * Returns the url string of the Curl object.
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }

    /**
     * Tests if "php_curl" extension is enabled.
     * @return bool
     */
    public static function isCurlEnabled() {
        return function_exists('curl_init');
    }

    /**
     * Tests if "allow_url_fopen" setting from php.ini is on.
     * @return bool
     */
    public static function isFopenEnabled() {
        return (ini_get('allow_url_fopen') !== '');
    }

    /**
     * Returns a message that explains why the local machine is unable to handle cURL functions, or an empty string if it is able to.
     * @return bool|string
     */
    public static function getUnableMessage() {
        $msg = '';
        if(!self::isCurlEnabled() || !self::isFopenEnabled()) {
            $todo = '';
            $msg .= 'Local server is unable to handle cURL functions.<br/>Possible reasons:';
            $msg .= '<ul>';
            if(!wlCurl::isCurlEnabled()) {
                $msg .= '<li>"php_curl" extension is not enabled onto your PHP installation.</li>';
                $todo .= 'to enable "php_curl" PHP extension';
            }
            if(!wlCurl::isFopenEnabled()) {
                $msg .= '<li>"allow_url_fopen" option from php.ini settings file is set to off.</li>';
                if ($todo) {
                    $todo .= ' or ';
                }
                $todo .= 'turn on the "allow_url_fopen" option from php.ini';
            }
            $msg .= '</ul>';
            $msg .= '<p>Ask your system administrator '.$todo.' and try again.</p>';
        }
        return $msg;
    }

    /**
     * Prepares a cURL handle for the current url; the returning cURL handle will behave like a real browser.
     * @param bool $forHeadersOnly specifes if the returning cURL handler is intended to be used only for getting the current url headers
     * @return bool|resource the cURL handle on success, false on errors
     */
    private function curlInit($forHeadersOnly = false) {
        if(!self::isCurlEnabled()) {
            return false;
        }
        $headers = array();
        $headers[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $headers[] = "Cache-Control: max-age=0";
        $headers[] = "Connection: keep-alive";
        $headers[] = "Keep-Alive: 300";
        $headers[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $headers[] = "Accept-Language: en-us,en;q=0.5";
        $headers[] = "Pragma: ";

        $ch = @curl_init($this->_url);
        if(false !== $ch) {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if(!$userAgent) {
                $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1"';
            }
            @curl_setopt($ch, CURLOPT_URL, $this->_url);
            @curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
            @curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            @curl_setopt($ch, CURLOPT_REFERER, 'http://localhost');
            @curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
            @curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            @curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            if($forHeadersOnly) {
                @curl_setopt($ch, CURLOPT_NOBODY, true);
                @curl_setopt($ch, CURLOPT_HEADER, true);
            }
        }
        return $ch;
    }

    /**
     * Checks if the current url exists.
     * @return bool if $_url exists
     */
    public function getExists() {
        if (!isset($this->_url) || $this->_url === '' || !$this->_url) {
            return false;
        }

        if (file_exists($this->_url)) {
            return true;
        }

        if(!isset($this->_headers)) {
            $this->getHeaders();
        }

        if(!isset($this->_headers)) {
            return false;
        }

        if(preg_match("/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/", $this->_headers[0])) {
            return true;
        }

        return false;
    }

    /**
     * Reads and return the entire content of the current url.
     * @return string the $_url contens
     */
    public function getContents() {
        if(isset($this->_contents)) {
            return $this->_contents;
        }

        $data = null;

        if ($data === null && is_readable($this->_url)) {
            $data = @file_get_contents($this->_url);
            if(false === $data) {
                $data = null;
            }
        }
        if(null === $data)
        {
            $ch = $this->curlInit();
            if(false !== $ch) {
                $data = @curl_exec($ch);
                if(false === $data) {
                    $data = null;
                }
                @curl_close($ch);
            }
        }
        if(null === $data) {
            $fh = @fopen($this->_url, "r");
            if (!$fh)
                return null;
            $data = "";
            while (!feof($fh))
                $data .= fgets($fh);
            @fclose($fh);
        }

        if(null === $data) {
            $data = '';
        }

        $this->_contents = $data;
        return $this->_contents;
    }

    /**
     * Returns the headers of the current url.
     * @return array
     */
    public function getHeaders()
    {
        if(isset($this->_headers)) {
            return $this->_headers;
        }

        if(
                !isset($this->_url) ||
                $this->_url == '' ||
                !$this->_url ||
                substr($this->_url, 0, 1) == '.' ||
                (
                    strtolower(substr($this->_url, 0, 4)) != 'http' &&
                    strtolower(substr($this->_url, 0, 3)) != 'www'
                )
        ) {
            return null;
        }

        $data = null;

        if(null === $data) {
            $ch = $this->curlInit(true);
            if(false !== $ch) {
                $data = @curl_exec($ch);
                if(false === $data) {
                    $data = null;
                }else {
                    $data = explode("\r\n", $data);
                }
                @curl_close($ch);
            }
        }
        if(null === $data) {
            $data = @get_headers($this->_url);
            if(!$data) {
                $data = null;
            }
        }

        $this->_headers = $data;
        return $this->_headers;
    }

    /**
     * Returns the content length of the current url.
     * @return bool|float
     */
    public function getLength()
    {
        if (is_readable($this->_url))
        {
            $data = @filesize($this->_url);
            if(false !== $data) {
                return $data;
            }
        }

        if(!isset($this->_headers)) {
            $this->getHeaders();
        }

        if(preg_match('/Content-Length: (\d+)/', implode("\r\n", $this->_headers), $matches)) {
            return (float)$matches[1];
        }

        $fh = @fopen($this->_url, "r");
        if (!$fh) {
            return -1;
        }
        $data = '';
        while (!feof($fh)) {
            $data .= fgets($fh);
        }
        @fclose($fh);
        return strlen($data);
    }

    /**
     * Returns the content type of the current url.
     * @return string
     */
    public function getContentType()
    {
        if(!isset($this->_headers)) {
            $this->getHeaders();
        }

        if(preg_match('@Content-Type:\s+([\w/+]+)(;\s+charset=(\S+))?@i', implode("\r\n", $this->_headers), $matches)) {
            return str_ireplace('content-type: ', '', $matches[1]);
        }

        return 'Unknown';
    }
}
?>