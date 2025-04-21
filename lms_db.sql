-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 09:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `published_year` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `category_id`, `published_year`, `quantity`, `created_at`, `updated_at`, `image`, `description`) VALUES
(1, 'Global Politics', 'Michael Wrangler', '978-7-9900-1266-4', 3, 1995, 1, '2025-03-08 15:59:35', '2025-04-14 16:44:39', 'uploads/67fb79d435561.jpg', 'In an era defined by shifting alliances, economic upheavals, and geopolitical tensions, Global Politics: Power, Conflict, and Cooperation in a Changing World offers a comprehensive exploration of the forces shaping international relations today. This book examines the roles of key global players, the impact of economic and military power, the challenges of diplomacy, and the evolving nature of international organizations.\r\n\r\nCovering critical topics such as global governance, security dilemmas, environmental politics, and human rights, the book provides an accessible yet in-depth analysis of contemporary global issues. With case studies from around the world, expert insights, and a balanced approach to complex debates, this book is essential reading for students, policymakers, and anyone interested in understanding the mechanisms that drive global affairs.'),
(2, 'Renewable Energy and climate change', 'Volker Quanchning', '978-4-3469-8830-7', 6, 1992, 2, '2025-03-08 16:28:16', '2025-04-14 13:17:32', 'uploads/67fb79d435561.jpg', 'This book serves as an introduction to climate protection and renewable energy, demonstrating the connections between energy use, energy prices, and climate change. It evaluates the current global situation with examples from various countries and offers practical guidance on personal climate protection. Each major type of renewable energy system is covered in detail with an accessible approach, making it an ideal manual for planning and implementing climate protection and renewable energy systems. It\'s also informative for students studying renewable energy and sustainability courses'),
(3, 'Cloud Computing', 'Daniel Kirsch', '978-3-0789-9069-5', 6, 1992, 10, '2025-03-18 19:11:13', '2025-04-16 11:12:23', 'uploads/67fb79d435561.jpg', 'In today’s digital era, cloud computing has revolutionized the way businesses and individuals store, process, and manage data. Cloud Computing: Foundations, Technologies, and Applications provides a comprehensive guide to the principles, architecture, and real-world implementations of cloud computing.\r\n\r\nThis book explores key concepts such as virtualization, cloud security, service models (IaaS, PaaS, SaaS), and deployment strategies (public, private, hybrid, and multi-cloud). It also covers emerging trends like edge computing, serverless computing, and artificial intelligence in the cloud.\r\n\r\nWith case studies, practical examples, and insights from industry leaders, this book is ideal for IT professionals, software developers, business decision-makers, and students looking to gain a deep understanding of cloud computing and its impact on the modern world.'),
(4, 'Hands on Azure DevOps', 'Teffan Umokoro', '978-6-1114-7874-7', 6, 2021, 2, '2025-03-18 19:16:09', '2025-03-18 19:21:21', 'uploads/67d716c712679.jpg', 'Azure DevOps has become a cornerstone for modern software development, enabling teams to automate workflows, enhance collaboration, and accelerate delivery. Hands-On Azure DevOps is a practical guide designed to help developers, IT professionals, and DevOps engineers master the tools and services within Azure DevOps.\r\n\r\nThis book covers key concepts such as CI/CD pipelines, infrastructure as code (IaC), repository management with Git, agile project tracking, test automation, and security best practices. Through hands-on exercises, real-world case studies, and expert insights, readers will learn how to optimize software development lifecycles and deploy applications efficiently in cloud environments.\r\n\r\nWhether you\'re new to DevOps or looking to refine your skills, this book provides step-by-step guidance to help you implement DevOps best practices with Azure and stay ahead in the fast-paced world of software development.'),
(5, 'Build a Website with Django', 'Nigel George', '978-4-0875-7011-3', 6, 2005, 3, '2025-03-19 16:20:58', '2025-03-19 16:21:37', 'uploads/67d716c712679.jpg', 'Unlock the power of Django 3 and build dynamic, scalable websites with ease! This comprehensive guide walks you through the fundamentals of Django, from setting up your development environment to deploying your project. Whether you\'re a beginner or an experienced developer, this book covers essential topics such as models, views, templates, user authentication, and RESTful APIs. With step-by-step tutorials, real-world examples, and best practices, you\'ll gain the skills to create modern web applications efficiently.'),
(6, 'The Capitalist Imaginaries of Popular Music', 'Charles FairChild', '978-7-9395-9974-4', 2, 2000, 3, '2025-03-19 16:26:06', '2025-03-19 16:28:02', 'uploads/67d716c712679.jpg', 'This thought-provoking book explores how popular music is shaped by, and in turn shapes, capitalist ideologies. Examining a range of genres, artists, and industry practices, The Capitalist Imaginaries of Popular Music delves into the ways music reflects consumer culture, labor relations, and the commodification of creativity. Through critical analysis, the book unpacks the tensions between artistic expression and economic structures, revealing how capitalism influences the sound, production, and distribution of music in the modern world.\r\n\r\nA must-read for scholars, musicians, and anyone interested in the intersection of music, culture, and economics.\r\n\r\n'),
(7, 'Too Much and Never Enough', 'Mary L. Trump', '978-3-2455-4766-0', 3, 2018, 2, '2025-03-19 16:32:08', '2025-03-19 16:33:36', 'uploads/67d716c712679.jpg', 'In this explosive and deeply personal account, Mary L. Trump, the niece of Donald J. Trump, offers a revealing look into the dysfunctional family dynamics that shaped the 45th President of the United States. As a trained clinical psychologist and insider, she unpacks the toxic relationships, emotional neglect, and ruthless ambition that defined the Trump household. Through firsthand experiences and psychological insight, Too Much and Never Enough exposes the making of a man whose actions have had profound consequences for the nation and the world.\r\n\r\nA compelling and unsettling read, this book provides a rare glimpse behind the curtain of power, privilege, and family trauma.'),
(8, 'Amateur Hour', 'Charlie Spiering', '978-2-5774-2389-5', 3, 2022, 1, '2025-03-19 16:36:42', '2025-03-19 16:39:12', 'uploads/67d716c712679.jpg', 'In Amateur Hour: Kamala Harris in the White House, journalist Charlie Spiering provides a critical examination of Vice President Kamala Harris’s tenure and influence within the Biden administration. The book delves into her political rise, leadership style, public perception, and policy decisions, analyzing the challenges and controversies she has faced. Through investigative reporting and insider accounts, Spiering paints a picture of Harris’s role in the White House and her impact on American politics.\r\n\r\nA provocative and in-depth look at one of the most high-profile figures in modern U.S. politics, this book offers insight into Harris’s leadership and what it means for the future.'),
(9, 'The Wisdom Of Teams', 'Douglas K. Smith', '978-7-9573-8889-4', 4, 2001, 1, '2025-03-19 16:47:04', '2025-03-19 16:48:29', 'uploads/67d716c712679.jpg', 'A timeless classic on teamwork, The Wisdom of Teams explores how high-performing teams drive success in organizations. Based on extensive research and real-world case studies, Katzenbach and Smith reveal the key principles that make teams effective, from shared purpose and accountability to trust and collaboration. The book provides practical insights on how to build and sustain strong teams, whether in small businesses or global corporations.\r\n\r\nEssential reading for leaders, managers, and anyone looking to unlock the full potential of teamwork, The Wisdom of Teams is a must-have guide to building a thriving, results-driven workplace.\r\n\r\n'),
(10, 'Making Sense Of Management', 'Hugh Willmott', '978-0-3545-1519-1', 4, 2004, 2, '2025-03-19 16:51:01', '2025-03-19 16:53:01', 'uploads/67d716c712679.jpg', 'This insightful and thought-provoking book challenges conventional management wisdom, offering a critical perspective on the theories and practices that dominate modern organizations. Making Sense of Management exposes the underlying assumptions, power dynamics, and ideological influences that shape managerial discourse. Alvesson and Willmott encourage readers to question mainstream management ideas and consider alternative approaches that promote ethical and effective leadership.\r\n\r\nIdeal for students, academics, and professionals seeking a deeper understanding of management beyond traditional frameworks, this book is a must-read for those who want to critically engage with the realities of organizational life.\r\n\r\n'),
(11, 'History Why It Matters', 'Lynn Hunt', '978-3-2838-7181-9', 1, 2008, 1, '2025-03-19 16:55:28', '2025-03-19 16:56:35', 'uploads/67d716c712679.jpg', 'In History: Why It Matters, renowned historian Lynn Hunt explores the vital role history plays in shaping our understanding of the present and future. She delves into how historical narratives are constructed, the power of history in politics and society, and why the past continues to influence contemporary debates. Through engaging insights and thought-provoking analysis, Hunt makes a compelling case for why history remains essential in an era of rapid change and misinformation.\r\n\r\nA must-read for students, scholars, and anyone interested in the significance of history in today’s world.\r\n\r\n'),
(12, 'The Psychology of Money', 'Morgan Housel', '978-8-9500-2756-8', 4, 2000, 1, '2025-03-19 17:01:10', '2025-03-19 17:02:21', 'uploads/67d716c712679.jpg', 'In The Psychology of Money, Morgan Housel explores the hidden forces behind financial decisions, revealing how emotions, biases, and personal experiences shape the way we think about money. Through engaging storytelling and real-world examples, Housel highlights timeless lessons about wealth, investing, and financial behavior—showing that success with money is less about knowledge and more about mindset.\r\n\r\nThis insightful and accessible book challenges conventional wisdom and provides valuable perspectives on managing money wisely, making it an essential read for investors, professionals, and anyone looking to build lasting financial success.'),
(13, 'Introduction to Organizational Behaviour', 'Ed Rose', '978-0-8571-2481-4', 4, 2005, 1, '2025-03-19 17:20:33', '2025-03-19 17:22:40', 'uploads/67d716c712679.jpg', 'This comprehensive guide provides an in-depth exploration of organizational behavior, examining how individuals and groups function within workplace settings. Butler and Rose cover key theories and practical applications, addressing topics such as motivation, leadership, communication, decision-making, and organizational culture. The book combines academic insights with real-world examples, making complex concepts accessible to students and professionals alike.\r\n\r\nDesigned for business students and management practitioners, Introduction to Organizational Behaviour offers a clear and engaging foundation for understanding human behavior in organizations and improving workplace effectiveness.'),
(14, 'History of Public Health in Alberta', 'Lindsay Mclaren', '978-6-6150-5728-8', 1, 1919, 2, '2025-03-19 18:27:37', '2025-03-19 18:27:37', 'uploads/books/1742408857_IMG-20250305-WA0058.jpg', 'A History of Public Health typically explores the development of public health systems, policies, and practices over time. It covers key milestones such as early sanitation efforts, the rise of epidemiology, vaccination programs, and the role of public health in controlling diseases.'),
(16, 'timidi', 'womotimi', '978-2-7256-3621-4', 2, 2005, 20, '2025-04-14 12:30:05', '2025-04-14 13:59:47', 'uploads/67fb79d435561.jpg', 'demo sake'),
(17, 'demo', 'timi', '978-8-3723-6323-7', 2, 2025, 2, '2025-04-14 13:15:44', '2025-04-14 13:15:44', 'uploads/books/1744636544_166987582102748cf9e4df07404c0ecae687d01a55_thumbnail_384x.jpg', 'demo video in progress'),
(18, 'Growth', 'timi', '978-1-2236-4785-2', 2, 20215, 2, '2025-04-14 13:42:40', '2025-04-14 13:42:40', 'uploads/books/1744638160_bb.jpg', 'demo video'),
(19, 'Divine Help', 'timi', '978-1-7867-6627-4', 2, 2025, 5, '2025-04-14 13:57:51', '2025-04-15 15:02:50', 'uploads/67fb79d435561.jpg', 'demonstration'),
(20, 'Computer studies', 'timi', '978-9-9457-9481-6', 1, 2025, 2, '2025-04-14 16:43:06', '2025-04-14 16:43:06', 'uploads/books/1744648986_1739185671d7fb28282b15e15293e16e1752a7ff88_thumbnail_384x.jpg', 'demo process'),
(21, 'Ways to be Successful', 'Timi', '978-6-6401-8018-0', 2, 2025, 2, '2025-04-15 14:27:13', '2025-04-15 14:28:58', 'uploads/67fb79d435561.jpg', 'Demo video ongoing'),
(22, 'Manchester is Grate', 'Ferguson', '978-8-4090-2449-0', 4, 2025, 2, '2025-04-15 15:00:47', '2025-04-15 15:00:47', 'uploads/books/1744729247_bike 2.jpg', 'United'),
(23, 'Blessed days', 'Womotimi', '978-7-6455-2743-7', 4, 2025, 3, '2025-04-16 11:10:48', '2025-04-16 11:10:48', 'uploads/books/1744801848_IMG-20250305-WA0050.jpg', 'demo progress');

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('borrowed','returned','overdue') DEFAULT 'borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`, `status`) VALUES
(8, 15, 1, '2025-04-14', '2025-04-14', 'returned'),
(9, 18, 6, '2025-04-14', '2025-04-14', 'returned'),
(10, 21, 7, '2025-04-14', '2025-04-15', 'returned'),
(11, 24, 9, '2025-04-14', '2025-04-14', 'returned'),
(12, 21, 3, '2025-04-14', '2025-04-28', 'borrowed'),
(13, 27, 5, '2025-04-14', '2025-04-28', 'borrowed'),
(14, 29, 4, '2025-04-14', '2025-04-14', 'returned'),
(15, 32, 8, '2025-04-15', '2025-04-15', 'returned'),
(16, 35, 7, '2025-04-15', '2025-04-15', 'returned'),
(17, 39, 12, '2025-04-16', '2025-04-16', 'returned');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'fiction', 'uploads/fiction.jpg'),
(2, 'art', 'uploads/art.jpg'),
(3, 'politics', 'uploads/politics.jpg'),
(4, 'business', 'uploads/business.jpg'),
(6, 'Technology', 'uploads/67cc6680167bd.jpg'),
(7, 'Astronomy', 'uploads/67d716ae198fb.jpg'),
(8, 'Computer', 'uploads/67d716c712679.jpg'),
(9, 'music', 'uploads/67fb79d435561.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(15, 'womotimi', 'timidiamondtimidi@gmail.com', '$2y$10$xjOyZak4U4x91yhMkxFAB.fDrn5wBB/kwCNMGxElRlRKZNMyrIDIe', 'user', '2025-04-14 12:25:32'),
(17, 'bobby', 'bobby123@gmail.com', '$2y$10$K/kBsVTO8yl2/kjDWc/hMecyjCRSG3EzbYK/f/qj0jSAP1DW1q1He', 'user', '2025-04-14 12:30:59'),
(18, 'prince', 'test123@gmail.com', '$2y$10$zZMEpoNY2LmBz5c.5qkpeOmGpSi0XrPzfqSY3U6M5EKAmJhtCgkQK', 'user', '2025-04-14 13:11:30'),
(20, 'kane', 'kane1123@gmail.com', '$2y$10$obqU7RcEoKYRUqUMC1c.suG9coUkG2Id9U0k9.84t.749tfSdzFhO', 'user', '2025-04-14 13:16:41'),
(21, 'jackson', 'jack123@gmail.com', '$2y$10$dCMjyx68PXB6DvMQypeAXelcSqYjloxp7YYgINnOyw8WX.IPhDcuO', 'user', '2025-04-14 13:37:53'),
(23, 'jolie', 'julian@gmail.com', '$2y$10$0baJaF84lleqs4FJd/WHYOdb1kKAwQyjId3b1fVGwRfF7erpZc/I.', 'user', '2025-04-14 13:43:20'),
(24, 'Emma', 'efe123@gmail.com', '$2y$10$mtcW.DTqH2Kwi/ZvEhy6CefofgUWezSPRiJ1Zx335484o4NMh5ZrO', 'user', '2025-04-14 13:53:54'),
(26, 'Lucy', 'lulu123@gmail.com', '$2y$10$c5ajsulsC5Fu6su2q3.38ODr8tgrmgS7Z0bzii2Bdh.LpJ/feOCme', 'user', '2025-04-14 13:58:46'),
(27, 'Hannah', 'hannah123@gmail.com', '$2y$10$6eSjCgxyAVUAcO5CPbHTguS/45Fii5VRO9O/ILgDixXDRoThBc9Wy', 'user', '2025-04-14 15:11:06'),
(28, 'David', 'dav123@gmail.com', '$2y$10$U.yDC98tcVl4kG2dynrd0OH4kwDFStuWKLgzAC.oZzltq23Cjw222', 'admin', '2025-04-14 15:11:45'),
(29, 'Raymond', 'ray123@gmail.com', '$2y$10$x2DQMiqr0GMK8lZLxMHv4OgExXzIMobGlOkisvS22FfOeCq8ZNcEe', 'user', '2025-04-14 16:39:04'),
(30, 'Dickson', 'dicky123@gmail.com', '$2y$10$8WpmCv8KuhmK0HCHcbtz8eknjc3DVRla1N7LLP51bqwwwZ3KZcZLG', 'admin', '2025-04-14 16:39:39'),
(31, 'fred', 'fred123@gmail.com', '$2y$10$m9ut4RJqfp01u6K2taLtZO1nJzrZ/vLgrE90ToFDbGh2VB66SRL4C', 'user', '2025-04-14 16:43:52'),
(32, 'Russel', 'rus123@gmail.com', '$2y$10$4zKRxOnBsiq50RyWVvT8eOs/eWM0IvpE7h8LCK9KY7LadL9pwaDrW', 'user', '2025-04-15 14:22:11'),
(33, 'Duncan', 'can123@gmail.com', '$2y$10$mytjVumTItQIu5V7Qxx4E.beMSkZ8IA38XRVMQbBNasPwqFxAGXZe', 'admin', '2025-04-15 14:22:44'),
(34, 'Tony', 'Tony123@gmail.com', '$2y$10$nFt9.xB7s/vKFy8AU/w9culgXdwZIb9AN0tTgdPZGRaIN8BgbjJne', 'user', '2025-04-15 14:28:11'),
(35, 'Andre', 'andre123@gmail.com', '$2y$10$Cc7LCNYpTdLKbBBbCznVWO6IQn3GFjxxfQfNH7apkbObay5BpzDEu', 'user', '2025-04-15 14:56:05'),
(36, 'Bruno', 'bruno123@gmail.com', '$2y$10$WYbLIjPlMAZZTOnGmxDbE.KL6o72VTJ6Az0FOJGP7QgvAW9hdLRMS', 'admin', '2025-04-15 14:56:36'),
(37, 'Fredrick', 'Fred8@gmail.com', '$2y$10$/izhkTIq7lcZ4T17v0dbG.NQKwPsl.vDfguxaNUN9.1Tu9tT/Otaa', 'user', '2025-04-15 15:01:52'),
(38, 'Fanta', 'fanta123@gmail.com', '$2y$10$W0kFaJWW23X26i7Gnv2eo.0GhCUNqbX9UEDUOEUuf64p8Oq/beThW', 'admin', '2025-04-16 11:00:44'),
(39, 'Mercy', 'mercy123@gmail.com', '$2y$10$zgTX7ZdYvR.Q/vu35oaSwud6N34yz1NlfWGF1SE1WGoZ0HKp1SGam', 'user', '2025-04-16 11:06:10'),
(40, 'Peace', 'peace123@gmail.com', '$2y$10$SMFHVhFWqmlfXQqqQe6SSukUv.V28SI81tiNaydHM0LghIIHvqdXy', 'admin', '2025-04-16 11:06:45'),
(41, 'Liberty', 'lib123@gmail.com', '$2y$10$vNm98ZzXLYmnY3.z9KZLc.PBWnDwqZke0adUhjkOKDj1JGCKRR8GS', 'user', '2025-04-16 11:11:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
