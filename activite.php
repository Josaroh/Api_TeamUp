<?php
    // Se connecter à la base de données
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

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

    print_r($response);
    echo json_encode($response, JSON_PRETTY_PRINT);
  }


  function AddActivite()
  {
    global $conn;


    $donnees = file_get_contents('php://input');

    $data = json_decode($donnees);

    $a_pour_team_leader_id = $data->{'a_pour_team_leader_id'};
    $titre = $data->{'titre'};
    $date = $data->{'date'};
    $heure_debut = $data->{'heure_debut'};
    $heure_fin = $data->{'heure_fin'};
    $lieu = $data->{'lieu'};
    $niveau = $data->{'niveau'};
    $nbr_participant = $data->{'nbr_participant'};
    $activite_terminee = $data->{'activite_terminee'};


    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s');
    echo $query="INSERT INTO activite(a_pour_team_leader_id, titre, date, heure_debut, heure_fin, lieu,niveau,nbr_participant,activite_terminee) VALUES('".$a_pour_team_leader_id."', '".$titre."', '".$date."', '".$heure_debut."', '".$heure_fin."', '".$lieu."', '".$niveau."', '".$nbr_participant."', '".$activite_terminee."')";
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

    echo json_encode($response);
  }

  function updateActivite($id)
  {
    global $conn;
    $donnees=file_get_contents('php://input');
    var_dump($donnees);
    // parse_str(file_get_contents('php://input'), $_PUT);

    $data = json_decode($donnees);

    $a_pour_team_leader_id = $data->{'a_pour_team_leader_id'};
    $titre = $data->{'titre'};
    $date = $data->{'date'};
    $heure_debut = $data->{'heure_debut'};
    $heure_fin = $data->{'heure_fin'};
    $lieu = $data->{'lieu'};
    $niveau = $data->{'niveau'};
    $nbr_participant = $data->{'nbr_participant'};
    $activite_terminee = $data->{'activite_terminee'};

    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s')

    //construire la requête SQL
    $query="UPDATE activite SET titre='".$titre."', date='".$date."', heure_debut='".$heure_debut."', duree='".$heure_fin."', lieu='".$lieu."' , niveau='".$niveau."', nbr_participant='".$nbr_participant."', activite_terminee='".$activite_terminee."'WHERE id=".$id;
    
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
    echo json_encode($response);
  }


?>