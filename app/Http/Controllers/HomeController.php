<?php

namespace App\Http\Controllers;

use App\Service\DailyRecordService;
use App\Service\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected UserService $userService;
    protected DailyRecordService $dailyRecordService;

    public function __construct(UserService $userService, DailyRecordService $dailyRecordService)
    {
        $this->userService = $userService;
        $this->dailyRecordService = $dailyRecordService;
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
        $dailyRecords = $this->dailyRecordService->getDailyRecords();
        return view('reports', [
            'daily_records' => $dailyRecords
        ]);
    }

    public function destroy(string $uuid)
    {
        try {
            $user = $this->userService->findUser($uuid);
            $this->userService->deleteUser($user);

            return redirect()->back()->with('success_message', 'Successfully deleted user');
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => true,
                'error_message' => $e->getMessage()
            ]);
        }
    }
}
