<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SyncRandomUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:random_user';

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
        $client = new Client();
        $response = $client->request('GET', 'https://randomuser.me/api/?results=20');
        $decodedResponse = json_decode($response->getBody(), true);
        $results = $decodedResponse["results"];
        dd(count($results));
        
        foreach ($results as $result) {
            dd($result);
        }
    }
}
