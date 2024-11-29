Delimiter //
CREATE PROCEDURE theater_revenue(
    date_from DATETIME,
    date_to DATETIME, 
    query_limit INT
    ) 
    BEGIN
SELECT
    `t`.`id` AS `theater_id`,
    `t`.`location_name` AS `theater_name`,
    `t`.`city` AS `theater_city`,
    `t`.`state` AS `theater_state`,
    `t`.`street` AS `theater_street`,
    `t`.`zip5` AS `theater_zip5`,
   	SUM(`sale`.`amount`) AS `total_theater_sales`
FROM `sale`
	JOIN `screening` `s` ON `sale`.`screening_id` = `s`.`id`
	JOIN `movie` `m` ON `s`.`movie_id` = `m`.`id`
	JOIN `theater` `t` ON `s`.`theater_id` = `t`.`id` 
WHERE 
	`sale`.`sale_date` BETWEEN date_from AND date_to
GROUP BY `t`.`id`
ORDER BY `total_theater_sales` DESC
LIMIT query_limit;
END;//