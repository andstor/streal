CREATE TABLE `article` (
`id` int(5) NOT NULL AUTO_INCREMENT,
`title` varchar(64) NOT NULL,
`text` text NOT NULL,
`cover` varchar(255) NULL,
`published` timestamp NULL DEFAULT NOW(),
`category_id` int(5) NOT NULL,
PRIMARY KEY (`id`) 
);
CREATE TABLE `comment` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(32) NULL,
`content` text NULL,
`published` timestamp NOT NULL DEFAULT NOW(),
`childOf` int(11) NOT NULL DEFAULT -1 COMMENT 'Parent comment id',
`article_id` int(5) NOT NULL,
PRIMARY KEY (`id`) 
);
CREATE TABLE `category` (
`id` int(5) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NULL,
`childOf` int(5) NOT NULL DEFAULT -1 COMMENT 'Parents category id',
PRIMARY KEY (`id`) 
);

ALTER TABLE `article` ADD CONSTRAINT `fk_article_category_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `comment` ADD CONSTRAINT `fk_comment_article_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

