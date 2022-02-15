<?php
  $url = 'http://127.0.0.1/Api/activite';
  $data = array('a_pour_team_leader_id' => '1', 'titre' => 'HH', 'date' => 'HH', 'heure_debut' => 'H'
  , 'heure_debut' => 'H'
  , 'duree' => 'H'
  , 'lieu' => 'H'
  , 'niveau' => 'H'
  , 'nbr_participant' => 'H'
  , 'activite_terminee' => 'H');
  // utilisez 'http' même si vous envoyez la requête sur https:// ...
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  if ($result === FALSE) { /* Handle error */ }
  var_dump($result);
?>