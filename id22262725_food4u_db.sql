-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2024 at 01:56 PM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id22262725_food4u_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `ADMIN_ID` int(11) NOT NULL,
  `ADMIN_NAME` varchar(100) NOT NULL,
  `ADMIN_EMAIL` varchar(255) NOT NULL,
  `ADMIN_PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`ADMIN_ID`, `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`) VALUES
(0, 'FOOD4U ADMIN #1', 'admin1@food4u.com', '$2y$10$iEN8qMUJAB85OU.jG3TwHOvW3R.gU9qXMOPMYqsVDUft0DSPLhteO');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `DONATION_ID` int(11) NOT NULL,
  `EVENT_ID` int(11) NOT NULL,
  `DONATION_QTY` int(11) NOT NULL,
  `DONATION_STATUS` varchar(10) NOT NULL,
  `DONATION_DATE` date NOT NULL,
  `MONEY_QR` varchar(255) DEFAULT NULL,
  `VOL_ID` int(11) NOT NULL,
  `FOOD_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`DONATION_ID`, `EVENT_ID`, `DONATION_QTY`, `DONATION_STATUS`, `DONATION_DATE`, `MONEY_QR`, `VOL_ID`, `FOOD_ID`) VALUES
(20, 4, 100, 'accepted', '2024-06-29', 'assets/payment_proof/1719658085_pen.png', 5, NULL),
(21, 4, 30, 'accepted', '2024-06-29', NULL, 5, 9),
(22, 4, 30, 'accepted', '2024-06-29', NULL, 5, 10),
(23, 4, 500, 'accepted', '2024-06-29', 'assets/payment_proof/1719663461_1718761414.webp', 1, NULL),
(24, 4, 25, 'accepted', '2024-06-29', NULL, 1, 10),
(25, 4, 10, 'accepted', '2024-06-29', NULL, 1, 12),
(27, 8, 30, 'accepted', '2024-06-29', NULL, 2, 26),
(28, 8, 10, 'accepted', '2024-06-29', NULL, 2, 27),
(29, 8, 100, 'accepted', '2024-06-30', 'assets/payment_proof/1719699885_image_2024-06-30_010626503-removebg-preview.png', 8, NULL),
(31, 8, 810, 'accepted', '2024-06-30', 'assets/payment_proof/1719711080_1718761414.webp', 10, NULL),
(32, 8, 25, 'accepted', '2024-06-30', NULL, 10, 28),
(33, 5, 2, 'pending', '2024-07-01', NULL, 11, 14),
(34, 4, 10, 'pending', '2024-07-02', 'assets/payment_proof/1719875371_FLOOR PLAN.png', 12, NULL),
(35, 4, 5, 'pending', '2024-07-02', NULL, 12, 9),
(36, 8, 15, 'pending', '2024-07-06', NULL, 2, 28);

-- --------------------------------------------------------

--
-- Table structure for table `drop_off`
--

CREATE TABLE `drop_off` (
  `DROPOFF_ID` int(11) NOT NULL,
  `EVENT_ID` int(11) NOT NULL,
  `DROPOFF_ADD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `drop_off`
--

INSERT INTO `drop_off` (`DROPOFF_ID`, `EVENT_ID`, `DROPOFF_ADD`) VALUES
(5, 4, '21, Jalan Raja Muda Abdul Aziz, 50300 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur'),
(6, 4, '54, Jalan Raja Alang, Chow Kit, 50300 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur'),
(7, 5, '32, Jalan Wawasan, 68000 Ampang, Selangor'),
(8, 6, '12, Jalan Plumbum, Seksyen 7, 40000 Shah Alam, Selangor'),
(9, 6, '5, Jalan Persiaran Kayangan, Seksyen 7, 40000 Shah Alam, Selangor'),
(11, 8, '14, Jalan Labu, 70200 Seremban, Negeri Sembilan'),
(13, 8, '9, Jalan Dato Bandar Tunggal, 70000 Seremban, Negeri Sembilan'),
(20, 12, 'Taman Nyalas Baru, 77100 Pekan Asahan, Melaka');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `EVENT_ID` int(11) NOT NULL,
  `EVENT_PHOTO` varchar(255) NOT NULL,
  `EVENT_NAME` varchar(255) NOT NULL,
  `EVENT_DATE` date NOT NULL,
  `EVENT_TIME` time NOT NULL,
  `EVENT_ADDRESS` varchar(255) NOT NULL,
  `EVENT_DESC` text NOT NULL,
  `VOL_GOAL` int(11) NOT NULL,
  `VOL_AMOUNT` int(11) NOT NULL,
  `MONEY_GOAL` int(11) NOT NULL,
  `MONEY_AMOUNT` int(11) NOT NULL,
  `ADMIN_ID` int(11) NOT NULL,
  `REQ_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`EVENT_ID`, `EVENT_PHOTO`, `EVENT_NAME`, `EVENT_DATE`, `EVENT_TIME`, `EVENT_ADDRESS`, `EVENT_DESC`, `VOL_GOAL`, `VOL_AMOUNT`, `MONEY_GOAL`, `MONEY_AMOUNT`, `ADMIN_ID`, `REQ_ID`) VALUES
