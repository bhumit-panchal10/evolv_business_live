<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\renewalhistory;
use Carbon\Carbon;

class UpdatePriorityClub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'priorityclub:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Priority Club (3,5,7 years)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        $histories = renewalhistory::with('members')->get();

        foreach ($histories as $history) {

            if (!$history->members || !$history->renewal_date) {
                continue;
            }

            $joiningDate = Carbon::parse($history->renewal_date);

            $years = $joiningDate->diffInYears($today);

            // Anniversary bhi same honi chahiye
            if (
                $joiningDate->format('m-d') == $today->format('m-d')
            ) {

                if (in_array($years, [3, 5, 7])) {

                    $history->members->update([
                        'priority_club' => $years
                    ]);

                    $this->info("Member ID {$history->member_id} updated to {$years}");
                }
            }
        }

        $this->info('Priority Club updated successfully.');
    }
}
