-- MySQL dump 10.13  Distrib 5.6.38, for Linux (x86_64)
--
-- Host: 112.74.105.107    Database: hospital
-- ------------------------------------------------------
-- Server version	5.6.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `hospital`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `hospital` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `hospital`;

--
-- Table structure for table `bak_hospital_out_info`
--

DROP TABLE IF EXISTS `bak_hospital_out_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bak_hospital_out_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `patient_name` varchar(45) NOT NULL DEFAULT '',
  `record_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `hospital_out_status` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `dead_date` varchar(45) NOT NULL DEFAULT '',
  `dead_reason` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `out_date` varchar(45) NOT NULL DEFAULT '',
  `out_reason` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `cost` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `comment` varchar(200) NOT NULL DEFAULT '',
  `hospital_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `manager_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `record_id` (`record_id`),
  KEY `patient_id` (`patient_id`),
  KEY `record_id_2` (`record_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bak_hospital_out_info`
--

LOCK TABLES `bak_hospital_out_info` WRITE;
/*!40000 ALTER TABLE `bak_hospital_out_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `bak_hospital_out_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bak_operation_after_info`
--

DROP TABLE IF EXISTS `bak_operation_after_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bak_operation_after_info` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `patient_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `patient_name` varchar(45) NOT NULL DEFAULT '',
  `record_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `hospital_time` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `b_jianhu` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '当天进出监护室',
  `jianhu_date` varchar(45) NOT NULL DEFAULT '' COMMENT '出监护室日期',
  `jianhu_time_stop` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '术后监护室停留时间',
  `leiji_days` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '累计有创辅助通气时间',
  `b_blood_input` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '围手术期血液制品输入',
  `red` float unsigned zerofill NOT NULL DEFAULT '000000000000',
  `blood` float unsigned zerofill NOT NULL DEFAULT '000000000000' COMMENT '新鲜冰冻血浆',
  `blood_down` float unsigned zerofill NOT NULL DEFAULT '000000000000' COMMENT '血浆冷沉淀',
  `xxb` float unsigned zerofill NOT NULL DEFAULT '000000000000' COMMENT '血小板',
  `xtx` float unsigned zerofill NOT NULL DEFAULT '000000000000' COMMENT '自体血',
  `b_operation_after_bfz` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '术后并发症',
  `b_operation_after_bfz_type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '术后并发症类型',
  `b_operation_after_bfz_desc` varchar(1024) NOT NULL DEFAULT '',
  `b_operation_after_bfz_other` varchar(1024) NOT NULL DEFAULT '',
  `manager_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `hospital_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `record_id` (`record_id`),
  KEY `patient_id` (`patient_id`),
  KEY `record_id_2` (`record_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bak_operation_after_info`
--

LOCK TABLES `bak_operation_after_info` WRITE;
/*!40000 ALTER TABLE `bak_operation_after_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `bak_operation_after_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bak_operation_before_info`
--

DROP TABLE IF EXISTS `bak_operation_before_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bak_operation_before_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `patient_name` varchar(45) NOT NULL DEFAULT '',
  `record_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operated_times` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '先心病手术次数',
  `operated_info` varchar(1024) NOT NULL DEFAULT '' COMMENT 'json',
  `high` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `weight` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `b_blood_oxygen_saturation_reason` varchar(256) NOT NULL DEFAULT '',
  `b_blood_oxygen_saturation_ru` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `b_blood_oxygen_saturation_lu` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `b_blood_oxygen_saturation_rd` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `b_blood_oxygen_saturation_ld` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `a_blood_oxygen_saturation_ru` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `a_blood_oxygen_saturation_lu` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `a_blood_oxygen_saturation_rd` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `a_blood_oxygen_saturation_ld` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `a_blood_oxygen_saturation_reason` varchar(256) NOT NULL DEFAULT '',
  `spec_check` varchar(256) NOT NULL DEFAULT '',
  `pre_check` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `birth_age` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `birth_weight` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `pre_surecheck` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `pre_danger` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `non_normal` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `hospital_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `manager_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `record_id` (`record_id`),
  KEY `patient_id` (`patient_id`),
  KEY `record_id_2` (`record_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bak_operation_before_info`
--

LOCK TABLES `bak_operation_before_info` WRITE;
/*!40000 ALTER TABLE `bak_operation_before_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `bak_operation_before_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bak_operation_info`
--

DROP TABLE IF EXISTS `bak_operation_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bak_operation_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `patient_name` varchar(20) NOT NULL DEFAULT '',
  `record_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operation_check` varchar(1024) NOT NULL DEFAULT '' COMMENT 'null is same with before',
  `operation_check_other` varchar(1024) NOT NULL DEFAULT '',
  `operation_name` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operation_name_other` varchar(60) NOT NULL DEFAULT '',
  `operator_name` varchar(60) NOT NULL DEFAULT '',
  `operation_time` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operation_age` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operation_status` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operation_type` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operation_route` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `operation_route_other` varchar(60) NOT NULL DEFAULT '',
  `b_delay_close` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `delay_close_days` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `body_out_cycle` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `body_out_isplan` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `body_out_tby` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '停搏液',
  `body_out_tby_type` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `body_out_tby_tem` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `body_out_cycle_time` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `body_out_zdm_time` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '主动脉阻断时间,0代表不能提供',
  `body_out_zdm_time_reason` varchar(200) NOT NULL DEFAULT '',
  `body_out_bsc` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '是否二次或多次体外循环',
  `body_out_bsc_reason` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `body_out_deep` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '深低温停循环',
  `body_out_deep_time` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '深低温停循环时间',
  `body_out_dcn` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '单侧脑灌注',
  `body_out_dcn_time` varchar(45) NOT NULL DEFAULT '' COMMENT '单侧脑灌注时间',
  `manager_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `hospital_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `record_id` (`record_id`),
  KEY `patient_id` (`patient_id`),
  KEY `record_id_2` (`record_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bak_operation_info`
--

LOCK TABLES `bak_operation_info` WRITE;
/*!40000 ALTER TABLE `bak_operation_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `bak_operation_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospital_info`
--

DROP TABLE IF EXISTS `hospital_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hospital_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `apartment` varchar(100) NOT NULL DEFAULT '',
  `iphone` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospital_info`
--

LOCK TABLES `hospital_info` WRITE;
/*!40000 ALTER TABLE `hospital_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `hospital_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospital_manager`
--

DROP TABLE IF EXISTS `hospital_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hospital_manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `modifytime` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hospital_id` int(10) unsigned NOT NULL DEFAULT '0',
  `iphone` varchar(45) NOT NULL DEFAULT '',
  `name` varchar(45) NOT NULL DEFAULT '',
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospital_manager`
--

LOCK TABLES `hospital_manager` WRITE;
/*!40000 ALTER TABLE `hospital_manager` DISABLE KEYS */;
INSERT INTO `hospital_manager` VALUES (1,'bh','816fd85672a7530bd8fbf329b3722ac4',0,'2018-05-11 08:56:54',1,'13590149774','',0);
/*!40000 ALTER TABLE `hospital_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospitalized_record`
--

DROP TABLE IF EXISTS `hospitalized_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hospitalized_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned NOT NULL DEFAULT '0',
  `patient_name` varchar(200) NOT NULL DEFAULT '',
  `hospitalization_in_time` int(10) unsigned NOT NULL DEFAULT '0',
  `operation_time` int(10) unsigned NOT NULL DEFAULT '0',
  `hospitalization_out_time` int(10) unsigned NOT NULL DEFAULT '0',
  `operation_before_info` text,
  `operation_info` text,
  `operation_after_info` text,
  `hospitalization_out_info` text,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastmodifytime` int(10) unsigned NOT NULL DEFAULT '0',
  `hospital_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '医院id',
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '医院管理员id',
  `lastmodify_manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalized_record`
--

LOCK TABLES `hospitalized_record` WRITE;
/*!40000 ALTER TABLE `hospitalized_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `hospitalized_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patientInfo`
--

DROP TABLE IF EXISTS `patientInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patientInfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) unsigned NOT NULL DEFAULT '0',
  `medical_id` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `nation` varchar(100) NOT NULL DEFAULT '',
  `birthday` varchar(30) NOT NULL DEFAULT '',
  `province` varchar(45) NOT NULL DEFAULT '',
  `city` varchar(45) NOT NULL DEFAULT '',
  `district` varchar(45) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '',
  `reason` varchar(200) NOT NULL DEFAULT '',
  `isSupply` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  `relate_text` text,
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `lastmod_manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sexy` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `uploadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastmodtime` int(10) unsigned NOT NULL DEFAULT '0',
  `create_manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `a` (`medical_id`,`hospital_id`),
  KEY `medical_id` (`medical_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `create_manager_id` (`create_manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patientInfo`
--

LOCK TABLES `patientInfo` WRITE;
/*!40000 ALTER TABLE `patientInfo` DISABLE KEYS */;
INSERT INTO `patientInfo` VALUES (17,1,'345435','黄刚','汉','19841128','','','','','不给',1,'fdgdf',1,1,1,1526179908,0,1526179908,1),(19,1,'fsdfs','黄刚','汉','19841128','','','','','不给',1,'fdgdf',1,1,1,1526179923,0,1526179923,1),(24,1,'555555','黄刚','汉','19841128','','','','','不给',1,'fdgdf',1,1,1,1526180603,0,1526180603,1);
/*!40000 ALTER TABLE `patientInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `username` varchar(50) NOT NULL DEFAULT '',
  `skey` varchar(200) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES ('alick','sdfsdfds',1233),('bh','96f895b6847c01872cb4da3afcc75e19',1526180943);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-13 11:10:32
