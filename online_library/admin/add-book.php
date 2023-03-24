<?php
session_start();

include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    // Si l'utilisateur est déconnecté
    // L'utilisateur est renvoyé vers la page de login : index.php
    header('location:../adminlogin.php');
  } else {

    $sql1 = "SELECT * FROM tblauthors";
      $query1 = $dbh->prepare($sql1);
      $query1->execute();
      
      
      $sql2 = "SELECT * FROM tblcategory";
      $query2 = $dbh -> prepare($sql2);
      $query2->execute();
      
    if (TRUE === isset($_POST['alogin'])){ 

        
      
// Sinon on peut continuer. Après soumission du formulaire de creation
// On recupere le nom et le statut de la categorie
    $name = $_POST['name'];
    $categorie = $_POST['categorie'];
    $auteur = $_POST['auteur'];
    $ISBN = $_POST['ISBN'];
    $prix = $_POST['prix'];
    if(!preg_match("^[A-Za-z '-]*$", $name)){
// On prepare la requete d'insertion dans la table tblcategory
    $sql = "INSERT INTO tblbooks(BookName, CatId, AuthorId, ISBNNumber, BookPrice) VALUE(:name, :categorie, :auteur, :isbn, :prix) ";
    $query = $dbh -> prepare($sql);
    $query ->bindParam(':name',$name, PDO::PARAM_STR);
    $query ->bindParam(':categorie',$categorie, PDO::PARAM_INT);
    $query ->bindParam(':auteur',$auteur, PDO::PARAM_INT);
    $query ->bindParam(':isbn',$ISBN, PDO::PARAM_INT);
    $query ->bindParam(':prix',$prix, PDO::PARAM_INT);
    $query-> execute();
    $last_id = $dbh ->lastInsertId();
    header('location:manage-books.php');
    
// On execute la requete
    validation($last_id);
      }
// On stocke dans $_SESSION le message correspondant au resultat de loperation
  }}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de livres</title>
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
<!-- MENU SECTION END-->
<div class="container">
        <div class="row">
            <div class="col">
            <h3>AJOUTER UN LIVRE</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="container">
                    <div class="card bg-primary text-black">
                        <h2 class="card-header">Information livre</h2>
                    </div>
                        <div class="card-body border p-4">
                            <form method="post">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" name="name" require pattern="^[A-Za-z '-]+$" required>
                                </div>
                                <div class="form-group">
                                    <label>Categorie</label>
                                    <select name="categorie">
                                        <option value="">Choix de la categorie</option>
                                    <?php while($result2 = $query2->fetchAll(PDO::FETCH_OBJ)){ ?>
                                        <option value="<?php echo $result2['id']; ?>"><?php echo $result2['CategoryName']; ?></option>
                                        <?php
                                    }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Auteur</label>
                                    <select name="auteur">
                                    <option value="">Choix de l'auteur'</option>
                                    <?php while($result1 = $query1->fetchAll(PDO::FETCH_OBJ)){ 
                                        ?>
                                        
                                        <option value="<?php echo ($result1['id']); ?>"><?php echo ($result1['AuthorName']); ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>ISBN</label>
                                    <input type="text" name="ISBN" required>
                                </div>
                                <div class="form-group">
                                    <label>Prix</label>
                                    <input type="text" name="prix" required>
                                </div>
                                <button type="submit" name="alogin" class="btn btn-info">Ajouter</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
      </div>
     <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
