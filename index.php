<?php

include("autoloader.php");
use App\SDK;
$sdk = new SDK([
    [
        "name" => 'Github',
        'client_id' => '12619e560e36bf9385e5',
        'client_secret' => 'f6e7a66a51dc6e292aac57c798b04ae385cac24d'
    ],
    [
        "name" => 'Twitch',
        'client_id' => 't49a1d7mw2axag48qrrfuouolj5szg',
        'client_secret' => 'euqmnea1wjeb0li02x8fk20wdsmr74'
    ]
    // Pour chaque nouveau provider, mettre leur nom, client_id et client_secret ici
]);

if (!isset($_GET["code"])) {
    $links = $sdk->getLinks();
    foreach ($links as $key => $link){
        var_dump($link);
        echo "<a href='".$link."'>".$key."</a><br>";
    }
} else {
    var_dump($sdk->getUserData());
}
