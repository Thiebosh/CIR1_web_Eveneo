<?php

if(!empty($_POST['hobby']) && is_array($_POST['hobby'])) {
	$listHobby = [];
	foreach ($_POST['hobby'] as $hobby) {
		if (!empty($hobby)){ // we need to test it because by default the input text sends an empty text
			$listHobby[] = $hobby;
		}
	}
	if (empty($listHobby)) {
		$_SESSION['errors'] = ['hobby' => 'Hobby is empty'];
	}
} else {
	$_SESSION['errors'] = ['hobby' => 'Hobby is empty'];
}
include('form_post.html');
unset($_SESSION['errors']); // now that errors are printed I can remove them.
