<?php
$req_etudiant_offres ='';

if($_SERVER['REQUEST_METHOD']=='GET' && (!empty($_GET['ville'])) )  {


    if (!empty($_GET['ville'])&&!empty($_GET['order']))
    {
        if ($_GET['ville']=='All')
            $ville='%';
        else
        $ville=$_GET['ville'];


        if ($_GET['order']=='none')
        $req_etudiant_offres = "SELECT * from OFFREDESTAGE offre,ENTREPRISE ent
                        WHERE offre.NUM_ENT = ent.NUM_ENT and  offre.NUM_NIV='$niveau'
                        AND offre.NUM_OFFR NOT IN (
                                                    SELECT NUM_OFFR FROM POSTULER 
                                                    WHERE CNE_ETU='$etudiant_cne'       
                )       AND offre.VILLE_OFFR like ('$ville')
                ";
        else {
           if ($_GET['order']=='1')
               $req_etudiant_offres = "SELECT * from OFFREDESTAGE offre,ENTREPRISE ent
                        WHERE offre.NUM_ENT = ent.NUM_ENT and  offre.NUM_NIV='$niveau'
                        AND offre.NUM_OFFR NOT IN (
                                                    SELECT NUM_OFFR FROM POSTULER 
                                                    WHERE CNE_ETU='$etudiant_cne'       
                )       AND offre.VILLE_OFFR like ('$ville')
                        ORDER BY offre.DATEDEB_OFFR ASC
                ";

           else

            $req_etudiant_offres = "SELECT * from OFFREDESTAGE offre,ENTREPRISE ent
                        WHERE offre.NUM_ENT = ent.NUM_ENT and  offre.NUM_NIV='$niveau'
                        AND offre.NUM_OFFR NOT IN (
                                                    SELECT NUM_OFFR FROM POSTULER 
                                                    WHERE CNE_ETU='$etudiant_cne'       
                )       AND offre.VILLE_OFFR like ('$ville')
                        ORDER BY offre.DATEDEB_OFFR DESC
                ";

        }

    }




}
else
{

    $req_etudiant_offres = "SELECT * from OFFREDESTAGE offre,ENTREPRISE ent
                        WHERE offre.NUM_ENT = ent.NUM_ENT and  offre.NUM_NIV='$niveau'
                        AND offre.NUM_OFFR NOT IN (
                                                    SELECT NUM_OFFR FROM POSTULER 
                                                    WHERE CNE_ETU='$etudiant_cne'       
                )
                ";

}
$Smt_etudiant_offres = $bdd->query($req_etudiant_offres);
$etudiant_offres = $Smt_etudiant_offres->fetchAll(PDO::FETCH_ASSOC);

/******************** recuperer dernier niveau de l etudiant  ******************** */
$req_last_niv = " SELECT ETUDIER.NUM_NIV from ETUDIER where CNE_ETU='$etudiant_cne' order by NUM_NIV desc; ";
$Smt_niv = $bdd->query($req_last_niv);
$last_niv = $Smt_niv->fetch(PDO::FETCH_ASSOC);
$niv=$last_niv['NUM_NIV'];
$req_last_stg = " SELECT offre.NUM_NIV 
                from STAGE st,OFFREDESTAGE offre 
                where offre.NUM_NIV='$niv'
                AND st.CNE_ETU='$etudiant_cne' ;
                ";

$Smt_stg = $bdd->query($req_last_stg);
$last_stg= $Smt_stg->fetch(PDO::FETCH_ASSOC);
$visiblePostuler=" ";

if($niv==@$last_stg['NUM_NIV']){
$visiblePostuler="disabled";

}
else
$visiblePostuler=" ";




?>
