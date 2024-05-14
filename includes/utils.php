<?php

// Test Data
define('TestProject\REQUESTED_PATH', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

switch (TestProject\REQUESTED_PATH) {
	case '/page1':
		$title = 'Page 1';
		break;

	case '/page2':
		$title = 'Page 2';
		break;

	case '/page3':
		$title = 'Page 3';
		break;

	default:
		$title = 'Home Page';
		break;
}

$Page = new \TestProject\Page($title, '');
