/*
SQLyog Ultimate v8.32 
MySQL - 5.0.67-community-nt : Database - doers
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admin_user` */

DROP TABLE IF EXISTS `admin_user`;

CREATE TABLE `admin_user` (
  `user_id` int(11) NOT NULL auto_increment COMMENT '用户id(主键)',
  `user_name` varchar(60) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT 'md5加密后的32位密码',
  PRIMARY KEY  (`user_id`,`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `admin_user` */

insert  into `admin_user`(`user_id`,`user_name`,`password`) values (1,'yan','202cb962ac59075b964b07152d234b70');

/*Table structure for table `art_class` */

DROP TABLE IF EXISTS `art_class`;

CREATE TABLE `art_class` (
  `art_class_id` int(11) NOT NULL auto_increment COMMENT '分类id(主键)',
  `art_class_name` varchar(255) collate utf8_bin NOT NULL COMMENT '分类名称',
  `art_class_brief` varchar(255) collate utf8_bin default NULL COMMENT '分类简介',
  `art_class_father_id` int(11) default '0' COMMENT '父分类',
  `art_class_sort` tinyint(4) default NULL COMMENT '排序，体现先后顺序',
  `is_father_class` tinyint(11) default NULL COMMENT '是否是父分类',
  `path` varchar(64) collate utf8_bin NOT NULL COMMENT '到达该分类的路径，据此可实现无极限分类',
  PRIMARY KEY  (`art_class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `art_class` */

insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (34,'摄影概论','摄影概论',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (37,'php数组介绍','php数组的介绍',34,NULL,NULL,'0,34,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (38,'php数组定义与声明','php数组的定义声明方法',34,NULL,NULL,'0,34,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (39,'php数组引用','',34,NULL,NULL,'0,34,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (40,'摄影发展史','摄影发展史',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (41,'镜头的选取','镜头的选取',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (42,'闪光灯的使用','闪光灯的使用',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (43,'黑白与暗房','黑白与暗房',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (44,'感光材料','感光材料',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (45,'摄影构图、用光','摄影构图、用光',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (46,'人像摄影美姿','人像摄影美姿',0,NULL,NULL,'0,');
insert  into `art_class`(`art_class_id`,`art_class_name`,`art_class_brief`,`art_class_father_id`,`art_class_sort`,`is_father_class`,`path`) values (47,'优秀作品赏析','优秀作品赏析',0,NULL,NULL,'0,');

/*Table structure for table `article_info` */

DROP TABLE IF EXISTS `article_info`;

CREATE TABLE `article_info` (
  `art_id` int(11) NOT NULL auto_increment COMMENT '文章id',
  `art_class_id` int(11) NOT NULL COMMENT '分类id',
  `art_title` varchar(50) collate utf8_bin NOT NULL COMMENT '文章标题',
  `author` varchar(50) character set utf8 NOT NULL COMMENT '作者',
  `publication_time` datetime NOT NULL COMMENT '时间',
  `art_sort` int(11) NOT NULL default '50' COMMENT '排序',
  `brief` varchar(100) character set utf8 default NULL COMMENT '简介',
  `art_type` tinyint(4) NOT NULL default '1' COMMENT '1/文字，2/图文，3/视频，4/习题',
  `thumbnail` varchar(255) character set utf8 default NULL COMMENT '缩略图路径',
  `words_num` int(11) default NULL COMMENT '文章字数',
  `text` text character set utf8 COMMENT '文章具体内容',
  `state` int(10) unsigned NOT NULL default '0' COMMENT '0/草稿，1/发布，2/回收站',
  PRIMARY KEY  (`art_id`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `article_info` */

insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (297,37,'数组的含义','doers','2016-03-08 14:56:01',0,'数组的含义',1,'20160308101155226068.gif',184,'<p>\r\n			所谓数组，就是相同数据类型的元素按一定顺序排列的集合，就是把有限个类型相同的变量用一个名字命名，然后用编号区分他们的变量的集合，这个名字称为数组名，编号称为下标。组成数组的各个变量称为数组的分量，也称为数组的元素，有时也称为下标变量。数组是在程序设计中，为了处理方便， 把具有相同类型的若干变量按有序的形式组织起来的一种形式。这些按序排列的同类数据元素的集合称为数组。		</p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (298,37,'php数组','doers','2016-03-08 10:13:20',1,'php数组分类',2,'20160308101320784173.gif',75,'<p><span style=\"font-family: 宋体, Arial, sans-serif; font-size: 14px; line-height: 25px; background-color: rgb(239, 244, 250);\">PHP支持两种数组：索引数组(indexed array)和联合数组(associative array)，前者使用数字作为键，后者使用字符串作为键。</span></p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (299,37,'php数组课程视频','doers','2016-03-08 14:46:40',2,'php数组课程视频',3,'1457419600531515.gif',1,'<p>			</p><p><video class=\"edui-upload-video  vjs-default-skin  video-js\" controls=\"\" preload=\"auto\" width=\"420\" height=\"280\" src=\"/weixin/upload/ueditor/video/20160308/1457419502138291.mp4\" data-setup=\"{}\"><source src=\"/weixin/upload/ueditor/video/20160308/1457419502138291.mp4\" type=\"video/mp4\"/></video><br/></p><p><br/></p><p><br/></p><p>		</p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (301,38,'php数组定义与声明——文本','yan','2016-03-08 14:04:39',0,'111',1,'',7,'<p>额外额外的负担</p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (302,38,'php数组定义与声明——图片','yan','2016-03-08 14:10:00',1,'php数组定义与声明——图片',2,'',2,'<p style=\"text-align:center\"><img src=\"/weixin/upload/ueditor/image/20160308/1457417367287882.png\" title=\"1457417367287882.png\" alt=\"2016-03-02_011623.png\"/></p><p style=\"text-align: center;\"><img src=\"/weixin/upload/ueditor/image/20151028/1446027925972518.jpg\" alt=\"1446027925972518.jpg\"/></p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (307,37,'测试','测试','2016-03-08 15:15:47',3,'测试',3,'1457421347882061.gif',1,'<p>			</p><p><embed type=\"application/x-shockwave-flash\" class=\"edui-faked-video\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" src=\"http://static.video.qq.com/TPout.swf?vid=k1400xcost3\" width=\"420\" height=\"280\" wmode=\"transparent\" play=\"true\" loop=\"false\" menu=\"false\" allowscriptaccess=\"never\" allowfullscreen=\"true\"/></p><p>		</p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (308,38,'php数组定义与声明——视频','yan','2016-03-08 15:49:49',2,'php数组定义与声明——视频',3,'',15,'<p>			</p><h2 style=\"text-align: center;\">php数组定义与声明——视频</h2><p style=\"text-align: center;\"><video class=\"edui-upload-video  vjs-default-skin video-js\" controls=\"\" preload=\"auto\" width=\"360\" height=\"280\" src=\"/weixin/upload/ueditor/video/20160308/1457421689769967.mp4\" data-setup=\"{}\"><source src=\"/weixin/upload/ueditor/video/20160308/1457421689769967.mp4\" type=\"video/mp4\"/></video></p><p>		</p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (312,38,'php数组定义与声明——习题','yan','2016-03-10 12:24:41',3,'php数组定义与声明——习题',4,'',41,'<h3 style=\"text-align: left;\">php数组定义与声明——习题</h3><ol class=\" list-paddingleft-2\" style=\"list-style-type: decimal;\"><li><p>性别</p><p><span title=\"sex\"><input name=\"sex\" value=\"A\" type=\"radio\"/>A.男&nbsp;<input name=\"sex\" value=\"B\" type=\"radio\"/>B.女&nbsp;</span><br/></p></li><li><p>爱好</p><p><span title=\"hobby\"><input name=\"hobby[]\" value=\"A\" type=\"checkbox\"/>A.上网&nbsp;<input name=\"hobby[]\" value=\"B\" type=\"checkbox\"/>B.看书&nbsp;<input name=\"hobby[]\" value=\"C\" type=\"checkbox\"/>C.打球&nbsp;</span><br/></p></li></ol>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (313,39,'php数组引用——文本','yan','2016-03-24 20:36:00',0,'php数组引用——文本',1,'',9,'<p>你好你好，测试测试<br/></p>',1);
insert  into `article_info`(`art_id`,`art_class_id`,`art_title`,`author`,`publication_time`,`art_sort`,`brief`,`art_type`,`thumbnail`,`words_num`,`text`,`state`) values (314,39,'php数组引用——图文','yan','2016-03-24 20:36:50',1,'php数组引用——图文',2,'',10,'<p>测试测试测试！！！！<br/></p>',1);

/*Table structure for table `curriculum_learn` */

DROP TABLE IF EXISTS `curriculum_learn`;

CREATE TABLE `curriculum_learn` (
  `cl_id` int(11) NOT NULL auto_increment,
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `curriculum_id` int(11) NOT NULL COMMENT '课时id,对应art_class_id',
  `unit_id` int(11) NOT NULL COMMENT '单元id',
  `session_id` varchar(40) NOT NULL COMMENT '对应1次课时的学习',
  `begin_time` datetime NOT NULL COMMENT '开始学习时间',
  `learn_time` int(11) NOT NULL COMMENT '学习时间长度',
  PRIMARY KEY  (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `curriculum_learn` */

insert  into `curriculum_learn`(`cl_id`,`student_id`,`curriculum_id`,`unit_id`,`session_id`,`begin_time`,`learn_time`) values (1,3,37,34,'nra0f53gu5gj0po9ep401t4dd7','2016-03-27 00:43:06',354);
insert  into `curriculum_learn`(`cl_id`,`student_id`,`curriculum_id`,`unit_id`,`session_id`,`begin_time`,`learn_time`) values (3,3,38,34,'h8p5oiootu3sa377gruf6esa34','2016-03-27 16:59:53',505);
insert  into `curriculum_learn`(`cl_id`,`student_id`,`curriculum_id`,`unit_id`,`session_id`,`begin_time`,`learn_time`) values (5,3,39,34,'h8p5oiootu3sa377gruf6esa34','2016-03-27 17:01:47',689);
insert  into `curriculum_learn`(`cl_id`,`student_id`,`curriculum_id`,`unit_id`,`session_id`,`begin_time`,`learn_time`) values (6,3,37,34,'h8p5oiootu3an377gruf6esa34','2016-03-27 17:02:20',300);
insert  into `curriculum_learn`(`cl_id`,`student_id`,`curriculum_id`,`unit_id`,`session_id`,`begin_time`,`learn_time`) values (7,3,39,34,'h8p5oiootu3sa377gruf6esa34','2016-03-27 20:58:11',600);
insert  into `curriculum_learn`(`cl_id`,`student_id`,`curriculum_id`,`unit_id`,`session_id`,`begin_time`,`learn_time`) values (8,3,37,34,'h8p5oiahtu3sa377gruf6esa34','2016-03-27 21:00:11',450);

/*Table structure for table `discuss` */

DROP TABLE IF EXISTS `discuss`;

CREATE TABLE `discuss` (
  `id` int(11) NOT NULL auto_increment COMMENT '主键',
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `curriculum_id` int(11) NOT NULL COMMENT '课时id(对应art_class_id)',
  `father_id` int(11) NOT NULL COMMENT '标识从属的讨论id，为0表示一次评论的开始',
  `content` varchar(255) collate utf8_bin NOT NULL COMMENT '评论内容',
  `time` datetime NOT NULL COMMENT '评论时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `discuss` */

insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (1,2,37,0,'你好','2016-03-09 10:57:56');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (2,3,37,1,'你也好呀','2016-03-09 13:09:18');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (3,4,37,1,'哈哈楼上你们够了','2016-03-09 13:15:21');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (4,4,37,0,'其实这只是测试而已','2016-03-09 13:15:47');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (5,3,37,4,'别逗了','2016-03-09 13:16:31');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (6,3,37,1,'hahah','2016-03-09 20:46:14');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (7,3,37,1,'hahah','2016-03-09 20:46:57');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (8,3,37,1,'手动阀手动阀','2016-03-09 20:47:56');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (9,3,37,4,'你好呀','2016-03-09 20:48:09');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (10,3,37,4,'这个其实还好','2016-03-09 20:54:53');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (11,3,37,1,'哈哈哈哈','2016-03-09 20:55:04');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (12,3,37,0,'123123123','2016-03-09 22:25:48');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (13,3,37,0,'士大夫发射点法','2016-03-09 22:26:50');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (14,3,37,0,'这是测试啊啊啊啊','2016-03-09 22:27:28');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (15,3,37,14,'哈哈哈哈哈哈','2016-03-09 22:27:36');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (16,3,38,0,'测试一下','2016-03-09 22:29:02');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (17,2,38,16,'我想你成功了','2016-03-09 22:29:40');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (18,3,37,13,'别乱来','2016-03-10 11:17:14');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (19,3,37,13,'哦','2016-03-10 11:17:24');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (20,3,37,12,'哈哈哈哈','2016-03-10 11:17:29');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (21,3,37,12,'哈哈哈哈','2016-03-10 11:17:30');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (22,3,37,12,'哈哈哈哈','2016-03-10 11:17:37');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (23,3,37,0,'哈哈哈哈哈哈哈','2016-03-10 11:21:48');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (24,3,37,0,'哈哈哈哈哈哈哈222','2016-03-10 11:21:53');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (25,3,37,0,'哈哈哈哈哈哈哈222','2016-03-10 11:21:54');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (26,3,37,0,'怎么会有两个','2016-03-10 11:22:10');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (27,3,37,0,'等下做一个删除操作好了。。。。。。','2016-03-10 11:26:32');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (28,3,37,27,'呵呵','2016-03-10 11:27:47');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (29,3,38,0,'哈哈哈哈','2016-03-10 16:43:46');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (30,3,37,0,'视频非常好','2016-03-12 13:44:55');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (31,3,37,30,'呵呵，是呀','2016-03-12 13:45:14');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (32,3,37,1,'呵呵，是呀','2016-03-12 14:06:39');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (33,2,37,23,'测试一下','2016-03-13 13:54:11');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (34,3,37,0,'这是测试','2016-03-24 21:49:29');
insert  into `discuss`(`id`,`student_id`,`curriculum_id`,`father_id`,`content`,`time`) values (35,3,37,34,'不用测试啦，已经成功了','2016-03-24 21:49:59');

/*Table structure for table `learn_order` */

DROP TABLE IF EXISTS `learn_order`;

CREATE TABLE `learn_order` (
  `lo_id` int(11) NOT NULL auto_increment,
  `student_id` int(11) NOT NULL COMMENT '学习者id',
  `art_class_id` int(11) NOT NULL COMMENT '单元、课程id',
  `learn_time` int(11) NOT NULL COMMENT '开始学习的时间',
  PRIMARY KEY  (`lo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `learn_order` */

insert  into `learn_order`(`lo_id`,`student_id`,`art_class_id`,`learn_time`) values (5,3,34,1457964272);
insert  into `learn_order`(`lo_id`,`student_id`,`art_class_id`,`learn_time`) values (6,3,37,1457964320);
insert  into `learn_order`(`lo_id`,`student_id`,`art_class_id`,`learn_time`) values (7,3,38,1458311718);
insert  into `learn_order`(`lo_id`,`student_id`,`art_class_id`,`learn_time`) values (8,3,47,1458311797);
insert  into `learn_order`(`lo_id`,`student_id`,`art_class_id`,`learn_time`) values (9,3,40,1458549156);
insert  into `learn_order`(`lo_id`,`student_id`,`art_class_id`,`learn_time`) values (10,3,46,1458830280);

/*Table structure for table `learn_path` */

DROP TABLE IF EXISTS `learn_path`;

CREATE TABLE `learn_path` (
  `lp_id` int(11) NOT NULL auto_increment COMMENT '主键id',
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `unit_id` int(11) NOT NULL COMMENT '单元id(学习路径以单元为单位)',
  `learn_path_content` varchar(10240) NOT NULL COMMENT '学习路径内容',
  `last_time` datetime NOT NULL COMMENT '最后记录的时间',
  PRIMARY KEY  (`lp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `learn_path` */

insert  into `learn_path`(`lp_id`,`student_id`,`unit_id`,`learn_path_content`,`last_time`) values (1,3,34,'a:1:{s:4:\"data\";a:6:{i:0;a:2:{i:0;i:1;i:1;d:6;}i:1;a:2:{i:0;i:2;i:1;d:8;}i:2;a:2:{i:0;i:3;i:1;d:11;}i:3;a:3:{s:6:\"marker\";a:3:{s:6:\"symbol\";s:6:\"square\";s:9:\"lineColor\";N;s:9:\"lineWidth\";i:2;}s:1:\"x\";s:1:\"1\";s:1:\"y\";d:5;}i:4;a:3:{s:6:\"marker\";a:3:{s:6:\"symbol\";s:6:\"square\";s:9:\"lineColor\";N;s:9:\"lineWidth\";i:2;}s:1:\"x\";s:1:\"3\";s:1:\"y\";d:10;}i:5;a:3:{s:6:\"marker\";a:3:{s:6:\"symbol\";s:8:\"triangle\";s:9:\"lineColor\";N;s:9:\"lineWidth\";i:2;}s:1:\"x\";s:1:\"1\";s:1:\"y\";d:8;}}}','2016-03-27 22:53:45');

/*Table structure for table `login_record` */

DROP TABLE IF EXISTS `login_record`;

CREATE TABLE `login_record` (
  `lr_id` int(11) NOT NULL auto_increment COMMENT '主键id',
  `session_id` varchar(40) collate utf8_bin NOT NULL COMMENT '登录对应的sessionid',
  `student_id` int(11) NOT NULL COMMENT '登录者id',
  `login_time` int(11) NOT NULL COMMENT '登录时间',
  `online_time` int(11) default '0' COMMENT '在线时间（单位秒）',
  PRIMARY KEY  (`lr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `login_record` */

insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (5,'kpcjrli5fj1om847gdansm0qd5',3,1457964013,762);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (6,'ng7ga4lsuuttq89u6ft59d1r21',3,1458269281,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (7,'2b59p0flrtss8vh4cbe9qlfa21',3,1458306573,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (8,'7h2nkgi2ll0k12kii0e51leac0',3,1458311628,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (9,'e3pt1mrusv2joeetqsv5jufoq4',3,1458549142,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (10,'ncfnb4oapk872b452omumr3a66',3,1458823625,681);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (11,'pldr3n6fqjppfg97b6mdgudq34',3,1458827346,3274);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (12,'v05pfb6rjcgnldkh84enin5uf3',3,1458836796,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (13,'4112s1etbjua43ua0fai3m71c6',3,1458915536,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (14,'4112s1etbjua43ua0fai3m71c6',3,1458915690,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (15,'4112s1etbjua43ua0fai3m71c6',3,1458915698,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (16,'4112s1etbjua43ua0fai3m71c6',3,1458915702,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (17,'ldpe8tg2kgdjqqindtpmr643q4',3,1458918960,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (18,'k72ivegb87pdn100gc05gre0u7',3,1458962182,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (19,'8gepfp61ib79gdh8q6ucpaidi3',11,1458985630,0);
insert  into `login_record`(`lr_id`,`session_id`,`student_id`,`login_time`,`online_time`) values (20,'2oo7ehcf6711spkf9sddd2eah4',3,1459013354,219);

/*Table structure for table `personal_info` */

DROP TABLE IF EXISTS `personal_info`;

CREATE TABLE `personal_info` (
  `subscribe` varchar(255) collate utf8_bin default '1',
  `id` int(11) NOT NULL auto_increment,
  `openid` int(11) default NULL,
  `nickname` varchar(255) collate utf8_bin default NULL,
  `sex` int(11) default NULL,
  `city` varchar(255) collate utf8_bin default NULL,
  `country` varchar(255) collate utf8_bin default NULL,
  `province` varchar(255) collate utf8_bin default NULL,
  `language` varchar(255) collate utf8_bin default '',
  `subscribe_time` datetime default NULL,
  `age` int(11) default NULL,
  `profession` varchar(255) collate utf8_bin default NULL,
  `education` varchar(255) collate utf8_bin default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `personal_info` */

insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',1,NULL,NULL,1,NULL,NULL,'广东','',NULL,16,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',2,NULL,NULL,2,NULL,NULL,'贵州','',NULL,19,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',3,NULL,NULL,1,NULL,NULL,'广东','',NULL,19,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',4,NULL,NULL,1,NULL,NULL,'贵州','',NULL,29,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',5,NULL,NULL,1,NULL,NULL,'广西','',NULL,17,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',6,NULL,NULL,2,NULL,NULL,'贵州','',NULL,18,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',7,NULL,NULL,2,NULL,NULL,'福建','',NULL,18,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',8,NULL,NULL,1,NULL,NULL,'广东','',NULL,18,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',9,NULL,NULL,2,NULL,NULL,'福建','',NULL,22,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',10,NULL,NULL,2,NULL,NULL,'云南','',NULL,22,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',11,NULL,NULL,2,NULL,NULL,'广东','',NULL,19,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',12,NULL,NULL,1,NULL,NULL,'福建','',NULL,20,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',13,NULL,NULL,1,NULL,NULL,'广东','',NULL,15,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',14,NULL,NULL,2,NULL,NULL,'天津','',NULL,30,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',15,NULL,NULL,1,NULL,NULL,'香港','',NULL,22,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',16,NULL,NULL,1,NULL,NULL,'广东','',NULL,23,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',17,NULL,NULL,2,NULL,NULL,'广东','',NULL,21,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',18,NULL,NULL,1,NULL,NULL,'广东','',NULL,21,NULL,NULL);
insert  into `personal_info`(`subscribe`,`id`,`openid`,`nickname`,`sex`,`city`,`country`,`province`,`language`,`subscribe_time`,`age`,`profession`,`education`) values ('1',19,NULL,NULL,1,NULL,NULL,'广东','',NULL,23,NULL,NULL);

/*Table structure for table `practice_answer` */

DROP TABLE IF EXISTS `practice_answer`;

CREATE TABLE `practice_answer` (
  `art_id` int(11) NOT NULL COMMENT '文章id',
  `answer_content` varchar(10240) NOT NULL COMMENT '答案内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `practice_answer` */

insert  into `practice_answer`(`art_id`,`answer_content`) values (312,'a:2:{s:3:\"sex\";s:1:\"A\";s:5:\"hobby\";a:2:{i:0;s:1:\"A\";i:1;s:1:\"B\";}}');

/*Table structure for table `practice_record` */

DROP TABLE IF EXISTS `practice_record`;

CREATE TABLE `practice_record` (
  `pr_id` int(11) NOT NULL auto_increment COMMENT '主键id',
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `art_id` int(11) NOT NULL COMMENT '文章id',
  `record_content` varchar(10240) default NULL COMMENT '答题记录',
  `answer_result` varchar(10240) default NULL COMMENT '对错情况',
  `correct_rate` decimal(3,2) default NULL COMMENT '正确率',
  PRIMARY KEY  (`pr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `practice_record` */

insert  into `practice_record`(`pr_id`,`student_id`,`art_id`,`record_content`,`answer_result`,`correct_rate`) values (15,3,312,'a:2:{s:3:\"sex\";s:1:\"A\";s:5:\"hobby\";a:2:{i:0;s:1:\"A\";i:1;s:1:\"B\";}}','a:2:{s:3:\"sex\";b:1;s:5:\"hobby\";b:1;}','0.95');

/*Table structure for table `read_behavior` */

DROP TABLE IF EXISTS `read_behavior`;

CREATE TABLE `read_behavior` (
  `rb_id` int(11) NOT NULL auto_increment COMMENT '主键id',
  `student_id` int(11) NOT NULL COMMENT '行为发生者id',
  `art_id` int(11) NOT NULL COMMENT '文章id',
  `read_count` tinyint(3) unsigned default NULL COMMENT '阅读次数',
  PRIMARY KEY  (`rb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `read_behavior` */

insert  into `read_behavior`(`rb_id`,`student_id`,`art_id`,`read_count`) values (94,3,298,5);
insert  into `read_behavior`(`rb_id`,`student_id`,`art_id`,`read_count`) values (95,3,297,2);

/*Table structure for table `student` */

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL auto_increment COMMENT '主键id',
  `student_name` varchar(255) collate utf8_bin NOT NULL COMMENT '学生名字',
  `student_psw` varchar(255) collate utf8_bin NOT NULL COMMENT '密码',
  `login_count` int(6) unsigned default '0' COMMENT '登录次数',
  PRIMARY KEY  (`student_id`,`student_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `student` */

insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (2,'huang','202cb962ac59075b964b07152d234b70',2);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (3,'yan','202cb962ac59075b964b07152d234b70',65);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (4,'yan1','202cb962ac59075b964b07152d234b70',0);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (5,'yan2','202cb962ac59075b964b07152d234b70',0);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (6,'yan3','202cb962ac59075b964b07152d234b70',0);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (7,'hahah','202cb962ac59075b964b07152d234b70',0);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (8,'nihao','202cb962ac59075b964b07152d234b70',0);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (9,'hahah','202cb962ac59075b964b07152d234b70',0);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (10,'213123','202cb962ac59075b964b07152d234b70',0);
insert  into `student`(`student_id`,`student_name`,`student_psw`,`login_count`) values (11,'','d41d8cd98f00b204e9800998ecf8427e',1);

/*Table structure for table `web_info` */

DROP TABLE IF EXISTS `web_info`;

CREATE TABLE `web_info` (
  `site_name` varchar(255) collate utf8_bin default NULL,
  `is_open_collection` int(11) default NULL,
  `is_open_collection_tip` int(11) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `web_info` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
