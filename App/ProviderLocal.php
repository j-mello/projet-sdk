<?php

namespace App;

class ProviderLocal extends Provider
{

    protected $data = [
        "name" => "Local",
        "redirect_uri" => "http://localhost:7070",
        "uri" => "http://localhost:7070"
    ];

    protected $clientId;
    protected $clientSecret;
    protected $uri = "https://auth-server";
    protected $accessLink = "https://auth-server/auth";
    protected $uriAuth = "https://auth-server/token";

    public function __construct(string $client_id = null, string $client_secret = null)
    {
        $response = $this->callback("/register", [
            "name" => "Local" . rand(0, 100),
            "uri" => $this->data["uri"],
            "redirect_success" => $this->data["redirect_uri"],
            "redirect_error" => $this->data["redirect_uri"],
        ]);

        //save client id and secret
        if (!is_null($client_id) && !is_null($client_secret)) {
            $this->clientId = $client_id;
            $this->clientSecret = $client_secret;
        } else {
            $this->clientId = $response["client_id"];
            $this->clientSecret = $response["client_secret"];
        }

    }

    public function getUserData()
    {
        return $this->callback("/me");
    }
}
