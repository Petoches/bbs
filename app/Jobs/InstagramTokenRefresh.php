<?php

namespace App\Jobs;

use App\Facades\Instagram;
use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InstagramTokenRefresh implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pages = Page::all();

        foreach ($pages as $page) {
          $response = Instagram::token($page->token)->refresh();

            if($response->status() === 200) {
              $page->token = $response->object()->access_token;
              $page->save();
          }
        }
    }
}
