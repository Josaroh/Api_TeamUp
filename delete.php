<?php
$url = "http://lakartxela.iutbayonne.univ-pau.fr/~nvgouvet/PHP/S4/Api/activites/5"; // supprimer le activite 5
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
var_dump($response);
curl_close($ch);
?>