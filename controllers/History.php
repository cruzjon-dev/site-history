<?php

if ($_POST['submit_history'] ?? false) {
	$action = $_POST['action'] ?? NULL;
	$index = $_POST['index'] ?? NULL;

	if ($action === 'forward') {
		$History->forward();
	} else if ($action === 'back') {
		$History->back();
	} else if ($action === 'goTo') {
		$History->goTo($index);
	}
}

$History->add(TestProject\REQUESTED_PATH, $title);
