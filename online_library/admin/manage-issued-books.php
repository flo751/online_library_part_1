<?php
session_start();

include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    // Si l'utilisateur est déconnecté
    // L'utilisateur est renvoyé vers la page de login : index.php
    header('location:../adminlogin.php');
  } else {
// On recupere l'identifiant de la catégorie a supprimer
$sql = "SELECT * FROM tblissuedbookdetails ti
JOIN tblbooks tb ON ti.BookId=tb.id
JOIN tblreaders tr ON tr.ReaderId=ti.ReaderID";
$query=$dbh->prepare($sql);
$query->execute();}


// On prepare la requete de suppression
if(isset($_GET['edit'])){
    $id=$_GET['edit'];
    $sql=("SELECT * FROM tbltblissuedbookdetails Where id= :id");
    $query=$dbh->prepare($sql);
    $query->bindParam(':id',$id,PDO::PARAM_INT);
    $query-> execute();
    $_SESSION['id']=$_GET['edit'];
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion des sorties</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>

<h3>GESTION DES LIVRES </h3>
    <!-- On prevoit ici une div pour l'affichage des erreurs ou du succes de l'operation de mise a jour ou de suppression d'une categorie-->
    <table>
    <tr>
        <th>#</th>
        <th>
            Lecteur
        </th>
        <th>
            Titre
        </th>
        <th>
            ISBN
        </th>
        <th>
            Sortie le
        </th>
        <th>
            Retourne le
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php while($result = $query->fetch()){
        if($result['ReturnDate'] ==NULL){
            $result['ReturnDate']='Non retourné';
        }else{
            $result['ReturnDate']=$result['ReturnDate'];
        }
        ?>
                <tr>
                    <th>
                       <?php echo($result['0']) ?>
                    </th>
                    <th>
                    <?php echo($result['FullName'])  ?>
                    </th>
                    <th>
                    <?php echo($result['BookName'])  ?>
                    </th>
                    <th>
                    <?php echo($result['ISBNNumber'])?>
                    </th>
                    <th>
                    <?php echo($result['IssuesDate']) ?>
                    </th>
                    <th>
                    <?php echo($result['ReturnDate']) ?>
                    </th>
                    <th>
                    <a href="edit-issue-book.php?edit=<?php echo ($result['0']); ?>">
                    <button type="submit" name="edit" class="btn btn-info">Editer</button></a>
                </th>
                </tr>
                <?php 
                  }
 ?>
    </table>
     <!-- CONTENT-WRAPPER SECTION END-->
 <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

