<?php

/**
 * Plugin Name: Auto2Credit
 * Version: 1.0
 * Author: Raxkor
 * Author uri: https://t.me/drKeinakh
 */

define('AUTO_CREDIT', plugin_dir_url(__FILE__));

require_once "includes/functions.php";
require_once "Auto2Credit.php";

global $Auto2Credit;
$Auto2Credit = new Auto2Credit();