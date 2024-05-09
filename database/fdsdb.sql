

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `fds_ctlog` (
  `ctlog_id` int(11) NOT NULL,
  `ctlog_usrdt_id` int(11) DEFAULT NULL,
  `ctlog_nme` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_prc` double DEFAULT NULL,
  `ctlog_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_shp` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_img` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctlog_log` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `fds_ctlog` (`ctlog_id`, `ctlog_usrdt_id`, `ctlog_nme`, `ctlog_prc`, `ctlog_desc`, `ctlog_shp`, `ctlog_img`, `ctlog_log`) VALUES
(1, 2, 'mee goreng', 12.9, 'mee goreng dari timur tengah', 'makcik kiah', '2_mee-goreng2.jpg', '2020/12/26 22:30pm'),
(3, 2, 'nasi goreng ayam', 14.9, 'nasi goreng dari jawa tengah', 'makcik kiah', '0008019_nasi-goreng-ayam.jpeg', '2020/12/26 22:32pm'),
(4, 2, 'nasi goreng pattaya', 12.9, 'nasi goreng dari jawa tengah', 'makcik kiah', 'nasi-goreng-pattaya.jpg', '2020/12/26 22:31pm'),
(6, 4, 'kuey tiew basah kungfu', 8.5, 'kuey tiew tiau kungfu hustle dari japang', 'damm', '2_mee-goreng2.jpg', '2020/12/26 22:46pm');



CREATE TABLE `fds_inv` (
  `inv_id` int(11) NOT NULL,
  `inv_ordr_id` int(11) DEFAULT NULL,
  `inv_pay_stat` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `inv_amt` double DEFAULT NULL,
  `inv_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `inv_dte` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `fds_inv` (`inv_id`, `inv_ordr_id`, `inv_pay_stat`, `inv_amt`, `inv_type`, `inv_dte`) VALUES
(7, 3, 'paid', 25.8, 'paypal', '2021/01/05 00:08am'),
(8, 4, 'paid', 29.8, 'paypal', '2021/01/05 00:08am'),
(9, 5, 'none', 25.8, 'cash', '2021/01/05 05:15am'),
(10, 6, 'none', 17, 'cash', '2021/01/05 05:15am'),
(11, 7, 'none', 12.9, 'cash', '2021/01/05 05:29am'),
(12, 8, 'none', 14.9, 'cash', '2021/01/05 05:29am');



CREATE TABLE `fds_ordr` (
  `ordr_id` int(11) NOT NULL,
  `ordr_usrdt_id` int(11) DEFAULT NULL,
  `ordr_ctlog_id` int(11) DEFAULT NULL,
  `ordr_qty` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordr_dte` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordr_stat` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `fds_ordr` (`ordr_id`, `ordr_usrdt_id`, `ordr_ctlog_id`, `ordr_qty`, `ordr_dte`, `ordr_stat`) VALUES
(3, 16, 1, '2', '2021/01/05 00:08am', 'Completed'),
(4, 16, 3, '2', '2021/01/05 00:08am', 'Completed'),
(5, 1, 1, '2', '2021/01/05 05:15am', 'Completed'),
(6, 1, 6, '2', '2021/01/05 05:15am', 'Completed'),
(7, 1, 1, '1', '2021/01/05 05:29am', 'Preparing'),
(8, 1, 3, '1', '2021/01/05 05:29am', 'Preparing');



CREATE TABLE `fds_usrdt` (
  `usrdt_id` int(11) NOT NULL,
  `usrdt_nme` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_usr` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_pwd` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_adrs` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_stat` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usrdt_log` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `fds_usrdt` (`usrdt_id`, `usrdt_nme`, `usrdt_usr`, `usrdt_pwd`, `usrdt_adrs`, `usrdt_stat`, `usrdt_log`) VALUES
(1, 'adam mikail', 'adam', '1d7c2923c1684726dc23d2901c4d8157', 'lingkaran 5 jalan batu sinar 11 bukit kepong', 'user', '2020/11/25 23:09pm'),
(2, 'makcik kiah', 'kiah', '0b79eec866e9be97a8fc9fe9955853fd', 'no 87 jalan lingkaran emas 6 bukit kepong', 'shop', '2020/11/26 00:36am'),
(4, 'damm', 'damm', '0cb0241e3244dd88a346f9d853d8836a', 'no 3 jalan perniagaan 2 bandar dato onn', 'shop', '2020/11/26 00:40am'),
(15, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '2020/12/26 22:33pm'),
(16, 'adam aiman', 'adamny', '3da5debc3095c0761563003ede880b8c', 'no 28 jalan perjiranan 2/12 bandar dato onn', 'user', '2020/12/26 23:02pm');


ALTER TABLE `fds_ctlog`
  ADD PRIMARY KEY (`ctlog_id`),
  ADD KEY `ctlog_usrdt_id` (`ctlog_usrdt_id`);


ALTER TABLE `fds_inv`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `inv_ordr_id` (`inv_ordr_id`);


ALTER TABLE `fds_ordr`
  ADD PRIMARY KEY (`ordr_id`),
  ADD KEY `ordr_usrdt_id` (`ordr_usrdt_id`),
  ADD KEY `ordr_ctlog_id` (`ordr_ctlog_id`);


ALTER TABLE `fds_usrdt`
  ADD PRIMARY KEY (`usrdt_id`);


ALTER TABLE `fds_ctlog`
  MODIFY `ctlog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `fds_inv`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


ALTER TABLE `fds_ordr`
  MODIFY `ordr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


ALTER TABLE `fds_usrdt`
  MODIFY `usrdt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;




ALTER TABLE `fds_ctlog`
  ADD CONSTRAINT `fds_ctlog_ibfk_1` FOREIGN KEY (`ctlog_usrdt_id`) REFERENCES `fds_usrdt` (`usrdt_id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `fds_inv`
  ADD CONSTRAINT `fds_inv_ibfk_1` FOREIGN KEY (`inv_ordr_id`) REFERENCES `fds_ordr` (`ordr_id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `fds_ordr`
  ADD CONSTRAINT `fds_ordr_ibfk_1` FOREIGN KEY (`ordr_ctlog_id`) REFERENCES `fds_ctlog` (`ctlog_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fds_ordr_ibfk_2` FOREIGN KEY (`ordr_usrdt_id`) REFERENCES `fds_usrdt` (`usrdt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
