<?php

namespace App\Repository;

use App\Models\DailyRecord;
use Illuminate\Database\Eloquent\Collection;

class IDailyRecordRepository implements DailyRecordRepository
{
    /**
     * Retrieve daily reports.
     * 
     * @return Collection
     */
    public function get(): Collection
    {
        return DailyRecord::select([
            'date',
            'male_count',
            'female_count',
            'male_avg_age',
            'female_avg_age'
        ])->get();
    }
}