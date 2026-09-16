-- =========================================================
--  MISFITS RIDERS — Database Structure
--  Import this file from phpMyAdmin on InfinityFree
--  (Control Panel > MySQL Databases > phpMyAdmin)
-- =========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- ---------------------------------------------------------
-- Table: admins  (the people who can log in to /admin)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `role` ENUM('super_admin','admin') NOT NULL DEFAULT 'admin',
  `status` ENUM('active','disabled') NOT NULL DEFAULT 'active',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default login: username = admin / password = Misfits2026!
-- (hash below is a real bcrypt hash of 'Misfits2026!' — CHANGE THIS PASSWORD after first login)
INSERT INTO `admins` (`username`,`password`,`full_name`,`email`,`role`,`status`,`created_at`) VALUES
('admin', '$2b$10$pTCNLo6TI2rjFRJAufsF9OkyZGPrTYb0jAv4Yg3soYpwFuhPYC5Oq', 'Club Administrator', 'admin@misfitsriders.local', 'super_admin', 'active', NOW());

-- ---------------------------------------------------------
-- Table: site_settings  (single-row config: vision/mission/logo/socials)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` TINYINT UNSIGNED NOT NULL,
  `club_name` VARCHAR(150) NOT NULL DEFAULT 'MISFITS RIDERS',
  `tagline` VARCHAR(255) DEFAULT NULL,
  `about_text` TEXT,
  `vision_text` TEXT,
  `mission_text` TEXT,
  `logo_image` VARCHAR(255) DEFAULT NULL,
  `hero_image` VARCHAR(255) DEFAULT NULL,
  `facebook_url` VARCHAR(255) DEFAULT NULL,
  `instagram_url` VARCHAR(255) DEFAULT NULL,
  `contact_email` VARCHAR(150) DEFAULT NULL,
  `contact_phone` VARCHAR(50) DEFAULT NULL,
  `founded_year` YEAR DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings`
(`id`,`club_name`,`tagline`,`about_text`,`vision_text`,`mission_text`,`logo_image`,`hero_image`,`facebook_url`,`instagram_url`,`contact_email`,`contact_phone`,`founded_year`,`updated_at`)
VALUES
(1, 'MISFITS RIDERS', 'Not everyone fits in a straight line.',
'MISFITS RIDERS is a motorcycle riding group built on brotherhood, the open road, and the belief that not every rider needs to follow the pack. We roll together, we look out for each other, and we ride for the love of it — no matter the make, model, or mile count.',
'To be the most welcoming, tight-knit riding community in the region — a group where every rider, regardless of background or bike, has a place in formation.',
'We organize safe, well-planned group rides and community events, support fellow riders on and off the road, and grow a culture of respect, safety, and freedom on two wheels.',
NULL, NULL, 'https://facebook.com', 'https://instagram.com', 'ride@misfitsriders.local', '+63 900 000 0000', 2019, NOW());

-- ---------------------------------------------------------
-- Table: members  (team roster)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(120) NOT NULL,
  `road_name` VARCHAR(80) DEFAULT NULL COMMENT 'nickname / callsign used on rides',
  `position` VARCHAR(80) NOT NULL DEFAULT 'Member' COMMENT 'e.g. President, Road Captain, Member',
  `bike_model` VARCHAR(120) DEFAULT NULL,
  `bio` TEXT,
  `image` VARCHAR(255) DEFAULT NULL,
  `instagram_handle` VARCHAR(100) DEFAULT NULL,
  `joined_date` DATE DEFAULT NULL,
  `display_order` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `members` (`full_name`,`road_name`,`position`,`bike_model`,`bio`,`image`,`joined_date`,`display_order`,`status`,`created_at`) VALUES
('Marco Villanueva', 'Ghost', 'President', 'Kawasaki Versys 650', 'Founder of MISFITS RIDERS. Been riding for over 15 years and started the club to bring stray riders together.', NULL, '2019-03-01', 1, 'active', NOW()),
('Diego Ramos', 'Torque', 'Road Captain', 'Honda CB500X', 'Plans every route, checks every road condition. If Torque says turn left, you turn left.', NULL, '2019-05-14', 2, 'active', NOW()),
('Elena Cruz', 'Vixen', 'Secretary', 'Yamaha MT-07', 'Keeps the club organized — events, records, and everyone in the loop.', NULL, '2020-01-20', 3, 'active', NOW());

