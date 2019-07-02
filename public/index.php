<?php

require_once '../config/config.php';

echo render(TEMPLATES_DIR . 'index.tpl', [
	'title' => 'Geek Brains Site',
	'h1' => 'Горячие новости',
	'content' => ''
]);
