-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2020 at 05:13 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(255) NOT NULL,
  `person_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `person_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(255) NOT NULL,
  `author_id` int(255) NOT NULL,
  `publisher_id` int(255) NOT NULL,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `publication_year` smallint(4) NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `number_of_pages` smallint(6) NOT NULL,
  `date_inserted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `author_id`, `publisher_id`, `title`, `publication_year`, `description`, `number_of_pages`, `date_inserted`) VALUES
(1, 1, 1, 'Short Letter, Long Farewell', 1972, 'Short Letter, Long Farewell is one the most inventive and exhilarating of the great Peter Handke’s novels. Full of seedy noir atmospherics and boasting an air of generalized delirium, the book starts by introducing us to a nameless young German who has just arrived in America, where he hopes to get over the collapse of his marriage.', 127, '2020-06-05 17:31:13'),
(2, 1, 2, 'A Sorrow Beyond Dreams', 1975, 'Peter Handke\'s mother was an invisible woman. Throughout her life, which spanned the Nazi era, the war, and the postwar consumer economy, she struggled to maintain appearances, only to arrive at a terrible recognition: \"I\'m not human any more.\"', 95, '2020-06-05 17:31:13'),
(3, 1, 1, 'The Goalie\'s Anxiety at the Penalty Kick', 1970, 'The self-destruction of a soccer goalie turned construction worker who wanders aimlessly around a stifling Austrian border town after pursuing and then murdering.', 127, '2020-06-05 17:42:24'),
(4, 2, 3, 'The Handmaid\'s Tale', 1985, 'Offred is a Handmaid in the Republic of Gilead. She may leave the home of the Commander and his wife once a day to walk to food markets whose signs are now pictures instead of words because women are no longer allowed to read', 127, '2020-06-05 17:49:43'),
(5, 2, 4, 'The Testaments', 2019, 'The novel alternates between the perspectives of three women, presented as portions of a manuscript written by one (the Ardua Hall Holograph) and testimony by the other two.', 432, '2020-06-05 18:18:46'),
(6, 3, 5, 'Lolita', 1955, 'Humbert Humbert - scholar, aesthete and romantic - has fallen completely and utterly in love with Lolita Haze, his landlady\'s gum-snapping, silky skinned twelve-year-old daughter.', 331, '2020-06-05 18:28:12'),
(7, 4, 6, 'Hamlet', 2005, 'Hamlet is a young prince in Denmark who was supposed to become king when his father (also named Hamlet) died. Instead, the throne was seized by Hamlet\'s uncle Claudius, who also married Hamlet\'s mother, Gertrude.', 483, '2020-06-05 18:39:09'),
(8, 4, 4, 'Romeo and Juliet', 2004, 'In Romeo and Juliet, Shakespeare creates a violent world, in which two young people fall in love. It is not simply that their families disapprove, the Montagues and the Capulets are engaged in a blood feud.', 389, '2020-06-08 04:58:01'),
(9, 5, 7, 'The Girl He Used to Know', 2019, 'Annika and Jonathan fell hard for one another after they met at chess club while studying at the University of Illinois. Their love seemed like it could withstand anything — until an unexpected tragedy forced them apart.', 291, '2020-06-08 05:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `books_prices`
--

CREATE TABLE `books_prices` (
  `book_price_id` int(255) NOT NULL,
  `book_id` int(255) NOT NULL,
  `price_id` int(255) NOT NULL,
  `date_become_effective` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `books_prices`
--

INSERT INTO `books_prices` (`book_price_id`, `book_id`, `price_id`, `date_become_effective`) VALUES
(1, 1, 1, '2020-06-05 18:12:34'),
(2, 2, 2, '2020-06-05 18:12:34'),
(3, 4, 2, '2020-06-05 18:12:34'),
(4, 3, 3, '2020-06-05 18:12:34'),
(5, 5, 4, '2020-06-05 18:20:47'),
(6, 6, 3, '2020-06-05 18:28:39'),
(7, 7, 3, '2020-06-05 18:42:19'),
(8, 8, 5, '2020-06-08 05:02:48'),
(9, 9, 3, '2020-06-08 05:09:17'),
(10, 6, 1, '2020-06-08 06:22:25'),
(11, 6, 5, '2020-06-09 05:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `book_images`
--

CREATE TABLE `book_images` (
  `image_id` int(255) NOT NULL,
  `alt` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `book_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `book_images`
--

INSERT INTO `book_images` (`image_id`, `alt`, `path`, `book_id`) VALUES
(1, 'Short Letter, Long Farewell', 'assets/img/short_letter.jpg', 1),
(2, 'sorrow beyond dreams', 'assets/img/sorrow.jpg', 2),
(3, 'handmaid\'s tale', 'assets/img/handmaid.jpg', 4),
(4, 'goalie\'s anxiety', 'assets/img/goalie.jpg', 3),
(5, 'testaments', 'assets/img/testaments.png', 5),
(6, 'lolita', 'assets/img/lolita.jpg', 6),
(7, 'hamlet', 'assets/img/hamlet.jpg', 7),
(8, 'romeo and juliet', 'assets/img/romeo.jpg', 8),
(9, 'the girl he used to know', 'assets/img/girl.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(255) NOT NULL,
  `city_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`, `country_id`) VALUES
(1, 'Smederevo', 1),
(2, 'Pancevo', 1),
(3, 'Serbia', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
  `contact_form_id` int(255) NOT NULL,
  `message` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(255) NOT NULL,
  `country_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`) VALUES
