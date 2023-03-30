<?php
// On démarre ou on récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    // Si l'utilisateur est déconnecté
    // L'utilisateur est renvoyé vers la page de login : index.php
    header('location:../adminlogin.php');
  } else {
// On recupere l'identifiant de la catégorie a supprimer
$sql = "SELECT * FROM tblreaders";
$query=$dbh->prepare($sql);
$query->execute();}
// On prepare la requete de suppression
if(isset($_GET['actif'])){
    $id=$_GET['actif'];

    $sql=("UPDATE tblreaders SET Status=1 WHERE id= :id");
    $query=$dbh->prepare($sql);
    $query->bindParam(':id',$id,PDO::PARAM_INT);
    $query-> execute();
    header('location:reg-readers.php');

}
if(isset($_GET['inactif'])){
    $id=$_GET['inactif'];


    $sql=("UPDATE tblreaders SET Status=0 WHERE id= :id");
    $query=$dbh->prepare($sql);
    $query->bindParam(':id',$id,PDO::PARAM_INT);
    $query-> execute();
    header('location:reg-readers.php');

}
// On execute la requete
if(isset($_GET['del'])){
    $id=$_GET['del'];
    $sql=("UPDATE tblreaders SET Status=2 WHERE id= :id");
    $query=$dbh->prepare($sql);
    $query->bindParam(':id',$id,PDO::PARAM_INT);
    $query-> execute();
    header('location:reg-readers.php');

}

// Si l'utilisateur n'est logué ($_SESSION['alogin'] est vide)
// On le redirige vers la page d'accueil
// Sinon on affiche la liste des lecteurs de la table tblreaders

// Lors d'un click sur un bouton "inactif", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['inid']
// et on met à jour le statut (0) dans la table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "actif", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['id']
// et on met à jour le statut (1) dans  table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "supprimer", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['del']
// et on met à jour le statut (2) dans la table tblreaders pour cet identifiant de lecteur

// On récupère tous les lecteurs dans la base de données
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Reg lecteurs</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!--On inclue ici le menu de navigation includes/header.php-->
    <?php include('includes/header.php'); ?>
    <!-- Titre de la page (Gestion du Registre des lecteurs) -->
    <h3>GESTION DES UTILISATEURS </h3>
    <!-- On prevoit ici une div pour l'affichage des erreurs ou du succes de l'operation de mise a jour ou de suppression d'une categorie-->
    <table>
    <tr>
        <th>#</th>
        <th>
            ID Lecteur
        </th>
        <th>
            Nom
        </th>
        <th>
            Email
        </th>
        <th>
            Portable
        </th>
        <th>
            Date de reg
        </th>
        <th>
            Status
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php while($result = $query->fetch()){
        if($result['Status'] ==1){
            $result['Status']='actif';
        }else if($result['Status']==0){
            $result['Status']='inactif';
        }else if($result['Status']==2){
            $result['Status']='supprimé(e)';
        }
        ?>
                <tr>
                    <th>
                       <?php echo($result['id']) ?>
                    </th>
                    <th>
                    <?php echo($result['ReaderId'])  ?>
                    </th>
                    <th>
                    <?php echo($result['FullName'])  ?>
                    </th>
                    <th>
                    <?php echo($result['EmailId'])?>
                    </th>
                    <th>
                    <?php echo($result['MobileNumber'])  ?>
                    </th>
                    <th>
                    <?php echo($result['RegDate']) ?>
                    </th>
                    <th>
                    <?php echo($result['Status']) ?>
                    </th>
                    <th>
                    <?php if($result['Status'] ==='actif'){?>
                    <a href="reg-readers.php?inactif=<?php echo ($result['id']); ?>">
                    <button type="submit" name="inactif" class="btn btn-info">inactif</button></a>
                    <a href="reg-readers.php?del=<?php echo ($result['id']); ?>">
                    <button type="submit" name="del" class="btn btn-info">Delet</button></a>
                    <?php } ?>
                    <?php if($result['Status'] ==='inactif'){?>
                    <a href="reg-readers.php?actif=<?php echo ($result['id']); ?>">
                    <button type="submit" name="actif" class="btn btn-info">actif</button></a>
                    <a href="reg-readers.php?del=<?php echo ($result['id']); ?>">
                    <button type="submit" name="del" class="btn btn-info">Delet</button></a>
                    <?php } ?>
                    <?php if($result['Status'] ==='supprimé(e)'){?>
                        <p>supprimé(e)</p>
                        <?php } ?>
                </th>
                </tr>
                <?php 
                  }
 ?>
    </table>
    <!--On insère ici le tableau des lecteurs.
       On gère l'affichage des boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>