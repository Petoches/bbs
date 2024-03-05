<?php

namespace App\Jobs;

use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateInstagramPostsLikes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $response = Http::withHeaders([
                'User-Agent' => config('services.instagram.user_agent'),
                'x-ig-app-id' => config('services.instagram.x_ig_app_id')
            ])->get('https://www.instagram.com/graphql/query/?query_hash=b3055c01b4b222b8a47dc12b090e4e64&shortcode='.$post->shortcode);

            if($response->ok()) {

                $response_body = $response->object();

                if($response_body->data?->shortcode_media?->edge_media_preview_like?->count) {
                    $post->likes = $response_body->data->shortcode_media->edge_media_preview_like->count;
                    $post->save();
                }
            } else {
                Log::warning("Can't update instagram post(" . $post->id . ") likes, status : " . $response->status());
            }
        }

    }
}
