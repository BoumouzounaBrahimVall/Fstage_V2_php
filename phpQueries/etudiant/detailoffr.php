<?php
//require(__DIR__ . './../../phpQueries/conxnBDD.php');
//require(__DIR__ . './../../phpQueries/authen.php');
require(__DIR__ . './../../phpQueries/etudiant/dash.php');

$numOffre=$_GET['noffr'];
$nivOffre=$_GET['niv'];
$req_offre= "SELECT * from OFFREDESTAGE offre,ENTREPRISE ent,NIVEAU niv
                        WHERE offre.NUM_ENT = ent.NUM_ENT 
                        and   offre.NUM_OFFR='$numOffre'
                        and   offre.NUM_NIV='$nivOffre'
                ";
$Smt_offre_info = $bdd->query($req_offre);
$offre_stage = $Smt_offre_info->fetch(PDO::FETCH_ASSOC);


?>