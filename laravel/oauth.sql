-- MySQL dump 10.13  Distrib 5.5.48, for Win64 (x86)
--
-- Host: localhost    Database: oauth
-- ------------------------------------------------------
-- Server version	5.5.48

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
-- Table structure for table `api_group`
--

DROP TABLE IF EXISTS `api_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_group`
--

LOCK TABLES `api_group` WRITE;
/*!40000 ALTER TABLE `api_group` DISABLE KEYS */;
INSERT INTO `api_group` VALUES (1,'组织关系','组织关系API信息','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'个人信息','个人信息API','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'aaa信息','aaa信息API','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'bbb信息','bbb信息API','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'ccc信息','ccc信息API','0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,'555','666','0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,'555','666','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `api_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_info`
--

DROP TABLE IF EXISTS `api_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `params` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `success_response` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fail_response` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_info`
--

LOCK TABLES `api_info` WRITE;
/*!40000 ALTER TABLE `api_info` DISABLE KEYS */;
INSERT INTO `api_info` VALUES (1,'GET','http://111','111','111',NULL,NULL,NULL,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'POST','http://222','222','222',NULL,NULL,NULL,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'POST','http://333','333','333',NULL,NULL,NULL,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'POST','222','111',NULL,'{\"333\":\"3333\",\"444\":\"444\",\"555\":\"555\"}','666','8888',1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'POST','11','11',NULL,'{\"11\":\"22\"}','33','44',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `api_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2017_02_22_031102_create_users_table',1),('2013_07_24_132419_create_oauth_clients_table',2),('2013_07_24_133032_create_oauth_client_endpoints_table',2),('2013_07_24_133359_create_oauth_sessions_table',2),('2013_07_24_133833_create_oauth_session_access_tokens_table',2),('2013_07_24_134209_create_oauth_session_authcodes_table',2),('2013_07_24_134437_create_oauth_session_redirects_table',2),('2013_07_24_134700_create_oauth_session_refresh_tokens_table',2),('2013_07_24_135036_create_oauth_scopes_table',2),('2013_07_24_135250_create_oauth_session_token_scopes_table',2),('2013_07_24_135634_create_oauth_session_authcode_scopes_table',2),('2013_08_07_112010_create_oauth_grants_table',2),('2013_08_07_112252_create_oauth_client_grants_table',2),('2013_08_07_183251_create_oauth_client_scopes_table',2),('2013_08_07_183635_create_oauth_grant_scopes_table',2),('2013_08_07_183636_create_oauth_client_metadata_table',2),('2017_03_06_054539_create_api_info_table',3),('2017_03_08_014238_create_api_group_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_endpoints`
--

DROP TABLE IF EXISTS `oauth_client_endpoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_endpoints` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_endpoints_client_id_foreign` (`client_id`),
  CONSTRAINT `oauth_client_endpoints_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_endpoints`
--

LOCK TABLES `oauth_client_endpoints` WRITE;
/*!40000 ALTER TABLE `oauth_client_endpoints` DISABLE KEYS */;
INSERT INTO `oauth_client_endpoints` VALUES (1,'client1id','http://localhost:8001/callback','2017-02-24 14:14:31','2017-02-24 14:14:31'),(2,'client2id','http://example2.com/callback','2017-02-24 14:14:31','2017-02-24 14:14:31');
/*!40000 ALTER TABLE `oauth_client_endpoints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_grants`
--

DROP TABLE IF EXISTS `oauth_client_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `grant_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_grants_client_id_foreign` (`client_id`),
  KEY `oauth_client_grants_grant_id_foreign` (`grant_id`),
  CONSTRAINT `oauth_client_grants_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_client_grants_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_grants`
--

LOCK TABLES `oauth_client_grants` WRITE;
/*!40000 ALTER TABLE `oauth_client_grants` DISABLE KEYS */;
INSERT INTO `oauth_client_grants` VALUES (1,'client1id',1,'2017-02-24 14:14:31','2017-02-24 14:14:31'),(2,'client2id',2,'2017-02-24 14:14:31','2017-02-24 14:14:31');
/*!40000 ALTER TABLE `oauth_client_grants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_metadata`
--

DROP TABLE IF EXISTS `oauth_client_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_client_metadata_cid_key_unique` (`client_id`,`key`),
  KEY `oauth_client_metadata_client_id_index` (`client_id`),
  CONSTRAINT `oauth_client_metadata_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_metadata`
--

LOCK TABLES `oauth_client_metadata` WRITE;
/*!40000 ALTER TABLE `oauth_client_metadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_client_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_scopes`
--

DROP TABLE IF EXISTS `oauth_client_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_scopes_client_id_foreign` (`client_id`),
  KEY `oauth_client_scopes_scope_id_foreign` (`scope_id`),
  CONSTRAINT `oauth_client_scopes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_client_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_scopes`
--

LOCK TABLES `oauth_client_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_client_scopes` DISABLE KEYS */;
INSERT INTO `oauth_client_scopes` VALUES (1,'client1id',1,'2017-02-24 14:14:31','2017-02-24 14:14:31'),(2,'client2id',2,'2017-02-24 14:14:31','2017-02-24 14:14:31');
/*!40000 ALTER TABLE `oauth_client_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `oauth_clients_id_unique` (`id`),
  UNIQUE KEY `oauth_clients_id_secret_unique` (`id`,`secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES ('client1id','client1secret','client1','2017-02-24 14:14:31','2017-02-24 14:14:31'),('client2id','client2secret','client2','2017-02-24 14:14:31','2017-02-24 14:14:31');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_grant_scopes`
--

DROP TABLE IF EXISTS `oauth_grant_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_grant_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grant_id` int(10) unsigned NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_grant_scopes_grant_id_foreign` (`grant_id`),
  KEY `oauth_grant_scopes_scope_id_foreign` (`scope_id`),
  CONSTRAINT `oauth_grant_scopes_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_grant_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_grant_scopes`
--

LOCK TABLES `oauth_grant_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_grant_scopes` DISABLE KEYS */;
INSERT INTO `oauth_grant_scopes` VALUES (1,1,1,'2017-02-24 14:14:31','2017-02-24 14:14:31'),(2,2,2,'2017-02-24 14:14:31','2017-02-24 14:14:31');
/*!40000 ALTER TABLE `oauth_grant_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_grants`
--

DROP TABLE IF EXISTS `oauth_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_grants_grant_unique` (`grant`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_grants`
--

LOCK TABLES `oauth_grants` WRITE;
/*!40000 ALTER TABLE `oauth_grants` DISABLE KEYS */;
INSERT INTO `oauth_grants` VALUES (1,'grant1','2017-02-24 14:14:31','2017-02-24 14:14:31'),(2,'grant2','2017-02-24 14:14:31','2017-02-24 14:14:31');
/*!40000 ALTER TABLE `oauth_grants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_scopes`
--

DROP TABLE IF EXISTS `oauth_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_scopes_scope_unique` (`scope`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_scopes`
--

LOCK TABLES `oauth_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_scopes` DISABLE KEYS */;
INSERT INTO `oauth_scopes` VALUES (1,'basic','scope1','Scope 1 Description','2017-02-24 14:14:31','2017-02-24 14:14:31'),(2,'scope2','scope1','Scope 2 Description','2017-02-24 14:14:31','2017-02-24 14:14:31');
/*!40000 ALTER TABLE `oauth_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_access_tokens`
--

DROP TABLE IF EXISTS `oauth_session_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_access_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(10) unsigned NOT NULL,
  `access_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_expires` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_session_access_tokens_access_token_session_id_unique` (`access_token`,`session_id`),
  KEY `oauth_session_access_tokens_session_id_index` (`session_id`),
  CONSTRAINT `oauth_session_access_tokens_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_access_tokens`
--

LOCK TABLES `oauth_session_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_session_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_session_access_tokens` VALUES (35,47,'rYnL6JGvq9QAbmd5x5cOX36VintXrgKdMi7jjI6G',1488168644,'2017-02-27 03:10:44','2017-02-27 03:10:44'),(44,50,'rTfmW73KSwj6MyWgvS3EGGntPktKXeBBzFypJa3O',1488184584,'2017-02-27 07:36:24','2017-02-27 07:36:24');
/*!40000 ALTER TABLE `oauth_session_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_authcode_scopes`
--

DROP TABLE IF EXISTS `oauth_session_authcode_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_authcode_scopes` (
  `oauth_session_authcode_id` int(10) unsigned NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `oauth_session_authcode_scopes_oauth_session_authcode_id_index` (`oauth_session_authcode_id`),
  KEY `oauth_session_authcode_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_session_authcode_scopes_oauth_session_authcode_id_foreign` FOREIGN KEY (`oauth_session_authcode_id`) REFERENCES `oauth_session_authcodes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_session_authcode_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_authcode_scopes`
--

LOCK TABLES `oauth_session_authcode_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_session_authcode_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_session_authcode_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_authcodes`
--

DROP TABLE IF EXISTS `oauth_session_authcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_authcodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(10) unsigned NOT NULL,
  `auth_code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `auth_code_expires` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_session_authcodes_session_id_index` (`session_id`),
  CONSTRAINT `oauth_session_authcodes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_authcodes`
--

LOCK TABLES `oauth_session_authcodes` WRITE;
/*!40000 ALTER TABLE `oauth_session_authcodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_session_authcodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_redirects`
--

DROP TABLE IF EXISTS `oauth_session_redirects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_redirects` (
  `session_id` int(10) unsigned NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`session_id`),
  CONSTRAINT `oauth_session_redirects_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_redirects`
--

LOCK TABLES `oauth_session_redirects` WRITE;
/*!40000 ALTER TABLE `oauth_session_redirects` DISABLE KEYS */;
INSERT INTO `oauth_session_redirects` VALUES (47,'http://localhost:8001/callback','2017-02-27 03:10:42','2017-02-27 03:10:42'),(50,'http://localhost:8001/callback','2017-02-27 07:36:23','2017-02-27 07:36:23');
/*!40000 ALTER TABLE `oauth_session_redirects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_session_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_refresh_tokens` (
  `session_access_token_id` int(10) unsigned NOT NULL,
  `refresh_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `refresh_token_expires` int(11) NOT NULL,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`session_access_token_id`),
  KEY `oauth_session_refresh_tokens_client_id_index` (`client_id`),
  CONSTRAINT `oauth_session_refresh_tokens_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_session_refresh_tokens_session_access_token_id_foreign` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_refresh_tokens`
--

LOCK TABLES `oauth_session_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_session_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth_session_refresh_tokens` VALUES (35,'6Yadfj35SSZ8oxldqG9635NzdAMzYWTksB3PWSXz',1488769844,'client1id','2017-02-27 03:10:44','2017-02-27 03:10:44'),(44,'oW56O042lYnEqgtwxjoyiINwUI34HeXHWN6deyNP',1488785784,'client1id','2017-02-27 07:36:24','2017-02-27 07:36:24');
/*!40000 ALTER TABLE `oauth_session_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_token_scopes`
--

DROP TABLE IF EXISTS `oauth_session_token_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_token_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_access_token_id` int(10) unsigned NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_session_token_scopes_satid_sid_unique` (`session_access_token_id`,`scope_id`),
  KEY `oauth_session_token_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_session_token_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `oauth_session_token_scopes_session_access_token_id_foreign` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_token_scopes`
--

LOCK TABLES `oauth_session_token_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_session_token_scopes` DISABLE KEYS */;
INSERT INTO `oauth_session_token_scopes` VALUES (35,35,1,'2017-02-27 03:10:44','2017-02-27 03:10:44'),(44,44,1,'2017-02-27 07:36:24','2017-02-27 07:36:24');
/*!40000 ALTER TABLE `oauth_session_token_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_sessions`
--

DROP TABLE IF EXISTS `oauth_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `owner_type` enum('client','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `owner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_sessions_client_id_owner_type_owner_id_index` (`client_id`,`owner_type`,`owner_id`),
  CONSTRAINT `oauth_sessions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_sessions`
--

LOCK TABLES `oauth_sessions` WRITE;
/*!40000 ALTER TABLE `oauth_sessions` DISABLE KEYS */;
INSERT INTO `oauth_sessions` VALUES (2,'client2id','user','2','2017-02-24 14:14:31','2017-02-24 14:14:31'),(47,'client1id','user','2','2017-02-27 03:10:42','2017-02-27 03:10:42'),(50,'client1id','user','1','2017-02-27 07:36:23','2017-02-27 07:36:23');
/*!40000 ALTER TABLE `oauth_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,2,'zzyo','zzyo@qq.com','$2y$10$YtXxzh75MHqJGnZqG.AGqOkOmYfLMg5t6ApT3vo7DCe97jBrnaUVO','','2017-02-24 14:19:31','2017-02-25 12:47:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-18 17:22:19
