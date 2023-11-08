<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Mail\SegmentEmail;
use App\Models\User;
use App\Models\Segmentation;
use Illuminate\Support\Facades\Mail;



class SendSegmentEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-segment-emails';

  

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to specific segments';

    /**
     * Execute the console command.
     */
   
     public function handle()
     {
         $this->info('Sending targeted emails to segmented groups...');
 
         $segments = Segmentation::all();
 
         foreach ($segments as $segment) {
             $usersInSegment = $segment->users;
 
             if ($usersInSegment->isNotEmpty()) {
               
                 $mailableClass = SegmentEmail::class;
 
                 foreach ($usersInSegment as $user) {
                     Mail::to($user->email)->send(new $mailableClass($user, $segment));
                 }
             }
         }
 
         $this->info('Targeted emails have been sent to segmented groups.');
     }
}
