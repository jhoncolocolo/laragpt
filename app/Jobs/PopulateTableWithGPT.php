<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PopulateTableWithGPT implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Service $service,private string $message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [];
        DB::beginTransaction();
        try {
            $jsonData = \Gpt::generateSeeders($request['message']);
            foreach ($jsonData as $item) {
                \ProgramParticipantService::store($item);
                $data['status'] = true;
                DB::commit();
            }
        } catch (Exception $e) {
            $data['status'] = false;
            DB::rollback();
        }
    }
}
