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
        getProfil($id);
      }
      else
      {
        // Récupérer tous les produits
        getProfils();
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
    case 'POST':
      // Ajouter une activite
      AddProfil();
      break;
      case 'PUT':
      // Modifier un activite
      $id = intval($_GET["id"]);
      updateProfil($id);
      break;
      case 'DELETE':
        // Supprimer un produit
        $id = intval($_GET["id"]);
        deleteProfil($id);
        break;
    }


  //LISTE DES FONCTIONS CONCERNANT L'ACTIVITE


    function getProfils()
  {
    global $conn;
    $query = "SELECT * FROM profil";
    $response = array();
    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result))
    {
    
      $response[] = $row;
  
    }


    header('Content-Type: application/json');

    echo json_encode($response,JSON_PRETTY_PRINT);
    
}


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

    while($row = mysqli_fetch_assoc($result))
    {
      $response[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }


  function AddProfil()
  {
    global $conn;


    $donnees = file_get_contents('php://input');
    echo "-------------------------";
   

    $data = json_decode($donnees);
    var_dump($data);

    echo "-------------------------";

    $localisation = $data->{'localisation'};
    $perimetre = $data->{'perimetre'};
    $preference = $data->{'preference'};
    
    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s');
    echo $query="INSERT INTO profil(localisation, perimetre, preference) VALUES('".$localisation."', '".$perimetre."', '".$preference."')";
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'profil ajoute avec succes.'
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

  function updateProfil($id)
  {
    global $conn;

    $donnees = file_get_contents('php://input');
    echo "-------------------------";
   

    $data = json_decode($donnees);
    var_dump($data);

    echo "-------------------------";
    $localisation = $data->{'localisation'};
    $perimetre = $data->{'perimetre'};
    $preference = $data->{'preference'};

    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s')

    //construire la requête SQL
    $query="UPDATE profil SET localisation='".$localisation."', perimetre='".$perimetre."', preference='".$preference."'WHERE id=".$id;
    
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'profil mis a jour avec succes.'
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


  function deleteProfil($id)
  {
    global $conn;
    $query = "DELETE FROM profil WHERE id=".$id;
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'profil supprime avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'La suppression du profil a echoue. '. mysqli_error($conn)
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }




?>