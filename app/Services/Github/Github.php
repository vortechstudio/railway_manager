<?php

namespace App\Services\Github;

use Github\AuthMethod;
use Github\Client;

class Github
{
    protected string $owner;
    protected string $repo;
    protected Client $client;
    public function __construct()
    {
        $this->owner = config('updater.github_username');
        $this->repo = config('updater.github_repository');
        $this->client = new Client();
        $this->client->authenticate(config('updater.github_token'), null, AuthMethod::ACCESS_TOKEN);
    }
}
