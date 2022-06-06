<?php
$req_etudiant_offres = "SELECT * from OFFREDESTAGE offre,ENTREPRISE ent
                        WHERE offre.NUM_ENT = ent.NUM_ENT and  offre.NUM_NIV='$niveau'
                        AND offre.NUM_OFFR NOT IN (
                                                    SELECT NUM_OFFR FROM POSTULER 
                                                    WHERE CNE_ETU='$etudiant_cne'       
                )
                ";
$Smt_etudiant_offres = $bdd->query($req_etudiant_offres);
$etudiant_offres = $Smt_etudiant_offres->fetchAll(PDO::FETCH_ASSOC);
?>
