-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: telecom_project
-- ------------------------------------------------------
-- Server version	8.0.44-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-boost:mcp:database-schema:mysql:','a:3:{s:6:\"engine\";s:5:\"mysql\";s:6:\"tables\";a:21:{s:5:\"cache\";a:5:{s:7:\"columns\";a:3:{s:3:\"key\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:5:\"value\";a:1:{s:4:\"type\";s:10:\"mediumtext\";}s:10:\"expiration\";a:1:{s:4:\"type\";s:3:\"int\";}}s:7:\"indexes\";a:1:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:3:\"key\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:11:\"cache_locks\";a:5:{s:7:\"columns\";a:3:{s:3:\"key\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:5:\"owner\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"expiration\";a:1:{s:4:\"type\";s:3:\"int\";}}s:7:\"indexes\";a:1:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:3:\"key\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:11:\"failed_jobs\";a:5:{s:7:\"columns\";a:7:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:4:\"uuid\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"connection\";a:1:{s:4:\"type\";s:4:\"text\";}s:5:\"queue\";a:1:{s:4:\"type\";s:4:\"text\";}s:7:\"payload\";a:1:{s:4:\"type\";s:8:\"longtext\";}s:9:\"exception\";a:1:{s:4:\"type\";s:8:\"longtext\";}s:9:\"failed_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:2:{s:23:\"failed_jobs_uuid_unique\";a:4:{s:7:\"columns\";a:1:{i:0;s:4:\"uuid\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:11:\"job_batches\";a:5:{s:7:\"columns\";a:10:{s:2:\"id\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:4:\"name\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"total_jobs\";a:1:{s:4:\"type\";s:3:\"int\";}s:12:\"pending_jobs\";a:1:{s:4:\"type\";s:3:\"int\";}s:11:\"failed_jobs\";a:1:{s:4:\"type\";s:3:\"int\";}s:14:\"failed_job_ids\";a:1:{s:4:\"type\";s:8:\"longtext\";}s:7:\"options\";a:1:{s:4:\"type\";s:10:\"mediumtext\";}s:12:\"cancelled_at\";a:1:{s:4:\"type\";s:3:\"int\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:3:\"int\";}s:11:\"finished_at\";a:1:{s:4:\"type\";s:3:\"int\";}}s:7:\"indexes\";a:1:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:4:\"jobs\";a:5:{s:7:\"columns\";a:7:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:5:\"queue\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:7:\"payload\";a:1:{s:4:\"type\";s:8:\"longtext\";}s:8:\"attempts\";a:1:{s:4:\"type\";s:7:\"tinyint\";}s:11:\"reserved_at\";a:1:{s:4:\"type\";s:3:\"int\";}s:12:\"available_at\";a:1:{s:4:\"type\";s:3:\"int\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:3:\"int\";}}s:7:\"indexes\";a:2:{s:16:\"jobs_queue_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:5:\"queue\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:10:\"migrations\";a:5:{s:7:\"columns\";a:3:{s:2:\"id\";a:1:{s:4:\"type\";s:3:\"int\";}s:9:\"migration\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:5:\"batch\";a:1:{s:4:\"type\";s:3:\"int\";}}s:7:\"indexes\";a:1:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:21:\"model_has_permissions\";a:5:{s:7:\"columns\";a:3:{s:13:\"permission_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:10:\"model_type\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:8:\"model_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}}s:7:\"indexes\";a:2:{s:47:\"model_has_permissions_model_id_model_type_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:8:\"model_id\";i:1;s:10:\"model_type\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:3:{i:0;s:13:\"permission_id\";i:1;s:8:\"model_id\";i:2;s:10:\"model_type\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:1:{i:0;a:7:{s:4:\"name\";s:43:\"model_has_permissions_permission_id_foreign\";s:7:\"columns\";a:1:{i:0;s:13:\"permission_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:11:\"permissions\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:15:\"model_has_roles\";a:5:{s:7:\"columns\";a:3:{s:7:\"role_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:10:\"model_type\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:8:\"model_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}}s:7:\"indexes\";a:2:{s:41:\"model_has_roles_model_id_model_type_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:8:\"model_id\";i:1;s:10:\"model_type\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:3:{i:0;s:7:\"role_id\";i:1;s:8:\"model_id\";i:2;s:10:\"model_type\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:1:{i:0;a:7:{s:4:\"name\";s:31:\"model_has_roles_role_id_foreign\";s:7:\"columns\";a:1:{i:0;s:7:\"role_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:5:\"roles\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:2:\"mt\";a:5:{s:7:\"columns\";a:13:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:10:\"service_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:15:\"subscription_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:6:\"msisdn\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:12:\"message_type\";a:1:{s:4:\"type\";s:4:\"enum\";}s:6:\"status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:9:\"dn_status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:10:\"dn_details\";a:1:{s:4:\"type\";s:4:\"text\";}s:10:\"price_code\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:9:\"mt_ref_id\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:7:\"message\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:8:{s:18:\"mt_dn_status_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:9:\"dn_status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:32:\"mt_message_type_price_code_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:12:\"message_type\";i:1;s:10:\"price_code\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:15:\"mt_msisdn_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:6:\"msisdn\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:18:\"mt_mt_ref_id_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:9:\"mt_ref_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:19:\"mt_mt_ref_id_unique\";a:4:{s:7:\"columns\";a:1:{i:0;s:9:\"mt_ref_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:26:\"mt_service_id_status_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:10:\"service_id\";i:1;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:34:\"mt_subscription_id_dn_status_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:15:\"subscription_id\";i:1;s:9:\"dn_status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:2:{i:0;a:7:{s:4:\"name\";s:21:\"mt_service_id_foreign\";s:7:\"columns\";a:1:{i:0;s:10:\"service_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:8:\"services\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}i:1;a:7:{s:4:\"name\";s:26:\"mt_subscription_id_foreign\";s:7:\"columns\";a:1:{i:0;s:15:\"subscription_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:13:\"subscriptions\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:8:\"set null\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:21:\"password_reset_tokens\";a:5:{s:7:\"columns\";a:3:{s:5:\"email\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:5:\"token\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:1:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:5:\"email\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:11:\"permissions\";a:5:{s:7:\"columns\";a:5:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:4:\"name\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"guard_name\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:2:{s:34:\"permissions_name_guard_name_unique\";a:4:{s:7:\"columns\";a:2:{i:0;s:4:\"name\";i:1;s:10:\"guard_name\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:12:\"renewal_jobs\";a:5:{s:7:\"columns\";a:10:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:10:\"service_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:15:\"renewal_plan_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:15:\"subscription_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:6:\"msisdn\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:6:\"status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:9:\"queued_at\";a:1:{s:4:\"type\";s:8:\"datetime\";}s:12:\"processed_at\";a:1:{s:4:\"type\";s:8:\"datetime\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:5:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:25:\"renewal_jobs_msisdn_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:6:\"msisdn\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:41:\"renewal_jobs_renewal_plan_id_status_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:15:\"renewal_plan_id\";i:1;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:36:\"renewal_jobs_service_id_status_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:10:\"service_id\";i:1;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:41:\"renewal_jobs_subscription_id_status_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:15:\"subscription_id\";i:1;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:3:{i:0;a:7:{s:4:\"name\";s:36:\"renewal_jobs_renewal_plan_id_foreign\";s:7:\"columns\";a:1:{i:0;s:15:\"renewal_plan_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:13:\"renewal_plans\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}i:1;a:7:{s:4:\"name\";s:31:\"renewal_jobs_service_id_foreign\";s:7:\"columns\";a:1:{i:0;s:10:\"service_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:8:\"services\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}i:2;a:7:{s:4:\"name\";s:36:\"renewal_jobs_subscription_id_foreign\";s:7:\"columns\";a:1:{i:0;s:15:\"subscription_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:13:\"subscriptions\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:13:\"renewal_plans\";a:5:{s:7:\"columns\";a:11:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:10:\"service_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:4:\"name\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:9:\"plan_type\";a:1:{s:4:\"type\";s:4:\"enum\";}s:14:\"schedule_rules\";a:1:{s:4:\"type\";s:4:\"json\";}s:21:\"skip_subscription_day\";a:1:{s:4:\"type\";s:7:\"tinyint\";}s:13:\"is_fixed_time\";a:1:{s:4:\"type\";s:7:\"tinyint\";}s:10:\"fixed_time\";a:1:{s:4:\"type\";s:4:\"time\";}s:10:\"start_from\";a:1:{s:4:\"type\";s:8:\"datetime\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:3:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:24:\"renewal_plans_name_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:4:\"name\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:40:\"renewal_plans_service_id_plan_type_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:10:\"service_id\";i:1;s:9:\"plan_type\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:1:{i:0;a:7:{s:4:\"name\";s:32:\"renewal_plans_service_id_foreign\";s:7:\"columns\";a:1:{i:0;s:10:\"service_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:8:\"services\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:20:\"role_has_permissions\";a:5:{s:7:\"columns\";a:2:{s:13:\"permission_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:7:\"role_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}}s:7:\"indexes\";a:2:{s:7:\"primary\";a:4:{s:7:\"columns\";a:2:{i:0;s:13:\"permission_id\";i:1;s:7:\"role_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:36:\"role_has_permissions_role_id_foreign\";a:4:{s:7:\"columns\";a:1:{i:0;s:7:\"role_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:2:{i:0;a:7:{s:4:\"name\";s:42:\"role_has_permissions_permission_id_foreign\";s:7:\"columns\";a:1:{i:0;s:13:\"permission_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:11:\"permissions\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}i:1;a:7:{s:4:\"name\";s:36:\"role_has_permissions_role_id_foreign\";s:7:\"columns\";a:1:{i:0;s:7:\"role_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:5:\"roles\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:5:\"roles\";a:5:{s:7:\"columns\";a:5:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:4:\"name\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"guard_name\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:2:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:28:\"roles_name_guard_name_unique\";a:4:{s:7:\"columns\";a:2:{i:0;s:4:\"name\";i:1;s:10:\"guard_name\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:16:\"service_messages\";a:5:{s:7:\"columns\";a:8:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:10:\"service_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:12:\"message_type\";a:1:{s:4:\"type\";s:4:\"enum\";}s:6:\"status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:7:\"message\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"price_code\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:3:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:47:\"service_messages_service_id_message_type_unique\";a:4:{s:7:\"columns\";a:2:{i:0;s:10:\"service_id\";i:1;s:12:\"message_type\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:42:\"service_messages_status_message_type_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:6:\"status\";i:1;s:12:\"message_type\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:1:{i:0;a:7:{s:4:\"name\";s:35:\"service_messages_service_id_foreign\";s:7:\"columns\";a:1:{i:0;s:10:\"service_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:8:\"services\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:8:\"services\";a:5:{s:7:\"columns\";a:7:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:12:\"shortcode_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:7:\"keyword\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:6:\"status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:12:\"fpmt_enabled\";a:1:{s:4:\"type\";s:7:\"tinyint\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:3:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:33:\"services_shortcode_keyword_unique\";a:4:{s:7:\"columns\";a:2:{i:0;s:12:\"shortcode_id\";i:1;s:7:\"keyword\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:21:\"services_status_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:1:{i:0;a:7:{s:4:\"name\";s:29:\"services_shortcode_id_foreign\";s:7:\"columns\";a:1:{i:0;s:12:\"shortcode_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:10:\"shortcodes\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:8:\"sessions\";a:5:{s:7:\"columns\";a:6:{s:2:\"id\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:7:\"user_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:10:\"ip_address\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"user_agent\";a:1:{s:4:\"type\";s:4:\"text\";}s:7:\"payload\";a:1:{s:4:\"type\";s:8:\"longtext\";}s:13:\"last_activity\";a:1:{s:4:\"type\";s:3:\"int\";}}s:7:\"indexes\";a:3:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:28:\"sessions_last_activity_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:13:\"last_activity\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:22:\"sessions_user_id_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:7:\"user_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:10:\"shortcodes\";a:5:{s:7:\"columns\";a:6:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:9:\"shortcode\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:11:\"description\";a:1:{s:4:\"type\";s:4:\"text\";}s:6:\"status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:3:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:27:\"shortcodes_shortcode_unique\";a:4:{s:7:\"columns\";a:1:{i:0;s:9:\"shortcode\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:23:\"shortcodes_status_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:13:\"subscriptions\";a:5:{s:7:\"columns\";a:10:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:6:\"msisdn\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"service_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:15:\"renewal_plan_id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:6:\"status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:13:\"subscribed_at\";a:1:{s:4:\"type\";s:8:\"datetime\";}s:15:\"last_renewal_at\";a:1:{s:4:\"type\";s:8:\"datetime\";}s:15:\"next_renewal_at\";a:1:{s:4:\"type\";s:8:\"datetime\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:5:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:26:\"subscriptions_msisdn_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:6:\"msisdn\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:38:\"subscriptions_msisdn_service_id_unique\";a:4:{s:7:\"columns\";a:2:{i:0;s:6:\"msisdn\";i:1;s:10:\"service_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:51:\"subscriptions_renewal_plan_id_next_renewal_at_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:15:\"renewal_plan_id\";i:1;s:15:\"next_renewal_at\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:37:\"subscriptions_service_id_status_index\";a:4:{s:7:\"columns\";a:2:{i:0;s:10:\"service_id\";i:1;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:2:{i:0;a:7:{s:4:\"name\";s:37:\"subscriptions_renewal_plan_id_foreign\";s:7:\"columns\";a:1:{i:0;s:15:\"renewal_plan_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:13:\"renewal_plans\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:8:\"set null\";}i:1;a:7:{s:4:\"name\";s:32:\"subscriptions_service_id_foreign\";s:7:\"columns\";a:1:{i:0;s:10:\"service_id\";}s:14:\"foreign_schema\";s:15:\"telecom_project\";s:13:\"foreign_table\";s:8:\"services\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:9:\"no action\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}s:5:\"users\";a:5:{s:7:\"columns\";a:10:{s:2:\"id\";a:1:{s:4:\"type\";s:6:\"bigint\";}s:8:\"username\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:4:\"name\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:5:\"email\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:17:\"email_verified_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:8:\"password\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:6:\"status\";a:1:{s:4:\"type\";s:4:\"enum\";}s:14:\"remember_token\";a:1:{s:4:\"type\";s:7:\"varchar\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:5:{s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}s:18:\"users_email_unique\";a:4:{s:7:\"columns\";a:1:{i:0;s:5:\"email\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}s:18:\"users_status_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:6:\"status\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:20:\"users_username_index\";a:4:{s:7:\"columns\";a:1:{i:0;s:8:\"username\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:21:\"users_username_unique\";a:4:{s:7:\"columns\";a:1:{i:0;s:8:\"username\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:0;}}s:12:\"foreign_keys\";a:0:{}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}}s:6:\"global\";a:4:{s:5:\"views\";a:0:{}s:17:\"stored_procedures\";a:0:{}s:9:\"functions\";a:0:{}s:9:\"sequences\";a:0:{}}}',1764705534),('laravel-cache-boost.roster.scan','a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:8:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.40.2\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.8\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:5:\"0.3.8\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.4\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.3.4\";s:6:\"\0*\0dev\";b:1;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.26.0\";s:6:\"\0*\0dev\";b:1;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.48.1\";s:6:\"\0*\0dev\";b:1;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^4.1\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PEST\";s:14:\"\0*\0packageName\";s:12:\"pestphp/pest\";s:10:\"\0*\0version\";s:5:\"4.1.6\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"12.4.4\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:6:\"12.4.4\";s:6:\"\0*\0dev\";b:1;}i:7;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:TAILWINDCSS\";s:14:\"\0*\0packageName\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:6:\"4.1.17\";s:6:\"\0*\0dev\";b:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1765642214;}',1765728614),('laravel-cache-spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:20:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"service.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:14:\"service.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:14:\"service.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:14:\"service.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:20:\"service_message.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:22:\"service_message.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:22:\"service_message.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:5;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:22:\"service_message.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:17:\"renewal_plan.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:19:\"renewal_plan.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:19:\"renewal_plan.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:19:\"renewal_plan.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:12:\"reports.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"reports.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"reports.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"reports.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:10:\"admin.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"admin.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"admin.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:12:\"admin.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"manager\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"marketing\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"developer\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:9:\"test_role\";s:1:\"c\";s:3:\"web\";}}}',1765768086);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_11_27_000090_create_shortcodes_table',1),(5,'2025_11_27_000095_modify_services_table_for_shortcodes',1),(6,'2025_11_27_000100_create_services_table',1),(7,'2025_11_27_000110_create_service_messages_table',1),(8,'2025_11_27_000120_create_renewal_plans_table',1),(9,'2025_11_27_000130_create_subscriptions_table',1),(10,'2025_11_27_000140_create_renewal_jobs_table',1),(11,'2025_11_27_000150_create_mt_table',1),(12,'2025_11_27_000200_create_permission_tables',1),(13,'2025_11_27_000300_add_username_to_users_table_if_missing',1),(14,'2025_12_03_000001_add_price_code_to_renewal_plans_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(1,'App\\Models\\User',3),(2,'App\\Models\\User',3),(3,'App\\Models\\User',3),(1,'App\\Models\\User',4),(2,'App\\Models\\User',4),(5,'App\\Models\\User',4),(1,'App\\Models\\User',5),(2,'App\\Models\\User',5),(4,'App\\Models\\User',5),(5,'App\\Models\\User',5);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mt`
--

DROP TABLE IF EXISTS `mt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mt` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `subscription_id` bigint unsigned DEFAULT NULL,
  `msisdn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_type` enum('FPMT','RENEWAL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('queued','success','fail') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued',
  `dn_status` enum('pending','success','fail') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `dn_details` text COLLATE utf8mb4_unicode_ci,
  `price_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mt_ref_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mt_mt_ref_id_unique` (`mt_ref_id`),
  KEY `mt_service_id_status_index` (`service_id`,`status`),
  KEY `mt_subscription_id_dn_status_index` (`subscription_id`,`dn_status`),
  KEY `mt_msisdn_index` (`msisdn`),
  KEY `mt_message_type_price_code_index` (`message_type`,`price_code`),
  KEY `mt_mt_ref_id_index` (`mt_ref_id`),
  KEY `mt_dn_status_index` (`dn_status`),
  CONSTRAINT `mt_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mt_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mt`
--

LOCK TABLES `mt` WRITE;
/*!40000 ALTER TABLE `mt` DISABLE KEYS */;
INSERT INTO `mt` VALUES (1,7,3,'+94787227554','FPMT','fail','success','test',NULL,'MT202512132030463522','Welcome to 2058 TEST service','2025-12-13 20:30:46','2025-12-14 03:53:31'),(2,7,4,'+94754793793','FPMT','fail','success','test',NULL,'MT202512140329184738','Welcome to 2058 TEST service','2025-12-14 03:29:18','2025-12-14 03:32:03'),(3,9,5,'+94755793793','FPMT','fail','success','test',NULL,'MT202512140352432298','Welcome to new subscription','2025-12-14 03:52:43','2025-12-14 03:52:58'),(4,9,6,'+94727557554','FPMT','fail','success','test',NULL,'MT202512140400173869','Welcome to new subscription','2025-12-14 04:00:17','2025-12-14 04:00:37'),(5,9,7,'+94755799799','FPMT','fail','success','success\n',NULL,'MT202512140405002992','Welcome to new subscription','2025-12-14 04:05:00','2025-12-14 04:05:14');
/*!40000 ALTER TABLE `mt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'service.view','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(2,'service.create','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(3,'service.update','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(4,'service.delete','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(5,'service_message.view','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(6,'service_message.create','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(7,'service_message.update','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(8,'service_message.delete','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(9,'renewal_plan.view','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(10,'renewal_plan.create','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(11,'renewal_plan.update','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(12,'renewal_plan.delete','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(13,'reports.view','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(14,'reports.create','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(15,'reports.update','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(16,'reports.delete','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(17,'admin.view','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(18,'admin.create','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(19,'admin.update','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(20,'admin.delete','web','2025-11-29 12:31:26','2025-11-29 12:31:26');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `renewal_jobs`
--

DROP TABLE IF EXISTS `renewal_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `renewal_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `renewal_plan_id` bigint unsigned NOT NULL,
  `subscription_id` bigint unsigned NOT NULL,
  `msisdn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('queued','processing','done','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued',
  `queued_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `renewal_jobs_service_id_status_index` (`service_id`,`status`),
  KEY `renewal_jobs_renewal_plan_id_status_index` (`renewal_plan_id`,`status`),
  KEY `renewal_jobs_subscription_id_status_index` (`subscription_id`,`status`),
  KEY `renewal_jobs_msisdn_index` (`msisdn`),
  CONSTRAINT `renewal_jobs_renewal_plan_id_foreign` FOREIGN KEY (`renewal_plan_id`) REFERENCES `renewal_plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `renewal_jobs_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `renewal_jobs_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `renewal_jobs`
--

LOCK TABLES `renewal_jobs` WRITE;
/*!40000 ALTER TABLE `renewal_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `renewal_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `renewal_plans`
--

DROP TABLE IF EXISTS `renewal_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `renewal_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_type` enum('daily','weekly','monthly') COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_rules` json NOT NULL,
  `skip_subscription_day` tinyint(1) NOT NULL DEFAULT '0',
  `is_fixed_time` tinyint(1) NOT NULL DEFAULT '0',
  `fixed_time` time DEFAULT NULL COMMENT 'Time in HH:mm format',
  `start_from` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `renewal_plans_service_id_plan_type_index` (`service_id`,`plan_type`),
  KEY `renewal_plans_name_index` (`name`),
  CONSTRAINT `renewal_plans_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `renewal_plans`
--

LOCK TABLES `renewal_plans` WRITE;
/*!40000 ALTER TABLE `renewal_plans` DISABLE KEYS */;
INSERT INTO `renewal_plans` VALUES (4,1,'test','200','weekly','{\"days\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\"], \"plan_type\": \"weekly\", \"fixed_time\": \"00:33\", \"is_fixed_time\": \"1\", \"skip_subscription_day\": false}',0,1,'00:33:00',NULL,'2025-12-13 13:31:48','2025-12-13 13:32:52'),(5,7,'TEST plan','200','daily','{\"plan_type\": \"daily\", \"fixed_time\": \"02:10\", \"is_fixed_time\": \"1\", \"skip_subscription_day\": false}',0,1,'02:10:00',NULL,'2025-12-13 14:59:51','2025-12-13 21:35:52'),(6,8,'test daily plan','500','daily','{\"plan_type\": \"daily\", \"fixed_time\": \"08:45\", \"is_fixed_time\": \"1\", \"skip_subscription_day\": false}',0,1,'08:45:00',NULL,'2025-12-13 21:35:41','2025-12-13 21:35:41'),(7,9,'NEW subscription Weekly plan','500','weekly','{\"days\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\"], \"plan_type\": \"weekly\", \"fixed_time\": \"09:25\", \"is_fixed_time\": \"1\", \"skip_subscription_day\": false}',0,1,'09:25:00',NULL,'2025-12-13 22:21:27','2025-12-13 22:21:55'),(8,9,'NEW subscription Daily plan','20','daily','{\"plan_type\": \"daily\", \"fixed_time\": \"09:38\", \"is_fixed_time\": \"1\", \"skip_subscription_day\": false}',0,1,'09:38:00',NULL,'2025-12-13 22:22:23','2025-12-13 22:36:13');
/*!40000 ALTER TABLE `renewal_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(1,3),(5,3),(6,3),(7,3),(9,3),(13,3),(1,4),(5,4),(9,4),(13,4),(1,5),(2,5),(3,5),(4,5),(5,5),(6,5),(7,5),(8,5),(9,5),(10,5),(11,5),(12,5),(13,5),(14,5),(15,5),(16,5),(17,5),(18,5),(19,5),(20,5);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(2,'manager','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(3,'marketing','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(4,'developer','web','2025-11-29 12:31:26','2025-11-29 12:31:26'),(5,'test_role','web','2025-12-13 12:15:35','2025-12-13 12:15:35');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_messages`
--

DROP TABLE IF EXISTS `service_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `message_type` enum('FPMT','RENEWAL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `message` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_messages_service_id_message_type_unique` (`service_id`,`message_type`),
  KEY `service_messages_status_message_type_index` (`status`,`message_type`),
  CONSTRAINT `service_messages_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_messages`
--

LOCK TABLES `service_messages` WRITE;
/*!40000 ALTER TABLE `service_messages` DISABLE KEYS */;
INSERT INTO `service_messages` VALUES (2,5,'FPMT','active','Welcome to mono service http://mono.com','100','2025-12-02 07:10:10','2025-12-02 07:10:10'),(5,5,'RENEWAL','active','test','150','2025-12-02 15:59:12','2025-12-02 15:59:12'),(6,2,'RENEWAL','active','First Premium Mobile Terminated','200','2025-12-08 20:11:13','2025-12-08 20:11:26'),(7,4,'FPMT','active','test renewal message entry - update',NULL,'2025-12-13 12:11:12','2025-12-13 12:34:33'),(8,1,'FPMT','active','test',NULL,'2025-12-13 13:30:04','2025-12-13 13:30:04'),(9,7,'FPMT','active','Welcome to 2058 TEST service',NULL,'2025-12-13 14:58:24','2025-12-13 14:58:24'),(10,9,'FPMT','active','Welcome to new subscription',NULL,'2025-12-13 14:59:00','2025-12-13 22:20:26'),(11,9,'RENEWAL','active','Renewal notice for NEW subscription',NULL,'2025-12-13 22:20:50','2025-12-13 22:20:50');
/*!40000 ALTER TABLE `service_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shortcode_id` bigint unsigned NOT NULL,
  `keyword` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `fpmt_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_shortcode_keyword_unique` (`shortcode_id`,`keyword`),
  KEY `services_status_index` (`status`),
  CONSTRAINT `services_shortcode_id_foreign` FOREIGN KEY (`shortcode_id`) REFERENCES `shortcodes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,1,'SUB','active',1,'2025-11-29 12:45:21','2025-11-29 12:45:21'),(2,1,'ABC','active',1,'2025-11-29 12:45:56','2025-11-29 12:45:56'),(3,1,'sports','active',0,'2025-12-02 06:21:43','2025-12-02 06:21:43'),(4,4,'game','active',1,'2025-12-02 07:00:49','2025-12-02 07:00:49'),(5,4,'mono update','active',0,'2025-12-02 07:02:37','2025-12-13 12:07:51'),(7,6,'TEST update','active',1,'2025-12-13 14:57:35','2025-12-13 21:33:42'),(8,6,'new test last update','active',1,'2025-12-13 21:34:07','2025-12-13 21:34:18'),(9,7,'NEW','active',1,'2025-12-13 22:19:47','2025-12-13 22:19:55');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('YYql3FnB4l4uG61GVhDoDICR3SCUxLlsc2EffspU',3,'127.0.0.1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWdhSDJuc1psbzk3SnRXV3N1UlVISGhBY1RIdWNaMzBXWHdLTnZwTCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM1OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvcmVuZXdhbC1wbGFucyI7czo1OiJyb3V0ZSI7czoxOToicmVuZXdhbC1wbGFucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==',1765685174);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shortcodes`
--

DROP TABLE IF EXISTS `shortcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shortcodes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shortcode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shortcodes_shortcode_unique` (`shortcode`),
  KEY `shortcodes_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shortcodes`
--

LOCK TABLES `shortcodes` WRITE;
/*!40000 ALTER TABLE `shortcodes` DISABLE KEYS */;
INSERT INTO `shortcodes` VALUES (1,'1234','Main subscription shortcode','active','2025-11-29 12:31:27','2025-11-29 12:31:27'),(2,'5678','Premium service shortcode','active','2025-11-29 12:31:27','2025-11-29 12:31:27'),(3,'9999','Test shortcode','active','2025-11-29 12:31:27','2025-11-29 12:31:27'),(4,'456','This is a test shortcode','active','2025-12-02 06:59:52','2025-12-02 14:47:34'),(5,'123','tested - update','inactive','2025-12-08 20:07:36','2025-12-13 12:06:40'),(6,'2058','New test shortcode update','active','2025-12-13 12:07:03','2025-12-13 21:33:20'),(7,'2020','test update','active','2025-12-13 22:19:14','2025-12-13 22:19:27');
/*!40000 ALTER TABLE `shortcodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint unsigned NOT NULL,
  `renewal_plan_id` bigint unsigned DEFAULT NULL,
  `status` enum('pending','active','suspended','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `subscribed_at` datetime NOT NULL,
  `last_renewal_at` datetime DEFAULT NULL,
  `next_renewal_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscriptions_msisdn_service_id_unique` (`msisdn`,`service_id`),
  KEY `subscriptions_service_id_status_index` (`service_id`,`status`),
  KEY `subscriptions_renewal_plan_id_next_renewal_at_index` (`renewal_plan_id`,`next_renewal_at`),
  KEY `subscriptions_msisdn_index` (`msisdn`),
  CONSTRAINT `subscriptions_renewal_plan_id_foreign` FOREIGN KEY (`renewal_plan_id`) REFERENCES `renewal_plans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `subscriptions_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,'+94725450951',4,NULL,'active','2025-12-03 04:04:42',NULL,'2025-12-04 04:04:42',NULL,NULL),(2,'+947254509511',1,NULL,'active','2025-12-13 18:47:05',NULL,'2025-12-16 18:47:05','2025-12-13 18:47:05','2025-12-13 18:47:05'),(3,'+94787227554',7,NULL,'active','2025-12-13 20:30:46',NULL,NULL,'2025-12-13 20:30:46','2025-12-13 20:30:46'),(4,'+94754793793',7,NULL,'active','2025-12-14 03:09:35',NULL,NULL,'2025-12-14 03:29:18','2025-12-14 03:29:18'),(5,'+94755793793',9,NULL,'active','2025-12-14 03:52:43',NULL,NULL,'2025-12-14 03:52:43','2025-12-14 03:52:43'),(6,'+94727557554',9,8,'active','2025-12-14 04:00:17',NULL,'2025-12-15 04:00:17','2025-12-14 04:00:17','2025-12-14 04:00:17'),(7,'+94755799799',9,8,'active','2025-12-14 04:05:01',NULL,'2025-12-15 04:05:01','2025-12-14 04:05:01','2025-12-14 04:05:01');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_username_index` (`username`),
  KEY `users_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','Administrator','admin@example.com',NULL,'$2y$12$O.jGUg9Gqv3pos4U8MyLvOjxirRcOWA2fYXSDKPViv/GJSsWAd7tu','active','f30Veu9V2wPiN3RNQGtXlEn95OboFGdHNyKDT4wpZs8Zn9FhgP4axCGpjMv5','2025-11-29 12:31:27','2025-11-29 12:31:27'),(2,'chanaka','chanaka','chanaka@gmail.com',NULL,'$2y$12$tDgR3P0LZdEkhP04XXdkPOcMysc.kmM5TDdDihjZPZbd.pM6tIrEu','active',NULL,'2025-12-02 06:55:35','2025-12-02 06:55:35'),(3,'pasan chathinthaka','pasan chathinthaka','pasan@gmail.com',NULL,'$2y$12$sqFb4CDG6EZ3bum/vKERQe9zZo9dzzD0kUYK1Gdrgg.nhf4CgM05y','active',NULL,'2025-12-02 14:40:00','2025-12-13 12:14:44'),(4,'Test User update','Test User','testuser@gmail.com',NULL,'$2y$12$FldRcl7PFMsy1lYlK72tKu.WVUItwCtDJmucLdEhF7YSdMp6zB8gy','active',NULL,'2025-12-13 12:16:14','2025-12-13 21:36:15'),(5,'Last test user','test user last','test@gmail.com',NULL,'$2y$12$Df48rBKfNkA9f4kORpxOXOW.MfGXXhFfUGf0daKZKZPWh0EdOry4G','active',NULL,'2025-12-13 21:37:05','2025-12-13 21:37:26');
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

-- Dump completed on 2025-12-14  9:39:25
