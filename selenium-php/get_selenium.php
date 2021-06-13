<?php
require_once './vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;

sample();

/**
 * selenium facebook-webdriver
 */

 function sample() {
   $host = 'http://localhost:4444/wd/hub';

   $driver = RemoteWebDriver::create($host,DesiredCapabilities::chrome());

   $driver->get('https://www.google.co.jp/');

   $file = __DIR__ . '/' . __METHOD__ . ".png";
   $driver->takeScreenshot($file);

   $driver->close();
 }

?>