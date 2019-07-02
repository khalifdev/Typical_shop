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

$id = isset($_GET['id']) ? $_GET['id'] : false;

if(!$id) {
    echo 'id не передан';
    exit();
}

//обезопашиваемся от инъекций
$id = (int)$id;



//?? - заменяет isset($a) ? $a : '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? false;
$file = $_FILES['image'] ?? [];


if($name || $description || $price !== false) {
    if($name && $description && $price !== false) {
        //пытаемся вставить новый товар
        $result = updateProduct($id, $name, $description, $price, $file);

        //если новость добавлено обнуляем $title и $content
        if($result) {
            echo "Товар $id успешно изменён<br>";
            $name = '';
            $description = '';
            $price = 0;
        } else {
            echo 'Произошла ошибка<br>';
        }
    } else {
        echo 'Недостаточно данных<br>';
    }

}

echo render(TEMPLATES_DIR . '/admin/index.tpl', [
    'title' => 'Панель управления',
    'h1' => "Изменить товар $id",
    'content' => showProduct($id, $role)
]);