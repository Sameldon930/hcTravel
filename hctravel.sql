-- --------------------------------------------------------
-- 主机:                           localhost
-- 服务器版本:                        5.7.19 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 hctravel.action_logs 结构
CREATE TABLE IF NOT EXISTS `action_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL COMMENT '操作用户',
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址，路由',
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '操作数据',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.admins 结构
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '昵称',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态：默认为1，激活',
  `api_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录验证',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_mobile_unique` (`mobile`),
  UNIQUE KEY `admins_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.admin_role 结构
CREATE TABLE IF NOT EXISTS `admin_role` (
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.apartment_rents 结构
CREATE TABLE IF NOT EXISTS `apartment_rents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '出租信息标题',
  `rental` bigint(20) NOT NULL COMMENT '租金',
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略图',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '详情图',
  `house_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '房屋类型：一室一厅 28平 精装修',
  `rent_way` tinyint(4) NOT NULL COMMENT '租赁方式：整租',
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付方式：押一付一、面议',
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '所属区域',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `is_hidden` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F' COMMENT '是否隐藏',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '招租详情',
  `orderby` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.applicants 结构
CREATE TABLE IF NOT EXISTS `applicants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` tinyint(4) NOT NULL,
  `sex` tinyint(4) NOT NULL COMMENT '性别：1男、2女',
  `apply_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '求职意向',
  `work_experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工作经验',
  `education` tinyint(4) NOT NULL COMMENT '学历',
  `current_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '近期职位',
  `is_hidden` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F' COMMENT '是否隐藏',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `evaluate` text COLLATE utf8mb4_unicode_ci COMMENT '自我评价',
  `orderby` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.articles 结构
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL COMMENT '管理员',
  `group_id` int(10) unsigned NOT NULL COMMENT '文章分组',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章标题',
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略图',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `ready` int(11) NOT NULL COMMENT '阅读数',
  `top` int(10) unsigned NOT NULL DEFAULT '2' COMMENT '是否置顶,默认为2，不置顶',
  `orderby` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态值：默认为1，为显示状态',
  `now` timestamp NULL DEFAULT NULL COMMENT '发布时间',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.article_groups 结构
CREATE TABLE IF NOT EXISTS `article_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态值为1，默认为显示状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.configs 结构
CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL COMMENT '分组id',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.config_groups 结构
CREATE TABLE IF NOT EXISTS `config_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '类别',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.decorations 结构
CREATE TABLE IF NOT EXISTS `decorations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '店名',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略图',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '描述',
  `address` text COLLATE utf8mb4_unicode_ci COMMENT '地址',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `url` text COLLATE utf8mb4_unicode_ci COMMENT '网址',
  `top` int(10) unsigned NOT NULL DEFAULT '2' COMMENT '是否置顶,默认为2，不置顶',
  `orderby` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态值：默认为1，为显示状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.external_api_logs 结构
CREATE TABLE IF NOT EXISTS `external_api_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `respond_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.feedback 结构
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `merchant_id` int(10) unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '反馈内容',
  `feedback` text COLLATE utf8mb4_unicode_ci COMMENT '回复内容',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '反馈照片',
  `is_read` tinyint(4) NOT NULL DEFAULT '0' COMMENT '阅读状态:0未读,1已读',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_merchant_id_index` (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.finances 结构
CREATE TABLE IF NOT EXISTS `finances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司名',
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略图',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '描述',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `url` text COLLATE utf8mb4_unicode_ci COMMENT '网址',
  `top` int(10) unsigned NOT NULL DEFAULT '2' COMMENT '是否置顶,默认为2，不置顶',
  `orderby` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态值：默认为1，为显示状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.goods 结构
CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商家',
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '价格',
  `market_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '市场价格',
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略图',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品描述',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `url` text COLLATE utf8mb4_unicode_ci COMMENT '网址',
  `top` int(10) unsigned NOT NULL DEFAULT '2' COMMENT '是否置顶,默认为2，不置顶',
  `orderby` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态值：默认为1，为显示状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `new_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '新旧状态',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '物品类型',
  `measure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '取货方式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.homestay_infos 结构
CREATE TABLE IF NOT EXISTS `homestay_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) unsigned NOT NULL COMMENT '商户ID',
  `merchant_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商家地址',
  `merchant_short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商家简称',
  `merchant_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商家名称',
  `merchant_principal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '负责人',
  `business_img` text COLLATE utf8mb4_unicode_ci COMMENT '营业执照',
  `business_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '注册号',
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业执照名称',
  `business_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业执照法人',
  `business_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业地址',
  `business_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业执照时间',
  `identity_front` text COLLATE utf8mb4_unicode_ci COMMENT '身份证正面',
  `identity_contrary` text COLLATE utf8mb4_unicode_ci COMMENT '身份证正面',
  `identity_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证号',
  `identity_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证姓名',
  `contract_tenancy` text COLLATE utf8mb4_unicode_ci COMMENT '租赁合同',
  `property_img` text COLLATE utf8mb4_unicode_ci COMMENT '其他产权证明',
  `property_img_7` text COLLATE utf8mb4_unicode_ci COMMENT '私危房翻改建许可证',
  `property_img_6` text COLLATE utf8mb4_unicode_ci COMMENT '建设工程规划许可证',
  `property_img_5` text COLLATE utf8mb4_unicode_ci COMMENT '乡村企业田地许可证',
  `property_img_4` text COLLATE utf8mb4_unicode_ci COMMENT '土地房产所有证',
  `property_img_3` text COLLATE utf8mb4_unicode_ci COMMENT '乡村房屋契证',
  `property_img_2` text COLLATE utf8mb4_unicode_ci COMMENT '乡村建房宅基地许可证个人建房田地临时凭据',
  `property_img_1` text COLLATE utf8mb4_unicode_ci COMMENT '集体土地使用权证农村房屋所有权证',
  `alibi_img` text COLLATE utf8mb4_unicode_ci COMMENT '犯罪(清白)证明',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.house_audits 结构
CREATE TABLE IF NOT EXISTS `house_audits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `img` text COLLATE utf8mb4_unicode_ci COMMENT '房屋鉴定图',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '房屋审批报告编号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '审核状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公共场所地址方位示意图',
  `system_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公共制度',
  `duty_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '黄厝社区民宿经营责任协议书',
  `mass_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '建筑结构质量鉴定委托书',
  `safe_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '民宿业治安管理制度',
  `self_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '厦门市个体工商户安全生产标准化建设自评表',
  `audit_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '厦门市民宿经营申报联合核验表',
  `accredit_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '授权委托书',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.marketings 结构
CREATE TABLE IF NOT EXISTS `marketings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司名',
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略图',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '描述',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `url` text COLLATE utf8mb4_unicode_ci COMMENT '网址',
  `top` int(10) unsigned NOT NULL DEFAULT '2' COMMENT '是否置顶,默认为2，不置顶',
  `orderby` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态值：默认为1，为显示状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.merchants 结构
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  `flow_status` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示流程',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手机号',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"merchant":1}' COMMENT '状态：默认为1未认证',
  `api_token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '判断登录用的缓存token',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchants_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.merchant_infos 结构
CREATE TABLE IF NOT EXISTS `merchant_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) unsigned NOT NULL COMMENT '商户ID',
  `merchant_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商家地址',
  `merchant_short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商家简称',
  `merchant_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商家名称',
  `merchant_principal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '负责人',
  `business_img` text COLLATE utf8mb4_unicode_ci COMMENT '营业执照',
  `business_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '注册号',
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业执照名称',
  `business_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业执照法人',
  `business_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业地址',
  `identity_front` text COLLATE utf8mb4_unicode_ci COMMENT '身份证正面',
  `identity_contrary` text COLLATE utf8mb4_unicode_ci COMMENT '身份证正面',
  `identity_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证号',
  `identity_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证姓名',
  `contract_tenancy` text COLLATE utf8mb4_unicode_ci COMMENT '租赁合同',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '缩略图',
  `interior_figure_one` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '内景图1',
  `interior_figure_two` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '内景图2',
  `interior_figure_three` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '内景图3',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `register` timestamp NULL DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.migrations 结构
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.notifies 结构
CREATE TABLE IF NOT EXISTS `notifies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '管理员ID',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '通知标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '通知内容',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '通知类型',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '通知状态：显示或者隐藏',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.operation_articles 结构
CREATE TABLE IF NOT EXISTS `operation_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.operation_article_groups 结构
CREATE TABLE IF NOT EXISTS `operation_article_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.orders 结构
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.password_resets 结构
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.permissions 结构
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.permission_role 结构
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.roles 结构
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名称',
  `display` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '显示名称',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.sides 结构
