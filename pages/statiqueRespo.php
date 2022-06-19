<?php
require('./../phpQueries/conxnBDD.php');

header('Content-Type: application/json');
//nombre des offres
$formation = $_POST['formation'];
$selected = $_POST['option'];
switch ($selected) {
    case 1:
        $req = "SELECT COUNT(distinct(NUM_OFFR)) nbr_offre_total  from 
                    `OFFREDESTAGE` ofr, `NIVEAU` niv where ofr.NUM_NIV=niv.NUM_NIV 
                    and niv.NUM_FORM='$formation'";
        $Smt = $bdd->query($req);
        $nbr_of_offre = $Smt->fetch(2); // arg: PDO::FETCH_ASSOC

        $req = "SELECT COUNT(distinct (E.CNE_ETU)) nbr_etudiant from `ETUDIANT` E,`ETUDIER` ETU, `NIVEAU` niv
                     where E.CNE_ETU=ETU.CNE_ETU and ETU.NUM_NIV=niv.NUM_NIV and niv.NUM_FORM='$formation'";
        $Smt = $bdd->query($req);
        $nbr_of_tt = $Smt->fetch(2); // arg: PDO::FETCH_ASSOC

        $req = "SELECT COUNT(distinct (NUM_ENS)) nbr_enseignant from `ENSEIGNER` 
                     where  NUM_FORM='$formation'";
        $Smt = $bdd->query($req);
        $nbr_of_ens = $Smt->fetch(2); // arg: PDO::FETCH_ASSOC


        $data = array();
        $labels = array('nbr_offre', 'nbr_etu', 'nbr_ens');
        $data[$labels[0]] = $nbr_of_offre['nbr_offre_total'];
        $data[$labels[1]] = $nbr_of_tt['nbr_etudiant'];
        $data[$labels[2]] = $nbr_of_ens['nbr_enseignant'];;
        break;

    case 2:

        $req1 = "SELECT COUNT(off.NUM_OFFR) nbr_nv_off FROM `OFFREDESTAGE` off,NIVEAU niv WHERE niv.NUM_NIV=off.NUM_NIV and off.ETATPUB_OFFR='NOUVEAU' and niv.NUM_FORM='$formation';";
        $Smt1 = $bdd->query($req1);
        $nbr_nv = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

        $req1 = "SELECT COUNT(off.NUM_OFFR) nbr_off_cmp FROM `OFFREDESTAGE` off,NIVEAU niv WHERE niv.NUM_NIV=off.NUM_NIV and off.ETATPUB_OFFR='COMPLETER' and niv.NUM_FORM='$formation';";
        $Smt1 = $bdd->query($req1);
        $nbr_off = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

        $req1 = "SELECT COUNT(off.NUM_OFFR) nbr_off_cls FROM `OFFREDESTAGE` off,NIVEAU niv WHERE niv.NUM_NIV=off.NUM_NIV and off.ETATPUB_OFFR='CLOSE' and niv.NUM_FORM='$formation';";
        $Smt1 = $bdd->query($req1);
        $nbr_off_cls = $Smt1->fetch(2);

        $data = array();
        $labels = array('nbr_nv', 'nbr_off', 'nbr_cls');
        $data[$labels[0]] = $nbr_nv['nbr_nv_off'];
        $data[$labels[1]] = $nbr_off['nbr_off_cmp'];
        $data[$labels[2]] = $nbr_off_cls['nbr_off_cls'];;
        break;
    case 3:

        $req1 = "SELECT COUNT(DISTINCT etu.CNE_ETU) nbr_active_cmp FROM ETUDIANT etu,NIVEAU n,ETUDIER e
                                             WHERE etu.CNE_ETU = e.CNE_ETU
                                               AND e.NUM_NIV=n.NUM_NIV
                                               AND n.NUM_FORM='$formation'
                                               
                                            AND etu.ACTIVE_ETU=0 ";
        $Smt1 = $bdd->query($req1);
        $nbr_active = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

        $req1 = "SELECT COUNT(DISTINCT etu.CNE_ETU) nbr_desactiver_cmp FROM ETUDIANT etu,NIVEAU n,ETUDIER e
                                             WHERE etu.CNE_ETU = e.CNE_ETU
                                               AND e.NUM_NIV=n.NUM_NIV
                                               AND n.NUM_FORM='$formation'
                                               
                                            AND etu.ACTIVE_ETU=1 ";
        $Smt1 = $bdd->query($req1);
        $nbr_desactiver = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC


        $data = array();
        $labels = array('nbr_active', 'nbr_desactiver');
        $data[$labels[0]] = $nbr_active['nbr_active_cmp'];
        $data[$labels[1]] = $nbr_desactiver['nbr_desactiver_cmp'];;
        break;


    case 4:

        $req1 = "SELECT COUNT(DISTINCT NUM_ENS) nbr_active_ens FROM ENSEIGNER 
                                               WHERE NUM_FORM='$formation'
                                            AND ACTIVE_ENS=0  ";
        $Smt1 = $bdd->query($req1);
        $nbr_active = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

        $req1 = "SELECT COUNT(DISTINCT NUM_ENS) nbr_active_ens FROM ENSEIGNER 
                                               WHERE NUM_FORM='$formation'
                                            AND ACTIVE_ENS=1   ";
        $Smt1 = $bdd->query($req1);
        $nbr_desactiver = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC


        $data = array();
        $labels = array('nbr_active', 'nbr_desactiver');
        $data[$labels[0]] = $nbr_active['nbr_active_ens'];
        $data[$labels[1]] = $nbr_desactiver['nbr_active_ens'];;
        break;
    case 6:

        $req1 = "       SELECT ent.NUM_ENT,ent.LIBELLE_ENT societe, sum(stg.NUM_STG) somme FROM offredestage offr ,entreprise ent,NIVEAU niv,stage stg
            WHERE ent.NUM_ENT=offr.NUM_ENT and stg.NUM_OFFR=offr.NUM_OFFR  and niv.NUM_NIV=offr.NUM_NIV and niv.NUM_FORM='$formation' GROUP by ent.NUM_ENT,ent.LIBELLE_ENT;
            ";
        $Smt1 = $bdd->query($req1);
        $offre_stat = $Smt1->fetchAll(2); // arg: PDO::FETCH_ASSOC

        $data = array();

        foreach ($offre_stat as $item) {
            $data[$item['societe']] = $item;
        };
        break;
    case 7:

        $req1 = "SELECT ent.NUM_ENT,ent.LIBELLE_ENT societe, COUNT(stg.NUM_STG) somme FROM offredestage offr ,entreprise ent,NIVEAU niv,stage stg
            WHERE stg.NUM_OFFR=offr.NUM_OFFR and   ent.NUM_ENT=offr.NUM_ENT and niv.NUM_NIV=offr.NUM_NIV and niv.NUM_FORM='$formation' GROUP by ent.NUM_ENT,ent.LIBELLE_ENT; ";
        $Smt1 = $bdd->query($req1);
        $stage_stat = $Smt1->fetchAll(2); // arg: PDO::FETCH_ASSOC

        $data = array();

        foreach ($stage_stat as $item) {
            $data[$item['societe']] = $item;
        };
        break;
    case 8:

        $req1 = "select niv.LIBELLE_NIV as societe,count(etu.CNE_ETU) as somme FROM niveau niv,etudier etu
        WHERE niv.NUM_NIV=etu.NUM_NIV
    AND niv.NUM_FORM='$formation'
    AND etu.DATE_NIV BETWEEN CURRENT_DATE-180 AND CURRENT_DATE
 GROUP BY niv.LIBELLE_NIV;";
        $Smt1 = $bdd->query($req1);
        $stage_stat = $Smt1->fetchAll(2); // arg: PDO::FETCH_ASSOC

        $data = array();

        foreach ($stage_stat as $item) {
            $data[$item['societe']] = $item;
        };
        break;




}

{
}


/*
foreach ($result as $row) {
    $data[] = $row;
}*/

echo json_encode($data);
?>