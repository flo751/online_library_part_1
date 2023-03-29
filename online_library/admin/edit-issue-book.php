<?php
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
      
      // Si l'utilisateur est déconnecté
      // L'utilisateur est renvoyé vers la page de login : index.php
      header('location:../adminlogin.php');
    } else {

      $id = $_GET['edit'];
  // On recupere l'identifiant de la catégorie a supprimer
  $sql = "SELECT * FROM tblissuedbookdetails ti
  JOIN tblbooks tb ON ti.BookId=tb.id
  JOIN tblreaders tr ON tr.ReaderId=ti.ReaderID
  WHERE ti.id=:id";
  $query=$dbh->prepare($sql);
  $query ->bindParam(':id',$id, PDO::PARAM_INT);
  $query->execute();
  $result= $query->fetch(PDO::FETCH_ASSOC);
  if (TRUE === isset($_POST['update'])){
  if($result['ReturnSatus'] == 1){

  }


}}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Sorties</title>
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
				<h3>UPDATE SORTIE D'UN LIVRE</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
				<form method="post">
                <div class="form-group">
						<p>Identifiant lecteur</p>
						<p><?php echo $result['ReaderId']; ?></p>
                                    <p><?php echo $result['FullName']; ?></p>
					</div>
                    <div class="form-group">
						<p>ISBN</p>
                                    <p><?php echo $result['ISBNNumber'];?></p>
						<p><?php echo $result['BookName'];?></p>
					</div>
                    <button type="submit" name="update" id="update" class="btn btn-info">Modifier</button>&nbsp;&nbsp;&nbsp;
				</form>
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
