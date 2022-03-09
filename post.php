<?php
 
  // API URL
$url = 'http://127.0.0.1/Api/activites';

// Create a new cURL resource
$ch = curl_init($url);

// Setup request to send json via POST
$data = array('a_pour_team_leader_id' => '1', 'titre' => 'HH', 'date' => 'HH', 'heure_debut' => 'H'
  , 'heure_debut' => 'H'
  , 'heure_fin' => 'waw'
  , 'lieu' => 'H'
  , 'niveau' => 'H'
  , 'nbr_participant' => 'H'
  , 'activite_terminee' => 'H');


$payload = json_encode( $data);
// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);
echo($result);

// Close cURL resource
curl_close($ch);

?>