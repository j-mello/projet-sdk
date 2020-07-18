<?php

namespace App;

class ProviderGithub extends Provider
{
    protected $data = [
        "name" => "Github",
        "redirect_uri" => "http://localhost:80"
    ];

    protected $clientId;
    protected $clientSecret;
    protected $uri = "https://api.github.com";
    protected $accessLink = "https://github.com/login/oauth/authorize";
    protected $uriAuth = "https://github.com/login/oauth/access_token";

    public function __construct(string $client_id, string $client_secret)
    {
        $this->clientId = $client_id;
        $this->clientSecret = $client_secret;
    }

    public function getUserData()
    {
        return $this->callback("/user");
    }

}