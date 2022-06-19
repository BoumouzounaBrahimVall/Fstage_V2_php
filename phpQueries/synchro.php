<?php
//CLOSE
function update_etat_offre($numOffre,$bdd)
{
    $req_update_etat_offre="UPDATE OFFREDESTAGE set OFFREDESTAGE.ETATPUB_OFFR='CLOSE' where NUM_OFFR='$numOffre';";
    $bdd->exec($req_update_etat_offre);
}
function Synchronisation_offre_date($bdd)
{
    $req_synchOffre = "SELECT * from OFFREDESTAGE ";
    $Smt_synchOffre = $bdd->query($req_synchOffre);
    $fitch_synchro = $Smt_synchOffre->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fitch_synchro as $V) {
        if ($V['DATEFIN_OFFR'] <= date("Y-m-d")) {
            update_etat_offre($V['NUM_OFFR'], $bdd);
        };
    }

}



/* fonction qui teste si l offre est terminer */
function offre_terminer($numOffre,$bdd)
{
    $req_nbr_accepter="SELECT count(POSTULER.NUM_OFFR) as nbr from POSTULER where POSTULER.NUM_OFFR='$numOffre' and POSTULER.ETATS_POST='ACCEPTER'; ";
    $nbr_accepter = $bdd->query($req_nbr_accepter);
    $ftch_nbr =$nbr_accepter->fetch(PDO::FETCH_ASSOC);
    return $ftch_nbr['nbr'];
}
function update_offre_complete($numOffre,$bdd)
{
    $req_update_etat_offre_pr="UPDATE OFFREDESTAGE set OFFREDESTAGE.ETATPUB_OFFR='COMPLETÉ' where NUM_OFFR='$numOffre' ;";
    $bdd->exec($req_update_etat_offre_pr);
}

//COMPLETER
function Synchronisation_offre_effectif($bdd)
{
    $req_synchOffre="SELECT * from OFFREDESTAGE where ETATPUB_OFFR!='CLOSE'";
    $Smt_synchOffre = $bdd->query($req_synchOffre);
    $fitch_synchro =$Smt_synchOffre->fetchAll(2);

    foreach($fitch_synchro as $V)
    {$nbr_effct_Acc=offre_terminer($V['NUM_OFFR'],$bdd);
        if($nbr_effct_Acc==$V['EFFECTIF_OFFRE'])
        {
            update_offre_complete($V['NUM_OFFR'],$bdd);
        }
    }
}
function update_etat_expire($bdd,$cne_etu_synch,$numOffre_synch)
{
    $req_update_etat_expire="UPDATE POSTULER set POSTULER.ETATS_POST='EXPIRER' where CNE_ETU='$cne_etu_synch' and NUM_OFFR='$numOffre_synch';";
    $bdd->exec($req_update_etat_expire);
}



function Synchronisation_post_expirer($bdd)
{
    $req_etat_expirer= "SELECT pos.NUM_OFFR, offre.DELAI_JOFFR, pos.date_reponse ,pos.CNE_ETU FROM POSTULER pos,OFFREDESTAGE offre
   
            WHERE pos.NUM_OFFR = offre.NUM_OFFR AND pos.ETATS_POST= 'RETENU';
                        ";
    $Smt_etat_expirer = $bdd->query($req_etat_expirer);
    $etat_expirer = $Smt_etat_expirer->fetchAll(PDO::FETCH_ASSOC);
    foreach($etat_expirer as $V){
        $jour_offr=$V['DELAI_JOFFR'];
        $date_rep=$V['date_reponse'];
        $date_expiration=date('Y-m-d',strtotime( $date_rep. ' + '.$jour_offr.' days'));
        if($date_expiration<=date("Y-m-d"))
        {
            update_etat_expire($bdd,$V['CNE_ETU'],$V['NUM_OFFR']);
        }

    }


}


//liste d attente(apres click button non valider)
function update_post_attente($bdd,$cne_etu_synch,$numOffre_synch,$etat_offre)
{
    
    if(strcmp($etat_offre,"1")==0)
    {
       
        //etablir un stage
        $req_stage= "
                        INSERT INTO STAGE (NUM_OFFR,CNE_ETU,ACTIVE_STG)
                        VALUES ('$numOffre_synch','$cne_etu_synch' ,'0')
                ";
        $stage_response = $bdd->exec($req_stage);
        $req_update_etat_expire="UPDATE POSTULER set POSTULER.ETATS_POST='RETENU' where CNE_ETU='$cne_etu_synch' and NUM_OFFR='$numOffre_synch';";
        $bdd->exec($req_update_etat_expire);

    }
    else if(strcmp($etat_offre,"2")==0){
        $req_update_etat_expire="UPDATE POSTULER set POSTULER.ETATS_POST='1' where CNE_ETU='$cne_etu_synch' and NUM_OFFR='$numOffre_synch';";
        $bdd->exec($req_update_etat_expire);
    }
    
    else if(strcmp($etat_offre,"3")==0){
        $req_update_etat_expire="UPDATE POSTULER set POSTULER.ETATS_POST='2' where CNE_ETU='$cne_etu_synch' and NUM_OFFR='$numOffre_synch';";
        $bdd->exec($req_update_etat_expire);
    }
   

   

}
//Liste attente
function Synchronisation_offre_attente($bdd)
{
    $req_synchOffre="SELECT * from POSTULER where POSTULER.ETATS_POST not in('ACCEPTER','NO ACCEPTER','RETENU');";
    $Smt_synchOffre = $bdd->query($req_synchOffre);
    $fitch_synchro =$Smt_synchOffre->fetchAll(2);

    foreach($fitch_synchro as $V)
    {
        update_post_attente($bdd,$V['CNE_ETU'],$V['NUM_OFFR'],$V['ETATS_POST']);
    }
}


?>
