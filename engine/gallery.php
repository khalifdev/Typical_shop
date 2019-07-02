<?php

/**
 * Функция получени всех изображений отсортированных по количеству просмотров
 * @return array
 */
function getImages()
{
	$sql = "SELECT * FROM `images` ORDER BY `views` DESC";

	return getAssocResult($sql);
}

/**
 * Функция получает одно изображение по его id
 * @param int $id
 * @return array|null
 */
function getImage($id)
{
	//для безопасности превращаем id в число
	$id = (int) $id;

	$sql = "SELECT * FROM `images` WHERE `id` = $id";

	return show($sql);
}

/**
 * Функция увеличивает количество просмотров для изображения по id
 * @param int $id
 * @param int ?$views
 * @return bool
 */
function updateViews($id, $views = null)
{
	//для безопасности превращаем id в число
	$id = (int) $id;

	$viewsString = $views ? (int)$views : '`views` + 1';

	$sql = "UPDATE `images` SET `views` = $viewsString WHERE `id` = $id";

	return execQuery($sql);
}


/**
 * Функция генерации галереи изображений
 * @return string
 */
function createGallery()
{
	//инициализируем результирующую строку
	$result = '';
	//получаем все изображения
	$images = getImages();

	//для каждого изображения
	foreach ($images as $image) {
		//если изображение существует
		if(is_file(WWW_DIR . $image['url'])) {
			//в результирующий массив добавляем render изображения
			$result .= render(TEMPLATES_DIR . 'galleryItem.tpl', $image);
		}
	}
	return $result;
}

/**
 * @param int $id
 * @return string
 */
function showImage($id)
{
	//для безопасности превращаем id в число
	//получаем изображение
	$image = getImage((int) $id);

	//если изображение не найдено выводим 404
	if(!$image) {
		return '404';
	}

	//увеличиваем количество просмотров в БД
	updateViews($id);
	//увеличиваем количество просмотров в нашей переменной, что бы правильно отобразить
	$image['views']++;

	//возвращаем render шаблона изображения
	return render(TEMPLATES_DIR . 'imagePage.tpl', $image);
}
