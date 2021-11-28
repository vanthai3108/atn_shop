-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 12, 2021 lúc 03:46 PM
-- Phiên bản máy phục vụ: 10.4.19-MariaDB
-- Phiên bản PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `atn_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`) VALUES
(1, 'Funko'),
(2, 'Car model'),
(3, 'Superman model'),
(4, 'Airplane model');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pay`
--

CREATE TABLE `pay` (
  `PayID` int(11) NOT NULL,
  `PayNumber` int(11) NOT NULL,
  `PayDate` datetime NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `pay`
--

INSERT INTO `pay` (`PayID`, `PayNumber`, `PayDate`, `UserID`, `ProductID`) VALUES
(1, 1, '2021-07-12 20:08:56', 1, 1),
(2, 1, '2021-07-12 20:08:56', 1, 3),
(3, 1, '2021-07-12 20:11:30', 1, 1),
(4, 1, '2021-07-12 20:12:01', 1, 2),
(5, 1, '2021-07-12 20:13:07', 1, 2),
(6, 6, '2021-07-12 20:14:16', 1, 2),
(7, 1, '2021-07-12 20:14:57', 1, 2),
(8, 5, '2021-07-12 20:15:37', 1, 2),
(9, 3, '2021-07-12 20:17:27', 1, 2),
(10, 1, '2021-07-12 20:23:57', 1, 2),
(11, 1, '2021-07-12 20:26:49', 1, 2),
(12, 1, '2021-07-12 20:28:47', 1, 2),
(13, 1, '2021-07-12 20:29:39', 1, 2),
(14, 4, '2021-07-12 20:29:59', 1, 2),
(15, 3, '2021-07-12 20:36:30', 1, 2),
(16, 3, '2021-07-12 20:39:34', 1, 2),
(17, 1, '2021-07-12 20:39:49', 1, 2),
(18, 3, '2021-07-12 20:40:55', 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(200) NOT NULL,
  `ProductScript` text NOT NULL,
  `ProductImage` varchar(200) NOT NULL,
  `ProductPrices` int(16) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductScript`, `ProductImage`, `ProductPrices`, `CategoryID`) VALUES
(1, 'The Mandalorian 379', 'this is a product', 'nnnh2.jpg', 18, 1),
(2, 'The Mandalorian 351', 'this is a product', 'h3.jpg', 15, 1),
(3, 'The Mandalorian 350', 'this is a product', 'h10.jpg', 20, 1),
(4, 'Naruto', 'this is a product', 'h5.jpg', 16, 1),
(5, 'SOUL EATER', 'this is a product', 'h6.jpg', 24, 1),
(6, 'Kimono', 'this is a product', 'h7.jpg', 20, 1),
(7, 'Critical Role', 'this is a', 'h4.jpg', 25, 1),
(8, 'Pokemon', 'this is a', 'h8.jpg', 18, 1),
(9, 'Colonel Mustang', 'This a demo', 'h9.jpg', 15, 1),
(11, 'ANTSIR Car Model 1 ', 'this is description', 'l1.jpg', 12, 2),
(12, 'ANTSIR Car Model 2 ', 'this is description', 'l3.jpg', 12, 2),
(14, 'ANTSIR Car Model 3 ', 'this is description', 'l2.jpg', 12, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(36) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `FullName` varchar(200) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `EmailAddress` varchar(200) NOT NULL,
  `AvataImage` varchar(250) NOT NULL,
  `Permission` int(1) DEFAULT NULL,
  `Status` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`UserID`, `UserName`, `Password`, `FullName`, `PhoneNumber`, `EmailAddress`, `AvataImage`, `Permission`, `Status`) VALUES
(1, 'thaimv', 'thaimv', 'Van Thai', '0969570235', 'thai0001@gmail.com', 'h4.jpg', 1, 'true'),
(2, 'thai', 'thai', 'Van Thai', '05025455115', 'thai1234@gmail.com', 'h7.jpg', 0, 'true');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `cart_pro` (`ProductID`),
  ADD KEY `cart_user` (`UserID`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`PayID`),
  ADD KEY `pay_pro` (`ProductID`),
  ADD KEY `pay_user` (`UserID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `cat_pro` (`CategoryID`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `pay`
--
ALTER TABLE `pay`
  MODIFY `PayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_pro` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `pay`
--
ALTER TABLE `pay`
  ADD CONSTRAINT `pay_pro` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pay_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `cat_pro` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
