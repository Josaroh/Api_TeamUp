<?php
    // Se connecter à la base de données
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    //générateur d'id pour profil


  //LISTE DES FONCTIONS CONCERNANT L'ACTIVITE


  function getProfil($id=0)
  {
    global $conn;
    $query = "SELECT * FROM profil";
    if($id != 0)
    {
      $query .= " WHERE id=".$id." LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($result))
    {
      $response[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }


  

  function updateProfil($id)
  {
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);

    $localisation = $_PUT["localisation"];
    $perimetre = $_PUT["perimetre"];
    $preference = $_PUT["preference"];
  
    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s')

    //construire la requête SQL
    $query="UPDATE profil SET localisation='".$localisation."', perimetre='".$perimetre."', preference='".$preference."'WHERE id=".$id;
    
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'Utilisateur mis a jour avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Echec de la mise a jour de produit. '. mysqli_error($conn)
      );
      
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }



  switch($request_method)
  {
    case 'GET':
        // Récupérer un seul produit
        $id = intval($_GET["id"]);
        print_r($id);
        getProfil($id);
        break;
      case 'PUT':
        // Modifier un activite
        $id = intval($_GET["id"]);
         updateProfil($id);
      break;
      default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
    }

?>