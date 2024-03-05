<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function store($post): void
    {

        if(Post::where('instagram_id', $post->node?->id)->exists()) {
            return;
        }

        if($post->node?->display_url) {

            $filename = Str::uuid()->toString();

            $path = storage_path('app/public/');

            $image = base64_decode(base64_encode(file_get_contents($post->node->display_url)));

            File::put($path . '/' . $filename . '.jpg', $image);

            if($post->node->is_video) {
                $video = base64_decode(base64_encode(file_get_contents($post->node->video_url)));
                File::put($path . '/' . $filename . '.mp4', $video);
            }

            Post::create([
                'instagram_id' => $post->node->id,
                'shortcode' => $post->node->shortcode,
                'display_url' => asset('storage/'.$filename.'.jpg'),
                'video_url' => $post->node->is_video ? asset('storage/'.$filename.'.mp4') : null,
                'description' => $post->node->edge_media_to_caption?->edges[0]?->node?->text,
                'likes' => $post->node->edge_liked_by?->count,
                'is_video' => $post->node->is_video
            ]);
        }
    }
}
