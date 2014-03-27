<?php
/**
 * WiseLoop Web Grabber entry point<br/>
 * It creates an Autoloader for loading the classes only when needed and checks if the current platform supports this package.<br/>
 * You sould include only this file in you application; the Autoloader will do the rest.
 * @author WiseLoop
 */
require_once (dirname(__FILE__) . "/wlAutoloader.php");
$autoLoader = new wlAutoloader();
$autoLoader->addPath(dirname(__FILE__));
$autoLoader->addPath(dirname(__FILE__)."/grabber");
$autoLoader->register();

try
{
    wlWgUtils::checkPlatform();
} catch (Exception $ex)
{
    die($ex->getMessage());
}
?>
