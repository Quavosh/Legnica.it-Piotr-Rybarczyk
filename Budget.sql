CREATE TABLE IF NOT EXISTS `budget` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
    `login` varchar(255) NOT NULL,
	`income` decimal(20,2) NOT NULL,
    `outcome` decimal(20,2) NOT NULL,
    `balance` decimal(20,2) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;