<?php

namespace App\Models\Repositories;

use App\Models\Theater;
use App\Services\OpenAiService;

class TheaterRepository
{
    protected $table;

	public function __construct()
	{
		$this->table = new Theater;
	}

    public function createTheaters(int $total) 
    {
        $openAi = new OpenAiService();
        $records = $openAi->requestTheaterData($total);
        $recordsArray = json_decode($records,true);

        foreach($recordsArray As $record) {
            $this->table->insert($record);
        }
    }

}
