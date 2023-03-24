<?php
// On récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');
//include('check_availability.php');

if (TRUE === isset($_POST['login'])) {
	// Après la soumission du formulaire de login ($_POST['login'] existe - voir pourquoi plus bas)
	// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
	// $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)
	if ($_POST['vercode'] != $_SESSION['vercode']) {
		// Le code est incorrect on informe l'utilisateur par une fenetre pop_up
		"<script> alert ('Code de vérification incorrect')</script>";
	} else {
//On lit le contenu du fichier readerid.txt au moyen de la fonction 'file'. Ce fichier contient le dernier identifiant lecteur cree.
$reader_id = file_get_contents('readerid.txt');

// On incrémente de 1 la valeur lue
$reader_id++;
// On ouvre le fichier readerid.txt en écriture
$reader= fopen('readerid.txt',"w");
// On écrit dans ce fichier la nouvelle valeur
fwrite($reader, $reader_id);
// On referme le fichier
fclose ($reader);

// On récupère le nom saisi par le lecteur
$name = $_POST['FullName']; 
// On récupère le numéro de portable
$telephone = $_POST['MobileNumber'];
// On récupère l'email
$email = $_POST['EmailId'];
// On récupère le mot de passe
$mdp = password_hash($_POST['Password'],PASSWORD_DEFAULT);
// On fixe le statut du lecteur à 1 par défaut (actif)
$status = 1;
// On prépare la requete d'insertion en base de données de toutes ces valeurs dans la table tblreaders
$sql = "INSERT INTO tblreaders(ReaderId,FullName, MobileNumber, EmailId, Password, Status) VALUES(:ReaderId, :FullName, :MobileNumber, :EmailId, :Password, :Status)";

// On éxecute la requete
    $query = $dbh -> prepare($sql);
    $query ->bindParam(':ReaderId',$reader_id, PDO::PARAM_STR);
    $query ->bindParam(':FullName',$name, PDO::PARAM_STR);
    $query ->bindParam(':MobileNumber',$telephone, PDO::PARAM_INT);
    $query ->bindParam(':EmailId',$email, PDO::PARAM_STR);
    $query ->bindParam(':Password',$mdp, PDO::PARAM_STR);
    $query ->bindParam(':Status',$status, PDO::PARAM_INT);
    $query -> execute();

// On récupère le dernier id inséré en bd (fonction lastInsertId)
$last_id = $dbh ->lastInsertId();
// Si ce dernier id existe, on affiche dans une pop-up que l'opération s'est bien déroulée, et on affiche l'identifiant lecteur (valeur de $hit[0])
   if($last_id){
    echo "<script> alert('cest ok'+'.$reader_id.');</script>";
   }
// Sinon on affiche qu'il y a eu un problème
else{
   echo "<script> alert('cest pas ok');</script>";
   }
}}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Gestion de bibliotheque en ligne | Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        
        // On cree une fonction valid() sans paramètre qui renvoie 
        // TRUE si les mots de passe saisis dans le formulaire sont identiques
        // FALSE sinon
        
        // On cree une fonction avec l'email passé en paramêtre et qui vérifie la disponibilité de l'email
        let mail = document.getElementById("mail");
        function checkAvailability(mail){
            let span = document.getElementById("answer");
                console.log(mail);
                console.log(mail.value);
            fetch('check_availability.php?mail='+mail.value)
            .then(rep => rep.json())
            .then(data => {
                console.log(data)

                switch(data){
                    case 1 :
                        span.innerHTML = "Est un mail déjà pris.";
                        break;
                    case 2:
                        span.innerHTML = "Est une adresse disponible.";
                        break;
                    case 3:
                        span.innerHTML = "N'est pas une adresse valide.";
                        break;
                    default:
                        break;
                }
       })
    }
    </script>
</head>

<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
    <?php include('includes/header.php'); ?>
    <!--On affiche le titre de la page : CREER UN COMPTE-->
    <!--On affiche le formulaire de creation de compte-->
    <!--A la suite de la zone de saisie du captcha, on insère l'image créée par captcha.php : <img src="captcha.php">  -->
    <!-- On appelle la fonction valid() dans la balise <form> onSubmit="return valid(); -->
    <!-- On appelle la fonction checkAvailability() dans la balise <input> de l'email onBlur="checkAvailability(this.value)" -->
    <div class="container">
		<div class="row">
			<div class="col">
				<h3>CREER UN COMPTE</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
				<form method="post" onsubmit="return valid();" action="signup.php" >
                <div class="form-group">
						<label>Entrez votre nom complet</label><br>
						<input type="text" name="FullName" required>
					</div>
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

					<button type="submit" name="login" id="register" class="btn btn-info">Enregistrer</button>&nbsp;&nbsp;&nbsp;
				</form>
			</div>
		</div>
	</div>

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

            let mail = document.getElementById("mail");
            
        function checkAvailability(mail){
            let span = document.getElementById("answer");
                console.log(mail);
                console.log(mail.value);
            fetch('check_availability.php?mail='+mail.value)
            .then(rep => rep.json())
            .then(data => {
                console.log(data)

                switch(data){
                    case 1 :
                        span.innerHTML = "Est un mail déjà pris.";
                        break;
                    case 2:
                        span.innerHTML = "Est une adresse disponible.";
                        break;
                    case 3:
                        span.innerHTML = "N'est pas une adresse valide.";
                        break;
                    default:
                        break;
                }
       })
    }
        </script>
    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>