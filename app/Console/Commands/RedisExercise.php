<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisExercise extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:redis-exercise';

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
        // Redis::set('user:1:first_name', 'Mike');
        // Redis::set('user:2:first_name', 'John');
        // Redis::set('user:3:first_name', 'Kate');

        // Redis::set('male:count', 100);
        // Redis::set('female:count', 200);

        // $maleCountFromRedis = Redis::get('male:count') ?? 0;
        // $femaleCountFromRedis = Redis::get('female:count');

        // dd($maleCountFromRedis);

        $maleCount = 100;
        $femaleCount = 200;
         // Increment male count in Redis
         Redis::hincrby('male:count', 'male', $maleCount);
         // Increment female count in Redis
         Redis::hincrby('female:count', 'female', $femaleCount);
    }
}
