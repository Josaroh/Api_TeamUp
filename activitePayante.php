<?php
    // Se connecter à la base de données
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];


  //LISTE DES FONCTIONS CONCERNANT L'ACTIVITE


    function getActivitesPayantes()
  {
    global $conn;
    $query = "SELECT * FROM activite_payante";
    $response = array();
    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($result))
    {
    
      $response[] = $row;
  
    }


    header('Content-Type: application/json');

    echo json_encode($response,JSON_PRETTY_PRINT);
    
}


  function getActivitePayante($id=0)
  {
    global $conn;
    $query = "SELECT * FROM activite_payante";
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


  function AddActivitePayante()
  {
    global $conn;
    $id = $_POST["id"];
    $tarif = $_POST["tarif"];


    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s');
    echo $query="INSERT INTO activite_payante(id, tarif) VALUES('".$id."', '".$tarif."')";
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'activite payante ajoute avec succes.'
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

  function updateActivitePayante($id)
  {
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);

    $id = $_PUT["id"];
    $tarif = $_PUT["tarif"];

    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s')

    //construire la requête SQL
    $query="UPDATE activite_payante SET id='".$id."', tarif='".$tarif."'WHERE id=".$id;
    
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'activite payante mis a jour avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Echec de la mise a jour d activite payante. '. mysqli_error($conn)
      );
      
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }


  function deleteActivitePayante($id)
  {
    global $conn;
    $query = "DELETE FROM activite_payante WHERE id=".$id;
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'activite payante supprime avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'La suppression du activite payante a echoue. '. mysqli_error($conn)
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
        getActivitePayante($id);
      }
      else
      {
        // Récupérer tous les produits
        getActivitesPayantes();
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
    case 'POST':
      // Ajouter une activite
      AddActivitePayante();
      break;
      case 'PUT':
      // Modifier un activite
      $id = intval($_GET["id"]);
      updateActivitePayante($id);
      break;
      case 'DELETE':
        // Supprimer un produit
        $id = intval($_GET["id"]);
        deleteActivitePayante($id);
        break;
    }

?>