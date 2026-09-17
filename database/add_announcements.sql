-- =========================================================
-- MISFITS RIDERS — Admin Announcements / Club Bulletin
-- Import this file once in phpMyAdmin.
-- =========================================================

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(180) NOT NULL,
  `message` TEXT NOT NULL,
  `type` ENUM('announcement','reminder','attention','suggestion') NOT NULL DEFAULT 'announcement',
  `priority` ENUM('normal','important','urgent') NOT NULL DEFAULT 'normal',
  `status` ENUM('published','draft') NOT NULL DEFAULT 'published',
  `show_until` DATE DEFAULT NULL,
  `created_by` INT UNSIGNED DEFAULT NULL COMMENT 'admins.id',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_announcement_status` (`status`),
  KEY `idx_announcement_show_until` (`show_until`),
  KEY `idx_announcement_created_by` (`created_by`),
  CONSTRAINT `fk_announcement_admin` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
