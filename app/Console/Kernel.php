<?php

namespace App\Console;

use App\Mail\CommsMail;
use App\Models\Suggestion;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $notify_hods = Suggestion::where('type', 'notify')->get();
            $notify_hods->load('dept', 'initiator');
            foreach ($notify_hods as $notify) {
                $data = [
                    'intro'  => 'Dear HOD ' . $notify->dept->department . ',',
                    'content'  => $notify->initiator->name . ' Mobile No: ' .  $notify->initiator->phone_number . ' has sent a communication saying "' . $notify->query . ' "',
                    'email' => $notify->dept->HOD_email,
                    'subject'  => 'New Communication for ' . $notify->dept->department . ' Dept'
                ];
                Mail::to($data['email'], $notify->initiator->supervisor_email)->send(new CommsMail($data));
                $notify->update(['type' => 'email sent']);
            }
        })->everyTwoHours();
        $schedule->call(function () {
            $put_roles = Suggestion::whereDate('created_at', Carbon::today())->get();
            foreach ($put_roles as $role) {
                if ($role->dept->department == 'Human Resources') {
                    $role->update(['access_role' => 'HR']);
                } else {
                    $role->update(['access_role' => 'CM']);
                }
            }
        })->everyThreeMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
