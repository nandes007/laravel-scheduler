<?php

namespace App\Console\Commands;

use App\Models\DailyRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TabulateDailyRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tabulate-daily-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');

        // Retrieve gender counts from Redis
        $maleCount = (int) Redis::hget('hourly_record', 'male:count');
        $femaleCount = (int) Redis::hget('hourly_record', 'female:count');

        // Retrieve average ages from the database
        $maleAverageAge = User::where('gender', 'male')
                    ->whereDate('created_at', $now)
                    ->avg('age');

        $femaleAverageAge = User::where('gender', 'female')
                        ->whereDate('created_at', $now)
                        ->avg('age');

        // Store the daily records in the database
        DailyRecord::create([
            'date' => Carbon::today(),
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            'male_avg_age' => $maleAverageAge,
            'female_avg_age' => $femaleAverageAge,
        ]);

        // Clear the gender counts in Redis for the next day
        Redis::del('hourly_record');
    }
}
