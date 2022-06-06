<?php
require(__DIR__ . './../../phpQueries/conxnBDD.php');
require(__DIR__ . './../../phpQueries/authen.php');
$etudiant_cne=$_SESSION['auth'];
require(__DIR__ . './../../phpQueries/etudiant/etudiant-info.php');
require(__DIR__ . './../../phpQueries/etudiant/etudiant-niveau.php');
$niveau =$etudiant_niveau['NUM_NIV'];
$req_formation_niveau = "SELECT * from NIVEAU niv,FORMATION fo 
                WHERE niv.NUM_FORM=fo.NUM_FORM
                AND   niv.NUM_NIV ='$niveau'
                ORDER BY niv.NUM_FORM  DESC";
$Smt_formation_niveau= $bdd->query($req_formation_niveau);
$formation_niveau = $Smt_formation_niveau->fetchAll(PDO::FETCH_ASSOC);

?>
