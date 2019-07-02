<?php

require_once __DIR__ . '/../config/config.php';


echo render(TEMPLATES_DIR . 'index.tpl', [
	'title' => 'Geek Brains Site',
	'h1' => 'Галерея',
	'content' => createGallery()
]);
