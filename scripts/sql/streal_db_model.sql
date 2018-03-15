CREATE TABLE `article` (
  `id`          INT(5)       NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(64)  NOT NULL,
  `text`        TEXT         NOT NULL,
  `cover`       VARCHAR(255) NULL,
  'author'      VARCHAR(255) NOT NULL,
  `published`   TIMESTAMP    NULL     DEFAULT NOW(),
  `category_id` INT(5)       NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE `comment` (
  `id`         INT(11)     NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(32) NULL,
  `content`    TEXT        NULL,
  `published`  TIMESTAMP   NOT NULL DEFAULT NOW(),
  `childOf`    INT(11)     NOT NULL DEFAULT -1
  COMMENT 'Parent comment id',
  `article_id` INT(5)      NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE `category` (
  `id`      INT(5)       NOT NULL AUTO_INCREMENT,
  `name`    VARCHAR(255) NULL,
  `childOf` INT(5)       NOT NULL DEFAULT -1
  COMMENT 'Parents category id',
  PRIMARY KEY (`id`)
);

ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_category_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_article_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`)
  ON DELETE NO ACTION
  ON UPDATE CASCADE;

