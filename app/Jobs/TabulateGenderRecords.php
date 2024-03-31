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
        $pattern = '*';
        $cursor = null;
        do {
            [$cursor, $keys] = Redis::scan($cursor, 'MATCH', $pattern);
            sort($keys);
            foreach ($keys as $key) {
                $explodedKey = explode('_', $key);
                $dateKey = end($explodedKey);
                try {
                    $dateKeyFormatted = Carbon::createFromFormat('Y-m-d', $dateKey)->format('Y-m-d');
                    $maleCount = (int) Redis::hget($dateKey, 'male:count');
                    $femaleCount = (int) Redis::hget($dateKey, 'female:count');

                    $maleAverageAge = User::where('gender', 'male')
                                ->whereDate('created_at', $dateKeyFormatted)
                                ->avg('age');

                    $femaleAverageAge = User::where('gender', 'female')
                                    ->whereDate('created_at', $dateKeyFormatted)
                                    ->avg('age');

                    DailyRecord::create([
                        'date' => $dateKeyFormatted,
                        'male_count' => $maleCount,
                        'female_count' => $femaleCount,
                        'male_avg_age' => $maleAverageAge,
                        'female_avg_age' => $femaleAverageAge,
                    ]);

                    Redis::del($dateKey);
                }catch(\Exception $e) {
                    continue;
                }
            }
        } while ($cursor !== '0');
    }
}