(1, 'Serbia');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(255) NOT NULL,
  `genre_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Love'),
(2, 'Drama'),
(3, 'Autobigraphy'),
(4, 'Fiction'),
(5, 'Tragedy');

-- --------------------------------------------------------

--
-- Table structure for table `genres_books`
--

CREATE TABLE `genres_books` (
  `genre_book_id` int(255) NOT NULL,
  `genre_id` int(255) NOT NULL,
  `book_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `genres_books`
--

INSERT INTO `genres_books` (`genre_book_id`, `genre_id`, `book_id`) VALUES
(1, 2, 1),
(2, 1, 1),
(3, 3, 2),
(4, 4, 3),
(5, 4, 4),
(6, 5, 4),
(7, 4, 5),
(8, 4, 6),
(9, 4, 7),
(10, 5, 7),
(11, 2, 7),
(12, 1, 8),
(13, 5, 8),
(14, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `navigation_id` int(20) NOT NULL,
  `text` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `href` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`navigation_id`, `text`, `href`, `priority`) VALUES
(1, 'Home', 'index.php?page=home', 5),
(2, 'Shop', 'index.php?page=shop', 10),
(3, 'Contact', 'index.php?page=contact', 15),
(4, 'Login', 'index.php?page=login', 20);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `date_order_placed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(255) NOT NULL,
  `book_id` int(255) NOT NULL,
  `order_id` int(255) NOT NULL,
  `order_item_quantity` int(20) NOT NULL,
  `order_item_price` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(255) NOT NULL,
  `card_number` char(12) COLLATE utf8_unicode_ci NOT NULL,
  `card_verification_value` char(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `card_number`, `card_verification_value`) VALUES
(1, '123412341234', '123'),
(2, '123412341234', '123');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `person_id` int(255) NOT NULL,
  `first_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`person_id`, `first_name`, `last_name`) VALUES
(1, 'Peter', 'Handke'),
(2, 'Margaret', 'Atwood'),
(3, 'Vladimir', 'Nabovkov'),
(4, 'William', 'Shakespeare'),
(5, 'Tracey', 'Gravis Graves'),
(6, 'Nikola', 'Zigic'),
(10, 'Pera', 'Peric');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `price_id` int(255) NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`price_id`, `value`) VALUES
(1, '3.98'),
(2, '9.99'),
(3, '7.99'),
(4, '6.99'),
(5, '8.99');

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `publisher_id` int(255) NOT NULL,
  `publisher_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`publisher_id`, `publisher_name`) VALUES
(6, 'Cambridge University Press'),
(4, 'Doubleday'),
(3, 'McClelland and Stewart'),
(5, 'Olympia Press'),
(2, 'Residenz Verlag'),
(7, 'St. Martin\'s Press'),
(1, 'Suhrkamp Verlag');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` tinyint(10) NOT NULL,
  `role_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(255) NOT NULL,
  `addres` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `city_id` int(255) NOT NULL,
  `role_id` tinyint(10) NOT NULL,
  `phone_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `person_id`, `addres`, `city_id`, `role_id`, `phone_number`, `date_updated`, `email`) VALUES
(1, 'nixi', '3ada52cf5855ff0d56f24c7b6167b598', 6, 'Slavonska 12', 2, 2, '1234556789', '2020-06-10 08:18:01', 'nikolakralj9@gmail.com'),
(5, 'pexi', '80c61d49926a30603fcaab713520675d', 10, 'Slavonska 12', 3, 2, '1234556789', '2020-06-10 08:23:16', 'nikolakralj9@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users_payments`
--

CREATE TABLE `users_payments` (
  `user_payment_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `payment_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_payments`
--

INSERT INTO `users_payments` (`user_payment_id`, `user_id`, `payment_id`) VALUES
(1, 1, 1),
(2, 5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- Indexes for table `books_prices`
--
ALTER TABLE `books_prices`
  ADD PRIMARY KEY (`book_price_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `price_id` (`price_id`);

--
-- Indexes for table `book_images`
--
ALTER TABLE `book_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `contact_forms`
--
ALTER TABLE `contact_forms`
  ADD PRIMARY KEY (`contact_form_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `genres_books`
--
ALTER TABLE `genres_books`
  ADD PRIMARY KEY (`genre_book_id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`navigation_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`price_id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisher_id`),
  ADD UNIQUE KEY `publisher_name` (`publisher_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `users_payments`
--
ALTER TABLE `users_payments`
  ADD PRIMARY KEY (`user_payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `books_prices`
--
ALTER TABLE `books_prices`
  MODIFY `book_price_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `book_images`
--
ALTER TABLE `book_images`
  MODIFY `image_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
  MODIFY `contact_form_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `genres_books`
--
ALTER TABLE `genres_books`
  MODIFY `genre_book_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `navigation_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `person_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `price_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisher_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` tinyint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_payments`
--
ALTER TABLE `users_payments`
  MODIFY `user_payment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `authors_persons` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_authors` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_publishers` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`publisher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `books_prices`
--
ALTER TABLE `books_prices`
  ADD CONSTRAINT `books_prices_books` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_prices_prices` FOREIGN KEY (`price_id`) REFERENCES `prices` (`price_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_images`
--
ALTER TABLE `book_images`
  ADD CONSTRAINT `images_books` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `genres_books`
--
ALTER TABLE `genres_books`
  ADD CONSTRAINT `genres_books_books` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genres_books_genres` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_books` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_person` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_payments`
--
ALTER TABLE `users_payments`
  ADD CONSTRAINT `users_payments_payments` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_payments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
