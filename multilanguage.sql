-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 25 2019 г., 23:10
-- Версия сервера: 5.6.34
-- Версия PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `multilanguage`
--

-- --------------------------------------------------------

--
-- Структура таблицы `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `russian` text NOT NULL,
  `english` text NOT NULL,
  `armenian` text NOT NULL,
  `classname` text NOT NULL,
  `info` text CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `content`
--

INSERT INTO `content` (`id`, `russian`, `english`, `armenian`, `classname`, `info`) VALUES
(1, 'Главная', 'Home', 'Գլխավոր', 'menu', '#'),
(2, 'ОБО МНЕ', 'ABOUT', 'ԻՄ ՄԱՍԻՆ', 'menu', '#about'),
(5, 'Код Хаффмана\r\n', 'Huffman coding\r\n\r\n', 'Հոֆֆմանի կոդավորում', 'name', ''),
(6, 'Сжатие без потерь', 'Lossless compression\r\n', 'Առանց կորստի սեղմում', 'desc', ''),
(7, 'УЗНАЕТЕ БОЛЬШЕ', 'KNOW MORE\r\n\r\n', 'ԻՄԱՑԵՔ ԱՎԵԼԻՆ', 'activeB', ''),
(9, 'УЗНАЙТЕ БОЛЬШЕ\r\n <br> ОБ АЛГОРИТМЕ', 'KNOW MORE\r\n <br> ABOUT ALGORITHM', 'ԻՄԱՑԻՐ ԱՎԵԼԻՆ\r\n <br> ԱԼԳՈՐԻԹՄԻ ՄԱՍԻՆ', 'hdr', ''),
(10, 'Кодирование Хаффмана использует особый метод для выбора представления для каждого символа, в результате чего получается код префикса (иногда называемый «кодами без префикса»), то есть строка битов, представляющая некоторый конкретный символ, никогда не является префиксом строки битов, представляющей любые другие условное обозначение).', 'Huffman coding uses a specific method for choosing the representation for each symbol, resulting in a prefix code (sometimes called \"prefix-free codes\", that is, the bit string representing some particular symbol is never a prefix of the bit string representing any other symbol). ', 'The Huffman կոդավորման ալգորիթմը շատ նման է Shannon-Fano սեղմման ալգորիթմին: Այս ալգորիթմը հորինել է Դեյվիդ Հաֆֆմանը 1952 թ. («Նվազագույն ավելորդության կանոնների մեթոդ») եւ ավելի հաջող էր, քան Shannon-Fano ալգորիթմը: ', 'lorem', ''),
(11, 'используйте Википедию ', 'use wikipedia for more info', 'օգտագործեք վիքիպեդիա', 'cv', ''),
(36, 'ЯЗЫКИ', 'LANGUAGES', 'ԼԵԶՈՒՆԵՐ', 'dropdown', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `content`
--
ALTER TABLE `content`
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
-- AUTO_INCREMENT для таблицы `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
