<?php

namespace Tests\Unit;
use App\Exceptions\ValidationException;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use App\Service\IUserService;
use Exception;
use Illuminate\Http\Request;

use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function test_get_all_users()
    {
        // Mock request
        $request = Mockery::mock(Request::class);
        // Set expectation for the all() method
        $request->shouldReceive('all')->andReturn([]);
        // Set expectation for the route() method
        $request->shouldReceive('route')->andReturn(''); // You can customize the return value if needed
 
        // Mock repository
        $userRepository = Mockery::mock(UserRepository::class);
 
        // Set up repository mock to return a LengthAwarePaginator instance
        // Here, I'm just creating a dummy paginator for demonstration
        $items = [
            [
                'uuid' => '21d3b43a-8c0b-4c53-ae65-677b36b6d750',
                'gender' => 'male',
                'name' => ['title' => 'Mr', 'first' => 'john', 'last' => 'Doe'],
                'location' => [
                    'street' => [
                      'number' => 2465, 
                      'name' => 'Sigurd Syrs gate' 
                    ], 
                    'city' => 'Honningsvåg', 
                    'state' => 'Description', 
                    'country' => 'Norway', 
                    'postcode' => '0140', 
                    'coordinates' => [
                        'latitude' => '44.8533', 
                        'longitude' => '-92.0494' 
                    ], 
                    'timezone' => [
                        'offset' => '+7:00', 
                        'description' => 'Bangkok, Hanoi, Jakarta' 
                    ] 
                ],
                'age' => 50
            ],
            [
                'uuid' => 'e4a6e5b0-539d-4fcd-8bd7-6daca357e298',
                'gender' => 'female',
                'name' => ['title' => 'Mrs', 'first' => 'Madame', 'last' => 'Hilde'],
                'location' => [
                    'street' => [
                      'number' => 2465, 
                      'name' => 'Sigurd Syrs gate' 
                    ], 
                    'city' => 'Honningsvåg', 
                    'state' => 'Description', 
                    'country' => 'Norway', 
                    'postcode' => '0140', 
                    'coordinates' => [
                        'latitude' => '44.8533', 
                        'longitude' => '-92.0494' 
                    ], 
                    'timezone' => [
                        'offset' => '+7:00', 
                        'description' => 'Bangkok, Hanoi, Jakarta' 
                    ] 
                ],
                'age' => 50
            ]
        ];
         $perPage = 10; // Set to a value that would not trigger pagination
         $currentPage = 1;
         $total = count($items);
         $options = ['path' => '/']; // Set the path for pagination links
         $paginator = new LengthAwarePaginator($items, $total, $perPage, $currentPage, $options);
         $userRepository->shouldReceive('get')->once()->with($request)->andReturn($paginator);
 
         // Create service instance with mocked repository
         $userService = new IUserService($userRepository);
 
         // Call service method with mock request
         $result = $userService->getUsers($request);
 
         // Assert that the returned result is an instance of LengthAwarePaginator
         $this->assertInstanceOf(LengthAwarePaginator::class, $result);
         $this->assertEquals($total, $result->total());
         $this->assertEquals($items, $result->items());
    }

    public function test_get_all_users_no_data()
    {
        // Mock request
        $request = Mockery::mock(Request::class);
        // Set expectation for the all() method
        $request->shouldReceive('all')->andReturn([]);
        // Set expectation for the route() method
        $request->shouldReceive('route')->andReturn(''); // You can customize the return value if needed

        // Mock repository
        $userRepository = Mockery::mock(UserRepository::class);

        // Set up repository mock to return an empty paginator
        $userRepository->shouldReceive('get')->once()->with($request)->andReturn(new LengthAwarePaginator([], 0, 10));

        // Create service instance with mocked repository
        $userService = new IUserService($userRepository);

        // Call service method with mock request
        $result = $userService->getUsers($request);

        // Assert that the returned result is an instance of LengthAwarePaginator
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(0, $result->total());
        $this->assertEmpty($result->items());
    }

    public function test_count_users()
    {
        $items = [
            [
                'uuid' => '21d3b43a-8c0b-4c53-ae65-677b36b6d750',
                'gender' => 'male',
                'name' => ['title' => 'Mr', 'first' => 'john', 'last' => 'Doe'],
                'location' => [
                    'street' => [
                      'number' => 2465, 
                      'name' => 'Sigurd Syrs gate' 
                    ], 
                    'city' => 'Honningsvåg', 
                    'state' => 'Description', 
                    'country' => 'Norway', 
                    'postcode' => '0140', 
                    'coordinates' => [
                        'latitude' => '44.8533', 
                        'longitude' => '-92.0494' 
                    ], 
                    'timezone' => [
                        'offset' => '+7:00', 
                        'description' => 'Bangkok, Hanoi, Jakarta' 
                    ] 
                ],
                'age' => 50
            ],
            [
                'uuid' => 'e4a6e5b0-539d-4fcd-8bd7-6daca357e298',
                'gender' => 'female',
                'name' => ['title' => 'Mrs', 'first' => 'Madame', 'last' => 'Hilde'],
                'location' => [
                    'street' => [
                      'number' => 2465, 
                      'name' => 'Sigurd Syrs gate' 
                    ], 
                    'city' => 'Honningsvåg', 
                    'state' => 'Description', 
                    'country' => 'Norway', 
                    'postcode' => '0140', 
                    'coordinates' => [
                        'latitude' => '44.8533', 
                        'longitude' => '-92.0494' 
                    ], 
                    'timezone' => [
                        'offset' => '+7:00', 
                        'description' => 'Bangkok, Hanoi, Jakarta' 
                    ] 
                ],
                'age' => 50
            ]
        ];
        // Mock repository
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('count')->once()->andReturn(count($items));
        $userService = new IUserService($userRepository);
        $result = $userService->countUser();
        $this->assertEquals(count($items), $result);
    }

    public function test_find_user_success()
    {
        $uuid = 'e4a6e5b0-539d-4fcd-8bd7-6daca357e298';
        $userRepository = Mockery::mock(UserRepository::class);
        $user = new User();
        $userRepository->shouldReceive('find')->once()->with($uuid)->andReturn($user);
        $userService = new IUserService($userRepository);
        $result = $userService->findUser($uuid);
        $this->assertSame($user, $result);
    }

    public function test_find_user_failur()
    {
        $uuid = 'e4a6e5b0-539d-4fcd-8bd7-6daca357e298';
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('find')->once()->with($uuid)->andReturn(null);
        $userService = new IUserService($userRepository);
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('User not found');
        $this->expectExceptionCode(400);
        $userService->findUser($uuid);
    }

    /**
     * @doesNotPerformAssertions
    */
    public function test_delete_user_success()
    {
        $user = Mockery::mock(User::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('delete')->once()->with($user);
        $userService = new IUserService($userRepository);
        $userService->deleteUser($user);
        $this->expectNotToPerformAssertions();
    }

    public function test_delete_user_failur()
    {
        $user = Mockery::mock(User::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('delete')->once()->with($user)->andThrow(new \Exception('Failed to delete user'));
        $userService = new IUserService($userRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Sorry, something went wrong');
        $this->expectExceptionCode(500);
        $userService->deleteUser($user);
    }
}
