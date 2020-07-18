<?php

namespace App;

abstract class Provider 
{

    private $token = null;

    public function getLink()
    {
        $params = [
            'client_id' => $this->clientId,
            'state' => "provider-{$this->data['name']}",
            'response_type' => 'code',
            'sdk' => 'php-sdk-7.0',
            'redirect_uri' => "{$this->data['redirect_uri']}",
            'scope' => isset($this->data["scope"]) ? $this->data["scope"] : null

        ];
        return "{$this->accessLink}?".http_build_query($params);
    }

    
    private function getToken()
    {
        if (isset($_GET["error"])) {
            [
                "error_reason" => $error_reason,
                "error" => $error,
                "error_description" => $error_description
            ] = $_GET;

            die($error);
        }

        [
            "code" => $code,
            "state" => $state,
        ] = $_GET;

        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => "{$this->data['redirect_uri']}",
            'client_secret' => $this->clientSecret,
            'code' => $code,
            "grant_type" => "authorization_code"
        ];

        if($this->data["name"] == "Github"){
            $result = $this->callback($this->uriAuth, $params);
            $string = explode("&", $result, 2)[0];
            $access_token = explode("=", $string)[1];
        }else{
            $surl = "{$this->uriAuth}?".http_build_query($params);
            $result = json_decode(file_get_contents($surl), true);
            ['access_token' => $access_token] = $result;
        }

        return $access_token;
    }

    public function callback(string $path, array $body = [])
    {
        if(empty($body)) {
            $token = $this->getToken();
            var_export($token);
            if(is_null($token)) return null;
            $sapi = $this->uri . $path;
        }else{
            $sapi = $this->uriAuth;
        }

        // Recherche données utilisateur avec access_token

        $userdata = curl_init($sapi);

        curl_setopt($userdata, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($userdata, CURLOPT_HEADER, 0);

        if(!empty($body)){
            curl_setopt($userdata, CURLOPT_POST, 1);
            curl_setopt($userdata, CURLOPT_POSTFIELDS,$body);
        }else{
            curl_setopt($userdata, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer {$token}"
            ]);

        }

        $result = curl_exec($userdata);
        var_dump($result);
        curl_close($userdata);
        return $result;
    }

}