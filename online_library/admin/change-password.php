<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
}else{
    if (TRUE === isset($_POST['up-date'])) {
        $name = $_SESSION['alogin'];

        $sql = "SELECT * FROM admin WHERE FullName=:name";
        $query=$dbh->prepare($sql);
        // $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
        $result= $query->fetch(PDO::FETCH_OBJ);

    if(!empty($result) && password_verify($_POST['OldPassword'], $result->Password)){
        $newmdp = validation($_POST['Password']);
        $newpassword = password_hash($newmdp, PASSWORD_DEFAULT);
        $sql = "UPDATE admin SET Password=:Password WHERE FullName=:name";
     $query = $dbh->prepare($sql);
     $query->bindParam(':Password',$newpassword, PDO::PARAM_STR);
     $query->bindParam(':name', $name, PDO::PARAM_STR);
     $query->execute();
     echo '<script>alert ("mot de passe modifié"); </script>';
    }else{
        echo '<script>alert ("erreur dans la modification du mot de passe"); </script>';
    }
    }
}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Gestion bibliotheque en ligne</title>
	<!-- BOOTSTRAP CORE STYLE  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- FONT AWESOME STYLE  -->
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLE  -->
	<link href="assets/css/style.css" rel="stylesheet" />
	<!-- Penser a mettre dans la feuille de style les classes pour afficher le message de succes ou d'erreur  -->
</head>


<body>
	<!------MENU SECTION START-->
	<?php include('includes/header.php'); ?>
	<!<div class="container">
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

	<?php include('includes/footer.php'); ?>
	<!-- FOOTER SECTION END-->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>