<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Segmentation;
use App\Models\User;
use DB;

class RefreshSegmentationData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-segmentation-data';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh customer segmentation data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing customer segmentation data...');
        
        $segmentsOver5 = Segmentation::where('min_order_count', '>', 5)->get();
        $segmentsOver15 = Segmentation::where('min_order_count', '>', 15)->get();
        $segmentsOver2000 = Segmentation::where('min_amount_spent', '>', 2000)->get();

        $users = User::all();

        foreach ($users as $user) {
 
            $orderCount = $user->orders->count();
            $totalAmountSpent = $user->orders->sum('total_amount');


            if ($orderCount > 15) {
                $user->segment_id = $segmentsOver15->first()->id;
            } elseif ($orderCount > 5) {
                $user->segment_id = $segmentsOver5->first()->id;
            } elseif ($totalAmountSpent > 2000) {
                $user->segment_id = $segmentsOver2000->first()->id;
            }

            $user->save();
        }

        $this->info('Segmentation data has been refreshed.');
    }

}
