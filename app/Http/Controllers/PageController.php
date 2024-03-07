<?php

namespace App\Http\Controllers;

use App\Facades\Instagram;
use App\Http\Requests\PageStoreRequest;
use App\Models\Media;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show(Page $page) {
        return Inertia::render('Page', [
            'page' => $page,
            'medias' => $page->medias
        ]);
    }

    public function store(PageStoreRequest $request) {

        $response = Instagram::token($request->token)->me();

        $data = $response->object();

        Page::create([
            'instagram_id' => $data->id,
            'username' => $data->username,
            'account_type' => $data->account_type,
            'token' => $request->token,
            'user_id' => auth()->user()->id
        ]);

        return to_route('dashboard');
    }

    public function fetch(Request $request) {

        $response = Instagram::token($request->page['token'])->getUserMedia($request->page['instagram_id']);

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
                    'page_id' => $request->page['id']
                ]);
            }
        }

        return to_route('dashboard');
    }
}
