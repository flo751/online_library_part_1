<?php
// On récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');
if (TRUE === isset($_POST['login'])) {
	// Après la soumission du formulaire de login ($_POST['login'] existe - voir pourquoi plus bas)
	// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
	// $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)
	if ($_POST['vercode'] != $_SESSION['vercode']) {
		// Le code est incorrect on informe l'utilisateur par une fenetre pop_up
		"<script> alert ('Code de vérification incorrect')</script>";
}else{ 


// Sinon on continue
// On récupère le numéro de portable
$telephone = $_POST['MobileNumber'];
// On récupère l'email
$email = $_POST['EmailId'];
// et le nouveau mot de passe que l'on encode (fonction password_hash)
$mdp = password_hash($_POST['Password'],PASSWORD_DEFAULT);
// On cherche en base le lecteur avec cet email et ce numero de tel dans la table tblreaders
$sql = "SELECT EmailId,MobileNumber FROM tblreaders  WHERE EmailId = :EmailId and MobileNumber= :MobileNumber";
$query = $dbh -> prepare($sql);
    $query ->bindParam(':MobileNumber',$telephone, PDO::PARAM_INT);
    $query ->bindParam(':EmailId',$email, PDO::PARAM_STR);
    $query -> execute();
// Si le resultat de recherche n'est pas vide
$result = $query->fetch(PDO::FETCH_OBJ);

if($result){
    $sql = "UPDATE tblreaders SET Password= :Password";

    // On éxecute la requete
        $query = $dbh -> prepare($sql);
        $query ->bindParam(':Password',$mdp, PDO::PARAM_STR);
        $query -> execute();
        echo  "<script> alert mdp modifier;</script>";
        header('location:index.php');
// On met a jour la table tblreaders avec le nouveau mot de passe
// On informa l'utilisateur par une fenetre popup de la reussite ou de l'echec de l'operation
}else{ echo "<script> alert mdp non changé;</script>";
}}}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

     <title>Gestion de bibliotheque en ligne | Recuperation de mot de passe </title>
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
     <!-- On insere le titre de la page (RECUPERATION MOT DE PASSE -->
     <div class="container">
		<div class="row">
			<div class="col">
				<h3>RECUPERATION DE MOT DE PASSE</h3>
			</div>
		</div>     
        <!--On insere le formulaire de recuperation-->
        <div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
				<form method="post" onsubmit="return valid();" action="user-forgot-password.php" >
                    <div class="form-group">
						<label>Portable</label><br>
						<input type="text" name="MobileNumber" required>
					</div>
					<div class="form-group">
						<label>Email</label><br>
						<input type="text" name="EmailId" id="mail" onblur="checkAvailability(mail)" required>
                        <span id="answer"></span>
					</div>
                    <div class="form-group">
						<label>Mot de passe</label><br>
						<input type="password" id="Password" name="Password" required>
					</div>
                    <div class="form-group">
						<label>Confirmez le mot de passe</label><br>
						<input type="password" id="checkpassword" name="checkpassword" required>
					</div>

					<div class="form-group">
						<label>Code de vérification</label>
						<input type="text" name="vercode" required style="height:25px;">&nbsp;&nbsp;&nbsp;<img src="captcha.php">
					</div>

					<button type="submit" name="login" id="register" class="btn btn-info">Envoyer</button>&nbsp;&nbsp;&nbsp;
				</form>
			</div>
		</div>
	</div>
     <!--L'appel de la fonction valid() se fait dans la balise <form> au moyen de la propri�t� onSubmit="return valid();"-->
     <script>
        valid();
        function valid(){
            var mdp = document.getElementById("Password");
            var checkmdp = document.getElementById("checkpassword");
            const register = document.getElementById("register");
            checkmdp.addEventListener("keyup", () =>{
            if((mdp.value) === (checkmdp.value)){
                register.disabled = false;
                console.log
            }else{
                register.disabled = true;
            }
            })}
     </script>

     <?php include('includes/footer.php'); ?>
     <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

     
</body>

</html>