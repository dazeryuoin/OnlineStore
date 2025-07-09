/*
 Navicat Premium Data Transfer

 Source Server         : Ryl's
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : online_store

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 21/06/2025 12:23:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'Baju Pria');
INSERT INTO `kategori` VALUES (2, 'Celana Pria');
INSERT INTO `kategori` VALUES (3, 'Baju Wanita');
INSERT INTO `kategori` VALUES (4, 'Celana wanita');
INSERT INTO `kategori` VALUES (5, 'Sepatu');

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `ketersediaan_stock` enum('tersedia','habis') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT 'tersedia',
  `harga` double NOT NULL,
  PRIMARY KEY (`id_produk`) USING BTREE,
  INDEX `id_kategori_idx`(`id_kategori` ASC) USING BTREE INVISIBLE,
  CONSTRAINT `id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (1, 3, 'Mickey t-shirt', 'qCo9sgjWohnM7eGE2USO.jpg', 'Mickey t-shirt', 'tersedia', 54000);
INSERT INTO `produk` VALUES (2, 3, 'Faith yarn t-shirt', 'ihT27w04F1GvDnLe710z.jpg', 'Faith yarn t-shirt', 'tersedia', 65000);
INSERT INTO `produk` VALUES (3, 3, 'condor-wei', 'pHyDyw0ZeYFJY5qJDLjO.jpg', 'cotton condor-wei ', 'tersedia', 105000);
INSERT INTO `produk` VALUES (4, 3, 'faith-yarn2 t-shirt', 'o8qwq3YbO8LOQyQMKEjd.jpg', 'faith-yarn2 t-shirt', 'tersedia', 57000);
INSERT INTO `produk` VALUES (5, 4, 'Levis Female', 'LyzzE7GBnxI5YxgzISle.jpg', 'Levis Female', 'tersedia', 89000);
INSERT INTO `produk` VALUES (6, 4, 'Red pants women', 'CMD0pP00go11d2RRUejD.jpg', 'Red pants women', 'tersedia', 150000);
INSERT INTO `produk` VALUES (7, 1, 'alex-haigh', 'cwoNpjOX3t2IvHlKCSiC.jpg', 'alex-haigh', 'tersedia', 68000);
INSERT INTO `produk` VALUES (8, 1, 'keagan-henman', 'nU6BbBAErkU4F5tV1PlV.jpg', 'keagan-henman', 'tersedia', 69000);
INSERT INTO `produk` VALUES (9, 1, 'Man beige', 'egihsuS9IeutGO7yWbym.jpg', 'man-beige-shirt', 'tersedia', 78500);
INSERT INTO `produk` VALUES (10, 1, 'man navy', 'aOUmqZRWJHYURA6Aeeqb.jpg', 'man navy', 'tersedia', 75000);
INSERT INTO `produk` VALUES (11, 1, 'Man brown', 'mKh0ojYf9OUKRJYLlWHi.jpg', 'Man brown', 'tersedia', 60000);
INSERT INTO `produk` VALUES (12, 2, 'Male pants', '5Y3xuK3ErR3VEjwG8kcM.jpg', 'Male pants', 'tersedia', 76000);
INSERT INTO `produk` VALUES (13, 2, 'man blue jeans', 'eXj3SaBlX97569PG6oGp.jpg', '                        man-blue-jeans                    ', 'tersedia', 85000);
INSERT INTO `produk` VALUES (14, 5, 'brown leather shoes', 'hHMy8IXPzzpYU63tcBO0.jpg', 'brown leather shoes', 'tersedia', 126000);
INSERT INTO `produk` VALUES (15, 5, 'Dark brown leather shoes', 'iAFNupUzlnd35lrNp4Ef.jpg', 'Dark brown leather shoes.', 'tersedia', 159000);
INSERT INTO `produk` VALUES (16, 5, 'Green Nike 1998', 'MA276kflSD8ZdqIYphvq.jpg', 'Green Nike 1998', 'tersedia', 256000);
INSERT INTO `produk` VALUES (17, 5, 'Blue Jordan 1506', 'JBNNkAv3polFUKe0oaFy.jpg', 'Blue Jordan 1506', 'tersedia', 1500000);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '$2y$10$xO6Pl017M.wbe7a3uL7f1.nyrK0A.hAE8cVJImdo2eS6rCQRzzdEm', '2025-06-04 08:38:36');

SET FOREIGN_KEY_CHECKS = 1;
