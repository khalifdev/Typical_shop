<?php

require_once __DIR__ . '/../../config/config.php';

//var_dump($_GET['id']);

$id = isset($_GET['id']) ? $_GET['id'] : false;

if(!$id) {
	echo 'id не передан';
	exit();
}

//$id = 1;

var_dump(showGalleryItem($id));
