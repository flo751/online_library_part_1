<?php 
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero l'identifiant du lecteur SID---*/
require_once("includes/config.php");

$sdi = $_GET['sdi'];
            

			// On prepare la requete de recherche du lecteur correspondnat
			// On execute la requete
			// Si un resultat est trouve
			if($sdi){
            $sql = "SELECT * FROM tblreaders WHERE ReaderId = :sdi";
            $query = $dbh -> prepare($sql);
            $query->bindParam(":sdi" , $sdi, PDO::PARAM_STR);
			$query->execute();
            $result = $query->fetch();
			if($result['Status'] === "0"){
				echo json_encode (['caca'=>'lecteur bloqué'])
			}else{
				echo json_encode(['caca' => $result['FullName']])
			}}
	// On affiche le nom du lecteur
	// On active le bouton de soumission du formulaire
// Sinon
	// Si le lecteur n existe pas
		// On affiche que "Le lecteur est non valide"
		// On desactive le bouton de soumission du formulaire
	// Si le lecteur est bloque
		// On affiche lecteur bloque
		// On desactive le bouton de soumission du formulaire

?>
