<?php
$url = "http://127.0.0.1/Api/utilisateur/2"; // modifier le utilisateur 2

$data = array('identifiant' => 'T', 'nom' => 'T', 'prenom' => 'T'
  , 'date_naissance' => 'T'
  , 'email' => 'T'
  , 'mot_de_passe' => 'T'
);
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