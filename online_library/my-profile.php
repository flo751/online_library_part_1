<?php 
// On r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
  header('location:index.php');
  // Sinon on peut continuer. Apr�s soumission du formulaire de profil
} else {

    $reader_id=$_SESSION['rdid'];	

    $sql = "SELECT * FROM tblreaders WHERE ReaderId = :rdid";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':rdid', $reader_id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    	// On recupere l'id du lecteur (cle secondaire)
        if($result['Status']=== "1"){
            $result['Status']= "actif";
        }else{
            $result['Status']= "inactif";
        }

            $fullname= $result['FullName'];
            $telephone = $result['MobileNumber'];
            $email = $result['EmailId'];
        
        // On recupere le nom complet du lecteur
        if (TRUE === isset($_POST['update'])) {

            $newname= $_POST['fullname'];
            $newtelephone = $_POST['mobilenumber'];
            $newemail = $_POST['emailid'];
            if(!$newname){
                $newname = $fullname;
            }
            if(!$newtelephone){
                $newtelephone = $telephone;
            }
            if(!$newemail){
                $newemail = $email;
            }
            $sql = "UPDATE tblreaders SET Fullname= :fullname, EmailId= :emailid, MobileNumber= :mobilenumber
            WHERE ReaderId = :rdid";
        
        // On éxecute la requete
            $query = $dbh -> prepare($sql);
            $query ->bindParam(':fullname',$newname, PDO::PARAM_STR);
            $query ->bindParam(':mobilenumber',$newtelephone, PDO::PARAM_STR);
            $query ->bindParam(':emailid',$newemail, PDO::PARAM_STR);
            $query->bindParam(':rdid', $reader_id, PDO::PARAM_STR);
            $query -> execute();
            header('location:my-profile.php');
        // On prepare la requete permettant d'obtenir 
        }
        // On recupere le numero de portable

		// On update la table tblreaders avec ces valeurs
        // On informe l'utilisateur du resultat de l'operation
       

}

	// On souhaite voir la fiche de lecteur courant.
	// On recupere l'id de session dans $_SESSION
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Profil</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />

</head>
<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php');?>
<!--On affiche le titre de la page : EDITION DU PROFIL-->
<div class="container">
        <div class="row">
            <div class="col">
                <h3>MON COMPTE</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <form method="post" action="my-profile.php" >
                <div class="form-group">Identifiant lecteur : <?php echo($result['ReaderId']);?></div>
                <div class="form-group">Date enregistrement : <?php echo($result['RegDate']);?></div>
                <div class="form-group">Date de la dernière mise à jour du compte : <?php echo($result['UpdateDate']);?></div>
                <div class="form-group">Statut du lecteur : <?php echo($result['Status']);?></div>

                    <div class="form-group">
                        <label>Entrez votre nom</label>
                        <input type="text" name="fullname" placeholder="<?php echo($result['FullName']);?>">
                    </div>
                    <div class="form-group">
                        <label>Entrez votre numéro de téléphone</label>
                        <input type="tel" name="mobilenumber"  placeholder="<?php echo($result['MobileNumber']);?>">
                    </div>
                    <div class="form-group">
                        <label>Entrez votre email</label>
                        <input type="text" name="emailid" id ="mail" onblur="availability(mail)"  placeholder="<?php echo($result['EmailId']);?>">
                        <span id="answer"></span>
                    </div>
                    <button type="submit" name="update" class="btn btn-info" <?php $status ?>>VALIDER</button>
                </form>
            </div>
        </div>
</div>
 <!--On affiche le formulaire-->
            <!--On affiche l'identifiant - non editable-->

			<!--On affiche la date d'enregistrement - non editable-->

            <!--On affiche la date de derniere mise a jour - non editable-->

			<!--On affiche la statut du lecteur - non editable-->

			<!--On affiche le nom complet - editable-->

			<!--On affiche le numero de portable- editable-->

			<!--On affiche l'email- editable-->
 
    <?php include('includes/footer.php');?>
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

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
</body>
</html>