-- ---------------------------------------------------------
-- Table: rides  (upcoming group rides + past/latest ride recaps)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `rides` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(180) NOT NULL,
  `slug` VARCHAR(200) DEFAULT NULL,
  `ride_type` ENUM('upcoming','past') NOT NULL DEFAULT 'upcoming',
  `description` TEXT,
  `meeting_point` VARCHAR(255) DEFAULT NULL,
  `ride_date` DATE NOT NULL,
  `ride_time` TIME DEFAULT NULL,
  `cover_image` VARCHAR(255) DEFAULT NULL,
  `route_id` INT UNSIGNED DEFAULT NULL,
  `created_by` INT UNSIGNED DEFAULT NULL COMMENT 'admins.id',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ride_type_date` (`ride_type`,`ride_date`),
  KEY `fk_ride_route` (`route_id`),
  KEY `fk_ride_admin` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Table: routes  (a planned route, optionally linked to a ride)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `routes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ride_id` INT UNSIGNED DEFAULT NULL COMMENT 'nullable: a route can be created before it is attached to a ride',
  `route_name` VARCHAR(180) NOT NULL,
  `start_point` VARCHAR(200) NOT NULL,
  `end_point` VARCHAR(200) NOT NULL,
  `waypoints` TEXT COMMENT 'free text, one stop per line',
  `distance_km` DECIMAL(6,2) DEFAULT NULL,
  `estimated_duration` VARCHAR(50) DEFAULT NULL COMMENT 'e.g. 3h 30m',
  `difficulty` ENUM('easy','moderate','hard') NOT NULL DEFAULT 'moderate',
  `map_embed_url` VARCHAR(500) DEFAULT NULL COMMENT 'Google Maps embed / share link',
  `route_image` VARCHAR(255) DEFAULT NULL,
  `notes` TEXT,
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_route_ride` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `rides`
  ADD CONSTRAINT `fk_ride_route` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `routes`
  ADD CONSTRAINT `fk_route_ride` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Seed: one upcoming ride with a route, one past ride recap
INSERT INTO `rides` (`title`,`ride_type`,`description`,`meeting_point`,`ride_date`,`ride_time`,`cover_image`,`created_at`) VALUES
('Sunrise Coastal Run', 'upcoming', 'A relaxed early-morning coastal cruise ending with breakfast by the bay. All bike types welcome, kickstands up at 5:30 AM sharp.', 'Misfits HQ, Main Garage', DATE_ADD(CURDATE(), INTERVAL 14 DAY), '05:30:00', NULL, NOW()),
('Mountain Pass Breakfast Run', 'past', 'Twenty riders braved the morning fog for a twisty climb up the pass, capped off with a well-earned breakfast stop. Great turnout and zero incidents.', 'Misfits HQ, Main Garage', DATE_SUB(CURDATE(), INTERVAL 20 DAY), '06:00:00', NULL, NOW());

INSERT INTO `routes` (`ride_id`,`route_name`,`start_point`,`end_point`,`waypoints`,`distance_km`,`estimated_duration`,`difficulty`,`map_embed_url`,`created_by`,`created_at`) VALUES
(1, 'Coastal Sunrise Loop', 'Misfits HQ, Main Garage', 'Bayfront Diner', 'Fuel stop at Route 9 Gas Station\nPhoto stop at Cliffside View Point', 68.50, '2h 15m', 'easy', NULL, 1, NOW());

UPDATE `rides` SET `route_id` = 1 WHERE `id` = 1;

-- ---------------------------------------------------------
-- Table: gallery  (approved photos shown publicly)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255) DEFAULT NULL,
  `ride_id` INT UNSIGNED DEFAULT NULL COMMENT 'optional: tag the photo to a ride',
  `submitted_by_name` VARCHAR(120) DEFAULT NULL COMMENT 'filled in if this came from an approved member request',
  `source` ENUM('admin_upload','member_request') NOT NULL DEFAULT 'admin_upload',
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_ride` (`ride_id`),
  CONSTRAINT `fk_gallery_ride` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Table: image_requests  (visitor-submitted photos awaiting approval)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `image_requests` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `submitter_name` VARCHAR(120) NOT NULL,
  `submitter_email` VARCHAR(150) DEFAULT NULL,
  `caption` VARCHAR(255) DEFAULT NULL,
  `image` VARCHAR(255) NOT NULL,
  `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` VARCHAR(255) DEFAULT NULL,
  `reviewed_by` INT UNSIGNED DEFAULT NULL COMMENT 'admins.id',
  `reviewed_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed: one pending example so the admin request queue isn't empty on first login
INSERT INTO `image_requests` (`submitter_name`,`submitter_email`,`caption`,`image`,`status`,`created_at`) VALUES
('Jhun Dela Cruz', 'jhun@example.com', 'Group shot at the mountain pass view deck', 'sample-request.jpg', 'pending', NOW());
