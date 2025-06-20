-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: spd_hub
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary table structure for view `active_events`
--

DROP TABLE IF EXISTS `active_events`;
/*!50001 DROP VIEW IF EXISTS `active_events`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `active_events` AS SELECT
 1 AS `event_id`,
  1 AS `event_name`,
  1 AS `event_date`,
  1 AS `event_time`,
  1 AS `event_location`,
  1 AS `location`,
  1 AS `event_duration`,
  1 AS `sampling_count`,
  1 AS `contact_person`,
  1 AS `contact_phone`,
  1 AS `requested_by`,
  1 AS `approved_by`,
  1 AS `status`,
  1 AS `uploaded_letter`,
  1 AS `created_at`,
  1 AS `updated_at`,
  1 AS `requested_by_name`,
  1 AS `propagandist_id`,
  1 AS `propagandist_name` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`log_id`),
  KEY `idx_activity_date` (`created_at`),
  KEY `idx_user_activity` (`user_id`,`activity_type`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_approvals`
--

DROP TABLE IF EXISTS `event_approvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_approvals` (
  `approval_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approval_status` enum('approved','rejected') NOT NULL,
  `approval_note` text DEFAULT NULL,
  `approval_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`approval_id`),
  KEY `approved_by` (`approved_by`),
  KEY `idx_event_approval` (`event_id`,`approval_status`),
  CONSTRAINT `event_approvals_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  CONSTRAINT `event_approvals_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_assignments`
--

DROP TABLE IF EXISTS `event_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_assignments` (
  `assignment_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `propagandist_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('assigned','in_progress','completed','cancelled') DEFAULT 'assigned',
  PRIMARY KEY (`assignment_id`),
  UNIQUE KEY `unique_event_assignment` (`event_id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `assigned_by` (`assigned_by`),
  KEY `idx_propagandist` (`propagandist_id`),
  KEY `idx_assignment_status` (`status`),
  CONSTRAINT `event_assignments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  CONSTRAINT `event_assignments_ibfk_2` FOREIGN KEY (`propagandist_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `event_assignments_ibfk_3` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`),
  CONSTRAINT `event_assignments_ibfk_4` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_duration` varchar(50) DEFAULT NULL,
  `sampling_count` int(11) DEFAULT 0,
  `contact_person` varchar(150) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `requested_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `uploaded_letter` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`event_id`),
  KEY `requested_by` (`requested_by`),
  KEY `approved_by` (`approved_by`),
  KEY `idx_status` (`status`),
  KEY `idx_event_date` (`event_date`),
  KEY `idx_event_date_status` (`event_date`,`status`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`requested_by`) REFERENCES `users` (`user_id`),
  CONSTRAINT `events_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gift_shuffle_winners`
--

DROP TABLE IF EXISTS `gift_shuffle_winners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_shuffle_winners` (
  `winner_id` int(11) NOT NULL AUTO_INCREMENT,
  `shuffle_id` int(11) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `winner_name` varchar(150) DEFAULT NULL,
  `winner_nic` varchar(20) DEFAULT NULL,
  `winner_phone` varchar(20) DEFAULT NULL,
  `won_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`winner_id`),
  KEY `shuffle_id` (`shuffle_id`),
  KEY `gift_id` (`gift_id`),
  KEY `idx_winner_nic` (`winner_nic`),
  KEY `idx_winner_phone` (`winner_phone`),
  KEY `idx_won_date` (`won_at`),
  CONSTRAINT `gift_shuffle_winners_ibfk_1` FOREIGN KEY (`shuffle_id`) REFERENCES `premium_shuffles` (`shuffle_id`),
  CONSTRAINT `gift_shuffle_winners_ibfk_2` FOREIGN KEY (`gift_id`) REFERENCES `gifts` (`gift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gifts`
--

DROP TABLE IF EXISTS `gifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gifts` (
  `gift_id` int(11) NOT NULL AUTO_INCREMENT,
  `gift_name` varchar(200) NOT NULL,
  `gift_description` text DEFAULT NULL,
  `gift_value` decimal(10,2) DEFAULT NULL,
  `stock_required` int(11) DEFAULT 1,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`gift_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `premium_breakdown_gifts`
--

DROP TABLE IF EXISTS `premium_breakdown_gifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `premium_breakdown_gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `breakdown_id` int(11) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_breakdown_gift` (`breakdown_id`,`gift_id`),
  KEY `gift_id` (`gift_id`),
  CONSTRAINT `premium_breakdown_gifts_ibfk_1` FOREIGN KEY (`breakdown_id`) REFERENCES `premium_breakdowns` (`breakdown_id`),
  CONSTRAINT `premium_breakdown_gifts_ibfk_2` FOREIGN KEY (`gift_id`) REFERENCES `gifts` (`gift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `premium_breakdowns`
--

DROP TABLE IF EXISTS `premium_breakdowns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `premium_breakdowns` (
  `breakdown_id` int(11) NOT NULL AUTO_INCREMENT,
  `breakdown_name` varchar(100) NOT NULL,
  `flap_count` int(11) NOT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`breakdown_id`),
  KEY `idx_flap_count` (`flap_count`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `premium_shuffles`
--

DROP TABLE IF EXISTS `premium_shuffles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `premium_shuffles` (
  `shuffle_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `breakdown_id` int(11) NOT NULL,
  `flaps_count` int(11) NOT NULL,
  `started_by` int(11) NOT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ended_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','completed') DEFAULT 'active',
  PRIMARY KEY (`shuffle_id`),
  KEY `breakdown_id` (`breakdown_id`),
  KEY `started_by` (`started_by`),
  KEY `idx_shuffle_status` (`status`),
  KEY `idx_shuffle_event` (`event_id`),
  CONSTRAINT `premium_shuffles_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  CONSTRAINT `premium_shuffles_ibfk_2` FOREIGN KEY (`breakdown_id`) REFERENCES `premium_breakdowns` (`breakdown_id`),
  CONSTRAINT `premium_shuffles_ibfk_3` FOREIGN KEY (`started_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_code` (`product_code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sampling_requests`
--

DROP TABLE IF EXISTS `sampling_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sampling_requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `uploaded_file` varchar(500) NOT NULL,
  `extracted_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extracted_data`)),
  `processed_by_ai` tinyint(1) DEFAULT 0,
  `event_id` int(11) DEFAULT NULL,
  `uploaded_by` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`request_id`),
  KEY `event_id` (`event_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `sampling_requests_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  CONSTRAINT `sampling_requests_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stock_locations`
--

DROP TABLE IF EXISTS `stock_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(100) NOT NULL,
  `location_type` enum('warehouse','vehicle','temporary') NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`location_id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `idx_location_type` (`location_type`),
  CONSTRAINT `stock_locations_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stock_movements`
--

DROP TABLE IF EXISTS `stock_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_movements` (
  `movement_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `from_location_id` int(11) DEFAULT NULL,
  `to_location_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `movement_type` enum('transfer','sampling','gift','damage','return','adjustment') NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `moved_by` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `movement_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`movement_id`),
  KEY `product_id` (`product_id`),
  KEY `from_location_id` (`from_location_id`),
  KEY `to_location_id` (`to_location_id`),
  KEY `moved_by` (`moved_by`),
  KEY `idx_movement_date` (`movement_date`),
  KEY `idx_movement_type` (`movement_type`),
  KEY `idx_movement_event` (`event_id`),
  CONSTRAINT `stock_movements_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `stock_movements_ibfk_2` FOREIGN KEY (`from_location_id`) REFERENCES `stock_locations` (`location_id`),
  CONSTRAINT `stock_movements_ibfk_3` FOREIGN KEY (`to_location_id`) REFERENCES `stock_locations` (`location_id`),
  CONSTRAINT `stock_movements_ibfk_4` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  CONSTRAINT `stock_movements_ibfk_5` FOREIGN KEY (`moved_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `stock_summary`
--

DROP TABLE IF EXISTS `stock_summary`;
/*!50001 DROP VIEW IF EXISTS `stock_summary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stock_summary` AS SELECT
 1 AS `product_name`,
  1 AS `product_code`,
  1 AS `location_name`,
  1 AS `quantity` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`stock_id`),
  UNIQUE KEY `unique_product_location` (`product_id`,`location_id`),
  KEY `location_id` (`location_id`),
  KEY `idx_stock_quantity` (`quantity`),
  KEY `idx_stock_product_location` (`product_id`,`location_id`),
  CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `stocks_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `stock_locations` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','hod','admin_manager','brand_manager','propagandist') NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_name` varchar(100) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `brand_assigned` varchar(100) DEFAULT NULL,
  `in_charge_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive','maintenance') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`vehicle_id`),
  UNIQUE KEY `vehicle_number` (`vehicle_number`),
  KEY `in_charge_id` (`in_charge_id`),
  KEY `idx_vehicle_status` (`status`),
  CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`in_charge_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `active_events`
--

/*!50001 DROP VIEW IF EXISTS `active_events`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `active_events` AS select `e`.`event_id` AS `event_id`,`e`.`event_name` AS `event_name`,`e`.`event_date` AS `event_date`,`e`.`event_time` AS `event_time`,`e`.`event_location` AS `event_location`,`e`.`location` AS `location`,`e`.`event_duration` AS `event_duration`,`e`.`sampling_count` AS `sampling_count`,`e`.`contact_person` AS `contact_person`,`e`.`contact_phone` AS `contact_phone`,`e`.`requested_by` AS `requested_by`,`e`.`approved_by` AS `approved_by`,`e`.`status` AS `status`,`e`.`uploaded_letter` AS `uploaded_letter`,`e`.`created_at` AS `created_at`,`e`.`updated_at` AS `updated_at`,`u`.`name` AS `requested_by_name`,`a`.`propagandist_id` AS `propagandist_id`,`p`.`name` AS `propagandist_name` from (((`events` `e` left join `users` `u` on(`e`.`requested_by` = `u`.`user_id`)) left join `event_assignments` `a` on(`e`.`event_id` = `a`.`event_id`)) left join `users` `p` on(`a`.`propagandist_id` = `p`.`user_id`)) where `e`.`status` = 'approved' and `e`.`event_date` >= curdate() */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stock_summary`
--

/*!50001 DROP VIEW IF EXISTS `stock_summary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stock_summary` AS select `p`.`product_name` AS `product_name`,`p`.`product_code` AS `product_code`,`l`.`location_name` AS `location_name`,`s`.`quantity` AS `quantity` from ((`stocks` `s` join `products` `p` on(`s`.`product_id` = `p`.`product_id`)) join `stock_locations` `l` on(`s`.`location_id` = `l`.`location_id`)) where `s`.`quantity` > 0 order by `p`.`product_name`,`l`.`location_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-21  4:54:56
