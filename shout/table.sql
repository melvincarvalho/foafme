CREATE TABLE `shoutbox`(
	`id` int(5) NOT NULL auto_increment,
	`date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`user` varchar(25) NOT NULL default 'anonimous',
	`message` varchar(255) NOT NULL default '',
	PRIMARY KEY (`id`)
);