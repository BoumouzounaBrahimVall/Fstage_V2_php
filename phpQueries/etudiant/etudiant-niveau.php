<?php
$req_etudiant_niveau = "SELECT NUM_NIV from ETUDIER 
                WHERE CNE_ETU='$etudiant_cne'";
$Smt_etudiant_niveau = $bdd->query($req_etudiant_niveau);
$etudiant_niveau = $Smt_etudiant_niveau->fetch(PDO::FETCH_ASSOC);

?>
