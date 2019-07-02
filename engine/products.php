<?php

/**
 * Функция получени всех продуктов
 * @return array
 */
//function getProducts()
//{
//	$sql = "SELECT * FROM `products`";
//
//	return getAssocResult($sql);
//}

/**
 * Функция получает один продукт по его id
 * @param int $id
 * @return array|null
 */
function getProduct($id)
{
	//для безопасности превращаем id в число
	$id = (int) $id;

	$sql = "SELECT * FROM `products` WHERE `id` = $id";

	return show($sql);
}

/**
 * Функция генерации списка продуктов
 * @param $role - индикатор админа
 * @return string
 */
function renderProductList($role = 0)
{
	//инициализируем результирующую строку
	$result = '';
    $sql = "SELECT * FROM `products`";
	//получаем все изображения
	$products = getAssocResult($sql);
    // Добавляем кнопку "Создать" для админа
    if ($role){
        $result .= "<div><a href='createProduct.php'>Создать</a></div>";
    }

    // Список товаров
    $list = '';
	//для каждого изображения
	foreach ($products as $product) {
		//если изображение существует
		if(empty($product['image'])) {
			$product['image'] = 'img/no-image.jpeg';
		}
		$id = $product['id'];

		$list .= render(TEMPLATES_DIR . 'productsListItem.tpl', $product);

        if (!$role){
            $list .= "<a class=\"btn\" onclick='addToCart($id)'>Купить</a></div>";
        } else {
            $list .= "<div><a href='updateProduct.php?id=$id'>Редактировать</a>
	                     <a class='btn' onclick='deleteProduct($id)'>Удалить</a>
	                   </div></div>";
        }
	}
	$result .= render(TEMPLATES_DIR . 'productsList.tpl', ['list' => $list]);
	return $result;
}

/**
 * Генерирует страницу корзины
 * @param array $cart
 * @return string
 */
function renderProductsCart($cart)
{
	if(empty($cart)) {
		return 'корзина пуста';
	}

	//получаем айдишники товаров
	$ids = array_keys($cart);

	//генерируем запрос
	$sql = "SELECT * FROM `products` WHERE `id` IN (" . implode(', ', $ids) . ")";
	$products = getAssocResult($sql);


	//инициализируем строку контента и сумму корзины
	$content = '';
	$cartSum = 0;
	foreach ($products as $product) {
		$count = $cart[$product['id']];
		$price = $product['price'];
		$productSum = $count * $price;
		//генерируем элемент корзины
		$content .= render(TEMPLATES_DIR . 'cartListItem.tpl', [
			'name' => $product['name'],
			'id' => $product['id'],
			'count' => $count,
			'price' => $price,
			'sum' => $productSum
		]);

		$cartSum += $productSum;
	}

	return render(TEMPLATES_DIR . 'cartList.tpl', [
		'content' => $content,
		'sum' => $cartSum
	]);
}

/**
 * @param int $id
 * @param int $role
 * @return string
 */
function showProduct($id, $role = 0)
{

	//для безопасности превращаем id в число
	//получаем товар
	$product = getProduct((int) $id);

	if(!$product) {
		return '404';
	}

    $result = '';

	if ($role) {
        //возвращаем render шаблона для админа
        $result .= render(TEMPLATES_DIR . '/admin/formProduct.tpl', $product);
    } else {
	    //возвращаем render шаблона для клиента
	    $result .= render(TEMPLATES_DIR . 'productPage.tpl', $product);
    }
	return $result;
}

/**
 * Создание нового продукта
 * @param string $name
 * @param string $description
 * @param float $price
 * @param array $file
 * @return bool
 */
function insertProduct($name, $description, $price, $file)
{
	if($file) {
		$fileName = loadFile('image', 'img/');
	}


	//создаем соединение с БД
	$db = createConnection();
	//Избавляемся от всех инъекций в $title и $content
	$name = escapeString($db, $name);
	$description = escapeString($db, $description);
	$price = (float) $price;

	//генерируем SQL добавления в БД

	$sql = $file
		? "INSERT INTO `products`(`name`, `description`, `price`, `image`) VALUES ('$name', '$description', $price, '$fileName')"
		: "INSERT INTO `products`(`name`, `description`, `price`) VALUES ('$name', '$description', $price)";

	//выполняем запрос
	return execQuery($sql, $db);
}

/**
 * @param int $id
 * @param string $name
 * @param string $description
 * @param float $price
 * @param array $file
 * @return string
 */
function updateProduct($id, $name, $description, $price, $file)
{
    if($file) {
        $fileName = loadFile('image', 'img/');
    }

    //создаем соединение с БД
    $db = createConnection();
    //Избавляемся от всех инъекций в $title и $content
    $name = escapeString($db, $name);
    $description = escapeString($db, $description);
    $price = (float) $price;

    //генерируем SQL добавления в БД

    $sql = $file
        ? "UPDATE `products` SET `name`='$name', `description`='$description', `price`=$price, `image`='$fileName' WHERE `id`=$id"
        : "UPDATE `products` SET `name`='$name', `description`='$description', `price`=$price WHERE `id`=$id";

    //выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Генерирует страницу заказов
 * @param int $role - индикатор админа
 * @return string
 */
function generateOrdersPage($role = 0)
{
	//получаем id пользователя и и получаем все заказы пользователя
	$userId = $_SESSION['login']['id'];
	$sql = "SELECT * FROM `orders`";
	// Если не админ, то добавляем id для конкретного клиента
	if (!$role) {
	    $sql .= " WHERE `userId` = $userId";
    }
	// Сортировка заказов по дате
	$sql .= " ORDER BY `dateCreate` DESC";
	$orders = getAssocResult($sql);

	$result = '';
	foreach ($orders as $order) {
		$orderId = $order['id'];

		//получаем продукты, которые есть в заказе
		$products = getAssocResult("
			SELECT * FROM `orderProducts` as op
			JOIN `products` as p ON `p`.`id` = `op`.`productId`
			WHERE `op`.`orderId` = $orderId
		");

		$content = '';
		$orderSum = 0;
		//генерируем элементы таблицы товаров в заказе
		foreach ($products as $product) {
			$count = $product['amount'];
			$price = $product['price'];
			$productSum = $count * $price;
			$content .= render(TEMPLATES_DIR . 'orderTableRow.tpl', [
				'name' => $product['name'],
				'id' => $product['id'],
				'count' => $count,
				'price' => $price,
				'sum' => $productSum
			]);
			$orderSum += $productSum;
		}

		$statuses = [
			1 => 'Заказ не обработан',
			2 => 'Заказ отменён',
			3 => 'Заказ оплачен',
			4 => 'Заказ доставлен',
		];

		//генерируем полную таблицу заказа
		$result .= render(TEMPLATES_DIR . 'orderTable.tpl', [
			'id' => $orderId,
			'content' => $content,
			'sum' => $orderSum,
			'status' => $statuses[$order['status']]
		]);

		// Добавляем кнопку "Отменить" для клиентов
		if (($order['status'] != 2) && $role === 0) {
            $result .= "<a class='btn' onclick='cancelOrder($orderId)'>Отменить</a>";
        }
		// Добавляем кнопку "Удалить" для админа
        if ($role === 1) {
            $result .= "<a class='btn' onclick='deleteOrder($orderId)'>Удалить</a>";
        }
	}
	return $result;
}
