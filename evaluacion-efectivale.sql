/*
 Navicat Premium Data Transfer

 Source Server         : Localhost - MySQL
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : evaluacion-efectivale

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 18/11/2022 16:07:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access`  (
  `ID_access` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'active',
  `Date` date NULL DEFAULT curdate,
  `Time` time(0) NULL DEFAULT curtime,
  `ID_users` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`ID_access`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of access
-- ----------------------------
INSERT INTO `access` VALUES (1, 'Leer menús', 'active', '2022-11-16', '11:03:46', 1);
INSERT INTO `access` VALUES (2, 'Agregar menús', 'active', '2022-11-16', '11:03:46', 1);
INSERT INTO `access` VALUES (3, 'Actualizar menús', 'active', '2022-11-16', '11:03:46', 1);
INSERT INTO `access` VALUES (4, 'Eliminar menús', 'active', '2022-11-16', '11:03:46', 1);

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact`  (
  `ID_contact` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'active',
  `Date` date NULL DEFAULT curdate,
  `Time` time(0) NULL DEFAULT curtime,
  `ID_users` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`ID_contact`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of contact
-- ----------------------------
INSERT INTO `contact` VALUES (1, 'Cesar', 'Ochoa', 'cochoa@hotmail.com', '5539298561', 'active', '2022-11-18', '14:14:12', 1);
INSERT INTO `contact` VALUES (2, 'Cesar', 'Ochoa', 'cochoa3@hotmail.com', '5539298561', 'active', '2022-11-16', '14:14:12', 1);

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `ID_menus` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Name_parent` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'active',
  `Date` date NULL DEFAULT curdate,
  `Time` time(0) NULL DEFAULT curtime,
  `ID_users` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`ID_menus`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'Home', '', 'Menú principal', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (2, 'Catálogos', '', 'Listado de catálogos', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (3, 'Marcas', '', 'Listado de marcas de autos', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (4, 'Tipo de archivos', 'Catálogos', 'Catálogo de archivos', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (5, 'Profesiones', 'Catálogos', 'Listado de profesiones', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (6, 'SEAT', 'Marcas', 'Marca SEAT', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (7, 'BMW', 'Marcas', 'Marca BMW', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (8, 'VW', 'Marcas', 'Marca VW', 'active', '2022-11-16', '10:12:23', 1);
INSERT INTO `menus` VALUES (9, 'México', '', 'Descripción de México', 'active', '2022-11-17', '12:36:18', 2);
INSERT INTO `menus` VALUES (10, 'Ciudad de México', 'México', 'Descripción de Ciudad de México', 'active', '2022-11-17', '12:36:18', 2);
INSERT INTO `menus` VALUES (11, 'Estado de México', 'México', 'Descripción de Estado de México', 'active', '2022-11-17', '14:36:04', 2);
INSERT INTO `menus` VALUES (12, 'Michoacán', 'México', 'Descripción de Michoacán', 'active', '2022-11-17', '15:01:53', 2);

-- ----------------------------
-- Table structure for profiles
-- ----------------------------
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles`  (
  `ID_profiles` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Date` date NULL DEFAULT curdate,
  `Time` time(0) NULL DEFAULT curtime,
  `Status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'active',
  `ID_users` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`ID_profiles`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of profiles
-- ----------------------------
INSERT INTO `profiles` VALUES (1, 'Administrador', '2022-11-16', '14:32:20', 'active', 1);
INSERT INTO `profiles` VALUES (2, 'Usuario', '2022-11-16', '14:32:20', 'active', 1);

-- ----------------------------
-- Table structure for profiles_access
-- ----------------------------
DROP TABLE IF EXISTS `profiles_access`;
CREATE TABLE `profiles_access`  (
  `ID_profiles_access` int(11) NOT NULL AUTO_INCREMENT,
  `ID_profiles` int(11) NULL DEFAULT NULL,
  `ID_access` int(11) NULL DEFAULT NULL,
  `Date` date NULL DEFAULT curdate,
  `Time` time(0) NULL DEFAULT curtime,
  `Status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'active',
  `ID_users` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`ID_profiles_access`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of profiles_access
-- ----------------------------
INSERT INTO `profiles_access` VALUES (1, 1, 1, '2022-11-16', '13:30:45', 'active', 1);
INSERT INTO `profiles_access` VALUES (2, 1, 2, '2022-11-16', '13:30:45', 'active', 1);
INSERT INTO `profiles_access` VALUES (3, 1, 3, '2022-11-16', '13:30:45', 'active', 1);
INSERT INTO `profiles_access` VALUES (4, 1, 4, '2022-11-16', '13:30:45', 'active', 1);
INSERT INTO `profiles_access` VALUES (5, 2, 1, '2022-11-16', '13:30:45', 'active', 1);
INSERT INTO `profiles_access` VALUES (6, 2, 2, '2022-11-16', '13:30:45', 'active', 1);
INSERT INTO `profiles_access` VALUES (7, 2, 3, '2022-11-16', '13:30:45', 'active', 1);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `ID_users` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lastname1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lastname2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `area` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `extension` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ID_profiles` int(11) NULL DEFAULT NULL,
  `Status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'active',
  `Date` date NULL DEFAULT curdate,
  `Time` time(0) NULL DEFAULT curtime,
  `ID_admin_users` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`ID_users`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Cesar', 'Ochoa', 'Aguirre', 'cochoa@hotmail.com', 'Desarrollo', 'Hombre', '5539298561', '126', 'cesar8a', '12345', 1, 'active', '2022-11-16', '14:49:12', 1);
INSERT INTO `users` VALUES (2, 'Cesar', 'Ochoa', 'Aguirre', 'cochoa3@hotmail.com', 'Desarrollo', 'Hombre', '5539298561', '126', 'cochoa', '12345', 2, 'active', '2022-11-16', '14:49:12', 1);

SET FOREIGN_KEY_CHECKS = 1;
