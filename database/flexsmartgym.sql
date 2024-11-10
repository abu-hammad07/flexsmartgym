-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 09:12 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flexsmartgym`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE `attendence` (
  `attend_id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `attend_date` varchar(100) DEFAULT NULL,
  `attend_status` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendence`
--

INSERT INTO `attendence` (`attend_id`, `users_id`, `attend_date`, `attend_status`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(2, 3, '2024-04-20', 'Present', 'noorulahad', '2024-04-20 09:03:11pm', 'noorulahad', '2024-04-25 08:45:57pm'),
(3, 3, '2024-04-19', 'Present', 'noorulahad', '2024-04-20 09:03:41pm', 'noorulahad', '2024-04-25 08:55:23pm'),
(8, 13, '2024-04-25', 'Present', 'noorulahad', '2024-04-25 08:44:56pm', NULL, NULL),
(9, 9, '2024-04-25', 'Present', 'noorulahad', '2024-04-25 08:57:16pm', 'noorulahad', '2024-04-25 08:58:26pm');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(11) NOT NULL,
  `expense_name` varchar(100) DEFAULT NULL,
  `expense_amount` varchar(100) DEFAULT NULL,
  `expense_image` varchar(255) DEFAULT NULL,
  `expense_category_id` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `expense_name`, `expense_amount`, `expense_image`, `expense_category_id`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'Buy New campus ', '900000', '846333138_athletic-man-woman-with-dumbbells.jpg', 2, 'noorulahad', '2024-04-24 18:58:50', 'noorulahad', '2024-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `exp_category_id` int(11) NOT NULL,
  `exp_category_name` varchar(50) DEFAULT NULL,
  `exp_category_status` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`exp_category_id`, `exp_category_name`, `exp_category_status`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'Category1', NULL, 'noorulahad', '2024-04-24', 'noorulahad', '2024-04-25'),
(2, 'Category2', NULL, 'noorulahad', '2024-04-24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pay_fees` varchar(100) DEFAULT NULL,
  `pay_fees_date` varchar(100) DEFAULT NULL,
  `remaining_fees` varchar(100) DEFAULT NULL,
  `remaining_fees_date` varchar(100) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `trx_image` varchar(255) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `user_id`, `pay_fees`, `pay_fees_date`, `remaining_fees`, `remaining_fees_date`, `payment_method`, `trx_image`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(22, 3, '7000', '2024-04-25', '0', NULL, 'Cash', '575023126_', 'noorulahad', '2024-04-25', NULL, NULL),
(24, 4, '3000', '2024-04-25', '0', NULL, 'Cash', '641077282_', 'noorulahad', '2024-04-25', NULL, NULL),
(25, 4, '7000', '2024-04-25', '0', NULL, 'Cash', '153228643_', 'noorulahad', '2024-04-25', NULL, NULL),
(26, 4, '7000', '2024-04-25', '0', NULL, 'Cash', '424080531_', 'noorulahad', '2024-04-25', NULL, NULL),
(28, 10, '3000', '2024-04-25', '0', NULL, 'Cash', '657748973_', 'noorulahad', '2024-04-25', NULL, NULL),
(29, 10, '7000', '2024-04-25', '0', NULL, 'Jazzcash', '876544718_', 'noorulahad', '2024-04-25', NULL, NULL),
(30, 10, '3000', '2024-04-25', '0', '2024-04-25', 'Cash Amount', '386388928_', 'noorulahad', '2024-04-25', 'noorulahad', '2024-04-25'),
(31, 11, '7000', '2024-04-25', '0', NULL, 'Cash Amount', '572451814_', 'noorulahad', '2024-04-25', NULL, NULL),
(32, 12, '4000', '2024-04-25', '1000', NULL, 'Cash Amount', '120324449_', 'noorulahad', '2024-04-25', NULL, NULL),
(33, 12, '5000', '2024-04-25', '0', NULL, 'Cash Amount', '568641085_', 'noorulahad', '2024-04-25', NULL, NULL),
(34, 12, '5000', '2024-04-25', '0', '2024-04-25', 'Cash Amount', '859633540_', 'noorulahad', '2024-04-25', 'noorulahad', '2024-04-25'),
(35, 13, '5000', '2024-04-25', '0', NULL, 'Cash Amount', '252400558_', 'noorulahad', '2024-04-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `membership_id` int(11) NOT NULL,
  `membership_name` varchar(100) DEFAULT NULL,
  `membership_amount` varchar(100) DEFAULT NULL,
  `validation_days` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`membership_id`, `membership_name`, `membership_amount`, `validation_days`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'Basic', '3000', 30, NULL, NULL, NULL, NULL),
