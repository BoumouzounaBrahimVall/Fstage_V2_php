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
                        ORDER BY st.NUM_STG DESC
                       
                ";
// and st.DATEFIN_STG >='$date'
$Smt_stage_info = $bdd->query($req_stage_actulle);
$stage_actulle = $Smt_stage_info->fetch(PDO::FETCH_ASSOC);

//liste de jury du stage
$num_stage=@$stage_actulle['NUM_STG'];
$req_jury= "SELECT * from STAGE st,JUGER jr,ENSEIGNANT ens
                        WHERE   st.NUM_STG=jr.NUM_STG
                        and ens.NUM_ENS = jr.NUM_ENS 
                        and st.NUM_STG='$num_stage'
                ";
$Smt_jury_info = $bdd->query($req_jury);
$stage_jury = $Smt_jury_info->fetchAll(PDO::FETCH_ASSOC);



$req_stage_preced= "SELECT * from STAGE st,OFFREDESTAGE offre,ENTREPRISE ent 
                        WHERE   offre.NUM_OFFR=st.NUM_OFFR
                        and offre.NUM_ENT = ent.NUM_ENT 
                        and st.CNE_ETU='$etudiant_cne'
                        and st.NUM_STG!='$num_stage'
                       
                ";
$Smt_stage_preced = $bdd->query($req_stage_preced);
$stage_preced = $Smt_stage_preced->fetchAll(PDO::FETCH_ASSOC);

// and st.DATEFIN_STG
function getJuryName($stage_jury)
{
    foreach ($stage_jury as $jury)
    {
        if ($jury['EST_ENCADRER']==1) return $jury['PRENOM_ENS'].'  ' . $jury['NOM_ENS'];
    }
}

?>
