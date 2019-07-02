<?php

require_once '../config/config.php';



if (empty($_SESSION['login'])) {
    echo render(TEMPLATES_DIR . 'login.tpl', [
        'title' => 'Авторизация',
        'h1' => 'Пожалуйста, авторизуйтесь',
        'content' => ''
    ]);
    die();
}

echo "<a href='/logout.php'>Выйти</a><br>";

echo render(TEMPLATES_DIR . 'index.tpl', [
	'title' => 'Личный кабинет',
	'h1' => 'Ваши заказы',
	'content' => generateOrdersPage(),
]);
