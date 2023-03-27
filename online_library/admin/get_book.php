<?php 

require_once("includes/config.php");

$isbn = $_GET['isbn'];
            

			
			if($isbn){
            $sql = "SELECT * FROM tblreaders WHERE ISBNNumber = :isbn";
            $query = $dbh -> prepare($sql);
            $query->bindParam(":isbn" , $isbn, PDO::PARAM_STR);
			$query->execute();
            $result = $query->fetch();
			if(empty($result)){
				echo json_encode (['caca'=>'ISBN non valide'])
			}else{
				echo json_encode(['caca' => $result['BookName']])
			}}
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
