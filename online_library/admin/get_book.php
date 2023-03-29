<?php 

require_once("includes/config.php");

$isbn = $_GET['isbn'];
            
error_log(print_r($_GET, 1));
			
			if($isbn){
            $sql = "SELECT * FROM tblbooks WHERE ISBNNumber = :isbn";
            $query = $dbh -> prepare($sql);
            $query->bindParam(":isbn" , $isbn, PDO::PARAM_INT);
			$query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
			error_log(print_r($result, 1));
			error_log("TEST : ".empty($result));
			if(empty($result)){
				error_log("OK1");
				echo json_encode(['caca'=>'ISBN non valide']);
			}else{
				error_log("OK2");
				echo json_encode(['caca' => "{$result['BookName']}"]);
			}}else{
				error_log("OK3");
				echo json_encode(['caca'=>'ISBN non disponible']);
			}
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero ISBN du livre*/
// On prepare la requete de recherche du livre correspondnat
// On execute la requete
// Si un resultat est trouve
	// On affiche le nom du livre
	// On active le bouton de soumission du formulaire
// Sinon
	// On affiche que "ISBN est non valide"
	// On desactive le bouton de soumission du formulaire 
?>
