<?php

use App\Jobs\GetInstagramLatestPosts;
use App\Models\Post;

dataset('instagram_response_values',[
    'instagram_response' => [
        [
            'id' => fake()->randomNumber(),
            'shortcode' => 'CFRxN5eqRir',
            'display_url' => fake()->imageUrl,
            'text' => fake()->text,
            'like_count' => fake()->randomNumber()
        ]
    ]
]);

it('fetch an instagram page and create a new post', function (array $response, bool $is_video, string|null $video_url) {

    Http::fake([
        '*' => Http::response([
            'data' => [
                'user' => [
                    'edge_owner_to_timeline_media' => [
                        'edges' => [
                            [
                                'node' => [
                                    'id' => $response['id'],
                                    'shortcode' => $response['shortcode'],
                                    'display_url' => $response['display_url'],
                                    'is_video' => $is_video,
                                    'video_url' => $video_url,
                                    'edge_media_to_caption' => [
                                        'edges' => [
                                            [
                                                'node' => [
                                                    'text' => $response['text']
                                                ]
                                            ]
                                        ]
                                    ],
                                    'edge_liked_by' => [
                                        'count' => $response['like_count']
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]),
    ]);

    File::spy();

    (new GetInstagramLatestPosts())->handle();

    Http::assertSent(function ($request) {
        return $request->url() === 'https://i.instagram.com/api/v1/users/web_profile_info/?username='.config('services.instagram.page');
    });

    if($is_video) {
        File::shouldHaveReceived('put')->twice();
    } else {
        File::shouldHaveReceived('put')->once();
    }

    $created_post = Post::first();

    expect(Post::count())->toBe(1)
        ->and($created_post->instagram_id)->toBe($response['id'])
        ->and($created_post->shortcode)->toBe($response['shortcode'])
        ->and($created_post->display_url)->toStartWith(asset('storage'))
        ->and($created_post->is_video)->toEqual($is_video)
        ->and($created_post->description)->toBe($response['text'])
        ->and($created_post->likes)->toBe($response['like_count']);

    if($is_video) {
        expect($created_post->video_url)->toStartWith(asset('storage'));
    } else {
        expect($created_post->video_url)->toBeNull();
    }

})->with('instagram_response_values')->with([
    "without video" => [
        'is_video' => false,
        'video_url' => null
    ],
    "with video" => [
        'is_video' => true,
        'video_url' => fake()->imageUrl
    ]
]);
