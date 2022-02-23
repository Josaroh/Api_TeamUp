<?php
$url = "http://127.0.0.1/Api/profils/40"; // modifier le profil 40

$data = array('localisation' => 'T', 'perimetre' => 'T', 'preference' => 'T');
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
$response = curl_exec($ch);
var_dump($response);
if (!$response) 
{
    return false;
}
?>