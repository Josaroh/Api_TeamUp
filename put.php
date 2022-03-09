<?php

  // API URL
  $url = 'http://lakartxela.iutbayonne.univ-pau.fr/~nvgouvet/PHP/S4/Api/activites/5';

  // Create a new cURL resource
  $ch = curl_init($url);
  
  // Setup request to send json via POST
  $data = array('a_pour_team_leader_id' => '1', 'titre' => 'EZGIUIO', 'date' => 'ZRIAGFI', 'heure_debut' => 'FHAZJFHJS'
  , 'heure_debut' => 'FJAZDFLS'
  , 'duree' => 'ZAEJGFZ'
  , 'lieu' => 'FJAKOZJ'
  , 'niveau' => 'FZJIFJH'
  , 'nbr_participant' => 'ZEJFIZJFZIJ'
  , 'activite_terminee' => 'ZIFJZIJF');
  $payload = json_encode($data);
  // Attach encoded JSON string to the POST fields
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  
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