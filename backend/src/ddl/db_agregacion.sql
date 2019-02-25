-- DATABASE: db_agregacion

CREATE TABLE `tbl_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `op_d1` varchar(50) DEFAULT NULL,
  `op_d2` varchar(50) DEFAULT NULL,
  `op_d3` varchar(50) DEFAULT NULL,
  `op_d4` varchar(50) DEFAULT NULL,
  `op_d5` varchar(50) DEFAULT NULL,
  `op_atr1` varchar(50) DEFAULT NULL,
  `op_atr2` varchar(50) DEFAULT NULL,
  `op_atr3` varchar(50) DEFAULT NULL,
  `op_m1` int(11) DEFAULT NULL,
  `op_m2` int(11) DEFAULT NULL,
  `op_m3` int(11) DEFAULT NULL,
  `op_m4` int(11) DEFAULT NULL,
  `op_cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `op_mdate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8