(2, 'Platinum', '5000', 10, 'noorulahad', '2024-04-20', NULL, NULL),
(3, 'Gold', '7000', 6, 'noorulahad', '2024-04-20', NULL, NULL),
(4, 'Platinum2', '4000', 50, 'noorulahad', '2024-04-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership_details`
--

CREATE TABLE `membership_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `membership_start_date` varchar(100) DEFAULT NULL,
  `membership_end_date` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `membership_details`
--

INSERT INTO `membership_details` (`id`, `user_id`, `membership_id`, `membership_start_date`, `membership_end_date`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(12, 3, 1, '2024-02-24', '2024/04/21', 'noorulahad', '2024-04-24', NULL, NULL),
(13, 3, 3, '2024-04-24', '2024/04/23', 'noorulahad', '2024-04-24', NULL, NULL),
(14, 3, 1, '2024-04-20', '2024/04/24', 'noorulahad', '2024-04-24', NULL, NULL),
(15, 3, 3, '2024-04-01', '2024/04/23', 'noorulahad', '2024-04-24', NULL, NULL),
(16, 4, 3, '2024-02-24', '2024/04/23', 'noorulahad', '2024-04-24', NULL, NULL),
(17, 3, 3, '2024-04-24', '2024/04/30', 'noorulahad', '2024-04-24', NULL, NULL),
(18, 3, 3, '2024-02-25', '2024/04/02', 'noorulahad', '2024-04-25', NULL, NULL),
(19, 4, 1, '2024-01-01', '2024/01/31', 'noorulahad', '2024-04-25', NULL, NULL),
(20, 4, 1, '2024-04-01', '2024/02/01', 'noorulahad', '2024-04-25', NULL, NULL),
(21, 4, 3, '2024-01-25', '2024/02/31', 'noorulahad', '2024-04-25', NULL, NULL),
(22, 4, 3, '2024-04-24', '2024/04/03', 'noorulahad', '2024-04-25', NULL, NULL),
(23, 4, 2, '2024-04-01', '2024/04/11', 'noorulahad', '2024-04-25', NULL, NULL),
(24, 10, 1, '2024-02-01', '2024/03/02', 'noorulahad', '2024-04-25', NULL, NULL),
(25, 10, 3, '2024-03-01', '2024/03/07', 'noorulahad', '2024-04-25', NULL, NULL),
(26, 10, 1, '2024-01-01', '2024/01/31', 'noorulahad', '2024-04-25', NULL, NULL),
(27, 11, 3, '2023-12-31', '2024/01/06', 'noorulahad', '2024-04-25', NULL, NULL),
(28, 12, 2, '2024-01-01', '2024/01/11', 'noorulahad', '2024-04-25', NULL, NULL),
(29, 12, 2, '2024-03-21', '2024/03/31', 'noorulahad', '2024-04-25', NULL, NULL),
(30, 12, 2, '2024-04-17', '2024/04/27', 'noorulahad', '2024-04-25', NULL, NULL),
(31, 13, 2, '2024-01-01', '2024/01/11', 'noorulahad', '2024-04-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`, `status`) VALUES
(1, 'Admin', 'Active'),
(2, 'Staff', 'Active'),
(3, 'Member', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `monthly_date` varchar(100) DEFAULT NULL,
  `pay_salary` varchar(100) DEFAULT NULL,
  `remaining_salary` varchar(100) DEFAULT NULL,
  `remaining_salary_date` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `users_id`, `monthly_date`, `pay_salary`, `remaining_salary`, `remaining_salary_date`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(4, 9, '2024-04', '7000', '0', '2024-04-25', 'noorulahad', '2024-04-24 21:56:21', 'noorulahad', '2024-04-25'),
(5, 9, '2023-12', '7000', '0', '2024-04-25', 'noorulahad', '2024-04-25 23:46:14', 'noorulahad', '2024-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `users_detail_id` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role_id`, `token`, `status`, `users_detail_id`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'noorulahad', 'noorulahad606@gmail.com', '$2y$10$c0jzfY3b0ZbF/ismBYFVZOLujQc3OAuaVGAxD1z5dFEiajWROEThW', 1, '50cc2ceef1e84385d7946dddbe340745e23fb558f9ea3cc00ebadf48120835d3e552d0c6a1c28e94067e9096ba00a65c13b0', 'Active', 1, NULL, NULL, 'noorulahad', '2024-04-25'),
(3, 'abu_hammad', 'hammadkamal2003@gmail.com', '$2y$10$jxtCAZPPM//bkzoRAR7DeeoSpbcE8LDepo6r63eB24jeXsHOwxQ1u', 3, '5429e1a5c1c882b865cd2544faa353f76c05ee7170e0019b45068d4e4570485f6dd42fc8510771e231dd96a0539d23c207c5', 'Active', 6, 'noorulahad', '2024-04-20', 'noorulahad', '2024-04-25'),
(4, 'noorulhaye', 'noorulhaye@gmail.com', '$2y$10$y8E7dLVPlvHqSEYuA2PNXOcToPrpO968Idgkc6AUUsvnCMaiP6Efq', 3, 'e3b5ea31364f0e158c717aa47612d0b87e9c4bf018876618156ab5a39441f7fc4ca6b4fc07a6ee1af3a5704049b9732395ac', 'Active', 7, 'noorulahad', '2024-04-20', 'noorulahad', '2024-04-20'),
(9, 'rayyan_nazeer', 'rayyan_nazeer@gmail.com', '$2y$10$pwEhboNHAf6YQSAf.0aw4u8wnPwivFUqbXy6ahUAzOc37MCOHUNoe', 2, 'b3f7a8c8696c9672c8ce5d106fad809b86079a92dcef2cd738e0f53e67ad151f2d798b3858beb4112e0a6075c307a185a23e', 'Active', 12, 'noorulahad', '2024-04-24', 'noorulahad', '2024-04-25'),
(10, 'javeria', 'javeria@gmail.com', '$2y$10$iN.TMJ6K4Jl4Z.hdQ9w8NuOjlMgBgM4E/3iiEbi4mWoUwqiY6fNvC', 3, 'd5fb96061630161183f07539e6cde8894e8b8e5123ecb77ca12e84d0d9cef3570c2014ccc362dbf18e3b3cd38b915bd662d9', 'Active', 13, 'noorulahad', '2024-04-25', NULL, NULL),
(11, 'anus', 'anusad@gmail.com', '$2y$10$1G4F2GcmzoFNoaNM7y4HmOImU0qQTNs13LTOT4a.qk2RLVXyHc9k.', 3, '9f4699809bcc52c77c314ff4281f2c679b69b32758c4696e30cadc933fa97ea012beb8832d03c43fc441d5eb9fe6e9204853', 'Active', 14, 'noorulahad', '2024-04-25', NULL, NULL),
(12, 'saad', 'saad@gmail.com', '$2y$10$znPBrsOrmWCiwBNX//avlO1.jsnsn34AbhfmpRHJrkNT63P3uOVmG', 3, 'e717969066e0a0adee977d9a012665af44202d7f8e1245637b3d37f9997f31d3e57bb6115aa707f6c9bfb5e603d1a203f501', 'Active', 15, 'noorulahad', '2024-04-25', 'noorulahad', '2024-04-25'),
(13, 'saifullah', 'Saifullah@gmail.com', '$2y$10$QJ9EamPfNs4ch8NvrdkS3ueFBhVQ4NMtVWUMJ1UU8dN7fzO8EkBFO', 3, 'bf3e0c706c4bcacfbf0badac78d66ef822a676bd29b8a6ed23f5edacf34f81aff46181b3ebd1f36b8da8c8b8c5813c4bdf8b', 'Active', 16, 'noorulahad', '2024-04-25', 'noorulahad', '2024-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `users_detail`
--

CREATE TABLE `users_detail` (
  `users_detail_id` int(11) NOT NULL,
  `registration_num` int(11) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `admission_fees` varchar(50) DEFAULT NULL,
  `monthly_fees` varchar(50) DEFAULT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `joining_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `start_timing` varchar(100) DEFAULT NULL,
  `end_timing` varchar(100) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_detail`
--

INSERT INTO `users_detail` (`users_detail_id`, `registration_num`, `full_name`, `Phone`, `address`, `gender`, `age`, `city`, `country`, `image`, `membership_id`, `admission_fees`, `monthly_fees`, `salary`, `joining_date`, `end_date`, `start_timing`, `end_timing`, `login_time`, `logout_time`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, NULL, 'NoorulAhad', '03452811522', '36/G Landhi Karachi', 'Male', 20, 'Karachi', 'Pakistan', '161611990_wrestler_6173707.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-25 22:59:50', NULL, NULL, NULL, 'noorulahad', '2024-04-25'),
(6, NULL, 'Abu Hammad', '0399299234', 'landhi', 'Male', 19, 'karachi', 'Pakistan', '303464157_Untitled design (26).png', 3, '5000', '5000', NULL, '2024-04-15', '2024-04-30', NULL, NULL, NULL, NULL, NULL, NULL, 'noorulahad', '2024-04-25'),
(7, NULL, 'Noor Ul Haye', '03992992343', 'landhi', 'Male', 20, 'karachi', 'Pakistan', '111453096_afzal.jpg', 2, '5000', '7000', NULL, '2024-04-20', '2024-04-30', NULL, NULL, NULL, NULL, 'noorulahad', '2024-04-20', 'noorulahad', '2024-04-20'),
(8, NULL, 'Hammad Kamal', '03788888999', 'landhi', 'Male', 19, 'karachi', 'Pakistan', '564745554_barbell_8120100.png', NULL, NULL, NULL, '500000', '2024-04-20', NULL, '18:50', '21:50', NULL, NULL, 'noorulahad', '2024-04-20', 'noorulahad', '2024-04-20'),
(9, NULL, 'Noor Ul Hadi', '039929993', 'landhi', 'Male', 19, 'karachi', 'Pakistan', '157998218_bench-press_3996458.png', NULL, NULL, NULL, '5000', '2024-04-14', NULL, '21:51', '15:51', NULL, NULL, 'noorulahad', '2024-04-20', 'noorulahad', '2024-04-20'),
(10, NULL, 'Rayyan', '03992433243', 'landhi', 'Female', 20, 'karachi', 'Pakistan', '334068721_staff.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'noorulahad', '2024-04-20', 'noorulahad', '2024-04-20'),
(12, NULL, 'Rayyan', '03999888', 'landhi', 'Male', 20, 'karachi', 'Pakistan', '495166920_barbell_8120100.png', NULL, NULL, NULL, '7000', '2024-04-24', NULL, '21:55', '23:55', NULL, NULL, 'noorulahad', '2024-04-24', 'noorulahad', '2024-04-25'),
(13, NULL, 'javeria', '039923434', 'landhi', 'Female', 19, 'karachi', 'Pakistan', '268802528_t2.png', 1, '5000', '5000', NULL, '2024-02-01', '', NULL, NULL, NULL, NULL, 'noorulahad', '2024-04-25', NULL, NULL),
(14, NULL, 'Anus', '039943422', 'landhi', 'Male', 24, 'karachi', 'Pakistan', '339889169_wrestler_6173707.png', 3, '5000', '7000', NULL, '2023-12-30', '', NULL, NULL, NULL, NULL, 'noorulahad', '2024-04-25', NULL, NULL),
(15, NULL, 'Saad', '0312897766', 'Karachi', 'Male', 30, 'karachi', 'Pakistan', '391514662_Untitled design (19).png', 2, '5000', '5000', NULL, '2024-01-01', '', NULL, NULL, NULL, NULL, 'noorulahad', '2024-04-25', 'noorulahad', '2024-04-25'),
(16, NULL, 'Saifullah', '03131187142', 'landhi', 'Male', 24, 'karachi', 'Pakistan', '342823004_gym_10484999.png', 2, '5000', '5000', NULL, '2024-04-01', '', NULL, NULL, NULL, NULL, 'noorulahad', '2024-04-25', 'noorulahad', '2024-04-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendence`
--
ALTER TABLE `attendence`
  ADD PRIMARY KEY (`attend_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `expense_category_id` (`expense_category_id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`exp_category_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`membership_id`);

--
-- Indexes for table `membership_details`
--
ALTER TABLE `membership_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `membership_id` (`membership_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `users_detail_id` (`users_detail_id`);

--
-- Indexes for table `users_detail`
--
ALTER TABLE `users_detail`
  ADD PRIMARY KEY (`users_detail_id`),
  ADD KEY `membership_id` (`membership_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `attend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `exp_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `membership_details`
--
ALTER TABLE `membership_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `users_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendence`
--
ALTER TABLE `attendence`
  ADD CONSTRAINT `attendence_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_category` (`exp_category_id`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `membership_details`
--
ALTER TABLE `membership_details`
  ADD CONSTRAINT `membership_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membership_details_ibfk_2` FOREIGN KEY (`membership_id`) REFERENCES `membership` (`membership_id`) ON DELETE CASCADE;

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`users_detail_id`) REFERENCES `users_detail` (`users_detail_id`);

--
-- Constraints for table `users_detail`
--
ALTER TABLE `users_detail`
  ADD CONSTRAINT `users_detail_ibfk_1` FOREIGN KEY (`membership_id`) REFERENCES `membership` (`membership_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
