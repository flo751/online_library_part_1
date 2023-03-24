<?php
// On demarre ou on recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// On invalide le cache de session $_SESSION['alogin'] = ''
if (isset($_SESSION['login']) && $_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}

if (TRUE === isset($_POST['login'])) {
	// Après la soumission du formulaire de login ($_POST['login'] existe - voir pourquoi plus bas)
	// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
	// $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)
	if ($_POST['vercode'] != $_SESSION['vercode']) {
		// Le code est incorrect on informe l'utilisateur par une fenetre pop_up
		echo "<script>alert('Code de vérification incorrect')</script>";
	}else{
// Le code est correct, on peut continuer
// On recupere le nom de l'utilisateur saisi dans le formulaire
		$username = $_POST['FullName'];
// On recupere le mot de passe saisi par l'utilisateur et on le crypte (fonction md5)
		$password = md5($_POST['Password']);
// On construit la requete qui permet de retrouver l'utilisateur a partir de son nom et de son mot de passe
// depuis la table admin
$sql = "SELECT FullName, Password FROM admin  WHERE Fullname = :FullName";
		$query = $dbh->prepare($sql);
		$query->bindParam(':FullName', $username, PDO::PARAM_STR);
		//$query->bindParam(':Password',$password, PDO::PARAM_STR);
		// On execute la requete
		$query->execute();
		// On stocke le resultat de recherche dans une variable $result
		$result = $query->fetch(PDO::FETCH_OBJ);
// Si le resultat de recherche n'est pas vide 
if(!empty($result) && password_verify($_POST['Password'], $result->Password)){
	// On stocke le nom de l'utilisateur  $_POST['username'] en session $_SESSION
	$_SESSION['alogin'] = $_POST['FullName'];
	header('location:admin/dashboard.php');
	//var_dump($_SESSION);
				// l'utilisateur est redirige vers dashboard.php
}else{
	echo'<script> alert ta mère</script>';
}
// On redirige l'utilisateur vers le tableau de bord administration (n'existe pas encore)

// sinon le login est refuse. On le signal par une popup
	}}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
    <?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <!--On affiche le titre de la page-->
        <div class="container">
		<div class="row">
			<div class="col">
				<h3>LOGIN ADMIN</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
				<form method="post">
					<div class="form-group">
						<label>Entrez nom</label>
						<input type="text" name="FullName" required>
					</div>

					<div class="form-group">
						<label>Entrez votre mot de passe</label>
						<input type="password" name="Password" required>
						<p>
							<a href="user-forgot-password.php">Mot de passe oublié ?</a>
						</p>
					</div>

					<div class="form-group">
						<label>Code de vérification</label>
						<input type="text" name="vercode" required style="height:25px;">&nbsp;&nbsp;&nbsp;<img src="captcha.php">
					</div>

					<button type="submit" name="login" class="btn btn-info">LOGIN</button>&nbsp;&nbsp;&nbsp;<a href="signup.php">Je n'ai pas de compte</a>
				</form>
			</div>
		</div>
	</div>
        <!--On affiche le formulaire de login-->

        <!--A la suite de la zone de saisie du captcha, on ins�re l'image cr��e par captcha.php : <img src="captcha.php">  -->
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>