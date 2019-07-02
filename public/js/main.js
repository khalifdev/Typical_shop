
//Функция AJAX авторизации
function login() {
	//Получаем input'ы логина и пароля
	const $login_input = $('[name="login"]');
	const $password_input = $('[name="password"]');

	//Получаем значение login и password
	const login = $login_input.val();
	const password = $password_input.val();

	//Инициализируем поле для сообщений
	const $message_field = $('.message');

	$.post({
		url: '/api.php',
		data: {
			apiMethod: 'login',
			postData: {
				login: login,
				password: password
			}
		},
		success: function (data) {
			//Вариан без json
			if (data === 'OK') {
				location.reload();
			} else {
				$message_field.text(data);
			}
		}
	});
}

function addToCart(id) {
	//Инициализируем поле для сообщений
	const $message_field = $('.message');

	$.post({
		url: '/api.php',
		data: {
			apiMethod: 'addToCart',
			postData: {
				id: id
			}
		},
		success: function (data) {
			if(data === 'OK') {
				$message_field.text('Товар добавлен в корзину');
			} else {
				$message_field.text(data);
			}
			setTimeout(function () {
				$message_field.text('');
			}, 1000);
		}
	})
}

function removeFromCart(id) {
	$.post({
		url: '/api.php',
		data: {
			apiMethod: 'removeFromCart',
			postData: {
				id: id
			}
		},
		success: function (data) {
			if(data === 'OK') {
				$('[data-id="' + id + '"]').remove();
			} else {
				alert(data);
			}
		}
	})
}

function cancelOrder(id) {
	if (confirm("Вы уверены, что хотите отменить заказ #" + id + "?")) {
		$.post({
			url: '/api.php',
			data: {
				apiMethod: 'cancelOrder',
				postData: {
					id: id
				}
			},
			success: function (data) {
				if(data === 'OK') {
					location.reload();
				} else {
					alert(data);
				}
			}
		})
	}
}

function deleteOrder(id) {
	if (confirm("Вы уверены, что хотите удалить данные о заказе #" + id + "?")) {
		$.post({
			url: '/api.php',
			data: {
				apiMethod: 'deleteOrder',
				postData: {
					id: id
				}
			},
			success: function (data) {
				if(data === 'OK') {
					location.reload();
				} else {
					alert(data);
				}
			}
		})
	}
}

function deleteProduct(id) {
	if (confirm("Вы уверены, что хотите удалить Товар " + id + "?")) {
		$.post({
			url: '/api.php',
			data: {
				apiMethod: 'deleteProduct',
				postData: {
					id: id
				}
			},
			success: function (data) {
				if(data === 'OK') {
					$('[data-id="' + id + '"]').remove();
				} else {
					alert(data);
				}
			}
		})
	}
}