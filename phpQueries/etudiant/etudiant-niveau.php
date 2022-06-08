<?php

$req_etudiant_niveau = "SELECT NUM_NIV from ETUDIER
                WHERE CNE_ETU='$etudiant_cne'
                ORDER BY DATE_NIV DESC";
$Smt_etudiant_niveau = $bdd->query($req_etudiant_niveau);
$etudiant_niveaux = $Smt_etudiant_niveau->fetchAll(PDO::FETCH_ASSOC);
$etudiant_niveau =$etudiant_niveaux[0];

?>
