<?php

$req_etudiant_info = "SELECT * from ETUDIANT 
                WHERE CNE_ETU='$etudiant_cne'";
$Smt_etudiant_info = $bdd->query($req_etudiant_info);
$etudiant_info = $Smt_etudiant_info->fetch(PDO::FETCH_ASSOC);

?>
