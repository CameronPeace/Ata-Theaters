<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(' 
            CREATE PROCEDURE theater_revenue(
            date_to DATETIME, 
            date_from DATETIME
            ) 
            BEGIN
            SELECT
            `t`.`id` AS `theater_id`,
            `t`.`location_name` AS `theater_name`,
            `t`.`city` AS `theater_city`,
            `t`.`state` AS `theater_state`,
            `t`.`street` AS `theater_street`,
            `t`.`zip5` AS `theater_zip5`,
   	        SUM(`sale`.`amount`) AS `total_theater_sales`,
            DATE(`sale`.`sale_date`) AS `total_date_sales_utc`
	        FROM `sale`
	        JOIN `screening` `s` ON `sale`.`screening_id` = `s`.`id`
	        JOIN `movie` `m` ON `s`.`movie_id` = `m`.`id`
	        JOIN `theater` `t` ON `s`.`theater_id` = `t`.`id` 
	        WHERE 
		        `sale`.`sale_date` BETWEEN date_to AND date_from
	        GROUP BY `t`.`id`, DATE(sale.`sale_date`) 
	        ORDER BY `total_theater_sales` DESC;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP PROCEDURE IF EXISTS theater_revenue;");
    }
};