<?php
require( __DIR__.'../../phpQueries/respoRequiries.php');

if (isset($_POST["telecharger"])) {
    $type=$_POST['type'];
    $niv=$_POST['niv'];

    if($type=='tous') $test='';
    else if($type=='1') $test='and  stage.ACTIVE_STG!=0';
    else if($type=='2') $test=' and stage.DATEFIN_STG>CURRENT_DATE';
    else $test=' and stage.DATEFIN_STG<CURRENT_DATE';

    if($niv=='tous') $testNiv='';
    else $testNiv='and  niveau.NUM_NIV='.$niv;

    $req="select etu.CNE_ETU CNE,etu.NOM_ETU Nom,etu.PRENOM_ETU Prenom,etu.DATENAISS_ETU Date_naissance,etu.TEL_ETU Tel, 
                    etu.EMAIL_ENS_ETU email,etu.PAYS_ETU Pays,enseignant.NOM_ENS encadrant, entreprise.LIBELLE_ENT as Entreprise, juger.NOTE Note_encadrant
                ,stage.NOTE_ENEX Note_encadrant_externe,stage.SUJET_STG,stage.DATEDEB_STG,stage.DATEFIN_STG
                from etudiant etu, offredestage,etudier,niveau,stage,juger, enseignant,entreprise 
                where entreprise.NUM_ENT=offredestage.NUM_ENT and offredestage.NUM_OFFR=stage.NUM_OFFR and juger.NUM_ENS=enseignant.NUM_ENS
                  and juger.NUM_STG=stage.NUM_STG and juger.EST_ENCADRER='1' and stage.CNE_ETU=etu.CNE_ETU and etudier.CNE_ETU=etu.CNE_ETU and 
                      niveau.NUM_NIV=etudier.NUM_NIV $testNiv and niveau.NUM_FORM='$formation' $test;";
    $stmReq=$bdd->query($req);
    $rows= $stmReq->fetchAll(2);

     // le nom du fichier
    $filename =  "FSTMStagieres-".date('d-m-Y').".xls";;

//pour informer le navigateur qu'il doit telecharger un fichier de type excel
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    header("Expires: 0");

//pour separer les colonnes
    $separator = "\t";

//If our query returned rows
    if(!empty($rows)){

        //ecrire les noms des colonnes comme la requette
        echo implode($separator, array_keys($rows[0])) . "\n";

        foreach($rows as $row){

            //enlever les caracteres specifique pour eviter les onflits
            foreach($row as $k => $v){
                $row[$k] = str_replace($separator . "$", "", $row[$k]);
                $row[$k] = preg_replace("/\r\n|\n\r|\n|\r/", " ", $row[$k]);
                $row[$k] = trim($row[$k]);
            }

            //Implode: pour ecrire les colonnes
            //$separator : lier entre les colonnes
            echo implode($separator, $row) . "\n";
        }
    }
    exit();// si on sort pas on aura toute la page php dans le fichier excel
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require_once "./meta-tag.php"
    ?>

    <title>Gerer Stages</title>
</head>
<body>


<?php
require_once "./nav-ens.php"
?>

<div class="container ">

    <div class="row pt-0">

        <div class="container ">
            <div class="row">
                <div class="col-xl-3   col-sm-12">
                    <div class="sidebar  ps-2 pe-2 pt-2 pb-2  mt-4">
                        <ul type="none">
                            <li > <a href="#" class="actuel-page"><i class=" active  bi bi-briefcase-fill "></i>Gerer Stages</a></li>
                        </ul>
                    </div>
                </div>
                <div class=" col p-4  mt-0">
                    <div class="row">
                        <h4>Mettre à jour listes des stages</h4>
                    </div>

                    <div class="container-fluid d-flex justify-content-center align-items-center row mt-2">
                        <div class="col-lg-6 col-md-12 p-xl-4 mr-2 my-sm-2 ">

                            <div class="row  pt-3 pb-3 statis-div-2 mt-2">

                                <div class="col-2 col-sm-5  p-4">
                                    <img  src="../assets/icon/bag_green.png" alt="stages">
                                </div>
                                <div class="col p-4">
                                    <h1 class=" text-center">
                                        <?php
                                        $req1="SELECT COUNT(stg.NUM_STG) nbr_stg FROM `stage` stg,offredestage off,NIVEAU niv WHERE stg.NUM_OFFR=off.NUM_OFFR and niv.NUM_NIV=off.NUM_NIV  and niv.NUM_FORM='$formation';";
                                        $Smt1=$bdd->query($req1);
                                        $nbr=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

                                        echo '<h1 class=" text-center">'.$nbr['nbr_stg'].'</h1>';//<h1 class=" text-center">250</h1>
                                        ?></h1>

                                    <p class=" text-center">Stages</p>

                                </div>
                            </div>
                        </div>
                        <!-- the other one-->
                        <div class="col p-4 mr-2 ">

                            <div class="row  p-4  addOffre-div">

                                <div class="col-12 p-3 d-flex align-items-center  justify-content-center">

                                    <i class="bi bi-download" style="font-size: 50px; color: #7b61ff"></i>

                                </div>
                                <div class="col-12 p-0 d-flex align-items-center  justify-content-center">
                                    <button class="btn btn-filtre" data-bs-toggle="modal" data-bs-target="#exampleModal">Telechager liste des  stagieres</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 border p-3 rounded-5 rounded border-1 ">
                            <table  id="table_id10"  style="width:100%" class="nowrap display">
                                <thead>
                                <tr>
                                    <th scope="col">№ stage</th>
                                    <th scope="col">№ offre</th>
                                    <th scope="col">CNE etudiant</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Date Deb</th>
                                    <th scope="col">Date Fin</th>
                                    <th scope="col">ANNULER</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $req="SELECT stg.*,niv.LIBELLE_NIV FROM `OFFREDESTAGE` ofr,stage stg,NIVEAU niv 
                      WHERE niv.NUM_NIV=ofr.NUM_NIV and stg.NUM_OFFR=ofr.NUM_OFFR and niv.NUM_FORM='$formation';";
                                $Smt=$bdd->query($req);
                                $rows=$Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC
                                //afficher le tableau
                                foreach($rows as $V):
                                    $postul=$V['NUM_OFFR'];
                                    $nbr="SELECT count(POSTULER.CNE_ETU) nbrpost FROM `POSTULER` WHERE POSTULER.NUM_OFFR='$postul';";
                                    $Smt2=$bdd->query($nbr);
                                    $nbrCnd=$Smt2->fetch(PDO::FETCH_ASSOC);
                                    echo' <tr>
                                          <td >'.$V['NUM_STG'].'</td>
                                            <td><a  href="../pages/resposable-details-offre.php?numOffre='.$V['NUM_OFFR'].'">'.$V['NUM_OFFR'].'</td>
                                            <td><a  href="../pages/resposable-details-etudiant.php?cne='.$V['CNE_ETU'].'">'.$V['CNE_ETU'].'</td> 
                                            <td>'.$V['LIBELLE_NIV'].'</td> 
                                            <td>'.$V['DATEDEB_STG'].'</td>
                                            <td>'.$V['DATEFIN_STG'].'</td>
                                            ';
                                            if($V['ACTIVE_STG']=='0')
                                                echo '  <td>NON</td>';
                                            else echo '  <td class="text-danger">OUI</td>';
                                         echo'   <td>  
                                          <a class="ms-3" href="../pages/resposable-details-stage.php?numStage='.$V['NUM_STG'].'"><i class=" active  bi bi-pencil-fill"></i></a>
                                        </td>
                                        </tr>
                        
                    <';
                                endforeach;

                                ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>


<!-- Modifier telecharger-->
<div  class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 370px;max-width: 800px">
        <div class="modal-content d-flex justify-content-center "style="min-width: 370px;max-width: 800px;margin:auto;">
            <div class="modal-header border-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <span class="headline-form"> Telecharger la liste des stagieres</span>

                    </div>
                    <div class="row">
                        <form class=" g-3 mt-2" method="post">
                            <div class="d-flex align-items-center ">
                                <img class="me-2" src="../assets/icon/step1.svg" alt="">
                                <span class="subheadline-form" >information sur les stages</span>
                            </div>

                            <div >
                                <div class="mt-4 p-2 border border-1 rounded-3">

                                    <div>
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-6">
                                                <label for="inputNom2" class="col-form-label" >Type</label>
                                                <select class="form-select" name="type">
                                                    <option value="tous" selected>Tous</option>
                                                    <option value="1">Annuler</option>
                                                    <option value="2">Encours</option>
                                                    <option value="3">Terminer</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <label for="inputPrenom2" class="col-form-label">Niveau</label>
                                                <select class="form-select"  name="niv">
                                                    <option value="tous" selected>Tous</option>
                                                    <?php
                                                    $reqniv="select NUM_NIV,LIBELLE_NIV from niveau where NUM_FORM='$formation'; ";
                                                    $Smtniv = $bdd->query($reqniv);
                                                    $rownivs=$Smtniv->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($rownivs as $rowniv) {
                                                        echo '<option value="' . $rowniv['NUM_NIV'] . '">' . $rowniv['LIBELLE_NIV'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">

                                <div class="row">
                                    <div class="col-xl-6 mt-4">
                                        <button type="submit" name="telecharger" class="btn btn-filtre btn-primary w-100 mb-3"> Teleharger <i class="bi bi-download"></i></button>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- JavaScript Bundle with Popper-->

<script>
    $(document).ready( function () {
        $('#table_id10').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json'
            },
            scrollY: 200,
            scrollX: true,
        });
    } );
</script>
</body>
</html>