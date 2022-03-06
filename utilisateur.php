<?php
    // Se connecter à la base de données
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    //générateur d'id pour profil


  //LISTE DES FONCTIONS CONCERNANT L'ACTIVITE


    function getUtilisateurs()
  {
    global $conn;
    $query = "SELECT * FROM utilisateur";
    $response = array();
    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($result))
    {
    
      $response[] = $row;
  
    }


    header('Content-Type: application/json');

    echo json_encode($response,JSON_PRETTY_PRINT);
    
}


  function getUtilisateur($id=0)
  {
    global $conn;
    $query = "SELECT * FROM utilisateur";
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

  function getUtilisateurIdentifiant($identifiant)
  {
    global $conn;
    $query = "SELECT * FROM utilisateur";
    
    $query .= " WHERE identifiant="."'".$identifiant."'";
    

 
    $response = array();
    $result = mysqli_query($conn, $query);



    while($row = mysqli_fetch_array($result))
    {
      $response[] = $row;
    }


    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }


  function AddUtilisateurAvecProfil()
  {
    global $conn;
    $identifiant = $_POST["identifiant"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $dateNaissance = $_POST["date_naissance"];
    $email = $_POST["email"];
    $motDePasse = $_POST["mot_de_passe"];
    


    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s');

    echo $queryProfil="INSERT INTO profil(localisation, perimetre, preference) VALUES('NULL','NULL','NULL')";
    if(mysqli_query($conn, $queryProfil))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'utilisateur ajoute avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'ERREUR!.'. mysqli_error($conn)
      );
    }
 //   header('Content-Type: application/json');
  //  echo json_encode($response);


    $queryProfil="SELECT * FROM profil ORDER BY id DESC LIMIT 1";

    $response = array();
    $result = mysqli_query($conn, $queryProfil);

    while($row = mysqli_fetch_array($result))
    {
      $response[] = $row;
    }

    $profilId=$response[0];


    $ID=$profilId[0];




    echo $query="INSERT INTO utilisateur(identifiant, nom, prenom, date_naissance, email, mot_de_passe,profil_id) VALUES('".$identifiant."', '".$nom."', '".$prenom."', '".$dateNaissance."', '".$email."', '".$motDePasse."', '".$ID."')";
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'utilisateur ajoute avec succes.'
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


  function updateUtilisateur($id)
  {
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);

    $identifiant = $_PUT["identifiant"];
    $nom = $_PUT["nom"];
    $prenom = $_PUT["prenom"];
    $dateNaissance = $_PUT["date_naissance"];
    $email = $_PUT["email"];
    $motDePasse = $_PUT["mot_de_passe"];
  
    //$created = date('Y-m-d H:i:s');
    //$modified = date('Y-m-d H:i:s')

    //construire la requête SQL
    $query="UPDATE utilisateur SET identifiant='".$identifiant."', nom='".$nom."', prenom='".$prenom."', date_naissance='".$dateNaissance."', email='".$email."' , mot_de_passe='".$motDePasse."'WHERE id=".$id;
    
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
        'status_message' =>'Echec de la mise a jour de l utilisateur. '. mysqli_error($conn)
      );
      
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }


  function deleteUtilisateur($id)
  {
    global $conn;
    $query = "DELETE FROM utilisateur WHERE id=".$id;
    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'Utilisateur supprime avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'La suppression du utilisateur a echoue. '. mysqli_error($conn)
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
        getUtilisateur($id);
      }
      else if(!empty($_GET["identifiant"])){
        $identifiant = $_GET["identifiant"];
        getUtilisateurIdentifiant($identifiant);
      }
      else
      {
        // Récupérer tous les produits
        getUtilisateurs();
      }
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
    case 'POST':
      // Ajouter une activite
      AddUtilisateurAvecProfil();
      break;
      case 'PUT':
      // Modifier un activite
      $id = intval($_GET["id"]);
      updateUtilisateur($id);
      break;
      case 'DELETE':
        // Supprimer un produit
        $id = intval($_GET["id"]);
        deleteUtilisateur($id);
        break;
    }

?>