/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.16-MariaDB : Database - studio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `slogon` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tp_1` varchar(45) DEFAULT NULL,
  `tp_2` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `clr_header_bg` varchar(10) DEFAULT '#0080c7',
  `clr_header_txt` varchar(10) DEFAULT '#ffffff',
  `clr_subheader_bg` varchar(10) DEFAULT '#e8e8e8',
  `clr_subheader_bg_hover` varchar(10) DEFAULT '#e8e8e8',
  `clr_subheader_txt` varchar(10) DEFAULT '#393939',
  `online` tinyint(1) DEFAULT '0',
  `clr_ui_border_bottom` varchar(10) DEFAULT '#e8e8e8',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `company` */

insert  into `company`(`id`,`name`,`address`,`slogon`,`email`,`tp_1`,`tp_2`,`fax`,`clr_header_bg`,`clr_header_txt`,`clr_subheader_bg`,`clr_subheader_bg_hover`,`clr_subheader_txt`,`online`,`clr_ui_border_bottom`) values (1,'Mangala Studio & Beauty Salon','Dandugamma Junction, Sevanagala.','HD Natural Touch...','mangalastudio@hotmail.com','+94717502687','+94772995390','+94712923500','#0080c7','#ffffff','#dddddd','#bcbcbc','#393939',1,'#ff0080');

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `tp_mobile` varchar(15) DEFAULT NULL,
  `tp_fixed` varchar(15) DEFAULT NULL,
  `nic` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` enum('MALE','FEMALE','OTHER') DEFAULT NULL,
  `online` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `visits` int(11) DEFAULT '0',
  `code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `customer` */

insert  into `customer`(`id`,`name`,`email`,`tp_mobile`,`tp_fixed`,`nic`,`address`,`gender`,`online`,`created`,`updated`,`visits`,`code`) values (1,'Prasad Viuthi','prasad@email.com','+945481212','+84124756585','901245565V','Mawanella, Kandy','MALE',1,'2017-01-21 08:58:12','2017-01-21 08:58:12',0,'C21012017_00001'),(2,'Viraj Vimukthi Jayasinghe','viraj.vimu@gmail.com','+97412325648','+94757874949','901430040V','Moaragammana, Aranayake','MALE',1,'2017-01-25 18:40:52','2017-01-25 18:40:52',0,'C25012017_00002');

/*Table structure for table `discout_type` */

DROP TABLE IF EXISTS `discout_type`;

CREATE TABLE `discout_type` (
  `id` int(4) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `online` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `discout_type` */

insert  into `discout_type`(`id`,`name`,`online`) values (1,'PERCENTAGE',1),(2,'VALUE',1);

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `selling` decimal(10,2) DEFAULT NULL,
  `min_price` decimal(10,2) DEFAULT NULL,
  `max_price` decimal(10,2) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `reorder_level` int(11) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_items_supplier1_idx` (`supplier_id`),
  CONSTRAINT `fk_items_supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `items` */

insert  into `items`(`id`,`name`,`cost`,`selling`,`min_price`,`max_price`,`online`,`reorder_level`,`supplier_id`) values (1,'4R Size','350.00','505.50','400.00','750.00',1,100,1),(2,'8R Large','500.00','700.00','300.00','900.00',1,50,1),(3,'6R Size','200.00','450.25','300.00','800.00',1,20,2);

/*Table structure for table `package` */

DROP TABLE IF EXISTS `package`;

CREATE TABLE `package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `desc` varchar(45) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `adjustment_charge` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_package_users1_idx` (`users_id`),
  CONSTRAINT `fk_package_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `package` */

/*Table structure for table `package_has_pkg_features` */

DROP TABLE IF EXISTS `package_has_pkg_features`;

