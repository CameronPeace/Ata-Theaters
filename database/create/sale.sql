CREATE TABLE `sale` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `amount` double(4,2) NOT NULL,
  `sale_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `screening_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_screening_id_foreign` (`screening_id`),
  CONSTRAINT `sale_screening_id_foreign` FOREIGN KEY (`screening_id`) REFERENCES `screening` (`id`)
);