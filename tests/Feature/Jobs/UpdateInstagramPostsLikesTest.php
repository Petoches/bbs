<?php

use App\Jobs\UpdateInstagramPostsLikes;
use App\Models\Post;

it('update a post likes', function () {

    Http::fake([
        '*' => Http::response([
            'data' => [
                'shortcode_media' => [
                    'edge_media_preview_like' => [
                        'count' => 13
                    ]
                ]
            ]
        ])
    ]);

    $post = Post::factory()->create();

    (new UpdateInstagramPostsLikes())->handle();

    $post->refresh();

    Http::assertSent(function ($request) use ($post) {
        return $request->url() === 'https://www.instagram.com/graphql/query/?query_hash=b3055c01b4b222b8a47dc12b090e4e64&shortcode='.$post->shortcode;
    });

    expect($post->likes)->toBe(13);
});
