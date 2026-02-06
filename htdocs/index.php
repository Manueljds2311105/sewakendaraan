<?php
    
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Configuration
define('BASE_URL', 'https://rentalkendaraan.wuaze.com/');

// Autoload core files
require_once 'app/core/App.php';
require_once 'app/core/Controller.php';
require_once 'config/Database.php';

// Run application
$app = new App();
?>