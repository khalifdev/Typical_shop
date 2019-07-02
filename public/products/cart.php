<?php

require_once __DIR__ . '/../../config/config.php';




echo render(TEMPLATES_DIR . 'index.tpl', [
	'title' => 'Geek Brains Site',
	'h1' => 'Корзина',
	'content' => renderProductsCart($_COOKIE['cart'] ?? []),
	'button' => empty($_SESSION['login'])
		? '<a href="/profile.php">Войти</a>'
		: '<a href="/products/createOrder.php" class="btn">Оформить заказ</a>'
]);
