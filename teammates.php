<?php
    // Se connecter à la base de données
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    switch($request_method)
  {
    case 'GET':

      if(!empty($_GET["idActivite"]))
      {
        // Récupérer un seul produit
        $idActivite = intval($_GET["idActivite"]);
        getTeammateActivite($idActivite);
      }
      else if(!empty($_GET["idUtilisateur"])){
        $idUtilisateur = $_GET["idUtilisateur"];
        getTeammateUtilisateur($idUtilisateur);
      }
      else
      {
        // Récupérer tous les produits
        getTeammates();
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
    case 'POST':
      // Ajouter une activite
      AddTeammates();
      break;
      case 'PUT':
      // Modifier un activite
      $id = intval($_GET["id"]);
      updateTeammate($id);
      break;
      case 'DELETE':
        // Supprimer un produit
        $idActivite = intval($_GET["idActivite"]);
        $idUtilisateur = intval($_GET["idUtilisateur"]);
        deleteTeammate($idActivite,$idUtilisateur);
        break;
    }


  //LISTE DES FONCTIONS CONCERNANT L'ACTIVITE


    function getTeammates()
  {
    global $conn;
    $query = "SELECT * FROM activite_utilisateur";
    $response = array();
    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result))
    {
    
      $response[] = $row;
  
    }


    header('Content-Type: application/json');

    echo json_encode($response,JSON_PRETTY_PRINT);
    
}


  function getTeammateActivite($id=0)
  {
    global $conn;
    $query = "SELECT * FROM activite_utilisateur";
    if($id != 0)
    {
      $query .= " WHERE activite_id=".$id;
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

  function getTeammateUtilisateur($id=0)
  {
    global $conn;
    $query = "SELECT * FROM activite_utilisateur";
    if($id != 0)
    {
      $query .= " WHERE utilisateur_id=".$id;
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


  function AddTeammates()
  {
    global $conn;

    $donnees = file_get_contents('php://input');

    $data = json_decode($donnees);

    $activite_id = $data->{'activite_id'};
    $utilisateur_id = $data->{'utilisateur_id'};


    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s');
    echo $query="INSERT INTO activite_utilisateur(activite_id, utilisateur_id) VALUES('".$activite_id."', '".$utilisateur_id."')";
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'teammate ajoute avec succes.'
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

  function updateTeammate($id)
  {
    global $conn;
    
    $donnees = file_get_contents('php://input');

    $data = json_decode($donnees);

    $activite_id = $data->{'activite_id'};
    $utilisateur_id = $data->{'utilisateur_id'};

    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s')

    //construire la requête SQL
    $query="UPDATE activite_utilisateur SET activite_id='".$activite_id."', utilisateur_id='".$utilisateur_id."'WHERE id=".$id;
    
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'teammate mis a jour avec succes.'
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


  function deleteTeammate($idActivite,$idUtilisateur)
  {
    global $conn;
    $query = "DELETE FROM activite_utilisateur WHERE activite_id=".$idActivite." AND utilisateur_id=".$idUtilisateur;
    if(mysqli_query($conn, $query))
    {
      print_r(4);
      $response=array(
        'status' => 1,
        'status_message' =>'teamamte supprime avec succes.'
      );
    }
    else
    {
      print_r(5);
      $response=array(
        'status' => 0,
        'status_message' =>'La suppression du teammate a echoue. '. mysqli_error($conn)
      );
    }
    echo json_encode($response);
  }


?>