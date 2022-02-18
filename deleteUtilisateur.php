<?php
$url = "http://127.0.0.1/Api/utilisateur/5"; // supprimer l'utilisateur 5
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
var_dump($response);
curl_close($ch);
?>