<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Models
require_once('models/Page.class.php');
require_once('models/History.class.php');

session_start();

// Includes
require_once('includes/utils.php');

// Controllers
require_once('controllers/History.php');

// Templates
require_once('templates/header.php');
require_once('templates/content.php');
require_once('templates/footer.php');
