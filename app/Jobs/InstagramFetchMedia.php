<?php

namespace App\Jobs;

use App\Facades\Instagram;
use App\Models\Media;
use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InstagramFetchMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pages = Page::all();

        foreach ($pages as $page) {
            $response = Instagram::token($page->token)->getUserMedia($page->instagram_id);

            if($response->status() === 200) {
                $data = $response->object()->data;
                foreach ($data as $media) {

                    if(Media::where('media_id', $media->id)->exists()) {
                        continue;
                    }

                    Media::create([
                        'caption' => $media->caption ?? null,
                        'media_id' => $media->id,
                        'media_type'=> $media->media_type,
                        'media_url'=> $media->media_url,
                        'permalink'=> $media->permalink,
                        'timestamp'=> \Carbon\Carbon::parse($media->timestamp),
                        'page_id' => $page->id
                    ]);
                }
            }
        }
    }
}
