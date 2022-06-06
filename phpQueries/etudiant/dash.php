<?php
require(__DIR__ . './../../phpQueries/conxnBDD.php');
require(__DIR__ . './../../phpQueries/authen.php');
$etudiant_cne=$_SESSION['auth'];
require(__DIR__ . './../../phpQueries/etudiant/etudiant-info.php');
require(__DIR__ . './../../phpQueries/etudiant/etudiant-niveau.php');

$niveau =$etudiant_niveau['NUM_NIV'];
require(__DIR__ . './../../phpQueries/etudiant/etudiant-offres.php');

$villes=array_column($etudiant_offres ,"VILLE_OFFR");
?>
