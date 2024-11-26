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
  	            m.id AS 'movie_id',
  	            m.title AS 'movie_title',
  	            m.genre AS 'movie_genre',
  	            m.director AS 'movie_director',
  	            m.poster_url AS 'movie_poster',
  	            m.release_date AS 'movie_release_date',
  	            t.id AS 'theater_id',
  	            t.location_name AS 'theater_name',
  	            t.city AS 'theater_city',
  	            t.state AS 'teather_state',
  	            t.street AS 'teather_street',
  	            t.zip5 AS 'teather_zip5',
  	            sale.amount AS 'total_teather_sales',
  	            DATE(sale.created) AS 'total_date_sales_utc'
                FROM sale
                JOIN screening s ON sale.screening_id = s.id
                JOIN movie m ON s.movie_id = m.id
                JOIN theater t ON s.theater_id = t.id
                GROUP BY DATE(sale.created), m.id, t.id, sale.amount;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_movie_revenue');
    }
};
