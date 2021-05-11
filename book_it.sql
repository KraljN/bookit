-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2021 at 07:48 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(8, 26),
(7, 27),
(10, 28),
(6, 29),
(9, 30);

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
(28, 8, 7, 'The Girl He Used to Know', 2019, 'Annika Rose likes being alone.\r\nShe feels lost in social situations, saying the wrong thing or acting the wrong way. She just can\'t read people.', 219, '2020-09-21 14:25:26'),
(29, 7, 1, 'The Goalie\'s Anxiety at the Penalty Kick', 1970, 'The first of Peter Handke\'s novels to be published in English, The Goalie\'s Anxiety at the Penalty Kick is a true modern classic that \"portrays the breakdown of a murderer in ways that recall Camus\'s The Stranger\"', 133, '2020-09-21 14:25:26'),
(30, 10, 6, 'Hamlet', 2005, 'Among Shakespeare\'s plays, \"Hamlet\" is considered by many his masterpiece. Among actors, the role of Hamlet, Prince of Denmark, is considered the jewel in the crown of a triumphant theatrical career.', 289, '2020-09-21 14:25:26'),
(31, 6, 3, 'The Handmaid\'s Tale', 1985, 'The Handmaid\'s Tale explores themes of subjugated women in a patriarchal society and the various means by which these women resist and attempt to gain individuality and independence.', 311, '2020-09-21 14:25:26'),
(32, 9, 5, 'Lolita', 1990, 'Humbert Humbert - scholar, aesthete and romantic - has fallen completely and utterly in love with Lolita Haze, his landlady\'s gum-snapping, silky skinned twelve-year-old daughter.', 336, '2020-09-21 14:25:26'),
(33, 10, 4, 'Romeo and Juliet', 2004, 'In Romeo and Juliet, Shakespeare creates a violent world, in which two young people fall in love. It is not simply that their families disapprove, the Montagues and the Capulets are engaged in a blood feud.', 301, '2020-09-21 14:25:26'),
(34, 7, 1, 'Short Letter, Long Farewell', 1972, 'Full of seedy noir atmospherics and boasting an air of generalized delirium, the book starts by introducing us to a nameless young German who has just arrived in America, where he hopes to get over the collapse of his marriage.', 76, '2020-09-21 14:25:26'),
(35, 7, 2, 'A Sorrow Beyond Dreams', 2002, 'Peter Handke\'s mother was an invisible woman. Throughout her life, which spanned the Nazi era, the war, and the postwar consumer economy, she struggled to maintain appearances, only to arrive at a terrible recognition: \"I\'m not human any more.\"', 76, '2020-09-21 14:25:26'),
(36, 6, 4, 'The Testaments', 2019, 'Margaret Atwood\'s sequel picks up the story more than fifteen years after Offred stepped into the unknown, with the explosive testaments of three female narrators from Gilead.', 422, '2020-09-21 14:25:26');

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
(12, 35, 2, '2020-09-21 14:40:21'),
(13, 30, 4, '2020-09-21 14:40:21'),
(14, 32, 1, '2020-09-21 14:40:21'),
(15, 33, 5, '2020-09-21 14:40:21'),
(16, 34, 4, '2020-09-21 14:40:21'),
(17, 28, 2, '2020-09-21 14:40:21'),
(18, 29, 4, '2020-09-21 14:40:21'),
(19, 31, 4, '2020-09-21 14:40:21'),
(20, 36, 1, '2020-09-21 14:40:21');

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
(10, 'girl', 'assets/img/girl.jpg', 28),
(11, 'goalie', 'assets/img/goalie.jpg', 29),
(12, 'hamlet', 'assets/img/hamlet.jpg', 30),
(13, 'handmaid', 'assets/img/handmaid.jpg', 31),
(14, 'lolita', 'assets/img/lolita.jpg', 32),
(15, 'romeo', 'assets/img/romeo.jpg', 33),
(16, 'short_letter', 'assets/img/short_letter.jpg', 34),
(17, 'sorrow', 'assets/img/sorrow.jpg', 35),
(18, 'testaments', 'assets/img/testaments.png', 36);

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
(3, 'Serbia', 1),
(4, 'Vrsac', 1),
(5, 'Paris', 2),
(6, 'Misa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
  `contact_form_id` int(255) NOT NULL,
  `message` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms_form_subjects`
--

CREATE TABLE `contact_forms_form_subjects` (
  `cffs_id` int(255) NOT NULL,
  `contact_form_id` int(255) NOT NULL,
  `subject_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Serbia'),
(2, 'France');

-- --------------------------------------------------------

--
-- Table structure for table `form_subjects`
--

CREATE TABLE `form_subjects` (
  `subject_id` int(255) NOT NULL,
  `subject_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_subjects`
--

INSERT INTO `form_subjects` (`subject_id`, `subject_name`) VALUES
(1, 'Order Problem'),
(2, 'Marketing Inquiry'),
(3, 'Login Problem'),
(4, 'Product Question');

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
(29, 4, 28),
(30, 1, 28),
(31, 4, 29),
(32, 2, 30),
(33, 5, 30),
(34, 4, 31),
(35, 4, 32),
(36, 1, 32),
(37, 1, 33),
(38, 2, 33),
(39, 4, 34),
(40, 3, 35),
(41, 4, 36);

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
(3, 'Contact', 'index.php?page=contact', 15);

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
(2, '123412341234', '123'),
(3, '123412341234', '442'),
(4, '123412341234', '442'),
(5, '123412341234', '442'),
(9, '123412341234', '123'),
(10, '123412341234', '123');

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
(18, 'Milutin', 'Milankovic'),
(25, 'Nikola', 'Kralj'),
(26, 'Tracey', 'Gravis Graves'),
(27, 'Peter', 'Handke'),
(28, 'William', 'Shakespeare'),
(29, 'Margaret', 'Atwood'),
(30, 'Vladimir', 'Nabokov');

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
-- Table structure for table `subject_descriptions`
--

CREATE TABLE `subject_descriptions` (
  `description_id` int(255) NOT NULL,
  `text` varchar(300) NOT NULL,
  `contact_form_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(13, 'miki', '4839641470743161315c2daed44ff32c', 18, 'Pristevska 34', 3, 2, '12345567891', '2020-09-20 12:41:29', 'milutin@gmail.com'),
(17, 'kraljina', '8ca5a193505320ab28795a63a2d826eb', 25, 'Dobrovoljacka 8', 2, 2, '1234556789', '2020-09-21 07:32:26', 'nikolakralj9@gmail.com');

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
(9, 13, 9),
(10, 17, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `user_activity_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`user_activity_id`, `user_id`, `last_activity`) VALUES
(2, 13, '2021-01-05 12:48:44'),
(3, 17, '2020-09-21 15:16:05');

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
-- Indexes for table `contact_forms_form_subjects`
--
ALTER TABLE `contact_forms_form_subjects`
  ADD PRIMARY KEY (`cffs_id`),
  ADD KEY `contact_form_id` (`contact_form_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `form_subjects`
--
ALTER TABLE `form_subjects`
  ADD PRIMARY KEY (`subject_id`);

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
-- Indexes for table `subject_descriptions`
--
ALTER TABLE `subject_descriptions`
  ADD PRIMARY KEY (`description_id`),
  ADD KEY `form_id` (`contact_form_id`);

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
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`user_activity_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `books_prices`
--
ALTER TABLE `books_prices`
  MODIFY `book_price_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `book_images`
--
ALTER TABLE `book_images`
  MODIFY `image_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
  MODIFY `contact_form_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_forms_form_subjects`
--
ALTER TABLE `contact_forms_form_subjects`
  MODIFY `cffs_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_subjects`
--
ALTER TABLE `form_subjects`
  MODIFY `subject_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `genres_books`
--
ALTER TABLE `genres_books`
  MODIFY `genre_book_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
  MODIFY `payment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `person_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- AUTO_INCREMENT for table `subject_descriptions`
--
ALTER TABLE `subject_descriptions`
  MODIFY `description_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users_payments`
--
ALTER TABLE `users_payments`
  MODIFY `user_payment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `user_activity_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `books_authors` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`),
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
-- Constraints for table `contact_forms_form_subjects`
--
ALTER TABLE `contact_forms_form_subjects`
  ADD CONSTRAINT `contact_forms_form_subjects` FOREIGN KEY (`contact_form_id`) REFERENCES `contact_forms` (`contact_form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_forms_form_subjects_` FOREIGN KEY (`subject_id`) REFERENCES `form_subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `subject_descriptions`
--
ALTER TABLE `subject_descriptions`
  ADD CONSTRAINT `subject_description_form` FOREIGN KEY (`contact_form_id`) REFERENCES `contact_forms` (`contact_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activites_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
