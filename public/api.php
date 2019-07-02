<?php

/*
 * Файл работы API
 * Файл ожидает что в _POST придет apiMethod с задачей, которую нужно выполнить
 * И (при необходимости) postData с информацией, необходимой для этой задачи
 *
 */

/*
 * Комментарий по json
 * Если использовать header('Content-Type: application/json');
 * То весь текст на странице попытается преобразоваться в json.
 * Следовательно нельзя будет увидеть ошибки, которые вам покажет php,
 * поэтому задает заголовок передаем в последний момент
 *
 * Если до этого были ошибки на php заголовок задать не получится
 *
 */

require_once '../config/config.php';

//Функция вывода ошибки
function error($error_text)
{
	//Вариант с json
//	header('Content-Type: application/json');
//	echo json_encode([
//		'error' => true,
//		'error_text' => $error_text,
//		'data' => null
//	]);
//	exit();

	//Вариант без json
	echo "Ошибка: $error_text";
	exit();
}

//Функция успешного ответа
function success($data = true)
{
	//Вариант с json
//	header('Content-Type: application/json');
//	echo json_encode([
//		'error' => false,
//		'error_text' => null,
//		'data' => $data
//	]);
//	exit();

	//Вариант без json
	echo "OK";
	exit();
}

//Если на api не передан apiMethod вызываем ошибку
if (empty($_POST['apiMethod'])) {
	error('Не передан apiMethod');
}


//Обработка метода login
if ($_POST['apiMethod'] === 'login') {
	//Получаем логин и пароль из postData
	$login = $_POST['postData']['login'] ?? '';
	$password = $_POST['postData']['password'] ?? '';

	//Если нет логина или пароля вызываем ошибку
	if (!$login || !$password) {
		error('Логин или пароль не переданы');
	}

	//приводим пароль к тому же виду, как он хранится в базе
	$password = md5($password);

	//генерируем запрос и пытаемся найти пользователя
	$sql = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
	$user = show($sql);

	//Если пользователь найден, записываем информацию о пользователе в сессию,
	//что бы к ней можно было обратиться с любой страницы
	//Если пользователь не найден, возвращаем ошибку
	if ($user) {
		$_SESSION['login'] = $user;
		success();
	} else {
		error('Неверная пара логин-пароль');
	}
}

//Обработка метода addToCart
if($_POST['apiMethod'] === 'addToCart') {
	$id = $_POST['postData']['id'] ?? 0;
	if(!$id) {
		error('ID не передан');
	}

	//Получаем данные корзины
	$cart = $_COOKIE['cart'] ?? [];

	//если в корзине товара еще нет, то получаем 0
	$count = $cart[$id] ?? 0;
	//увеличиваем количество в корзине
	$count++;

	//устанавливаем новое куки
	setcookie("cart[$id]", $count);

	success();
}

//Обработка метода removeFromCart
if($_POST['apiMethod'] === 'removeFromCart') {
	$id = $_POST['postData']['id'] ?? 0;
	if(!$id) {
		error('ID не передан');
	}

	//удаляем товар из корзины
	setcookie("cart[$id]", null);
	success();
}

//Обработка метода cancelOrder
if($_POST['apiMethod'] === 'cancelOrder') {
    $id = $_POST['postData']['id'] ?? 0;
    if(!$id) {
        error('ID не передан');
    }
    $sql = "UPDATE `orders` SET `status`= 2 WHERE `id` = $id";
    if (execQuery($sql)) {
        success();
    } else {
        error("Ошибка отмены заказа!");
    }

}

//Обработка метода deleteOrder
if($_POST['apiMethod'] === 'deleteOrder') {
    $id = $_POST['postData']['id'] ?? 0;
    if(!$id) {
        error('ID не передан');
    }
    $sql = "DELETE FROM `orders` WHERE `id` = $id";
    if (execQuery($sql)) {
        success();
    } else {
        error("Ошибка удаления заказа!");
    }

}

//Обработка метода deleteProduct
if($_POST['apiMethod'] === 'deleteProduct') {
    $id = $_POST['postData']['id'] ?? 0;
    if(!$id) {
        error('ID не передан');
    }
    $sql = "DELETE FROM `products` WHERE `id` = $id";
    if (execQuery($sql)) {
        success();
    } else {
        error("Ошибка удаления товара!");
    }

}

error('Неизвестный метод');
