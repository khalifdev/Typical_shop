-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 27 2019 г., 22:30
-- Версия сервера: 5.7.26-0ubuntu0.18.04.1
-- Версия PHP: 7.2.19-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `geek_brains`
--

-- --------------------------------------------------------

--
-- Структура таблицы `baskets`
--

CREATE TABLE `baskets` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `baskets`
--

INSERT INTO `baskets` (`id`, `userId`, `productId`, `amount`) VALUES
(1, 1, 5, 5),
(3, 1, 2, 3),
(4, 1, 3, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `url`, `views`, `title`, `size`) VALUES
(1, 'img/1.jpg', 65, 'Картинка 1', 0),
(2, 'img/2.jpg', 2, 'Картинка 2', 0),
(3, 'img/3.jpg', 16, 'Картинка 3', 0),
(4, 'img/4.jpg', 2, 'Картинка 4', 0),
(5, 'img/5.jpg', 0, 'Картинка 5', 0),
(6, 'img/6.jpg', 3, 'Картинка 6', 0),
(7, 'img/7.jpg', 19, 'Картинка 7', 0),
(8, 'img/8.jpg', 5, 'Картинка 8', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `date_create`) VALUES
(1, 'Новый сайт', 'Нам удалось создать сайтик с новостями', '2019-06-17 18:26:02'),
(2, 'Список новостей', 'Мы научились выводить новости на главной', '2019-06-17 18:31:31');

-- --------------------------------------------------------

--
-- Структура таблицы `orderProducts`
--

CREATE TABLE `orderProducts` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orderProducts`
--

INSERT INTO `orderProducts` (`id`, `orderId`, `productId`, `price`, `amount`) VALUES
(1, 1, 1, '101.00', 1),
(2, 1, 2, '100.00', 1),
(3, 1, 3, '100.00', 2),
(4, 2, 4, '100.00', 9),
(5, 3, 16, '111.00', 14);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 - не обработан, 2 - отменен, 3- оплачен, 4 - доставлен'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `userId`, `address`, `dateCreate`, `dateChange`, `status`) VALUES
(1, 1, 'zakaz', '2019-06-27 19:20:17', NULL, 1),
(2, 1, 'tyda je', '2019-06-27 19:21:11', NULL, 1),
(3, 1, 'домой', '2019-06-27 19:21:47', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(11,2) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'img/no-image.jpeg',
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `categoryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `dateCreate`, `dateChange`, `isActive`, `categoryId`) VALUES
(1, 'товарчик изменен', 'стал новым', '101.00', 'img/2.jpg', '2019-03-29 06:40:16', NULL, 1, 1),
(2, 'товар', 'из модели 22', '100.00', 'img/2.jpg', '2019-03-29 06:40:16', NULL, 1, 1),
(3, 'товар', 'из модели', '100.00', 'img/3.jpg', '2019-03-29 06:40:16', NULL, 1, 1),
(4, 'товар', 'из модели', '100.00', 'img/4.jpg', '2019-03-29 06:40:16', NULL, 1, 2),
(5, 'товар', 'из модели', '100.00', 'img/5.jpg', '2019-03-29 06:40:16', NULL, 1, 2),
(6, 'товар', 'из модели', '100.00', 'img/6.jpg', '2019-03-29 06:40:16', NULL, 1, 2),
(7, 'товар', 'из модели', '100.00', 'img/8.jpg', '2019-03-29 06:40:16', NULL, 1, 2),
(8, 'товар', 'из модели', '100.00', 'img/1.jpg', '2019-03-29 06:40:16', NULL, 1, 2),
(9, 'товар', 'из модели', '100.00', 'img/2.jpg', '2019-03-29 06:40:16', NULL, 1, 3),
(10, 'товар', 'из модели', '100.00', 'img/3.jpg', '2019-03-29 06:40:16', NULL, 1, 3),
(11, 'товар', 'из модели', '100.00', 'img/4.jpg', '2019-03-29 06:40:16', NULL, 1, 3),
(12, 'товар', 'из модели', '100.00', 'img/5.jpg', '2019-03-29 06:40:16', NULL, 1, 3),
(13, 'Новый товаришка', 'из модели', '100.00', 'img/6.jpg', '2019-03-29 06:40:16', NULL, 1, 1),
(14, 'ТоварищЪ', 'Описание', '111.00', 'img/AP7FXFTBnvg.jpg', '2019-05-16 16:07:27', NULL, 1, NULL),
(15, 'Носок', 'Хлопок, желтые, с пальцами', '100.00', 'img/images.jpg', '2019-05-16 17:06:26', NULL, 1, NULL),
(16, 'Товар', 'Дескр', '111.00', '0', '2019-06-25 16:53:18', NULL, 1, NULL),
(17, 'Товар', 'Дескр', '111.00', 'img/2.jpg', '2019-06-25 16:53:38', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `author`, `text`) VALUES
(2, 'Сидоров Петр Иванович', 'Сайт на 10/10'),
(3, 'Имя', 'ОТзыв'),
(4, 'Света', 'Нужно больше розового'),
(5, 'Света', 'Нужно больше розового'),
(6, 'Наденька', 'Все чики-пуки'),
(7, 'Ренат', 'Мой комментарий важнее'),
(8, 'Ренат', 'Я все еще тут'),
(9, 'Имя', 'Коммент'),
(10, 'Иван', 'Все гуд'),
(11, 'Света', 'Comment'),
(12, 'Надя', 'Любит Вадю'),
(14, 'Хакер', 'hello'),
(15, 'hello', '&gt;!123123\'&quot;INSERT DROP adasdas\'\r\nz!@#*)!(@+_$/*-+\r\n'),
(16, 'hello', '&gt;!123123\'&quot;INSERT DROP adasdas\'\r\nz!@#*)!(@+_$/*-+\r\n'),
(17, 'hello', '&gt;!123123\'&quot;INSERT DROP adasdas\'\r\nz!@#*)!(@+_$/*-+\r\n'),
(18, 'Петр', 'Могло быть и лучше'),
(19, 'Петр', 'Могло быть и лучше'),
(20, 'Петр', 'Могло быть и лучше'),
(21, 'Петр', 'Могло быть и лучше'),
(22, 'Петр', 'Могло быть и лучше'),
(23, '1', '1'),
(24, '1', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '0 - обычный юзер, 1 - админ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `role`) VALUES
(1, 'admin', 'admin@admin.ru', '4297f44b13955235245b2497399d7a93', 1),
(2, 'Иван Васильевич', 'stesnyashka_666', '4297f44b13955235245b2497399d7a93', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`userId`,`productId`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orderProducts`
--
ALTER TABLE `orderProducts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orderId` (`orderId`,`productId`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `isActive` (`isActive`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `baskets`
--
ALTER TABLE `baskets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orderProducts`
--
ALTER TABLE `orderProducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
