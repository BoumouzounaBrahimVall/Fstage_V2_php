<?php

require(__DIR__ . './../../phpQueries/etudiant/dash.php');

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




$num_stage=@$stage_actulle['NUM_STG'];

//Rappot de stage
$req_Rap_Actuel= "SELECT * from  rapport rap WHERE   rap.NUM_STG='$num_stage';";
// and st.DATEFIN_STG >='$date'
$Smt_Rap_Actuel= $bdd->query($req_Rap_Actuel);
$Rap_Actuel = $Smt_Rap_Actuel->fetch(PDO::FETCH_ASSOC);
$rapportStageActuel=@$Rap_Actuel['PATH_RAP'];
if(empty($rapportStageActuel)) $rapportStageActuel='#';
//liste de jury du stage
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
