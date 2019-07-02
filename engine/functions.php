<?php

/**
 * Функция шаблонизатора. Получает шаблон из файла и заменяет ключи типа {{KEY}} на значение
 * @param string $file - путь к файлу с шаблоном
 * @param array $variables - массив подставляемых значений
 * @return string
 */
function render($file, $variables = [])
{
	//если файл не существует, выкидываем ошибку
	if (!is_file($file)) {
		echo 'Template file "' . $file . '" not found';
		exit();
	}

	//если файл пустой, выкидываем ошибку
	if (filesize($file) === 0) {
		echo 'Template file "' . $file . '" is empty';
		exit();
	}

	//получаем содержимое шаблона
	$templateContent = file_get_contents($file);

	//если переменны не заданны, возвращаем шаблон как есть
	if (empty($variables)) {
		return $templateContent;
	}

	//проходимся по всем переменным
	foreach ($variables as $key => $value) {
		//преобразуе ключ из key в {{KEY}}
		$key = '{{' . strtoupper($key) . '}}';

		//заменяем все ключи в шаблоне
		$templateContent = str_replace($key, $value, $templateContent);
	}

	//возвращаем получившийся шаблон
	return $templateContent;
}

function loadFile($fileName, $path)
{
	//$fileName - имя name заданное для input типа file
	//Если $_FILES[$fileName] не существует, и есть ошибоки
	if(empty($_FILES[$fileName]) || $_FILES[$fileName]['error']) {
		return 0;
	}

	$file = $_FILES[$fileName];

	//выбираем деррикторию куда загружать изображение
	$uploaddir = WWW_DIR . $path;

	//выбираем конечное имя файла
	$uploadfile = $uploaddir . basename($file['name']);

	//Пытаемся переместить файл из временного местонахождения в постоянное
	if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
		return $path . basename($file['name']);
	} else {
		return 0;
	}
}


function indexByKey($array, $key)
{
	$newArray = [];
	foreach ($array as $value) {
		$keyValue = $value[$key];
		$newArray[$keyValue] = $value;
	}
	return $newArray;
}