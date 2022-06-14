<?php
require(__DIR__ . './../../phpQueries/etudiant/dash.php');

$req_formation_niveau = "SELECT * from NIVEAU niv,FORMATION fo 
                WHERE niv.NUM_FORM=fo.NUM_FORM
                AND   niv.NUM_NIV ='$niveau'
                ORDER BY niv.NUM_FORM  DESC";
$Smt_formation_niveau= $bdd->query($req_formation_niveau);
$formation_niveau = $Smt_formation_niveau->fetchAll(PDO::FETCH_ASSOC);

?>
