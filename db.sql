CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `last_name` VARCHAR(100) NOT NULL,
  `first_name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `address` TEXT NOT NULL,
  `comment` TEXT DEFAULT NULL,
  `items_json` JSON NOT NULL,
  `total` INT UNSIGNED NOT NULL,
  `status` ENUM('new','processing','done','cancelled') DEFAULT 'new',
  `ip` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status_idx` (`status`),
  KEY `created_idx` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `leads` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone` VARCHAR(30) NOT NULL,
  `source` VARCHAR(50) DEFAULT 'landing',
  `ip` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_idx` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;