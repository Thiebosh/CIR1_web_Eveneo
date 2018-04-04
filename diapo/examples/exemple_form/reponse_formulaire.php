<?php
$name = filter_input(INPUT_GET, 'firstname');
$lastName = filter_input(INPUT_GET, 'lastname');
if (empty($name) || empty($lastName)) {
	unset($name);
	unset($lastName);
}

include('form_get.html');
