<?php

/**
 * Получить всео отзывы
 * @return array
 */
function getReviews()
{

	$sql = "SELECT * FROM `reviews` ORDER BY `date` DESC";

	return getAssocResult($sql);
}

/**
 * Добавить новый отзыв
 * @param $author
 * @param $content
 * @return bool
 */
function insertReview($author, $content)
{
	//Создаем подключение к БД
	$db = createConnection();
	//Избоавляемся от всех инъекций в $author и $content
	$author = escapeString($db, $author);
	$content = escapeString($db, $content);

	//Генерируем SQL запрос на добавляение в БД
	$sql = "INSERT INTO `reviews`(`author`, `comment`) VALUES ('$author', '$content')";

	//Выпонляем запрос
	return execQuery($sql, $db);
}
