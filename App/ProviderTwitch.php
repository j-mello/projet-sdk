<?php

namespace App;

class ProviderTwitch extends Provider
{
    protected $data = [
        "name" => "Twitch",
        "redirect_uri" => "http://localhost:80"
    ];

    protected $clientId;
    protected $clientSecret;
    protected $uri = "https://www.twitch.tv/";
    protected $accessLink = "https://id.twitch.tv/oauth2/authorize";
    protected $uriAuth = "https://api.twitch.tv/kraken/oauth2/token";

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