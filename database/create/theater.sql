CREATE TABLE `theater` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(105) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(170) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip5` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);