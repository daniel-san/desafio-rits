<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Candidate;
use App\Mail\NotifyAdmin;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            // Getting the total of candidates
            $totalCandidates = Candidate::select('*')->count();

            // Getting the old candidate count that was set in the last run
            $oldCandidatesCount = \Cache::get('total_candidates', 0);

            // Calculating the number of new registered candidates since the last email sent
            $newCandidatesCount = $totalCandidates - $oldCandidatesCount;

            // Sending email to admin
            \Mail::to(env('ADMIN_EMAIL'))->send(
                new NotifyAdmin(env('ADMIN_NAME'), $newCandidatesCount)
            );

            // Updating the counter of total candidates
            \Cache::forever('total_candidates', $totalCandidates);
        })->twiceDaily(12, 18);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
