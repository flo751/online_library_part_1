<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logué
if (strlen($_SESSION['alogin']) == 0) {
    // On le redirige vers la page de login  
    header('location:../index.php');
} else {
// Sinon on peut continuer. Après soumission du formulaire de creation
// On recupere le nom et le statut de la categorie
    $id = $_GET['edit'];
    
    if (isset($_POST['update'])){
    if(!preg_match("^[A-Za-z '-]*$", $name)){
        $name = $_POST['name'];
    $status = $_POST['radio'];
// On prepare la requete d'insertion dans la table tblcategory
    $sql=("UPDATE tblcategory SET Status= :radio, CategoryName= :name WHERE id= :id");
    $query=$dbh->prepare($sql);
    $query->bindParam(':id',$id,PDO::PARAM_INT);
    $query ->bindParam(':name',$name, PDO::PARAM_STR);
    $query ->bindParam(':radio',$status, PDO::PARAM_INT);
    $query-> execute();
    header('location:manage-categories.php');

// On execute la requete
    validation($last_id);
      }else{
        return false;
      }
// On stocke dans $_SESSION le message correspondant au resultat de loperation
  }}
    // Apres soumission du formulaire de categorie

    // On recupere l'identifiant, le statut, le nom

    // On prepare la requete de mise a jour

    // On prepare la requete de recherche des elements de la categorie dans tblcategory

    // On execute la requete

    // On stocke dans $_SESSION le message "Categorie mise a jour"

    // On redirige l'utilisateur vers edit-categories.php


?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Categories</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <!-- On affiche le titre de la page "Editer la categorie-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="header-line">Editer la categorie</h4>
            </div>
        </div>
        <!-- On affiche le formulaire dedition-->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <!-- On affiche ici le formulaire d'édition -->
            </div>
        
        <!-- Si la categorie est active (status == 1)-->
        <!-- On coche le bouton radio "actif"--><div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="container">
                    <div class="card bg-primary text-black">
                        <h2 class="card-header">Information catégorie</h2>
                    </div>
                        <div class="card-body border p-4">
                            <form method="post">
                                <div class="form-group">
                                    <label>Nom</label>
                                    <input type="text" name="name" require pattern="^[A-Za-z '-]+$" required>
                                </div>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radio" value="1">
                                        <label class="form-check-label" for="radio"> Active</label>
                                    </div>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radio" value="0">
                                        <label class="from-check-label" for="radio">Inactive</label>
                                    </div>
                                </div>
                                <button type="submit" name="update" class="btn btn-info">Modifier</button>
                            </form>
                        </div>
                    
                

                </div>
            </div>
        </div>
        <!-- Sinon-->
        <!-- On coche le bouton radio "inactif"-->

        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>