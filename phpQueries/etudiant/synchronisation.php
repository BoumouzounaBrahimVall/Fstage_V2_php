<?php
//require( __DIR__.'./../phpQueries/etudiant/dash.php');
//require( __DIR__.'../../phpQueries/respoRequiries.php'); 
require(__DIR__ . './../../phpQueries/conxnBDD.php');


function update_etat_offre($numOffre,$bdd)
{
    $req_update_etat_offre="UPDATE OFFREDESTAGE set OFFREDESTAGE.ETATPUB_OFFR='CLOSE';";
    $update_etat =$bdd->exec($req_update_etat_offre);
}


function update_etat_offre_privee($numOffre,$bdd)
{
    $req_update_etat_offre_pr="UPDATE OFFREDESTAGE set OFFREDESTAGE.ETATPUB_OFFR='COMPLETER';";
    $update_etat_pr =$bdd->exec($req_update_etat_offre_pr);
}




//CLOSE

function Synchronisation_offre_date($bdd)
{
$req_synchOffre="SELECT * from OFFREDESTAGE ";
$Smt_synchOffre = $bdd->query($req_synchOffr);
$fitch_synchro =$Smt_synchOffro->fetch(PDO::FETCH_ASSOC);

foreach($fitch_synchro as $V)
{
    if($V['DATEFIN_OFFR']>=date("Y-m-d"))
    {
       update_etat_offre($V['NUM_OFFR']);
    };
}



}

/* fonction qui teste si l offre est terminer */
function offre_terminer($numOffre,$bdd)
{
$req_nbr_accepter="SELECT count(POSTULER.NUM_OFFR) as nbr from POSTULER where POSTULER.NUM_OFFR='$numOffre' and POSTULER.ETATS_POST='ACCEPTER'; ";
$nbr_accepter = $bdd->query($req_nbr_accepter);
$fitch_nbr =$nbr_accepter->fetch(PDO::FETCH_ASSOC);
return $fitch_nbr['nbr'];
}


//COMPLETER(ANNULER)
function Synchronisation_offre_effectif($bdd)
{ 
    $req_synchOffre="SELECT * from OFFREDESTAGE ";
    $Smt_synchOffre = $bdd->query($req_synchOffre);
    $fitch_synchro =$Smt_synchOffre->fetchAll(2);

     foreach($fitch_synchro as $V)
     {$kkk=offre_terminer($V['NUM_OFFR'],$bdd);
      if($kkk==$V['EFFECTIF_OFFRE'])
      {
        
         update_etat_offre_privee($V['NUM_OFFR'],$bdd);
      }
     }


}




?>