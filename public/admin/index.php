<?php

require_once '../../config/config.php';

// Проверка на админа
if ($_SESSION['login']['role'] != 1) {

    echo render(TEMPLATES_DIR . 'login.tpl', [
        'title' => 'Авторизация',
        'h1' => 'Вход в панель управления',
        'content' => ''
    ]);
    die();
}

$role = 1;

echo "<a href='/logout.php'>Выйти</a><br>";

echo render(TEMPLATES_DIR . '/admin/index.tpl', [
	'title' => 'Панель управления',
	'h1' => 'Заказы',
	'content' => generateOrdersPage($role)
]);
