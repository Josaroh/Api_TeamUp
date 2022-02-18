<?php
  $url = 'http://127.0.0.1/Api/utilisateur';
  $data = array('identifiant' => 'Swanou', 'nom' => 'Bourgeois', 'prenom' => 'Swan', 'date_naissance' => '01/01/2002'
  , 'email' => 'swan.bourgeois@gmail.com'
  , 'mot_de_passe' => 'swan123'
  , 'mot_de_passe' => 5
  );
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