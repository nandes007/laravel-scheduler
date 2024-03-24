<?php

namespace App\Observers;

use App\Models\DailyRecord;
use App\Models\User;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('Y-m-d');
        $gender = $user->gender;
        $dailyRecord = DailyRecord::where('date', $date)->first();
        $genderAverageAge = $gender.'_avg_age';
        $genderCount = $gender.'_count';

        if (in_array($gender, ['male', 'female']) && !empty($dailyRecord)) {
            $newAverageAge = User::where('gender', $gender)
                    ->whereDate('created_at', $date)
                    ->avg('age');
            
            $dailyRecord->{$genderAverageAge} = $newAverageAge;
            $dailyRecord->{$genderCount} -= 1;
            $dailyRecord->save();
        }
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
