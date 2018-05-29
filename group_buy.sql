/*
Navicat MySQL Data Transfer

Source Server         : testadmin
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : group_buy

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-05-29 10:48:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', '0', '1', '首頁', 'fa-bar-chart', '/', null, '2018-04-28 01:08:31');
INSERT INTO `admin_menu` VALUES ('2', '0', '21', '超級管理員', 'fa-tasks', '', null, '2018-05-17 14:47:44');
INSERT INTO `admin_menu` VALUES ('4', '2', '23', '角色', 'fa-user', 'auth/roles', null, '2018-05-17 14:47:44');
INSERT INTO `admin_menu` VALUES ('5', '2', '24', '權限', 'fa-user', 'auth/permissions', null, '2018-05-17 14:47:44');
INSERT INTO `admin_menu` VALUES ('6', '2', '25', '菜單', 'fa-bars', 'auth/menu', null, '2018-05-17 14:47:44');
INSERT INTO `admin_menu` VALUES ('23', '0', '5', '站内信', 'fa-envelope-o', 'platform/mail', '2018-04-27 02:29:19', '2018-05-07 15:54:35');
INSERT INTO `admin_menu` VALUES ('27', '2', '22', '賬號管理', 'fa-users', 'auth/users', '2018-05-08 18:37:06', '2018-05-17 14:47:44');
INSERT INTO `admin_menu` VALUES ('28', '2', '26', '操作日志', 'fa-book', 'auth/logs', '2018-05-08 18:37:40', '2018-05-17 14:47:44');

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11842 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_operation_log
-- ----------------------------
INSERT INTO `admin_operation_log` VALUES ('11800', '1', 'auth/logs', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:46:26', '2018-05-29 10:46:26');
INSERT INTO `admin_operation_log` VALUES ('11801', '1', 'auth/menu', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:46:29', '2018-05-29 10:46:29');
INSERT INTO `admin_operation_log` VALUES ('11802', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:46:33', '2018-05-29 10:46:33');
INSERT INTO `admin_operation_log` VALUES ('11803', '1', 'auth/permissions', 'GET', '::1', '[]', '2018-05-29 10:46:38', '2018-05-29 10:46:38');
INSERT INTO `admin_operation_log` VALUES ('11804', '1', 'auth/permissions/13', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:46:44', '2018-05-29 10:46:44');
INSERT INTO `admin_operation_log` VALUES ('11805', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:46:46', '2018-05-29 10:46:46');
INSERT INTO `admin_operation_log` VALUES ('11806', '1', 'auth/permissions/11', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:46:50', '2018-05-29 10:46:50');
INSERT INTO `admin_operation_log` VALUES ('11807', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:46:52', '2018-05-29 10:46:52');
INSERT INTO `admin_operation_log` VALUES ('11808', '1', 'auth/permissions/9', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:46:53', '2018-05-29 10:46:53');
INSERT INTO `admin_operation_log` VALUES ('11809', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:46:55', '2018-05-29 10:46:55');
INSERT INTO `admin_operation_log` VALUES ('11810', '1', 'auth/permissions/8', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:46:56', '2018-05-29 10:46:56');
INSERT INTO `admin_operation_log` VALUES ('11811', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:46:58', '2018-05-29 10:46:58');
INSERT INTO `admin_operation_log` VALUES ('11812', '1', 'auth/permissions/6', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:00', '2018-05-29 10:47:00');
INSERT INTO `admin_operation_log` VALUES ('11813', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:01', '2018-05-29 10:47:01');
INSERT INTO `admin_operation_log` VALUES ('11814', '1', 'auth/permissions/5', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:03', '2018-05-29 10:47:03');
INSERT INTO `admin_operation_log` VALUES ('11815', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:04', '2018-05-29 10:47:04');
INSERT INTO `admin_operation_log` VALUES ('11816', '1', 'auth/permissions/4', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:06', '2018-05-29 10:47:06');
INSERT INTO `admin_operation_log` VALUES ('11817', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:07', '2018-05-29 10:47:07');
INSERT INTO `admin_operation_log` VALUES ('11818', '1', 'auth/permissions/2', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:09', '2018-05-29 10:47:09');
INSERT INTO `admin_operation_log` VALUES ('11819', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:11', '2018-05-29 10:47:11');
INSERT INTO `admin_operation_log` VALUES ('11820', '1', 'auth/permissions/1', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:11', '2018-05-29 10:47:11');
INSERT INTO `admin_operation_log` VALUES ('11821', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:13', '2018-05-29 10:47:13');
INSERT INTO `admin_operation_log` VALUES ('11822', '1', 'auth/users', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:18', '2018-05-29 10:47:18');
INSERT INTO `admin_operation_log` VALUES ('11823', '1', 'auth/roles', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:20', '2018-05-29 10:47:20');
INSERT INTO `admin_operation_log` VALUES ('11824', '1', 'auth/permissions', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:22', '2018-05-29 10:47:22');
INSERT INTO `admin_operation_log` VALUES ('11825', '1', 'auth/menu', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:25', '2018-05-29 10:47:25');
INSERT INTO `admin_operation_log` VALUES ('11826', '1', 'auth/logs', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:29', '2018-05-29 10:47:29');
INSERT INTO `admin_operation_log` VALUES ('11827', '1', 'auth/users', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:33', '2018-05-29 10:47:33');
INSERT INTO `admin_operation_log` VALUES ('11828', '1', 'auth/users/5', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:40', '2018-05-29 10:47:40');
INSERT INTO `admin_operation_log` VALUES ('11829', '1', 'auth/users', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:42', '2018-05-29 10:47:42');
INSERT INTO `admin_operation_log` VALUES ('11830', '1', 'auth/users/4', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:45', '2018-05-29 10:47:45');
INSERT INTO `admin_operation_log` VALUES ('11831', '1', 'auth/users', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:46', '2018-05-29 10:47:46');
INSERT INTO `admin_operation_log` VALUES ('11832', '1', 'auth/users/10', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:50', '2018-05-29 10:47:50');
INSERT INTO `admin_operation_log` VALUES ('11833', '1', 'auth/users', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:52', '2018-05-29 10:47:52');
INSERT INTO `admin_operation_log` VALUES ('11834', '1', 'auth/users/11', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:47:54', '2018-05-29 10:47:54');
INSERT INTO `admin_operation_log` VALUES ('11835', '1', 'auth/users', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:47:56', '2018-05-29 10:47:56');
INSERT INTO `admin_operation_log` VALUES ('11836', '1', 'auth/users/8', 'DELETE', '::1', '{\"_method\":\"delete\",\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\"}', '2018-05-29 10:48:04', '2018-05-29 10:48:04');
INSERT INTO `admin_operation_log` VALUES ('11837', '1', 'auth/users', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:48:06', '2018-05-29 10:48:06');
INSERT INTO `admin_operation_log` VALUES ('11838', '1', 'auth/users/2/edit', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:48:07', '2018-05-29 10:48:07');
INSERT INTO `admin_operation_log` VALUES ('11839', '1', 'auth/users/2', 'PUT', '::1', '{\"username\":\"admin01\",\"name\":\"\\u7ba1\\u7406\\u54e1\",\"password\":\"$2y$10$1lfzHydCIWMTVVOs7dHg2.UR2jbjbxl9bajZKwBNvjgBKfF961K3W\",\"password_confirmation\":\"$2y$10$1lfzHydCIWMTVVOs7dHg2.UR2jbjbxl9bajZKwBNvjgBKfF961K3W\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"KxO0MBABFAjrCablQDrKaTVKYioi4CE0Wh9pTAGn\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/localhost\\/admin\\/public\\/auth\\/users\"}', '2018-05-29 10:48:14', '2018-05-29 10:48:14');
INSERT INTO `admin_operation_log` VALUES ('11840', '1', 'auth/users', 'GET', '::1', '[]', '2018-05-29 10:48:15', '2018-05-29 10:48:15');
INSERT INTO `admin_operation_log` VALUES ('11841', '1', 'auth/logout', 'GET', '::1', '{\"_pjax\":\"#pjax-container\"}', '2018-05-29 10:48:30', '2018-05-29 10:48:30');

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES ('3', '站内信', 'mail', '2018-04-28 18:30:28', '2018-04-28 18:30:28');
INSERT INTO `admin_permissions` VALUES ('12', '日志', 'logs', '2018-05-10 17:19:12', '2018-05-10 17:19:12');

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES ('1', '超級管理員', 'administrator', '2018-04-26 09:28:34', '2018-05-02 09:21:19');
INSERT INTO `admin_roles` VALUES ('2', '管理員', 'admin', '2018-05-02 09:12:38', '2018-05-02 09:12:38');
INSERT INTO `admin_roles` VALUES ('6', '站内信', 'mail', '2018-05-02 09:14:08', '2018-05-02 09:14:08');

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES ('1', '2', null, null);
INSERT INTO `admin_role_menu` VALUES ('1', '8', null, null);
INSERT INTO `admin_role_menu` VALUES ('8', '15', null, null);
INSERT INTO `admin_role_menu` VALUES ('3', '21', null, null);
INSERT INTO `admin_role_menu` VALUES ('6', '23', null, null);
INSERT INTO `admin_role_menu` VALUES ('7', '22', null, null);
INSERT INTO `admin_role_menu` VALUES ('5', '12', null, null);
INSERT INTO `admin_role_menu` VALUES ('4', '17', null, null);
INSERT INTO `admin_role_menu` VALUES ('9', '24', null, null);
INSERT INTO `admin_role_menu` VALUES ('1', '15', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '15', null, null);
INSERT INTO `admin_role_menu` VALUES ('1', '21', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '21', null, null);
INSERT INTO `admin_role_menu` VALUES ('1', '23', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '23', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '24', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '22', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '12', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '17', null, null);
INSERT INTO `admin_role_menu` VALUES ('10', '25', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '7', null, null);
INSERT INTO `admin_role_menu` VALUES ('11', '26', null, null);
INSERT INTO `admin_role_menu` VALUES ('11', '3', null, null);
INSERT INTO `admin_role_menu` VALUES ('1', '27', null, null);
INSERT INTO `admin_role_menu` VALUES ('1', '28', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '25', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '30', null, null);
INSERT INTO `admin_role_menu` VALUES ('12', '29', null, null);
INSERT INTO `admin_role_menu` VALUES ('12', '32', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '29', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '32', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '33', null, null);
INSERT INTO `admin_role_menu` VALUES ('12', '33', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '34', null, null);
INSERT INTO `admin_role_menu` VALUES ('12', '34', null, null);
INSERT INTO `admin_role_menu` VALUES ('12', '35', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '35', null, null);
INSERT INTO `admin_role_menu` VALUES ('2', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('3', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('4', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('5', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('6', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('7', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('8', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('9', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('10', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('12', '1', null, null);
INSERT INTO `admin_role_menu` VALUES ('13', '36', null, null);
INSERT INTO `admin_role_menu` VALUES ('13', '37', null, null);
INSERT INTO `admin_role_menu` VALUES ('13', '38', null, null);
INSERT INTO `admin_role_menu` VALUES ('13', '39', null, null);

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES ('2', '1', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '2', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '3', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '4', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '5', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '6', null, null);
INSERT INTO `admin_role_permissions` VALUES ('3', '1', null, null);
INSERT INTO `admin_role_permissions` VALUES ('4', '2', null, null);
INSERT INTO `admin_role_permissions` VALUES ('5', '6', null, null);
INSERT INTO `admin_role_permissions` VALUES ('6', '3', null, null);
INSERT INTO `admin_role_permissions` VALUES ('7', '4', null, null);
INSERT INTO `admin_role_permissions` VALUES ('8', '5', null, null);
INSERT INTO `admin_role_permissions` VALUES ('9', '8', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '8', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '9', null, null);
INSERT INTO `admin_role_permissions` VALUES ('10', '9', null, null);
INSERT INTO `admin_role_permissions` VALUES ('11', '10', null, null);
INSERT INTO `admin_role_permissions` VALUES ('12', '11', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '11', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '12', null, null);
INSERT INTO `admin_role_permissions` VALUES ('13', '13', null, null);

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES ('1', '1', null, null);
INSERT INTO `admin_role_users` VALUES ('2', '2', null, null);
INSERT INTO `admin_role_users` VALUES ('3', '3', null, null);
INSERT INTO `admin_role_users` VALUES ('8', '4', null, null);
INSERT INTO `admin_role_users` VALUES ('6', '5', null, null);
INSERT INTO `admin_role_users` VALUES ('7', '6', null, null);
INSERT INTO `admin_role_users` VALUES ('9', '7', null, null);
INSERT INTO `admin_role_users` VALUES ('5', '8', null, null);
INSERT INTO `admin_role_users` VALUES ('2', '10', null, null);
INSERT INTO `admin_role_users` VALUES ('2', '11', null, null);
INSERT INTO `admin_role_users` VALUES ('4', '6', null, null);
INSERT INTO `admin_role_users` VALUES ('5', '6', null, null);
INSERT INTO `admin_role_users` VALUES ('10', '9', null, null);
INSERT INTO `admin_role_users` VALUES ('3', '6', null, null);
INSERT INTO `admin_role_users` VALUES ('9', '5', null, null);
INSERT INTO `admin_role_users` VALUES ('11', '2', null, null);
INSERT INTO `admin_role_users` VALUES ('13', '12', null, null);

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'admin', '$2y$10$/nNBVrkdXODVkVMYSvQcjOmh9OPEUPJedU2wVCwrSF4BC5gSyrjtK', 'Administrator', null, null, '2018-04-26 09:28:34', '2018-04-26 09:28:34');

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_user_permissions
-- ----------------------------
INSERT INTO `admin_user_permissions` VALUES ('9', '4', null, null);

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('administrator', '1', '1522830591');

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/*', '2', null, null, null, '1522830041', '1522830041');
INSERT INTO `auth_item` VALUES ('/admin/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/assignment/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/assignment/assign', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/assignment/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/assignment/revoke', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/assignment/view', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/default/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/default/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/menu/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/menu/create', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/menu/delete', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/menu/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/menu/update', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/menu/view', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/assign', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/create', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/delete', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/remove', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/update', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/permission/view', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/assign', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/create', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/delete', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/remove', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/update', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/role/view', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/route/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/route/assign', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/route/create', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/route/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/route/refresh', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/route/remove', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/rule/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/rule/create', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/rule/delete', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/rule/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/rule/update', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/rule/view', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/*', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/activate', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/change-password', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/delete', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/index', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/login', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/logout', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/request-password-reset', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/reset-password', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/signup', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/admin/user/view', '2', null, null, null, '1522830280', '1522830280');
INSERT INTO `auth_item` VALUES ('/shop/*', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('/shop/create', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('/shop/delete', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('/shop/index', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('/shop/update', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('/shop/view', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('/site/*', '2', null, null, null, '1522830041', '1522830041');
INSERT INTO `auth_item` VALUES ('/site/error', '2', null, null, null, '1522830041', '1522830041');
INSERT INTO `auth_item` VALUES ('/site/index', '2', null, null, null, '1522830041', '1522830041');
INSERT INTO `auth_item` VALUES ('/site/login', '2', null, null, null, '1522830041', '1522830041');
INSERT INTO `auth_item` VALUES ('/site/logout', '2', null, null, null, '1522830041', '1522830041');
INSERT INTO `auth_item` VALUES ('/user/*', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('/user/update', '2', null, null, null, '1522837160', '1522837160');
INSERT INTO `auth_item` VALUES ('administrator', '1', null, null, null, '1522830097', '1522837197');
INSERT INTO `auth_item` VALUES ('Assignment', '2', '后台用户權限分配', null, null, '1522830636', '1522830636');
INSERT INTO `auth_item` VALUES ('dashboard', '2', null, null, null, '1522830153', '1522830494');
INSERT INTO `auth_item` VALUES ('Menu', '2', '菜单管理权限', null, null, '1522830681', '1522830681');
INSERT INTO `auth_item` VALUES ('Permission', '2', '后台用户权限管理', null, null, '1522830717', '1522830717');
INSERT INTO `auth_item` VALUES ('Role', '2', '后台用户角色管理', null, null, '1522830746', '1522830746');
INSERT INTO `auth_item` VALUES ('route', '2', '路由列表', null, null, '1522830780', '1522830780');
INSERT INTO `auth_item` VALUES ('Shop', '2', '店鋪管理', null, null, '1522837175', '1522837218');
INSERT INTO `auth_item` VALUES ('User', '2', '后台用户管理', null, null, '1522830816', '1522830816');

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('Assignment', '/admin/assignment/*');
INSERT INTO `auth_item_child` VALUES ('Assignment', '/admin/assignment/assign');
INSERT INTO `auth_item_child` VALUES ('Assignment', '/admin/assignment/index');
INSERT INTO `auth_item_child` VALUES ('Assignment', '/admin/assignment/revoke');
INSERT INTO `auth_item_child` VALUES ('Assignment', '/admin/assignment/view');
INSERT INTO `auth_item_child` VALUES ('Menu', '/admin/menu/*');
INSERT INTO `auth_item_child` VALUES ('Menu', '/admin/menu/create');
INSERT INTO `auth_item_child` VALUES ('Menu', '/admin/menu/delete');
INSERT INTO `auth_item_child` VALUES ('Menu', '/admin/menu/index');
INSERT INTO `auth_item_child` VALUES ('Menu', '/admin/menu/update');
INSERT INTO `auth_item_child` VALUES ('Menu', '/admin/menu/view');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/*');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/assign');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/create');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/delete');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/index');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/remove');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/update');
INSERT INTO `auth_item_child` VALUES ('Permission', '/admin/permission/view');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/*');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/assign');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/create');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/delete');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/index');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/remove');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/update');
INSERT INTO `auth_item_child` VALUES ('Role', '/admin/role/view');
INSERT INTO `auth_item_child` VALUES ('route', '/admin/route/*');
INSERT INTO `auth_item_child` VALUES ('route', '/admin/route/assign');
INSERT INTO `auth_item_child` VALUES ('route', '/admin/route/create');
INSERT INTO `auth_item_child` VALUES ('route', '/admin/route/index');
INSERT INTO `auth_item_child` VALUES ('route', '/admin/route/refresh');
INSERT INTO `auth_item_child` VALUES ('route', '/admin/route/remove');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/*');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/activate');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/change-password');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/delete');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/index');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/login');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/logout');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/request-password-reset');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/reset-password');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/signup');
INSERT INTO `auth_item_child` VALUES ('User', '/admin/user/view');
INSERT INTO `auth_item_child` VALUES ('Shop', '/shop/*');
INSERT INTO `auth_item_child` VALUES ('Shop', '/shop/create');
INSERT INTO `auth_item_child` VALUES ('Shop', '/shop/delete');
INSERT INTO `auth_item_child` VALUES ('Shop', '/shop/index');
INSERT INTO `auth_item_child` VALUES ('Shop', '/shop/update');
INSERT INTO `auth_item_child` VALUES ('Shop', '/shop/view');
INSERT INTO `auth_item_child` VALUES ('dashboard', '/site/*');
INSERT INTO `auth_item_child` VALUES ('administrator', 'Assignment');
INSERT INTO `auth_item_child` VALUES ('administrator', 'dashboard');
INSERT INTO `auth_item_child` VALUES ('administrator', 'Menu');
INSERT INTO `auth_item_child` VALUES ('administrator', 'Permission');
INSERT INTO `auth_item_child` VALUES ('administrator', 'Role');
INSERT INTO `auth_item_child` VALUES ('administrator', 'route');
INSERT INTO `auth_item_child` VALUES ('administrator', 'Shop');
INSERT INTO `auth_item_child` VALUES ('administrator', 'User');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for mail_list
-- ----------------------------
DROP TABLE IF EXISTS `mail_list`;
CREATE TABLE `mail_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '站內信ID',
  `content_type` tinyint(4) DEFAULT NULL COMMENT '類型',
  `title` varchar(80) DEFAULT NULL COMMENT '主題',
  `content` text COMMENT '內容',
  `status` tinyint(4) DEFAULT NULL COMMENT '狀態',
  `sender` int(11) DEFAULT NULL COMMENT '发送者',
  `send_time` int(11) DEFAULT NULL COMMENT '发送时间',
  `updated_time` int(11) DEFAULT NULL COMMENT '修改時間',
  `updated_by` int(11) DEFAULT NULL COMMENT '修改者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='平台站內信';

-- ----------------------------
-- Records of mail_list
-- ----------------------------
INSERT INTO `mail_list` VALUES ('1', '2', '站内信', '<p>站内信</p><p style=\"text-align:center\"><img src=\"http://office.techrare.com:5681/wopinapi/public/upload/other/2018-05-15/5afa3fb5912f5.jpg\" width=\"394\" height=\"206\"/></p><p><br/></p>', '1', '2', '1526349770', null, null);
INSERT INTO `mail_list` VALUES ('2', '3', 'jglsjgaljl', '<p>感覺到了撒嬌個垃圾了jl</p>', '1', '2', '1526350633', null, null);
INSERT INTO `mail_list` VALUES ('3', '2', '特特我', '<p>特特網特網特我</p>', '1', '2', '1526350943', null, null);

-- ----------------------------
-- Table structure for mail_list_mall
-- ----------------------------
DROP TABLE IF EXISTS `mail_list_mall`;
CREATE TABLE `mail_list_mall` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `mail_id` int(11) DEFAULT NULL COMMENT '平台站內信ID',
  `read_status` tinyint(4) DEFAULT '1' COMMENT '查看状态，1未读2已读',
  `read_time` datetime DEFAULT NULL COMMENT '查看時間',
  `mall_id` int(11) DEFAULT NULL COMMENT '店鋪ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='店鋪站內信';

-- ----------------------------
-- Records of mail_list_mall
-- ----------------------------
INSERT INTO `mail_list_mall` VALUES ('1', '1', '2', '2018-05-15 10:09:42', '1');
INSERT INTO `mail_list_mall` VALUES ('2', '1', '2', '2018-05-15 10:09:42', '2');
INSERT INTO `mail_list_mall` VALUES ('3', '1', '2', '2018-05-15 10:09:42', '3');
INSERT INTO `mail_list_mall` VALUES ('4', '1', '2', '2018-05-15 10:09:42', '4');
INSERT INTO `mail_list_mall` VALUES ('5', '1', '2', '2018-05-15 10:09:42', '5');
INSERT INTO `mail_list_mall` VALUES ('6', '1', '2', '2018-05-15 10:09:42', '6');
INSERT INTO `mail_list_mall` VALUES ('7', '2', '2', '2018-05-15 10:18:15', '1');
INSERT INTO `mail_list_mall` VALUES ('8', '2', '2', '2018-05-15 10:22:44', '2');
INSERT INTO `mail_list_mall` VALUES ('9', '2', '2', '2018-05-15 10:18:15', '3');
INSERT INTO `mail_list_mall` VALUES ('10', '2', '2', '2018-05-15 10:18:15', '4');
INSERT INTO `mail_list_mall` VALUES ('11', '2', '2', '2018-05-15 10:18:15', '5');
INSERT INTO `mail_list_mall` VALUES ('12', '2', '2', '2018-05-15 10:18:15', '6');
INSERT INTO `mail_list_mall` VALUES ('13', '3', '1', null, '1');
INSERT INTO `mail_list_mall` VALUES ('14', '3', '2', '2018-05-15 10:22:50', '2');
INSERT INTO `mail_list_mall` VALUES ('15', '3', '1', null, '3');
INSERT INTO `mail_list_mall` VALUES ('16', '3', '1', null, '4');
INSERT INTO `mail_list_mall` VALUES ('17', '3', '1', null, '5');
INSERT INTO `mail_list_mall` VALUES ('18', '3', '1', null, '6');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2018_04_24_163906_create_failed_jobs_table', '1');
INSERT INTO `migrations` VALUES ('2', '2016_01_04_173148_create_admin_tables', '2');

-- ----------------------------
-- Table structure for options
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `options_name` varchar(50) DEFAULT NULL COMMENT '配置项',
  `options_value` tinytext COMMENT '配置值',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='平台配置表';

-- ----------------------------
-- Records of options
-- ----------------------------

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(100) DEFAULT NULL COMMENT '权限名称',
  `menus` varchar(80) DEFAULT NULL COMMENT '菜单组',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission
-- ----------------------------

-- ----------------------------
-- Table structure for platform_menu
-- ----------------------------
DROP TABLE IF EXISTS `platform_menu`;
CREATE TABLE `platform_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `platform_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `platform_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of platform_menu
-- ----------------------------
INSERT INTO `platform_menu` VALUES ('1', '面板', null, '/site/index', '1', 0x746163686F6D65746572);
INSERT INTO `platform_menu` VALUES ('2', '系统设定', null, null, '120', 0x636F67);
INSERT INTO `platform_menu` VALUES ('3', '权限管理', '2', '/admin/permission/index', '3', null);
INSERT INTO `platform_menu` VALUES ('4', '菜单管理', '2', '/admin/menu/index', '5', null);
INSERT INTO `platform_menu` VALUES ('5', '用户管理', null, null, '100', 0x757365722D6D64);
INSERT INTO `platform_menu` VALUES ('6', '用户管理', '5', '/admin/user/index', '1', null);
INSERT INTO `platform_menu` VALUES ('7', '角色管理', '5', '/admin/role/index', '2', null);
INSERT INTO `platform_menu` VALUES ('8', '分配权限', '5', '/admin/assignment/index', '3', null);
INSERT INTO `platform_menu` VALUES ('9', '店鋪管理', null, null, '5', null);
INSERT INTO `platform_menu` VALUES ('10', '店鋪管理', '9', '/shop/index', '1', null);

-- ----------------------------
-- Table structure for platform_user
-- ----------------------------
DROP TABLE IF EXISTS `platform_user`;
CREATE TABLE `platform_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `password_reset_token` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '10',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of platform_user
-- ----------------------------
INSERT INTO `platform_user` VALUES ('1', 'superadmin', 's3kb6DJAomzaVflcF8x5MFTeOjXK8b3z', '$2y$10$mL15PP4/ecs3vU3Tkrhi4OppdrJYf/R7ryAijexri8rnMS4Hqc.1G', null, 'admin@admin.com', '10', '0000-00-00 00:00:00', '2018-05-11 14:16:28', null, '6QW1elayLMkCcEfsPFzRQHEgwH1a35xjA2PGOxfpTEjvnc74Ueis3pMupNf7', 'superadmin');
INSERT INTO `platform_user` VALUES ('2', 'admin01', null, '$2y$10$1lfzHydCIWMTVVOs7dHg2.UR2jbjbxl9bajZKwBNvjgBKfF961K3W', null, null, '10', '2018-04-28 18:29:33', '2018-05-29 10:48:14', null, 'whVraVVYk2SGCAT8q7LCs7f3nsBX6UtiI4Xmkix6lvJItxOW1GdKLDxHDkIz', '管理員');
INSERT INTO `platform_user` VALUES ('6', 'operation', null, '$2y$10$0M4ubK5QZMHVU576e4xwyeB259Wl8MG/uKMrIQfReJDGqF2e5her.', null, null, '10', '2018-05-02 14:40:15', '2018-05-08 16:50:46', null, '1HBRLKmHNPsH2bwKSzCmBHURBAiPheD3a1jGPYAYMUav5HmG2PIzfr2LUWLg', '運營');