(4, 'assets/event_images/1719573519_EVENT_3.jpg', 'Food and Hygiene Drive for the Homeless in Chow Kit', '2024-07-05', '10:00:00', '54, Jalan Raja Alang, Chow Kit, 50300 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 'This drive focuses on providing essential food and hygiene products to the homeless population in Chow Kit. We will have food distribution, personal hygiene workshops, and medical consultations. The goal is to support health and well-being through proper nutrition and hygiene.', 15, 1, 7000, 600, 0, NULL),
(5, 'assets/event_images/1719574465_EVENT_4.jpg', 'Back to School Program for Low-Income Families in Ampang', '2024-07-03', '15:30:00', '12, Jalan Ampang, 68000 Ampang, Selangor', 'This event aims to support low-income families as they prepare for the new school year. In addition to food distribution, we will provide school supplies, uniforms, and educational workshops. The goal is to ensure children have the necessary resources to succeed academically.', 6, 1, 2500, 0, 0, NULL),
(6, 'assets/event_images/1719574805_EVENT_5.avif', 'Ramadan Food Drive for Underprivileged Families in Shah Alam', '2024-03-18', '15:30:00', '5, Jalan Persiaran Kayangan, Seksyen 7, 40000 Shah Alam, Selangor', 'This drive is dedicated to supporting underprivileged families during Ramadan. We will distribute food packages suitable for breaking fast, including dates, rice, and lentils. Activities include community iftar (breaking fast) events and religious talks.', 5, 0, 1500, 0, 0, NULL),
(8, 'assets/event_images/1719575258_EVENT_7.jpg', 'Elderly Support Program in Seremban Food Drive', '2024-07-09', '10:00:00', '9, Jalan Dato Bandar Tunggal, 70000 Seremban, Negeri Sembilan', 'This program focuses on supporting the elderly community in Seremban with essential food items and nutritional supplements. Activities include health screenings, social activities, and distribution of care packages. The aim is to enhance their quality of life.', 24, 3, 4000, 4000, 0, NULL),
(12, 'assets/event_images/1720228282_image_2024-07-06_090951097.png', 'Rural Village Area Food Donation (Edited)', '2024-07-25', '10:15:00', 'Kampung Orang Asli Lubuk Bandung, Taman Nyalas Baru, 77100, Pekan Asahan, Melaka', 'To provide food for those who live in the rural area.', 30, 0, 5000, 5000, 0, 11);

-- --------------------------------------------------------

--
-- Table structure for table `event_request`
--

CREATE TABLE `event_request` (
  `REQ_ID` int(11) NOT NULL,
  `REQ_NAME` varchar(255) NOT NULL,
  `REQ_ADDRESS` varchar(255) NOT NULL,
  `REQ_DESC` text NOT NULL,
  `REQ_RECPTNUM` int(11) NOT NULL,
  `REQ_ASSISTANCE` text NOT NULL,
  `REQ_DATE` date NOT NULL,
  `REQ_IMAGE` varchar(255) NOT NULL,
  `PARTNERSHIP` tinyint(1) NOT NULL,
  `REQ_STATUS` varchar(10) NOT NULL,
  `VOL_ID` int(11) DEFAULT NULL,
  `ORG_ID` int(11) DEFAULT NULL,
  `ADMIN_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event_request`
--

INSERT INTO `event_request` (`REQ_ID`, `REQ_NAME`, `REQ_ADDRESS`, `REQ_DESC`, `REQ_RECPTNUM`, `REQ_ASSISTANCE`, `REQ_DATE`, `REQ_IMAGE`, `PARTNERSHIP`, `REQ_STATUS`, `VOL_ID`, `ORG_ID`, `ADMIN_ID`) VALUES
(5, 'new event', 'jalan udang', 'best', 100, 'orang susah', '2024-06-29', 'assets/request_images/1719658372_pen.png', 0, 'pending', 6, NULL, NULL),
(8, 'a', 'a', 'a', 2, 'a', '2024-06-30', 'assets/request_images/1719706694_FLOOR PLAN (1).png', 0, 'pending', NULL, 3, NULL),
(11, 'Rural Village Area Food Donation', 'Kampung Orang Asli Lubuk Bandung, Taman Nyalas Baru, 77100, Pekan Asahan, Melaka', 'To provide food for those who live in the rural area.', 100, '5 days and 4 night event. Need someone who can in the rural area and physically fit.', '2024-07-06', 'assets/request_images/1720228282_image_2024-07-06_090951097.png', 0, 'accepted', 2, NULL, NULL),
(12, 'Iftar with Homeless People', 'Jalan Petaling, City Centre, 50000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 'Provide food for around 300 homeless people in KL', 15, 'Physically Fit', '2024-07-06', 'assets/request_images/1720233164_Overfeeding-street-sleepers.png', 1, 'pending', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_donation`
--

CREATE TABLE `food_donation` (
  `FOOD_ID` int(11) NOT NULL,
  `EVENT_ID` int(11) NOT NULL,
  `FOOD_TYPE` varchar(255) NOT NULL,
  `FOOD_GOAL` int(11) NOT NULL,
  `FOOD_AMOUNT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `food_donation`
--

INSERT INTO `food_donation` (`FOOD_ID`, `EVENT_ID`, `FOOD_TYPE`, `FOOD_GOAL`, `FOOD_AMOUNT`) VALUES
(9, 4, 'Canned Food', 100, 30),
(10, 4, 'Cooking Oil (1kg)', 50, 55),
(11, 4, 'Rice Bags (10kg)', 50, 0),
(12, 4, 'Hygiene Kits', 200, 10),
(13, 5, 'Fresh Fruits', 100, 0),
(14, 5, 'Multigrain Cereal', 60, 0),
(15, 5, 'Instant Oat Meal', 75, 0),
(16, 6, 'Dates', 100, 0),
(17, 6, 'Cooking Oil (3kg)', 45, 0),
(18, 6, 'Lentils', 60, 0),
(19, 6, 'Rice Bags (5kg)', 35, 0),
(26, 8, 'Nutritional Supplements', 50, 45),
(27, 8, 'Fruits (sorted)', 75, 70),
(28, 8, 'Chicken', 50, 55),
(29, 8, 'Vegetables (sorted)', 75, 40),
(32, 8, 'Instant Noodles', 75, 50),
(40, 12, 'Rice 5KG', 100, 100),
(41, 12, 'Instant Noodles', 500, 500),
(42, 12, 'Canned Food', 200, 200);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `ORG_ID` int(11) NOT NULL,
  `ORG_NAME` varchar(100) NOT NULL,
  `ORG_PASSWORD` varchar(255) NOT NULL,
  `ORG_EMAIL` varchar(255) NOT NULL,
  `ORG_IMAGE` varchar(255) NOT NULL,
  `ORG_PHONE` varchar(20) NOT NULL,
  `ORG_ADDRESS` varchar(255) NOT NULL,
  `ORG_DESC` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`ORG_ID`, `ORG_NAME`, `ORG_PASSWORD`, `ORG_EMAIL`, `ORG_IMAGE`, `ORG_PHONE`, `ORG_ADDRESS`, `ORG_DESC`) VALUES
(1, 'daus sdn bhd', '$2y$10$ShCRm5xgmHwnIq9Dh23D2OocdEzvjFe605mfesTieh3SnBd51r.km', 'mohamadfirdaus04@gmail.com', 'assets/images/default_image.png', '0143741451', 'jalan kenari', 'besar'),
(2, 'Universiti Teknologi MARA', '$2y$10$vCXOJ8URz.I0FSEkWeIghulzUPk9MZbawhrzrxskqNGZnFGmEoZMW', 'amersyafiq44@gmail.com', 'assets/images/default_image.png', '0169039032', 'Jalan Universiti Off, KM 12, Jalan Muar, Kemajuan Tanah Jementah Batu Sebelas, 85000 Segamat, Johor', 'UiTM Segamat Campus is one of the Universiti Teknologi MARA campuses located in the state of Johor Darul Ta\'azim , Malaysia . This campus is the main campus and houses the state\'s executive management, while Pasir Gudang Campus is the second campus.'),
(3, 'JUICER Sdn. Bhd.', '$2y$10$qzdiswkqApxHJkGFV3i3t.MAhWVbwXGwczi3EGJIGrsihtlolseBO', 'humanresources@juicer.com', 'assets/images/default_image.png', '0112223333', 'Jalan Dato Abdul Rahman Musa, Kampung Abdullah, 85000 Segamat, Johor', 'Food and Beverages Manufacturer'),
(4, '448 Foodbank Johor', '$2y$10$s7xMjE7yEwOyLrkNkKLW2uWxXNIR6eufB.pzL4n9tiJcoEBfTcyp6', 'amernafis50@gmail.com', 'assets/images/default_image.png', '1234567890', '8, Jalan Seri Orkid 36, Taman Seri Orkid, 81300 Skudai, Johor, Malaysia.', 'Under the same banner of 448, Persatuan Sukarelawan Berkat Kasih, dedicated to volunteering, and Persatuan Kebajikan Bank Makanan, focused on food banking, collectively embody the ethos of community empowerment and assistance. Together, we form a formidab'),
(5, 'AMER NAFIS', '$2y$10$bPRM28K9eMEpetVVtlwvE.yD1QLPykjpDo02NfEkU.E9rHROSm6oW', 'amernafis55@gmail.com', 'assets/images/default_image.png', '0164552695', 'TEST', 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `participation`
--

CREATE TABLE `participation` (
  `VOL_ID` int(11) NOT NULL,
  `EVENT_ID` int(11) NOT NULL,
  `JOIN_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `participation`
--

INSERT INTO `participation` (`VOL_ID`, `EVENT_ID`, `JOIN_DATE`) VALUES
(1, 8, '2024-07-06'),
(2, 8, '2024-07-06'),
(5, 4, '2024-06-29'),
(10, 8, '2024-06-30'),
(11, 5, '2024-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `partnership`
--

CREATE TABLE `partnership` (
  `PARTNER_ID` int(11) NOT NULL,
  `REQ_ID` int(11) NOT NULL,
  `CONTRIBUTION` text NOT NULL,
  `REQUIREMENTS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `partnership`
--

INSERT INTO `partnership` (`PARTNER_ID`, `REQ_ID`, `CONTRIBUTION`, `REQUIREMENTS`) VALUES
(3, 8, 'a', 'a'),
(5, 12, 'We can give RM100,000 for donation purpose', 'This event to be publicly known (publicity)');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `SPONSOR_ID` int(11) NOT NULL,
  `EVENT_ID` int(11) NOT NULL,
  `PICKUP_ADD` varchar(255) DEFAULT NULL,
  `STATUS` varchar(8) NOT NULL,
  `ORG_ID` int(11) NOT NULL,
  `DROPOFF_ID` int(11) DEFAULT NULL,
  `ADMIN_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`SPONSOR_ID`, `EVENT_ID`, `PICKUP_ADD`, `STATUS`, `ORG_ID`, `DROPOFF_ID`, `ADMIN_ID`) VALUES
(4, 6, NULL, 'pending', 2, 8, NULL),
(5, 8, NULL, 'accepted', 1, 13, 0),
(6, 5, NULL, 'notified', 2, 7, NULL),
(7, 4, NULL, 'notified', 2, 6, NULL),
(9, 8, '8, Jalan Seri Orkid 36, Taman Seri Orkid, 81300 Skudai, Johor, Malaysia', 'deferred', 4, NULL, 0),
(10, 12, NULL, 'accepted', 2, 20, 0),
(11, 12, 'Kampung Orang Asli Lubuk Bandung, Taman Nyalas Baru, 77100, Pekan Asahan, Melaka', 'deferred', 4, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `VOL_ID` int(11) NOT NULL,
  `VOL_NAME` varchar(70) NOT NULL,
  `VOL_PASSWORD` varchar(255) NOT NULL,
  `VOL_IMAGE` varchar(255) NOT NULL,
  `VOL_EMAIL` varchar(255) NOT NULL,
  `VOL_PHONE` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`VOL_ID`, `VOL_NAME`, `VOL_PASSWORD`, `VOL_IMAGE`, `VOL_EMAIL`, `VOL_PHONE`) VALUES
(1, 'AMER SYAFIQ BIN ABDUL RAZAK', '$2y$10$Cr2Yb0SS79s/wSrSjjXCF.yAo49Urn3/wGzQ4RHede9F/DNDqwZoG', 'assets/user_images/1719102019_syafiq-min.png', 'someoneyouknow155@gmail.com', '0169039032'),
(2, 'MOHAMAD FIRDAUS BIN MOHD RAZI', '$2y$10$c.5iZ.PLfaeIZDo7l5C1ced3dli3lhRVg.jjjJi.oJotib2iYcFau', 'assets/images/default_image.png', 'daus.guccigang@gmail.com', '0143741451'),
(3, 'firdaus', '$2y$10$MNDA2HxMbO4hmEDHm0rbEuDaq0//BMZqdg94.9Q4JKzgtueUYtVJa', 'assets/images/default_image.png', 'firdausrazi04@gmail.com', '0143741451'),
(4, 'TEST NAME FOR VOLUNTEER', '$2y$10$T3od1PL2XAKdNWfz.u.Sv.0CXbZ4Yr2YkRfRodr3JDeunqR6low0O', 'assets/images/default_image.png', 'hihimystery155@gmail.com', '0169039032'),
(5, 'PANJANG', '$2y$10$dPSN/8uKrJrur6iNZWVBWeR5Fk2gBMn0UQsJDF4BdFnwIMs/CofY.', 'assets/images/default_image.png', 'panjang13@gmail.com', '0147856945'),
(6, 'dasdasdas', '$2y$10$x.yWR51E9NMt0RnJ.zg5SeLYQ3951U74szu/jJ.vm9unWVdHytSmW', 'assets/images/default_image.png', 'dasdassda@gmail.com', '2165055'),
(7, 'firdaus', '$2y$10$OzC4vW93MrB6.F7LIlQYru7Z7sXKnly.x6DeI640jfquqAW8s5EPW', 'assets/user_images/1719699538_04c73392eee546b7cc24bfc1db628485.png', 'firdausrazi99@gmail.com', '0143741451'),
(8, 'firdaus', '$2y$10$HFsFqsnQs5aFaXV2cAYTq.nG12/XJCzHAXnijBWrWa0Crp8i.sYUe', 'assets/user_images/1719699599_04c73392eee546b7cc24bfc1db628485.png', 'mohamadfirdaus79@gmail.com', '0143741451'),
(9, 'MOHAMAD FIRDAUS BIN MOHD RAZI', '$2y$10$IQFk9IfMB8mNikR2uIHNi.H8xOSjzHWjCVV2el5v/n8arFDgyum6a', 'assets/images/default_image.png', 'dausrazi@gmail.com', '0123456789'),
(10, 'AMER SYAFIQ BIN ABDUL RAZAK', '$2y$10$ABy.EGWgcrAmgLg2vz8Y4eI1VGHcDzG/lVAw8nmjhOyKdDDZxPnJu', 'assets/user_images/1719710958_vol_profile_pic.png', 'amersyafiq1103@gmail.com', '0169039032'),
(11, 'syakir', '$2y$10$zIkIWIgou.fXEPPuQUudH.oJgv/oaxygpm0uxpRgarhw1ipTEsxAm', 'assets/images/default_image.png', 'syakfai04@gmail.com', '0177992023'),
(12, 'AMER NAFIS BIN ABDUL RAZAK', '$2y$10$8FyRRV5SXq3giTt.upNkluSkn8ZotOsUz16ib2QmXDx78zP/0uuRa', 'assets/user_images/1719875282_depositphotos_137014128-stock-illustration-user-profile-icon.jpg', 'amernafis1103@gmail.com', '016-4552695');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`ADMIN_ID`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`DONATION_ID`,`EVENT_ID`) USING BTREE,
  ADD KEY `EVENT_ID` (`EVENT_ID`,`VOL_ID`,`FOOD_ID`),
  ADD KEY `VOL_ID` (`VOL_ID`),
  ADD KEY `FOOD_ID` (`FOOD_ID`);

--
-- Indexes for table `drop_off`
--
ALTER TABLE `drop_off`
  ADD PRIMARY KEY (`DROPOFF_ID`,`EVENT_ID`),
  ADD KEY `EVENT_ID` (`EVENT_ID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`EVENT_ID`),
  ADD KEY `ADMIN_ID` (`ADMIN_ID`),
  ADD KEY `REQ_ID` (`REQ_ID`);

--
-- Indexes for table `event_request`
--
ALTER TABLE `event_request`
  ADD PRIMARY KEY (`REQ_ID`),
  ADD KEY `VOL_ID` (`VOL_ID`,`ORG_ID`),
  ADD KEY `ORG_ID` (`ORG_ID`),
  ADD KEY `ADMIN_ID` (`ADMIN_ID`);

--
-- Indexes for table `food_donation`
--
ALTER TABLE `food_donation`
  ADD PRIMARY KEY (`FOOD_ID`,`EVENT_ID`),
  ADD KEY `EVENT_ID` (`EVENT_ID`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`ORG_ID`);

--
-- Indexes for table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`VOL_ID`,`EVENT_ID`),
  ADD KEY `VOL_ID` (`VOL_ID`,`EVENT_ID`),
  ADD KEY `EVENT_ID` (`EVENT_ID`);

--
-- Indexes for table `partnership`
--
ALTER TABLE `partnership`
  ADD PRIMARY KEY (`PARTNER_ID`,`REQ_ID`),
  ADD KEY `REQ_ID` (`REQ_ID`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`SPONSOR_ID`,`EVENT_ID`) USING BTREE,
  ADD KEY `EVENT_ID` (`EVENT_ID`,`ORG_ID`,`DROPOFF_ID`,`ADMIN_ID`),
  ADD KEY `ORG_ID` (`ORG_ID`),
  ADD KEY `DROPOFF_ID` (`DROPOFF_ID`),
  ADD KEY `ADMIN_ID` (`ADMIN_ID`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`VOL_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `ADMIN_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `DONATION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `drop_off`
--
ALTER TABLE `drop_off`
  MODIFY `DROPOFF_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `EVENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_request`
--
ALTER TABLE `event_request`
  MODIFY `REQ_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `food_donation`
--
ALTER TABLE `food_donation`
  MODIFY `FOOD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `ORG_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `partnership`
--
ALTER TABLE `partnership`
  MODIFY `PARTNER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sponsor`
--
ALTER TABLE `sponsor`
  MODIFY `SPONSOR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `VOL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`EVENT_ID`) REFERENCES `event` (`EVENT_ID`),
  ADD CONSTRAINT `donation_ibfk_2` FOREIGN KEY (`VOL_ID`) REFERENCES `volunteer` (`VOL_ID`),
  ADD CONSTRAINT `donation_ibfk_3` FOREIGN KEY (`FOOD_ID`) REFERENCES `food_donation` (`FOOD_ID`);

--
-- Constraints for table `drop_off`
--
ALTER TABLE `drop_off`
  ADD CONSTRAINT `drop_off_ibfk_1` FOREIGN KEY (`EVENT_ID`) REFERENCES `event` (`EVENT_ID`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`ADMIN_ID`) REFERENCES `administrator` (`ADMIN_ID`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`REQ_ID`) REFERENCES `event_request` (`REQ_ID`);

--
-- Constraints for table `event_request`
--
ALTER TABLE `event_request`
  ADD CONSTRAINT `event_request_ibfk_1` FOREIGN KEY (`ORG_ID`) REFERENCES `organization` (`ORG_ID`),
  ADD CONSTRAINT `event_request_ibfk_2` FOREIGN KEY (`VOL_ID`) REFERENCES `volunteer` (`VOL_ID`),
  ADD CONSTRAINT `event_request_ibfk_3` FOREIGN KEY (`ADMIN_ID`) REFERENCES `administrator` (`ADMIN_ID`);

--
-- Constraints for table `food_donation`
--
ALTER TABLE `food_donation`
  ADD CONSTRAINT `food_donation_ibfk_1` FOREIGN KEY (`EVENT_ID`) REFERENCES `event` (`EVENT_ID`);

--
-- Constraints for table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`VOL_ID`) REFERENCES `volunteer` (`VOL_ID`),
  ADD CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`EVENT_ID`) REFERENCES `event` (`EVENT_ID`);

--
-- Constraints for table `partnership`
--
ALTER TABLE `partnership`
  ADD CONSTRAINT `partnership_ibfk_1` FOREIGN KEY (`REQ_ID`) REFERENCES `event_request` (`REQ_ID`);

--
-- Constraints for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD CONSTRAINT `sponsor_ibfk_1` FOREIGN KEY (`EVENT_ID`) REFERENCES `event` (`EVENT_ID`),
  ADD CONSTRAINT `sponsor_ibfk_2` FOREIGN KEY (`ORG_ID`) REFERENCES `organization` (`ORG_ID`),
  ADD CONSTRAINT `sponsor_ibfk_3` FOREIGN KEY (`DROPOFF_ID`) REFERENCES `drop_off` (`DROPOFF_ID`),
  ADD CONSTRAINT `sponsor_ibfk_4` FOREIGN KEY (`ADMIN_ID`) REFERENCES `administrator` (`ADMIN_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
