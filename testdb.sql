-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 24 2023 г., 18:27
-- Версия сервера: 5.7.39
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `engine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mileage` float DEFAULT NULL,
  `owners` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `ads`
--

INSERT INTO `ads` (`id`, `user_id`, `region`, `city`, `brand`, `model`, `engine`, `mileage`, `owners`, `created_at`) VALUES
(1, 1, 'Region1', 'City11', 'Brand11', 'Model11', '1,25', 120000, 2, '2023-02-24 07:27:53'),
(2, 1, 'Region1', 'City12', 'Brand12', 'Model12', '2,25', 220000, 1, '2023-02-24 07:54:28'),
(4, 1, 'Region3', 'City13', 'Brand13', 'Model13', '3,25', 10000, 3, '2023-02-24 07:58:01'),
(5, 2, 'Region3', 'City14', 'Brand11', 'Model14', '1,25', 120000, 3, '2023-02-24 08:45:26'),
(6, 3, 'Region1', 'City1', 'Brand1', 'Model1', '3', 10000, 1, '2023-02-24 11:28:33'),
(7, 2, 'Region2', 'City2', 'Brand2', 'Model2', '4', 20000, 2, '2023-02-24 11:28:33'),
(8, 3, 'Region3', 'City3', 'Brand3', 'Model3', '5', 30000, 3, '2023-02-24 11:28:33'),
(9, 4, 'Region3', 'City4', 'Brand4', 'Model4', '6', 40000, 1, '2023-02-24 11:28:33'),
(10, 5, 'Region1', 'City5', 'Brand5', 'Model5', '7', 50000, 2, '2023-02-24 11:28:33'),
(11, 6, 'Region3', 'City6', 'Brand6', 'Model6', '8', 60000, 3, '2023-02-24 11:28:33'),
(12, 7, 'Region1', 'City7', 'Brand7', 'Model7', '9', 70000, 1, '2023-02-24 11:28:33'),
(13, 8, 'Region3', 'City8', 'Brand8', 'Model8', '10', 80000, 2, '2023-02-24 11:28:33'),
(14, 9, 'Region3', 'City9', 'Brand9', 'Model9', '11', 90000, 3, '2023-02-24 11:28:33'),
(15, 10, 'Region3', 'City10', 'Brand10', 'Model10', '12', 100000, 1, '2023-02-24 11:28:33');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `ad_id`, `path`) VALUES
(1, 1, 'uploads/7594ce72-eed721d62acaf70de036fae71fbe88d2.jpg'),
(5, 4, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(6, 5, 'uploads/7594ce72-eed721d62acaf70de036fae71fbe88d2.jpg'),
(7, 5, 'uploads/1942359f-a36cf30c916cb7e5af20c7ed1de57fd3.jpg'),
(8, 5, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(9, 6, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(10, 6, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(11, 7, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(12, 8, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(13, 9, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(14, 10, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(15, 11, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(16, 12, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(17, 13, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(18, 14, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(19, 15, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp'),
(20, 2, 'uploads/p6kdmXcedgV1C14kejegsQ=s800.webp');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'test1@mail.ru', '1234', '2023-02-23 20:18:02'),
(2, 'test@mail.ru', '1234', '2023-02-23 20:19:16');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
