CREATE TABLE `screening` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` bigint unsigned NOT NULL,
  `theater_id` bigint unsigned NOT NULL,
  `is_showing` tinyint NOT NULL DEFAULT '1',
  `screen_end` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `screening_movie_id_foreign` (`movie_id`),
  KEY `screening_theater_id_foreign` (`theater_id`),
  CONSTRAINT `screening_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`),
  CONSTRAINT `screening_theater_id_foreign` FOREIGN KEY (`theater_id`) REFERENCES `theater` (`id`)
);