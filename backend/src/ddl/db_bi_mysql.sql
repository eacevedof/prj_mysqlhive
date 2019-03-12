CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_bi` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_bi`;

/*Table structure for table `operation` */

DROP TABLE IF EXISTS `operation`;

CREATE TABLE `operation` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `d1` varchar(50) DEFAULT NULL,
    `d2` varchar(50) DEFAULT NULL,
    `d3` varchar(50) DEFAULT NULL,
    `d4` varchar(50) DEFAULT NULL,
    `d5` varchar(50) DEFAULT NULL,
    `atr1` varchar(50) DEFAULT NULL,
    `atr2` varchar(50) DEFAULT NULL,
    `atr3` varchar(50) DEFAULT NULL,
    `atr4` varchar(50) DEFAULT NULL,
    `atr5` varchar(50) DEFAULT NULL,
    `m1` int(11) DEFAULT NULL,
    `m2` int(11) DEFAULT NULL,
    `m3` int(11) DEFAULT NULL,
    `m4` int(11) DEFAULT NULL,
    `m5` int(11) DEFAULT NULL,
    `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
    `mdate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
