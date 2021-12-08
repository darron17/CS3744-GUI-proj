-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2019 at 04:21 AM
-- Server version: 5.6.45
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gui_proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `storyID` int(11) NOT NULL,
  `author` varchar(100) CHARACTER SET utf8 NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `storyID`, `author`, `author_id`, `date`, `comment`) VALUES
(1, 3, 'User1', 3, '2019-12-02 20:40:49', 'This article is really cool!'),
(2, 3, 'User2', 4, '2019-12-02 20:41:50', 'I didn\'t like this post :(');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `event_type` int(11) NOT NULL,
  `user_1_id` int(11) NOT NULL,
  `user_2_id` int(11) DEFAULT NULL,
  `post_1_id` int(11) UNSIGNED DEFAULT NULL,
  `post_2_id` int(11) UNSIGNED DEFAULT NULL,
  `data_1` text CHARACTER SET utf8,
  `data_2` text CHARACTER SET utf8,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `event_type`, `user_1_id`, `user_2_id`, `post_1_id`, `post_2_id`, `data_1`, `data_2`, `date`) VALUES
(1, 220, 1, 1, NULL, NULL, NULL, NULL, '2019-12-16 22:45:58'),
(2, 220, 1, 1, NULL, NULL, NULL, NULL, '2019-12-16 23:02:53'),
(3, 220, 1, 5, NULL, NULL, NULL, NULL, '2019-12-16 23:03:01'),
(4, 220, 1, 5, NULL, NULL, NULL, NULL, '2019-12-17 01:29:28'),
(5, 240, 1, NULL, NULL, NULL, NULL, NULL, '2019-12-17 01:38:43'),
(6, 220, 1, 1, NULL, NULL, NULL, NULL, '2019-12-17 03:01:07'),
(7, 220, 1, 1, NULL, NULL, NULL, NULL, '2019-12-17 01:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `liked_posts`
--

CREATE TABLE `liked_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liked_posts`
--

INSERT INTO `liked_posts` (`id`, `user_id`, `news_id`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news_story`
--

CREATE TABLE `news_story` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(50) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `body` text NOT NULL,
  `description` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `url` varchar(200) DEFAULT NULL,
  `url_header` text NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_story`
--

INSERT INTO `news_story` (`id`, `title`, `author`, `author_id`, `body`, `description`, `likes`, `url`, `url_header`, `img`, `date`) VALUES
(1, 'BTS ends their break', 'Armyfan43', 3, 'Ever since their debut, BTS hasn\'t taken a break for more than a month or 2. Fans were surprised, but understanding when they heard the news that they would take their first \"long-term\" break back in Spring 2019. They were just finishing up their tour when the announcement was made and were due for a well-deserved rest. After many months, the group announced the end of their break and were spotted in the Incheon Korean airport. Are you excited to see what they come back with?', 'After announcing their first long-term break last 2 months ago, BTS members are seen together at Incheon airport.', 94, '', '', 'https://lh3.googleusercontent.com/sBCyW6OF7VtcMBBSHPnv2GM7HuRPY59StGRllFsEE1xfsZiznUi6PadhWLJdZhCbCu0iDQ-jQM0PWAZI-jYeS6pL9YX-3iONJQ=w1600-rw', '2019-09-20 05:15:34'),
(2, 'Twice releases new album', 'Oncefan29', 4, 'The hit girl group Twice releases their new album \"Fell Special\" and fans are excited to hear the 6 new hits on it. They also released a music video of the hit cover song and you can watch it by hitting the link below! Are you a Once, have you listened to the new hits? Comment down below.', 'K-pop girl group \"Twice\" just released their new album called \"Feel Special\"!', 59, 'https://youtu.be/3ymwOvzhwHs', 'Twice \"Feel Special\" MV', 'https://preview.redd.it/jgfbnjyu1bo31.jpg?width=960&crop=smart&auto=webp&s=fc4e29734a97634cb7417d7beacbd8aa2fa1ca8d', '2019-09-23 05:20:04'),
(3, 'New group SuperM debuts!', 'SuperFan1', 5, 'SuperM is a new group made my SM Entertainment. Even though the group is new the members are actually all pre-exisiting members of other K-pop groups including: NCT, EXO, and SHINEE. They are going to debut with a tour in the U.S. and they just released their 1st mini-album. If you are interested in getting tickets click the link below!', 'New K-pop group, SuperM debuts in America!', 37, '', 'Buy concert tickets here', 'https://www.cheatsheet.com/wp-content/uploads/2019/09/SuperM-first-concert.jpg', '2019-10-07 05:22:11'),
(4, 'Top 10 songs of August 2019', 'Listmaker10', 6, 'These are the top 10 songs of August 2019: \r\n *1 Chungha - Snapping 1* \r\n *2 (G) I-dle - Uh-Oh 2* \r\n *3 Ateez - Wave 3* \r\n *4 CLC - Me 4* \r\n *5 Stray Kids - Side Effects 5* \r\n *6 NCT Dream - Boom 6* \r\n *7 Itzy - ICY 7* \r\n *8 Ateez - Illusion 8* \r\n *9 NCT 127 - Superhuman 9* \r\n *10 Oneus - Twilight 10* \r\n\r\nDo you agree with our list? Comment down below!\r\n', 'Find out what the top 10 songs are in August 2019!', 36, '', '', '', '2019-08-30 05:22:55'),
(5, 'Top 10 songs of September 2019', 'Listmaker10', 6, 'These are the top 10 songs of September 2019: \r\n *1 CLC - Devil 1* \r\n *2 Everglow - Adios 2* \r\n *3 NCT Dream - Boom 3* \r\n *4 Itzy - ICY 4* \r\n *5 SUNMI - LALALAY 5* \r\n *6 SEVENTEEN - Hit 6* \r\n *7 Red Velvet - Umpah Umpah 7* \r\n *8 SEVENTEEN - Fear 8* \r\n *9 X1 - Flash 9* \r\n *10 PENTAGON - Humph! 10* \r\n\r\nDo you agree with our list? Comment down below!\r\n', 'Find out what the top 10 songs are in September 2019!', 14, '', '', '', '2019-09-30 05:23:34'),
(6, 'Comebacks and debuts coming October 2019', 'GroupSrchr5', 7, 'Lots of new and exciting album comebacks from groups including TXT, ATEEZ, DAY6, Stray Kids, Super Junior, and many more. Also the new JYP group \"SuperM\" is debuting this month starting with a tour in America. Are you guys excited to see what these groups have in store? What groups are you most excited for. Let us know down below!', 'Find out the artists coming back and debuting this October 2019.', 27, '', '', '', '2019-10-01 06:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) DEFAULT 'default',
  `role` int(11) NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL,
  `first` varchar(40) NOT NULL,
  `last` varchar(40) NOT NULL,
  `experience` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `email`, `first`, `last`, `experience`) VALUES
(1, 'admin', 'password', 0, '', '', '', 'expert'),
(2, 'passive_user', 'password', 1, '', '', '', 'new'),
(3, 'Armyfan43', 'password', 2, 'Armyfan43@gmail.com', 'John', '', 'novice'),
(4, 'Oncefan29', 'password', 2, 'Oncefan29@gmail.com', 'Katie', '', 'novice'),
(5, 'Superfan1', 'password', 2, 'Superfan1@gmail.com', 'Billy', '', 'new'),
(6, 'Listmaker10', 'password', 2, 'ListMaker10@gmail.com', 'Jack', '', 'expert'),
(7, 'GroupSrchr5', 'password', 2, 'GroupSrchr5@gmail.com', 'Timmy', '', 'expert'),
(8, 'active_user', 'password', 2, '', '', '', 'expert');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_1_id` (`user_1_id`),
  ADD KEY `user_2_id` (`user_2_id`),
  ADD KEY `post_1_id` (`post_1_id`),
  ADD KEY `post_2_id` (`post_2_id`);

--
-- Indexes for table `liked_posts`
--
ALTER TABLE `liked_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liked_posts_ibfk_1` (`user_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `news_story`
--
ALTER TABLE `news_story`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `liked_posts`
--
ALTER TABLE `liked_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news_story`
--
ALTER TABLE `news_story`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`user_1_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`user_2_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`post_1_id`) REFERENCES `news_story` (`id`),
  ADD CONSTRAINT `event_ibfk_4` FOREIGN KEY (`post_2_id`) REFERENCES `news_story` (`id`);

--
-- Constraints for table `liked_posts`
--
ALTER TABLE `liked_posts`
  ADD CONSTRAINT `liked_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `liked_posts_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news_story` (`id`);

--
-- Constraints for table `news_story`
--
ALTER TABLE `news_story`
  ADD CONSTRAINT `news_story_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
