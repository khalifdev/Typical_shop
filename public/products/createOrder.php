<?php

require_once __DIR__ . '/../../config/config.php';

if (empty($_SESSION['login'])) {
	header('Location: /profile.php');
}

$cart = $_COOKIE['cart'] ?? [];

if (empty($cart)) {
	echo "Корзина пуста";
	exit;
}

$address = $_POST['address'] ?? false;

if (!empty($address)) {
	$userId = $_SESSION['login']['id'];

	//создаем соединение с БД
	$db = createConnection();
	//Избавляемся от всех инъекций в $title и $content
	$address = escapeString($db, $address);

	//генерируем SQL добавления в БД

	$sql = "INSERT INTO `orders` (`userId`, `address`, `status`) VALUES ($userId, '$address', 1)";
	$orderId = insert($sql, $db);

	if(!$orderId) {
		echo 'Произошла ошибка';
		exit();
	}

	$ids = array_keys($cart);

	//генерируем запрос
	$sql = "SELECT * FROM `products` WHERE `id` IN (" . implode(', ', $ids) . ")";
	$products = getAssocResult($sql);


	$values = [];

	foreach ($products as $product) {
		$productId = $product['id'];
		$amount = $cart[$productId];
		$price = $product['price'];
		$values[] = "($orderId, $productId, $price, $amount)";
	}


	$sql = "INSERT INTO `orderProducts` (`orderId`, `productId`, `price`, `amount`) VALUES " . implode(', ', $values);

	if(execQuery($sql)) {
        foreach ($_COOKIE['cart'] as $productId => $amount) {
            setcookie("cart[$productId]", null, 1, '/');

        }
	    echo 'Заказ успешно создан!';
        echo "<br><a href='/profile.php'>Мои заказы</a>";
	} else {
		echo 'Произошла ошибка';
	}

}

?>
<form method="POST">
	Введите адрес доставки:

	<input type="text" name="address">
	<input type="submit">
</form>