CREATE TABLE `package_has_pkg_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost` decimal(10,2) DEFAULT NULL,
  `selling` decimal(10,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `pkg_features_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_package_has_pkg_features_pkg_features1_idx` (`pkg_features_id`),
  KEY `fk_package_has_pkg_features_package1_idx` (`package_id`),
  CONSTRAINT `fk_package_has_pkg_features_package1` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_package_has_pkg_features_pkg_features1` FOREIGN KEY (`pkg_features_id`) REFERENCES `pkg_features` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `package_has_pkg_features` */

/*Table structure for table `payment_type` */

DROP TABLE IF EXISTS `payment_type`;

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `payment_type` */

insert  into `payment_type`(`id`,`name`,`online`,`created`) values (1,'Advance Payment',1,'2017-02-12 20:19:39'),(2,'Complete Payment',1,'2017-02-12 20:19:42'),(3,'Installment Payment',1,'2017-02-12 20:19:44');

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `remark` varchar(45) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `payment_type_id` int(11) NOT NULL,
  `wrk_order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_payments_payment_type1_idx` (`payment_type_id`),
  KEY `fk_payments_wrk_order1_idx` (`wrk_order_id`),
  CONSTRAINT `fk_payments_payment_type1` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_payments_wrk_order1` FOREIGN KEY (`wrk_order_id`) REFERENCES `wrk_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `payments` */

insert  into `payments`(`id`,`name`,`online`,`remark`,`amount`,`created`,`payment_type_id`,`wrk_order_id`) values (6,'CR_0602_00001 | Viraj Vimukthi Jayasinghe',1,'fgdgdfg','200.00','2017-02-14 15:39:40',1,4),(7,'CR_0602_00001 | Viraj Vimukthi Jayasinghe',1,'sdasdasd','800.00','2017-02-14 15:50:07',2,4),(8,'CS_01022017_00002 | Prasad Viuthi',1,'sdfdsfsdfds','461.25','2017-02-14 16:12:30',1,3),(9,'CS_01022017_00002 | Prasad Viuthi',1,'dasdasdasd','200.00','2017-02-14 16:14:32',3,3),(10,'CS_01022017_00002 | Prasad Viuthi',1,'dasdasdasd','200.00','2017-02-14 16:14:32',3,3),(11,'CS_01022017_00002 | Prasad Viuthi',1,'sdsd','100.00','2017-02-14 16:15:44',3,3),(12,'CS_01022017_00002 | Prasad Viuthi',1,'dfsdsdfsd','100.00','2017-02-14 16:16:54',3,3),(13,'CS_01022017_00002 | Prasad Viuthi',1,'dfsdsdfsd','100.00','2017-02-14 16:16:54',3,3),(14,'CS_01022017_00002 | Prasad Viuthi',1,'dfsdfsdfds','50.00','2017-02-14 16:18:06',3,3),(15,'CS_01022017_00002 | Prasad Viuthi',1,'sdfdsfsd','50.00','2017-02-14 16:33:52',3,3),(16,'CS_01022017_00002 | Prasad Viuthi',1,'sssds','100.00','2017-02-19 18:19:45',1,3);

/*Table structure for table `pkg_features` */

DROP TABLE IF EXISTS `pkg_features`;

CREATE TABLE `pkg_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `desc` tinytext,
  `online` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `selling` decimal(10,2) DEFAULT NULL,
  `hits` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `pkg_features` */

insert  into `pkg_features`(`id`,`name`,`desc`,`online`,`created`,`cost`,`selling`,`hits`) values (1,'Test Feature','Test FeatureTest FeatureDescription',1,'2017-01-22 10:49:20','400.00','550.75',0),(2,'Test Feature 2','Test Feature 2Test Feature 2Test Feature 2Test Feature 2',1,'2017-01-24 16:38:28','1500.00','2500.00',0);

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_type_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `qty_in` int(11) DEFAULT NULL,
  `qty_out` int(11) DEFAULT NULL,
  `eff_date` date DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `selling` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `wo_type` enum('CASH','CREDIT') DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `wrk_order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_trans_type1_idx` (`trans_type_id`),
  KEY `fk_stock_items1_idx` (`items_id`),
  KEY `fk_stock_supplier1_idx` (`supplier_id`),
  KEY `fk_stock_wrk_order1_idx` (`wrk_order_id`),
  CONSTRAINT `fk_stock_items1` FOREIGN KEY (`items_id`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_stock_supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_stock_trans_type1` FOREIGN KEY (`trans_type_id`) REFERENCES `trans_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_stock_wrk_order1` FOREIGN KEY (`wrk_order_id`) REFERENCES `wrk_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `stock` */

insert  into `stock`(`id`,`trans_type_id`,`items_id`,`supplier_id`,`qty_in`,`qty_out`,`eff_date`,`cost`,`selling`,`amount`,`remark`,`wo_type`,`online`,`created`,`wrk_order_id`) values (1,1,1,1,20,NULL,'2017-02-05','350.00','505.50','7000.00',NULL,NULL,1,'2017-02-05 19:55:50',NULL),(2,1,2,1,10,NULL,'2017-02-05','500.00','700.00','5000.00',NULL,NULL,1,'2017-02-05 19:55:50',NULL),(3,1,1,1,15,NULL,'2017-02-06','350.00','505.50','5250.00',NULL,NULL,1,'2017-02-06 17:18:06',NULL),(4,3,1,1,NULL,2,'2017-02-06','350.00','505.50','1011.00',NULL,'CREDIT',1,'2017-02-06 18:24:58',4);

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tp_fixed` varchar(15) DEFAULT NULL,
  `tp_mobile` varchar(15) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `supplier` */

insert  into `supplier`(`id`,`name`,`address`,`tp_fixed`,`tp_mobile`,`online`,`created`,`email`) values (1,'Nine Hearts Pvt Ltd.','Dalanda Street, Kandy','+94814562321','+94713215487',1,'2017-01-20 21:38:50','ninehearts@gmail.com'),(2,'Kavindya Pvt Ltd','Mawanella, Aranayake','+94781245623','+47123456942',1,'2017-01-21 17:56:11','kavindya@email.com');

/*Table structure for table `trans_type` */

DROP TABLE IF EXISTS `trans_type`;

CREATE TABLE `trans_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `trans_type` */

insert  into `trans_type`(`id`,`name`,`online`,`created`) values (1,'GRN',1,'2017-02-05 13:01:20'),(2,'CASH SALE',1,'2017-02-05 13:01:23'),(3,'CREDIT SALE',1,'2017-02-05 13:01:26');

/*Table structure for table `user_levels` */

DROP TABLE IF EXISTS `user_levels`;

CREATE TABLE `user_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `user_levels` */

insert  into `user_levels`(`id`,`name`,`online`,`created`) values (1,'Super Admin',1,'2017-01-18 21:15:27'),(2,'Admin',1,'2017-01-24 12:59:18'),(3,'Operator',1,'2017-01-24 12:59:31');

/*Table structure for table `user_logs` */

DROP TABLE IF EXISTS `user_logs`;

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_logs_users1_idx` (`users_id`),
  CONSTRAINT `fk_user_logs_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_logs` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `nic` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tp_fixed` varchar(15) DEFAULT NULL,
  `tp_mobile` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `last_logged` datetime DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `user_levels_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nic_UNIQUE` (`nic`),
  KEY `fk_users_company_idx` (`company_id`),
  KEY `fk_users_user_levels1_idx` (`user_levels_id`),
  CONSTRAINT `fk_users_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_user_levels1` FOREIGN KEY (`user_levels_id`) REFERENCES `user_levels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`nic`,`address`,`tp_fixed`,`tp_mobile`,`dob`,`created`,`last_logged`,`online`,`username`,`password`,`email`,`company_id`,`user_levels_id`) values (1,'Viraj Vimukthi','901430040V','Moragammana, Aranayaka.','0772861046','0718784949','1990-07-11','2017-01-18 21:17:32','2017-02-19 18:18:57',1,'viraj','21232f297a57a5a743894a0e4a801fc3','viraj.vimu@gmail.com',1,1);

/*Table structure for table `wo_status` */

DROP TABLE IF EXISTS `wo_status`;

CREATE TABLE `wo_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `wo_status` */

insert  into `wo_status`(`id`,`name`,`online`,`created`) values (1,'PENDING',1,'2017-01-25 20:57:39'),(2,'HALF PAID',1,'2017-01-25 20:57:41'),(3,'COMPLETED',1,'2017-01-25 20:58:16'),(4,'CANCELED',1,'2017-01-25 20:58:16');

/*Table structure for table `wrk_order` */

DROP TABLE IF EXISTS `wrk_order`;

CREATE TABLE `wrk_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) DEFAULT NULL,
  `eff_date` date DEFAULT NULL,
  `wo_type` enum('CASH','CREDIT') DEFAULT 'CASH',
  `delivery_date` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `wo_status_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `discount_type_id` int(11) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `discount_percentage` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `fk_wrk_order_wo_status1_idx` (`wo_status_id`),
  KEY `fk_wrk_order_customer1_idx` (`customer_id`),
  KEY `discount_type_id` (`discount_type_id`),
  CONSTRAINT `fk_wrk_order_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_wrk_order_wo_status1` FOREIGN KEY (`wo_status_id`) REFERENCES `wo_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `wrk_order_ibfk_1` FOREIGN KEY (`discount_type_id`) REFERENCES `discout_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `wrk_order` */

insert  into `wrk_order`(`id`,`code`,`eff_date`,`wo_type`,`delivery_date`,`remark`,`wo_status_id`,`customer_id`,`created`,`customer_name`,`discount_type_id`,`discount`,`total`,`discount_percentage`) values (3,'CS_01022017_00002','2017-02-01','CASH','2017-02-24','sdfsdfdsf',2,1,'2017-02-01 16:47:37','Prasad Viuthi',2,'0.00','1461.25','10.00'),(4,'CR_0602_00001','2017-02-06','CREDIT','2017-02-06','dsdfsdf',3,2,'2017-02-06 18:24:57','Viraj Vimukthi Jayasinghe',2,'11.00','1000.00','0.00');

/*Table structure for table `wrk_order_has_items` */

DROP TABLE IF EXISTS `wrk_order_has_items`;

CREATE TABLE `wrk_order_has_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `selling` decimal(10,2) DEFAULT NULL,
  `min_price` decimal(10,2) DEFAULT NULL,
  `max_price` decimal(10,2) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `items_id` int(11) NOT NULL,
  `wrk_order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wrk_order_has_items_items1_idx` (`items_id`),
  KEY `fk_wrk_order_has_items_wrk_order1_idx` (`wrk_order_id`),
  CONSTRAINT `fk_wrk_order_has_items_items1` FOREIGN KEY (`items_id`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_wrk_order_has_items_wrk_order1` FOREIGN KEY (`wrk_order_id`) REFERENCES `wrk_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `wrk_order_has_items` */

insert  into `wrk_order_has_items`(`id`,`name`,`cost`,`selling`,`min_price`,`max_price`,`qty`,`amount`,`items_id`,`wrk_order_id`) values (7,'4R Size','350.00','505.50','400.00','750.00','2.00','1011.00',1,3),(8,'6R Size','200.00','450.25','300.00','800.00','1.00','450.25',3,3),(9,'4R Size','350.00','505.50','400.00','750.00','2.00','1011.00',1,4);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
