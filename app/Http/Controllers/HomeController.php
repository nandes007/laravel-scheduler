<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getUsers($request);
        $totalUsers = $this->userService->countUser();

        return view('home', [
            'users' => $users,
            'total_users' => $totalUsers
        ]);
    }

    public function reports()
    {
        return view('reports');
    }

    public function destroy(string $uuid)
    {
        $user = $this->userService->findUser($uuid);
        $this->userService->deleteUser($user);
        return redirect()->back();
    }
}
