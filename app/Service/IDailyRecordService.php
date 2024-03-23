<?php

namespace App\Service;

use App\Repository\DailyRecordRepository;
use Illuminate\Database\Eloquent\Collection;

class IDailyRecordService implements DailyRecordService
{
    protected DailyRecordRepository $dailyRecordRepository;

    public function __construct(DailyRecordRepository $dailyRecordRepository)
    {
        $this->dailyRecordRepository = $dailyRecordRepository;
    }

    /**
     * Retrieve daily records.
     * 
     * @return Collection
     */
    public function getDailyRecords(): Collection
    {
        return $this->dailyRecordRepository->get();
    }
}