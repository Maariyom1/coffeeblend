-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 25, 2024 at 08:24 PM
-- Server version: 8.3.0
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeeblend`
--

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `firstname`, `lastname`, `time`, `date`, `phone`, `message`, `status`, `created_at`, `updated_at`) VALUES
(18, 1, 'Emmanuel Ariyo', 'Ogunfunwa', '12:30am', '8/22/2024', '08101033541', 'Hi', 1, '2024-08-20 04:32:32', '2024-08-20 04:32:32'),
(17, 1, 'Emmanuel Ariyo', 'Ogunfunwa', '12:00am', '8/21/2024', '08081770338', 'Hi', 1, '2024-08-20 04:31:48', '2024-08-20 04:31:48'),
(16, 1, 'Emmanuel Ariyo', 'Ogunfunwa', '12:00am', '8/20/2024', '08101033541', 'Hi', 1, '2024-08-20 04:31:27', '2024-08-20 04:31:27');

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('user@user.com|127.0.0.1:timer', 'i:1724451454;', 1724451454),
('user@user.com|127.0.0.1', 'i:1;', 1724451454),
('ariyomiracle1234@gmail.com|127.0.0.1:timer', 'i:1724616664;', 1724616664),
('ariyomiracle1234@gmail.com|127.0.0.1', 'i:1;', 1724616664),
('ariyomiracle123@gmail.com|127.0.0.1:timer', 'i:1724453077;', 1724453077),
('ariyomiracle123@gmail.com|127.0.0.1', 'i:1;', 1724453077);

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `pro_id`, `name`, `image`, `price`, `description`, `user_id`, `quantity`, `created_at`, `updated_at`) VALUES
(82, 3, 'Latte', 'product_3.jpg', 5.55, 'Similar to cappuccino but with more steamed milk and less foam. It has a smoother, creamier taste.', 3, 1, '2024-08-22 10:32:19', '2024-08-22 10:32:19'),
(83, 3, 'Latte', 'product_3.jpg', 5.55, 'Similar to cappuccino but with more steamed milk and less foam. It has a smoother, creamier taste.', 1, 1, '2024-08-24 18:13:55', '2024-08-24 18:13:55'),
(84, 7, 'Seasonal Soup', 'dessert-3.jpg', 20.00, 'A small river named Duden flows by their place and supplies', 1, 1, '2024-08-24 21:59:08', '2024-08-24 21:59:08');

--
-- Dumping data for table `counter`
--

INSERT INTO `counter` (`id`, `icon_class`, `name`, `count`, `status`, `created_at`, `updated_at`) VALUES
(1, 'flaticon-coffee-cup', 'Coffee Branches', 100, 1, '2024-07-28 21:48:19', '2024-07-28 21:48:19'),
(2, 'flaticon-coffee-cup', 'Number of Awards', 80, 1, '2024-07-28 21:48:19', '2024-07-28 21:48:19'),
(3, 'flaticon-coffee-cup', 'Happy Customer', 10567, 1, '2024-07-28 21:48:19', '2024-07-28 21:48:19'),
(4, 'flaticon-coffee-cup', 'Staff', 900, 1, '2024-07-28 21:48:19', '2024-07-28 21:48:19');

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `image`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'gallery-1.jpg', '', 1, '2024-07-29 18:56:17', '2024-07-29 18:56:17'),
(2, 'gallery-3.jpg', '', 1, '2024-07-29 18:56:17', '2024-07-29 18:56:17'),
(3, 'gallery-3.jpg', '', 1, '2024-07-29 18:56:17', '2024-07-29 18:56:17'),
(4, 'gallery-4.jpg', '', 1, '2024-07-29 18:56:17', '2024-07-29 18:56:17');

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_07_22_124130_create_password_resets_table', 1),
(5, '2024_07_23_013005_add_quantity_to_cart_table', 2);

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `firstname`, `lastname`, `country`, `state`, `streetaddress`, `address_line2`, `towncity`, `postcodezip`, `phone`, `email`, `total_price`, `paymentMethod`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(39, 'Emmanuel Ariyo', 'Ogunfunwa', 'Angola', 'Benguela', 'America', NULL, 'Lagos', '0000245', '08081770338', 'mundipat@yahoo.com', 2.55, 'Transfer', 3, NULL, '2024-08-23 17:23:41', '2024-08-23 17:23:41'),
(38, 'Emmanuel Ariyo', 'Ogunfunwa', 'Brazil', 'Acre', 'America', NULL, 'Lagos', '0000245', '08081770338', 'user@user.com', 2.55, 'Card', 3, NULL, '2024-08-22 10:43:45', '2024-08-22 10:43:45'),
(37, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Ogun', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 4.50, 'Transfer', 1, NULL, '2024-08-15 18:22:34', '2024-08-15 18:22:34'),
(36, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Ogun', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 4.50, 'Cash', 1, NULL, '2024-08-06 11:10:41', '2024-08-06 11:10:41'),
(35, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Edo', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 4.50, 'Card', 3, NULL, '2024-08-01 03:00:49', '2024-08-01 03:00:49'),
(34, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Ogun', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 3.00, 'Card', 3, NULL, '2024-07-31 09:47:48', '2024-07-31 09:47:48'),
(29, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Ogun', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 3.00, 'Transfer', 1, NULL, '2024-07-30 22:08:16', '2024-07-30 22:08:16'),
(30, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Ogun', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 3.00, 'Card', 1, NULL, '2024-07-30 22:15:33', '2024-07-30 22:15:33'),
(31, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Ogun', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 17.00, 'Transfer', 1, NULL, '2024-07-31 08:46:49', '2024-07-31 08:46:49'),
(32, 'Emmanuel Ariyo', 'Ogunfunwa', 'Nigeria', 'Ogun', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', '39, Opatola Olubushe Street, Ayetoro, Itele Road, Ota, Ogun State, Nigeria.', 'Ota', '00234', '08101033541', 'ariyomiracle1234@gmail.com', 24.50, 'Card', 1, NULL, '2024-07-31 09:10:11', '2024-07-31 09:10:11'),
(33, 'User', 'User', 'Brazil', 'Acre', '2, Road H, Righteous CDA, Opposite Ola Anobi Block, Onigbin, Obasanjo Farm Bus Stop', NULL, 'Ota', '00234', '08081770338', 'user@user.com', 51.30, 'Card', 3, NULL, '2024-07-31 09:44:15', '2024-07-31 09:44:15');

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ariyomiracle1234@gmail.com', '$2y$12$weHy9kJ2xRThpEn.xg8Hh.BJFj.VDb3f5HfRbQ6x/Uf0DlPaj4/6O', '2024-08-24 18:13:05');

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `description`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Coffee Capuccino', 'product_1.jpg', 5.90, 'A strong and concentrated coffee brewed by forcing hot water through finely-ground coffee beans. It\'s the base for many coffee drinks.', 'drink', '2024-07-22 19:20:01', '2024-07-22 19:20:01'),
(2, 'Espresso', 'product_2.jpg', 5.90, 'Made with equal parts espresso, steamed milk, and milk foam. It\'s known for its creamy texture and rich flavor.', 'drink', '2024-07-22 19:20:23', '2024-07-22 19:20:23'),
(3, 'Latte', 'product_3.jpg', 5.55, 'Similar to cappuccino but with more steamed milk and less foam. It has a smoother, creamier taste.', 'drink', '2024-07-22 19:20:33', '2024-07-22 19:20:33'),
(4, 'Americano\n', 'product_4.jpg', 6.00, 'Made by diluting a shot of espresso with hot water, resulting in a coffee that’s similar in strength to drip coffee but with a different flavor profile.', 'drink', '2024-07-22 19:20:40', '2024-07-22 19:20:40'),
(5, 'Pancake\r\n', 'dessert-1.jpg', 6.00, 'A popular Italian dessert made with ladyfingers soaked in coffee and liqueur, layered with a creamy mascarpone cheese mixture, and cocoa powder. The coffee and mascarpone give tiramisu its distinctive flavor and creamy texture, making it a beloved treat around the world.\r\n', 'dessert', '2024-07-22 19:20:40', '2024-07-22 19:20:40'),
(6, 'Tiramisu\r\n', 'dessert-2.jpg', 7.50, 'A popular Italian dessert made with ladyfingers soaked in coffee and liqueur, layered with a creamy mascarpone cheese mixture, and cocoa powder. The coffee and mascarpone give tiramisu its distinctive flavor and creamy texture, making it a beloved treat around the world.\r\n', 'dessert', '2024-07-22 19:20:40', '2024-07-22 19:20:40'),
(7, 'Seasonal Soup', 'dessert-3.jpg', 20.00, 'A small river named Duden flows by their place and supplies', 'dessert', '2024-07-27 18:17:01', '2024-07-27 18:17:01'),
(8, 'Chicken Curry', 'dessert-4.jpg', 15.00, 'A small river named Duden flows by their place and supplies', 'dessert', '2024-07-27 18:17:01', '2024-07-27 18:17:01');

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon_class`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'flaticon-choices', 'Easy to order', 'Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.', 1, '2024-07-28 20:56:31', '2024-07-28 20:56:31'),
(2, 'flaticon-delivery-truck', 'Fastest Delivery', 'Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.', 1, '2024-07-28 20:56:31', '2024-07-28 20:56:31'),
(3, 'flaticon-coffee-bean', 'Quality Coffee', 'Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.', 1, '2024-07-28 20:56:31', '2024-07-28 20:56:31'),
(4, 'flaticon-choices', 'Easy to choose', 'Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.', 1, '2024-07-28 20:56:31', '2024-07-28 20:56:31'),
(5, 'flaticon-delivery-truck', 'Fastest Service', 'Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.', 1, '2024-07-28 20:56:31', '2024-07-28 20:56:31'),
(6, 'flaticon-coffee-bean', 'Quality Drink', 'Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.', 1, '2024-07-28 20:56:31', '2024-07-28 20:56:31');

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fFbafQCAZKHMvgZCR8WSwzMZqAAI8ViBevCcGJ2i', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlhuaHl5MnF4TG9TNlpTaEZiOTQ1Z0phZXpoRmJZWm1mZjV3RHJtciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1724616501),
('uqhx1d24pY9JKC3nLIzr71PpqVu5QSEJ8SeB3fTm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZW9yWE9WRENsNGxHb2NjN09DREF1OUJIMzJZRkJDa0t6N0ROR1A1TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9fQ==', 1724616638),
('6vZoA5ztP1AReFZCoJ3CdJK13FRca4px9xozpn5c', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS1BMcmZEWDdUQU5XNkEzMW54QTlzZGdHWjUyMHpob1lCY2ZwYXI3UCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1724617035);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BroCode', 'ariyomiracle1234@gmail.com', NULL, '$2y$12$K6ojNmqsiaIspIQNgV.lIO6bV8QQFPtotVmR3rwx6aOodbIjsVKqO', 'bcohEaDuhubUEE6G9guVJkdru0TiI6W9nGngefPtxfn3egZTUXrxgD390gWR', 1, '2024-07-22 11:55:20', '2024-08-25 19:16:11'),
(2, 'Jon Deo', 'johndoe@gmail.com', NULL, '$2y$12$dAvOGMBJqZYo49XinVDskOb0YY8djSHKvlM7KFHbSITG/jSvpw5zO', 'swM2jsbPOeRXiWndvMi3112G4yj4KSjvUsRlb9FrvGuA8fgQ6hKMMZuLkSow', 1, '2024-07-22 15:03:31', '2024-07-22 15:03:31'),
(4, 'John Doe', 'johnnyjohn@gmail.com', NULL, '$2y$12$kWqgTl2VxrYhCHdYbNa7.eJNKiVfpz7tQ72Ptcs5dU8OhICaZEuD6', NULL, 1, '2024-08-20 05:10:21', '2024-08-20 05:10:21');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
