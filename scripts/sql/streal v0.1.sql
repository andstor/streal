/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100129
 Source Host           : localhost:3306
 Source Schema         : streal

 Target Server Type    : MySQL
 Target Server Version : 100129
 File Encoding         : 65001

 Date: 15/03/2018 22:06:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article`  (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cover` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `caption` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rating` enum('1','2','3','4','5') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '1',
  `published` timestamp(0) NULL DEFAULT NULL,
  `category_id` int(5) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_article_category_category_id`(`category_id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  CONSTRAINT `fk_article_category_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `childOf` int(5) NOT NULL DEFAULT -1 COMMENT 'Parents category id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `content` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `published` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `childOf` int(11) NOT NULL DEFAULT -1 COMMENT 'Parent comment id',
  `article_id` int(5) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_comment_article_article_id`(`article_id`) USING BTREE,
  CONSTRAINT `fk_comment_article_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
