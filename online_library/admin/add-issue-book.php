<?php
session_start();

include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    // Si l'utilisateur est déconnecté
    // L'utilisateur est renvoyé vers la page de login : index.php
    header('location:../adminlogin.php');
  } else {

    if (TRUE === isset($_POST['add'])){ 

        $isbn = $_POST['isbn'];
    $sql = "SELECT * FROM tblbooks WHERE ISBNNUmber=:isbn";
      $query = $dbh->prepare($sql);
      $query ->bindParam(':isbn',$isbn, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $bookid = $result['id'];
      
    

        
      
// Sinon on peut continuer. Après soumission du formulaire de creation
// On recupere le nom et le statut de la categorie
    $readerid = $_POST['readerid'];
    $returndate = NULL;
// On prepare la requete d'insertion dans la table tblcategory
    $sql = "INSERT INTO tblissuedbookdetails(BookId, ReaderId,ReturnDate, ReturnStatus) VALUE(:bookid, :readerid, :returndate, :isbn) ";
    $query = $dbh -> prepare($sql);
    $query ->bindParam(':bookid',$bookid, PDO::PARAM_INT);
    $query ->bindParam(':readerid',$readerid, PDO::PARAM_STR);
    $query ->bindParam(':returndate',$reterdate, PDO::PARAM_INT);
    $query ->bindParam(':isbn',$isbn, PDO::PARAM_INT);
    $query-> execute();
    $last_id = $dbh ->lastInsertId();
    header('location:manage-issued-books.php');
    
// On execute la requete
// On stocke dans $_SESSION le message correspondant au resultat de loperation
  }}
?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Ajout de sortie</title>
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
    <div class="container">
		<div class="row">
			<div class="col">
				<h3>SORTIE D'UN LIVRE</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
				<form method="post">
                <div class="form-group">
						<label>Identifiant lecteur</label><br>
						<input type="text" name="readerid" id="readerid" onblur="get_reader(readerid)" required>
                        <span id="answer"></span>
					</div>
                    <div class="form-group">
						<label>ISBN</label><br>
						<input type="text" name="isbn" id="isbn" onblur="get_book(isbn)" required>
                        <span id="answer1"></span>
					</div>
                    <button type="submit" name="add" id="add" class="btn btn-info">Ajouter</button>&nbsp;&nbsp;&nbsp;
				</form>
			</div>
		</div>
	</div>
    <!-- Dans le formulaire du sortie, on appelle les fonctions JS de recuperation du nom du lecteur et du titre du livre 
 sur evenement onBlur-->

 
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // On crée une fonction JS pour récuperer le nom du lecteur à partir de son identifiant
        function get_reader(readerid){
            let button = document.getElementById("add");
            let span = document.getElementById("answer");
            fetch('get_reader.php?readerid='+readerid.value)
            .then(rep => rep.json())
            .then(data => {
            span.innerHTML = data.caca;
            if((span.innerHTML == "lecteur bloqué")||(span.innerHTML == "lecteur non disponible")){
                button.disabled = true;
            }})}

            function get_book(isbn){
            let button = document.getElementById("add");
            let span = document.getElementById("answer1");
            fetch('get_book.php?isbn='+isbn.value)
            .then(rep => rep.json())
            .then(data => {
                console.log(data);
                span.innerHTML = data.caca;
                if((span.innerHTML == "ISBN non valide")||(span.innerHTML == "ISBN non disponible")){
                button.disabled = true;
            }})}
        // On crée une fonction JS pour recuperer le titre du livre a partir de son identifiant ISBN
    </script>
</body>

</html>