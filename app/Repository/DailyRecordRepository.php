<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

interface DailyRecordRepository
{
    /**
     * Retrieve daily reports.
     * 
     * @return Collection
     */
    public function get(): Collection;
}