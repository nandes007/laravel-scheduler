<?php

namespace App\Jobs;

use App\Models\DailyRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class TabulateGenderRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
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
            'date' => Carbon::now()->format('Y-m-d'),
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            'male_avg_age' => $maleAverageAge,
            'female_avg_age' => $femaleAverageAge,
        ]);

        // Clear the gender counts in Redis for the next day
        Redis::del('hourly_record');
    }
}
