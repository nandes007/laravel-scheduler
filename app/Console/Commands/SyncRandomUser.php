<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Psr\Http\Message\StreamInterface;

class SyncRandomUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-random-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Request method.
     */
    protected const REQUEST_METHOD = 'GET';
    
    /**
     * Provider url.
     */
    protected const URL = 'https://randomuser.me/api/';
    
    /**
     * Request query params.
     */
    protected const QUERY_PARAMS = '?results=20';

    /**
     * Failed parse error message.
     */
    protected const PARSE_ERROR = 'ERROR! Failed to parse response (%s)';

    /**
     * Success create new user message.
     */
    protected const SUCCESS_MESSAGE = 'INFO! Successfully created new user with uuid (%s) on row (%s) of (%s)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $response = $client->request($this::REQUEST_METHOD, $this::URL.$this::QUERY_PARAMS);

        try {
            $decodedResponse = $this->parseBodyResponse($response->getBody());
        } catch (\Throwable $th) {
            $this->error(sprintf($this::PARSE_ERROR, $th->getMessage()));
        }

        $results = $decodedResponse['results'];
        $totalRow = count($results);
        $totalRowCreated = 0;
        foreach ($results as $index => $result) {
            $userUuid = $result['login']['uuid'] ?? NULL;
            if (empty($userUuid)) {
                $this->error('Skipped user without uuid on index : ' . $index);
                continue;
            }

            try {
                $user = User::where('uuid', $userUuid)->first();
                if (empty($user)) {
                    $user = new User();
                }

                $user->uuid = $userUuid;
                $user->gender = $result['gender'] ?? NULL;
                $user->name = $this->transformName($result['name'] ?? []);
                $user->location = $this->transformLocation($result['location']);
                $user->age = $result['dob']['age'] ?? NULL;
                $user->save();
                
                $this->info(sprintf($this::SUCCESS_MESSAGE, $user->uuid, ++$index, $totalRow));
                $totalRowCreated++;
            } catch (\Throwable $th) {
                $this->error('Failed to created user : ', $th->getMessage());
                return;
            }
        }

        $this->syncTotalGenderToRedis();
        $this->info("Total user successfully to created $totalRowCreated of $totalRow");
    }

    /**
     * Parse response body json to associative array.
     * 
     * @param StreamInterface $responseBody
     * @return array
     */
    private function parseBodyResponse(StreamInterface $responseBody): array
    {
        return json_decode($responseBody, true);
    }

    /**
     * Transform the given name array.
     * 
     * @param array $name
     * @return array 
     */
    protected function transformName(array $name): array
    {
        return [
            'title' => $name["title"] ?? '',
            'first' => $name["first"] ?? '',
            'last' =>  $name["last"] ?? ''
        ];
    }

    /**
     * Transform the given location array.
     * 
     * @param array $location
     * @return array 
     */
    protected function transformLocation(array $location): array
    {
        return [
            'street' => [
                'number' => $location["street"]["number"] ?? '',
                'name' => $location["street"]["name"] ?? ''
            ],
            'city' => $location["city"] ?? '',
            'state' => $location["state"] ?? '',
            'country' => $location["country"] ?? '',
            'postcode' => $location["postcode"] ?? '',
            'coordinates' => [
                'latitude' => $location["coordinates"]["latitude"] ?? '',
                'longitude' => $location["coordinates"]["longitude"] ?? ''
            ],
            'timezone' => [
                'offset' => $location["timezone"]["offset"] ?? '',
                'description' => $location["timezone"]["description"] ?? ''
            ]
        ];
    }

    /**
     * Sync total gender loaded.
     * 
     * @return void
     */
    protected function syncTotalGenderToRedis()
    {
        $syncDate = Carbon::now()->format('Y-m-d');
        $maleCount = User::select('id')
                ->where('gender', 'male')
                ->whereDate('created_at', $syncDate)
                ->count();

        $femaleCount = User::select('id')
                ->where('gender', 'female')
                ->whereDate('created_at', $syncDate)
                ->count();

        // Increment male count in Redis
        Redis::hincrby('hourly_record', 'male:count', $maleCount);

        // Increment female count in Redis
        Redis::hincrby('hourly_record', 'female:count', $femaleCount);
    }
}
