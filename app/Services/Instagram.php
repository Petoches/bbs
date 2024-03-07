<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Instagram
{
    protected string $apiUrl = 'https://graph.instagram.com';
    protected string $apiVersion = 'v19.0';
    protected string $token = '';
    protected string $method = "";
    protected array $fields = [];
    protected string $since = "";
    protected string $until = "";
    protected string $grantType = "";

    public function token(string $token):self {
        $this->token = $token;

        return $this;
    }

    public function refresh() {
        $this->method = 'refresh_access_token';

        $this->grantType = 'ig_refresh_token';

        return $this->get();
    }

    public function me() {
        $this->method = 'me';

        $this->fields = [
            'id',
            'username',
            'account_type',
            'media_count',
            'media'
        ];

        return $this->get();
    }

    public function getUserMedia($userId) {
        $this->method = $userId.'/media';

        $this->fields = [
            'caption',
            'id',
            'media_type',
            'media_url',
            'permalink',
            'thumbnail_url',
            'timestamp',
            'username',
            'children'
        ];

        return $this->get();
    }

    public function getMediaById(string $id) {
        $this->method = $id;

        $this->fields = [
            'caption',
            'id',
            'media_type',
            'media_url',
            'permalink',
            'thumbnail_url',
            'timestamp',
            'username',
            'children'
        ];

        return $this->get();
    }

    protected function get(): object|null  {
        return Http::get($this->apiUrl.'/'.$this->apiVersion.'/'.$this->method.'/', $this->buildQuery());
    }

    protected function buildQuery(): array {

        $query = [
            'access_token' => $this->token
        ];

        if(count($this->fields) > 0) {
            $query['fields'] = implode(',', $this->fields);
        }

        if($this->since) {
            $query['since'] = $this->since;
        }

        if($this->until) {
            $query['until'] = $this->until;
        }

        if($this->grantType) {
            $query['grant_type'] = $this->grantType;
        }

        return $query;
    }
}
