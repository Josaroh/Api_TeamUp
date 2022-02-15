<?php
$url = "http://127.0.0.1/Api/activite/5"; // modifier le produit 5

$data = array('titre' => 'T', 'date' => 'T', 'heure_debut' => 'T'
  , 'heure_debut' => 'T'
  , 'duree' => 'T'
  , 'lieu' => 'T'
  , 'niveau' => 'T'
  , 'nbr_participant' => 'T'
  , 'activite_terminee' => 'T');
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