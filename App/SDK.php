<?php

namespace App;

class SDK
{
    private $sdk;

    private static $mySDK = [
        'Github' => ProviderGithub::class,
        // Ajouter mes autres provider ici
    ];

    private $instances;

    public function __construct(array $providers)
    {
        session_start();

        foreach ($providers as $provider){
            $this->instances[$provider["name"]] = new self::$mySDK[$provider["name"]]($provider["client_id"], $provider["client_secret"]);
        }
    }

    public function getLinks(){
        $links = [];

        foreach ($this->instances as $key => $instance){
            $links[$key] = $instance->getLink();
        }

        return $links;
    }

    public function getUserData(){
        ["state" => $state] = $_GET;

        $provider = explode("-", $state, 2);

        return $this->instances[array_pop($provider)]->getUserData();
    }

    public function getCallback(string $path){
        return $this->sdk->callback($path);
    }

}