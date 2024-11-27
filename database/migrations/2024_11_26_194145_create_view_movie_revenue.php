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
        DB::statement("
            CREATE VIEW view_movie_revenue AS
                SELECT
                    `m`.`id` AS `movie_id`,
                    `m`.`title` AS `movie_title`,
                    `m`.`genre` AS `movie_genre`,
                    `m`.`director` AS `movie_director`,
                    `m`.`poster_url` AS `movie_poster`,
                    `m`.`release_date` AS `movie_release_date`,
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
                GROUP BY `t`.`id`, `m`.`id`, DATE(`sale`.`sale_date`);
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW view_movie_revenue");
    }
};
