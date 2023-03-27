<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');
if(strlen($_SESSION['login'])==0) {
    header('location:index.php');
}else{
    if (TRUE === isset($_POST['up-date'])) {
        $mail = $_SESSION['login'];

        $sql = "SELECT * FROM tblreaders WHERE EmailId=:mail";
        $query=$dbh->prepare($sql);
        // $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->execute();
        $result= $query->fetch(PDO::FETCH_OBJ);

    if(!empty($result) && password_verify($_POST['OldPassword'], $result->Password)){
        $newmdp = $_POST['Password'];
        $newpassword = password_hash($newmdp, PASSWORD_DEFAULT);
        $sql = "UPDATE tblreaders SET Password=:Password WHERE EmailId=:mail";
     $query = $dbh->prepare($sql);
     $query->bindParam(':Password',$newpassword, PDO::PARAM_STR);
     $query->bindParam(':mail', $mail, PDO::PARAM_STR);
     $query->execute();
     echo '<script>alert ("mot de passe modifié"); </script>';
    }else{
        echo '<script>alert ("erreur dans la modification du mot de passe"); </script>';
    }
    }
}
// Si l'utilisateur n'est pas logue, on le redirige vers la page de login (index.php)
// sinon, on peut continuer,
// si le formulaire a ete envoye : $_POST['change'] existe
// On recupere le mot de passe et on le crypte (fonction php password_hash)
// On recupere l'email de l'utilisateur dans le tabeau $_SESSION
// On cherche en base l'utilisateur avec ce mot de passe et cet email
// Si le resultat de recherche n'est pas vide
// On met a jour en base le nouveau mot de passe (tblreader) pour ce lecteur
// On stocke le message d'operation reussie
// sinon (resultat de recherche vide)
// On stocke le message "mot de passe invalide"

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<title>Gestion de bibliotheque en ligne | changement de mot de passe</title>
	<!-- BOOTSTRAP CORE STYLE  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- FONT AWESOME STYLE  -->
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLE  -->
	<link href="assets/css/style.css" rel="stylesheet" />

	<!-- Penser au code CSS de mise en forme des message de succes ou d'erreur -->

</head>
<script type="text/javascript">
	/* On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques 
	Cette fonction retourne un booleen*/
</script>

<body>
	<!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
	<?php include('includes/header.php'); ?>
	<!--On affiche le titre de la page : CHANGER MON MOT DE PASSE-->
	<!--  Si on a une erreur, on l'affiche ici -->
	<!--  Si on a un message, on l'affiche ici -->
	<div class="container">
		<div class="row">
			<div class="col">
				<h3>CHANGEMENT DE MOT DE PASSE</h3>
			</div>
		</div>     
        <!--On insere le formulaire de recuperation-->
        <div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
				<form method="post" onsubmit="return valid();" action="change-password.php" >
					<div class="form-group">
						<label>Ancien mot de passe</label><br>
						<input type="password" id="OldPassword" name="OldPassword" required>
					</div>
                    <div class="form-group">
						<label>Nouveau mot de passe</label><br>
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

					<button type="submit" name="up-date" id="register" class="btn btn-info">Envoyer</button>&nbsp;&nbsp;&nbsp;
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

	<!--On affiche le formulaire-->
	<!-- la fonction de validation de mot de passe est appelee dans la balise form : onSubmit="return valid();"-->


	<?php include('includes/footer.php'); ?>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>