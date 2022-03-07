<?php
    // Se connecter à la base de données
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];


  //LISTE DES FONCTIONS CONCERNANT L'ACTIVITE


    function getActivites()
  {
    global $conn;
    $query = "SELECT * FROM activite";
    $response = array();
    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result))
    {
    
      $response[] = $row;
  
    }


    header('Content-Type: application/json');

    echo json_encode($response,JSON_PRETTY_PRINT);
    
}


  function getActivite($id=0)
  {
    global $conn;
    $query = "SELECT * FROM activite";
    if($id != 0)
    {
      $query .= " WHERE id=".$id." LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result))
    {
      $response[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }


  function AddActivite()
  {
    global $conn;
    $a_pour_team_leader_id = $_POST["a_pour_team_leader_id"];
    $titre = $_POST["titre"];
    $date = $_POST["date"];
    $heure_debut = $_POST["heure_debut"];
    $duree = $_POST["duree"];
    $lieu = $_POST["lieu"];
    $niveau = $_POST["niveau"];
    $nbr_participant = $_POST["nbr_participant"];
    $activite_terminee = $_POST["activite_terminee"];


    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s');
    echo $query="INSERT INTO activite(a_pour_team_leader_id, titre, date, heure_debut, duree, lieu,niveau,nbr_participant,activite_terminee) VALUES('".$a_pour_team_leader_id."', '".$titre."', '".$date."', '".$heure_debut."', '".$duree."', '".$lieu."', '".$niveau."', '".$nbr_participant."', '".$activite_terminee."')";
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'activite ajoute avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'ERREUR!.'. mysqli_error($conn)
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  function updateActivite($id)
  {
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);

    $titre = $_PUT["titre"];
    $date = $_PUT["date"];
    $heure_debut = $_PUT["heure_debut"];
    $duree = $_PUT["duree"];
    $lieu = $_PUT["lieu"];
    $niveau = $_PUT["niveau"];
    $nbr_participant = $_PUT["nbr_participant"];
    $activite_terminee = $_PUT["activite_terminee"];

    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s')

    //construire la requête SQL
    $query="UPDATE activite SET titre='".$titre."', date='".$date."', heure_debut='".$heure_debut."', duree='".$duree."', lieu='".$lieu."' , niveau='".$niveau."', nbr_participant='".$nbr_participant."', activite_terminee='".$activite_terminee."'WHERE id=".$id;
    
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'activite mis a jour avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Echec de la mise a jour d activite. '. mysqli_error($conn)
      );
      
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }


  function deleteActivite($id)
  {
    global $conn;
    $query = "DELETE FROM activite WHERE id=".$id;
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'activite supprime avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'La suppression du activite a echoue. '. mysqli_error($conn)
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }




  switch($request_method)
  {
    case 'GET':
      if(!empty($_GET["id"]))
      {
        // Récupérer un seul produit
        $id = intval($_GET["id"]);
        getActivite($id);
      }
      else
      {
        // Récupérer tous les produits
        getActivites();
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
    case 'POST':
      // Ajouter une activite
      AddActivite();
      break;
      case 'PUT':
      // Modifier un activite
      $id = intval($_GET["id"]);
      updateActivite($id);
      break;
      case 'DELETE':
        // Supprimer un produit
        $id = intval($_GET["id"]);
        deleteActivite($id);
        break;
    }

?>