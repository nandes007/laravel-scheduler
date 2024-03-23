<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Collection;

interface DailyRecordService
{
    /**
     * Retrieve daily records.
     * 
     * @return Collection
     */
    public function getDailyRecords(): Collection;
}