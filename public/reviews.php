<?php

require_once '../config/config.php';

//?? - заменяет isset($a) ? $a : '';
$author = $_POST['author'] ?? '';
$comment = $_POST['comment'] ?? '';

//если есть и автор и комментарий
if($author && $comment) {
	//пытаемся вставить отзыв
	$result = insertReview($author, $comment);

	//в случае успеха обнуляем $author и $comment
	if ($result) {
		echo 'Отзыв добавлен';
		$author = '';
		$comment = '';
	} else {
		echo 'Произошла ошибка';
	}
}

echo '<hr>';

//Получаем список отзывов
$reviews = getReviews();

//выводим отзывы на экран
foreach ($reviews as $review) {
	echo '<div>';
	echo "<div>{$review['author']}</div>";
	echo "<div>{$review['comment']}</div>";
	echo '</div>';
	echo '<hr>';
}


?>
<hr>
<form action="" method="POST">
	<div>
		<!-- атрибут value позволяет выставить значение по умолчанию -->
		Title: <input type="text" name="author" value="<?= $author ?>">
	</div>
	<div>
		comment:
		<!-- для textarea значение по умолчанию выглядит так -->
		<textarea name="comment" cols="30" rows="10"><?= $comment ?></textarea>
	</div>
	<div>
		<input type="submit">
	</div>
</form>


