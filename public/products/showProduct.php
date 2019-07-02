<?php

require_once __DIR__ . '/../../config/config.php';

$id = isset($_GET['id']) ? $_GET['id'] : false;

if(!$id) {
	echo 'id не передан';
	exit();
}

//обезопашиваемся от инъекций
$id = (int)$id;



//если передан параметр addToCart то добавляем этот товар в корзину
if(!empty($_GET['addToCart'])) {
	$cart = $_COOKIE['cart'] ?? [];

	setcookie("cart[$id]", ($cart[$id] ?? 0) + 1);
	echo 'Товар добавлен в корзину';
}



echo render(TEMPLATES_DIR . 'index.tpl', [
	'title' => 'Geek Brains Site',
	'h1' => "Товар $id",
	'content' => showProduct($id)
]);
