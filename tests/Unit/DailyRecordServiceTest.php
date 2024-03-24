<?php

namespace Tests\Unit;

use App\Repository\DailyRecordRepository;
use App\Service\IDailyRecordService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class DailyRecordServiceTest extends TestCase
{
    public function test_get_daily_records()
    {
        $dailyRecordRepository = Mockery::mock(DailyRecordRepository::class);
        $expectedRecords = new Collection([
            'id' => 1,
            'date' => '2024-03-23',
            'male_count' => 9,
            'female_count' => 11,
            'male_avg_age' => 48.33,
            'female_avg_age' => 51.36,
        ]);
        $dailyRecordRepository->shouldReceive('get')->once()->andReturn($expectedRecords);
        $IDailyRecordService = new IDailyRecordService($dailyRecordRepository);
        $result = $IDailyRecordService->getDailyRecords();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($expectedRecords, $result);
    }
}
