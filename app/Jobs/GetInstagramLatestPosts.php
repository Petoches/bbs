<?php

namespace App\Jobs;

use App\Http\Controllers\PostController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetInstagramLatestPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::withHeaders([
            'User-Agent' => config('services.instagram.user_agent'),
            'x-ig-app-id' => config('services.instagram.x_ig_app_id')
        ])->get('https://i.instagram.com/api/v1/users/web_profile_info/?username='.config('services.instagram.page'));

        if($response->ok()) {

            $response_body = $response->object();

            if(count($response_body->data?->user?->edge_owner_to_timeline_media?->edges) > 0) {
                for ($i = config('services.instagram.post_count') - 1; $i >= 0 ; $i--) {
                    if(isset($response_body->data->user->edge_owner_to_timeline_media->edges[$i])) {
                        (new PostController())->store($response_body->data->user->edge_owner_to_timeline_media->edges[$i]);
                    }
                }
            }
        } else {
            Log::warning("Can't get instagram latest posts status : " . $response->status());
        }
    }
}
