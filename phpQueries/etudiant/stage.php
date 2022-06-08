<?php
require(__DIR__ . './../../phpQueries/conxnBDD.php');
require(__DIR__ . './../../phpQueries/authen.php');

$etudiant_cne=$_SESSION['auth'];
require(__DIR__ . './../../phpQueries/etudiant/etudiant-info.php');

$date=date("Y-m-d");
$req_stage_actulle= "SELECT * from STAGE st,OFFREDESTAGE offre,ENTREPRISE ent 
                        WHERE   offre.NUM_OFFR=st.NUM_OFFR
                        and offre.NUM_ENT = ent.NUM_ENT 
                        and st.CNE_ETU='$etudiant_cne'
                        and st.DATEFIN_STG >='$date'
                ";
$Smt_stage_info = $bdd->query($req_stage_actulle);
$stage_actulle = $Smt_stage_info->fetch(PDO::FETCH_ASSOC);

//liste de jury du stage
$num_stage=$stage_actulle['NUM_STG'];
$req_jury= "SELECT * from STAGE st,JUGER jr,ENSEIGNANT ens
                        WHERE   st.NUM_STG=jr.NUM_STG
                        and ens.NUM_ENS = jr.NUM_ENS 
                        and st.NUM_STG='$num_stage'
                ";
$Smt_jury_info = $bdd->query($req_jury);
$stage_jury = $Smt_jury_info->fetchAll(PDO::FETCH_ASSOC);


?>
