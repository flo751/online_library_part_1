<?php
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    // Si l'utilisateur est déconnecté
    // L'utilisateur est renvoyé vers la page de login : index.php
    header('location:../adminlogin.php');
  } else {
    if (TRUE === isset($_POST['alogin'])){ 
// Sinon on peut continuer. Après soumission du formulaire de creation
// On recupere le nom et le statut de la categorie
    $name = $_POST['name'];
    $status = $_POST['radio'];
    if(!preg_match("/^[A-Za-z '-]*$/", $name)){
// On prepare la requete d'insertion dans la table tblcategory
    $sql = "INSERT INTO tblcategory(CategoryName, Status) VALUE(:name, :radio) ";
    $query = $dbh -> prepare($sql);
    $query ->bindParam(':name',$name, PDO::PARAM_STR);
    $query ->bindParam(':radio',$status, PDO::PARAM_INT);
    $query-> execute();
    $last_id = $dbh ->lastInsertId();
    header('location:manage-categories.php');
// On execute la requete
    validation($last_id);
      }else{
        return false;
      }
// On stocke dans $_SESSION le message correspondant au resultat de loperation
  }}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de categories</title>
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
    <div class="container">
        <div class="row">
            <div class="col">
            <h3>AJOUTER UNE CATÉGORIE</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
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
                                <button type="submit" name="alogin" class="btn btn-info">Créer</button>
                            </form>
                        </div>
                    
                

                </div>
            </div>
        </div>
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>