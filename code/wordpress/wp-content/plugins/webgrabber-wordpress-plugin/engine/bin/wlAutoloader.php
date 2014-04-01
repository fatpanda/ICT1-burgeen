<?php
if(class_exists('wlAutoloader')) {
    return;
}

/**
 * WiseLoop Autoloader class definition<br/>
 * The Autoloader object is responsible for dynamically requesting of file based on its filesystem paths (see $_paths).<br/>
 * Using this class makes it easier to load needed class definitions without worrying about multiple includes, miss-spelling or php file locations.<br/>
 * Just add the paths where classes defintion files resides, and call register().<br/>
 * @remark Every class definition must reside in a separate php file named exactly the same as the name of the class (.php extension must be added also).
 * @author WiseLoop
 */
class wlAutoloader {

    /**
     * @var array
     */
    private $_paths;

    /**
     * Constructor<br/>
     * Creates an Autoloader object.
     * @return void
     */
    public function __construct() {
        $this->_paths = array();
    }

    /**
     * Adds a filesystem path (directory or php file) to the autoloader.
     * @param string $path the path (absolute or relative) of the directory or file to add
     * @return void
     */
    public function addPath($path) {
        if (!in_array($path, $this->_paths)) {
            $this->_paths[] = $path;
        }
    }

    /**
     * Loads a class definition based on the class name given as parameter.
     * @param string $className the name of the class to load
     * @return void
     */
    public function autoload($className) {
        if (class_exists($className) || interface_exists($className)) {
            return;
        }

        foreach ($this->_paths as $path) {
            if (is_file($path)) {
                include_once $path;
            }
            elseif (is_dir($path)) {
                $file = $path . DIRECTORY_SEPARATOR . $className . '.php';
                if (is_file($file)) {
                    include_once $file;
                }
            }
        }
    }

    /**
     * Registers (activates) the autoloader object.
     * The autoload feature is available only since PHP version 5.1.2. If current PHP version is under 5.1.2, this function will load all php files founded in $_paths array
     * @return void
     */
    public function register() {
        if (version_compare(phpversion(), "5.1.2") == 1 && function_exists("spl_autoload_functions")) {
            //save exisiting autoloaders
            $als = spl_autoload_functions();
            if ($als) {
                foreach ($als as $al) {
                    spl_autoload_unregister($al);
                }
            }

            //set my autoloader
            spl_autoload_register(array($this, 'autoload'));

            //append saved autoloaders
            if ($als) {
                foreach ($als as $al) {
                    spl_autoload_register($al);
                }
            }
        }else {
            foreach ($this->_paths as $path) {
                $this->loadAllFromFolder($path);
            }
        }
    }

    /**
     * Recursively loads all the PHP files founded in the specified folder
     * @param string $path
     * @return void
     */
    private function loadAllFromFolder($path) {
        if (is_file($path)) {
            $validExtensions = array('.php', '.inc');
            $ext = '.' . strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, $validExtensions)) {
                $className = str_ireplace($validExtensions, '', $path);
                if (!class_exists($className) && !interface_exists($className)) {
                    require_once $path;
                }
            }
        } elseif (is_dir($path)) {
            $dh = @opendir(realpath($path));
            if ($dh) {
                while (false !== ($file = readdir($dh)))
                {
                    if($file!=='.' && $file!=='..')
                    {
                        $subpath = str_replace("\\", '/',  $path.DIRECTORY_SEPARATOR.$file);
                        if(!(is_dir($subpath) && in_array($subpath, $this->_paths))) {
                            $this->loadAllFromFolder($subpath);
                        }
                    }
                }
                @closedir($dh);
            }
        }
    }
}
