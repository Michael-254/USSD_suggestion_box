<?php

namespace App\Console;

use App\Mail\CommsMail;
use App\Models\SMSProgress;
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
            $notify_hods = Suggestion::where('type', 'notify')->orWhere('type', 'hod')->get();
            $notify_hods->load('dept', 'initiator');
            foreach ($notify_hods as $notify) {
                $data = [
                    'intro'  => 'Dear HOD ' . $notify->dept->department . ',',
                    'content'  => $notify->initiator->name . ' Mobile No: ' .  $notify->initiator->phone_number . ' has sent a communication saying "' . $notify->query . ' "',
                    'email' => $notify->dept->HOD_email,
                    'subject'  => 'New Communication for ' . $notify->dept->department . ' Dept'
                ];
                if ($notify->type == 'notify') {
                    $message = Mail::to($data['email'], $notify->initiator->supervisor_email);
                    if ($notify->access_role == 'CM') {
                        $message->cc('claudiah@betterglobeforestry.com');
                    }
                    $message->send(new CommsMail($data));
                } else {
                    $message = Mail::to($data['email']);
                    if ($notify->access_role == 'CM') {
                        $message->cc('claudiah@betterglobeforestry.com');
                    }
                    $message->send(new CommsMail($data));
                }
                $notify->update(['type' => 'email sent']);
            }
        })->everyThreeMinutes();
        $schedule->call(function () {
            $put_roles = Suggestion::whereDate('created_at', Carbon::today())->get();
            foreach ($put_roles as $role) {
                if ($role->dept->department == 'Human Resources') {
                    $role->update(['access_role' => 'HR']);
                } else {
                    $role->update(['access_role' => 'CM']);
                }
            }
        })->everyMinute();
        $schedule->call(function () {
            $sms = SMSProgress::where('progress', 4)->get();
            foreach ($sms as $sm) {
                $suggestion = Suggestion::create([
                    'user_id' => $sm->user_id, 'department_id' => $sm->department_id,
                    'query' => $sm->query
                ]);
                if ($sm->type == 1) {
                    $suggestion->update(['type' => 'notify']);
                } else {
                    $suggestion->update(['type' => 'hod']);
                }
                $sm->delete();
            }
        })->everyMinute();
        $schedule->call(function () {
            $sms = SMSProgress::where('created_at', '<', Carbon::now()->subDays(1)->toDateString())->delete();
        })->daily();
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