CREATE TABLE IF NOT EXISTS `sides` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '幻灯片地址',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '跳转链接',
  `orderby` int(10) unsigned NOT NULL COMMENT '排序值',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '客户端:1显示、2隐藏',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.sm_dorm_info 结构
CREATE TABLE IF NOT EXISTS `sm_dorm_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) unsigned NOT NULL COMMENT '商户ID',
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '省份',
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '城市',
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '所属区县',
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商家名称',
  `merchant_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '店招名称',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '统一社会信用代码',
  `juridical_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '法人姓名',
  `service_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客服电话',
  `leader_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '负责人姓名',
  `sex` int(10) unsigned DEFAULT NULL COMMENT '负责人性别',
  `leader_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '负责人手机',
  `leader_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '负责人邮箱',
  `leader_qq` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '负责人QQ',
  `leader_wx` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '负责人微信',
  `papers` text COLLATE utf8mb4_unicode_ci COMMENT '经营资质',
  `type` text COLLATE utf8mb4_unicode_ci COMMENT '经营品类',
  `brand` text COLLATE utf8mb4_unicode_ci COMMENT '经营品牌',
  `feature` text COLLATE utf8mb4_unicode_ci COMMENT '主题特色',
  `config` text COLLATE utf8mb4_unicode_ci COMMENT '配套设施',
  `room_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客房数量',
  `adorn_time` timestamp NOT NULL COMMENT '最后装修时间',
  `trait` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '投资规模及民宿特色',
  `earning` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '营业收入',
  `lease` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '租期',
  `ratio` text COLLATE utf8mb4_unicode_ci COMMENT '入住率',
  `price` text COLLATE utf8mb4_unicode_ci COMMENT '均价',
  `rent` text COLLATE utf8mb4_unicode_ci COMMENT '年租金',
  `staff_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '员工数量',
  `awards` text COLLATE utf8mb4_unicode_ci COMMENT '获奖情况',
  `penalty` text COLLATE utf8mb4_unicode_ci COMMENT '受到处罚情况',
  `opinion` text COLLATE utf8mb4_unicode_ci COMMENT '对当地民宿发展政策的意见和建议',
  `hard` text COLLATE utf8mb4_unicode_ci COMMENT '民宿经营过程中遇到的困难',
  `img` text COLLATE utf8mb4_unicode_ci COMMENT '民宿美图',
  `status` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `site` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '位置',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
-- 导出  表 hctravel.verify_logs 结构
CREATE TABLE IF NOT EXISTS `verify_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `verify_success` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '审核记录内容',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '审核状态',
  `type` int(11) NOT NULL COMMENT '审核类型',
  `feedback` text COLLATE utf8mb4_unicode_ci COMMENT '客服反馈',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 数据导出被取消选择。
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
