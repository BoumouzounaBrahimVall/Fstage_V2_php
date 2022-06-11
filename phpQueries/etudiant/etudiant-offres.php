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
?>
