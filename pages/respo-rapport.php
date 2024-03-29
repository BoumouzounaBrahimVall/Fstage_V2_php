<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "./meta-tag.php"
    ?>
    <title>Historique</title>
</head>


<body>


<?php
require(__DIR__ . './../phpQueries/uploads.php');
require_once "nav-ens.php";
?>

<div class="container ">
    <div class="row">
        <div class="col-xl-3   col-sm-12">
            <div class="sidebar py-1  mt-4 mx-3">
                <ul type="none">
                    <li> <a href="./homeRespo.php"><i class=" active  bi bi-house-fill"></i>Home</a></li>




                </ul>
            </div>
            <?php



            function info_etu($rap, $bdd)
            {
                $student = "SELECT ETUDIANT.NOM_ETU,ETUDIANT.PRENOM_ETU,ETUDIANT.CV_ETU,ETUDIANT.IMG_ETU,niveau.NUM_NIV,niveau.LIBELLE_NIV from STAGE,ETUDIANT,etudier,niveau,RAPPORT
                              where STAGE.CNE_ETU=ETUDIANT.CNE_ETU and etudiant.CNE_ETU=etudier.CNE_ETU and etudier.NUM_NIV=niveau.NUM_NIV and RAPPORT.NUM_STG=STAGE.NUM_STG
                              and RAPPORT.NUM_RAP='$rap' order by NUM_NIV desc; ";
                $info_etu = $bdd->query($student);

                $etu = $info_etu->fetchAll(2);
                return $etu;

            }

            function mot_clets($rap, $bdd)
            {
                $student = "SELECT MOTCLE.LIBELLE_CLE from MOTCLE,CONTENIRMOTRAP 
                              where MOTCLE.NUM_CLE=CONTENIRMOTRAP.NUM_CLE and 
                              CONTENIRMOTRAP.NUM_RAP='$rap'; ";
                $info_motcle = $bdd->query($student);

                $motcl = $info_motcle->fetchAll(2);
                return $motcl;

            }
            $niveaux_req="select DISTINCT (LIBELLE_NIV) FROM niveau";
            $niveaux_stmt=$bdd->query($niveaux_req);
            $All_niveaux = $niveaux_stmt->fetchAll(2);

            $niveaux=array_column($All_niveaux ,"LIBELLE_NIV");

            $motcl_req="select DISTINCT (LIBELLE_CLE) FROM motcle ";
            $motcl_stmt=$bdd->query($motcl_req);
            $All_motcl = $motcl_stmt->fetchAll(2);

            $mocles=array_column($All_motcl ,"LIBELLE_CLE");

            $filtred=false;
            $seletedCle="";
            $seletedNiv="";
            if (isset($_POST['filterClicked']))
            {
                $filtred=true;
                if (empty($_POST['inputMotcle']))
                {
                    $req="SELECT rapport.* from rapport ,stage,niveau,offredestage
                         WHERE stage.NUM_STG = rapport.NUM_STG
                           AND stage.NUM_OFFR=offredestage.NUM_OFFR
                           AND offredestage.NUM_NIV=niveau.NUM_NIV

                    ";
                }else
                    $req="SELECT rapport.* from rapport ,stage,niveau,offredestage,motcle,contenirmotrap
                         WHERE stage.NUM_STG = rapport.NUM_STG
                           AND stage.NUM_OFFR=offredestage.NUM_OFFR
                           AND offredestage.NUM_NIV=niveau.NUM_NIV
                           AND contenirmotrap.NUM_RAP=rapport.NUM_RAP
                           AND contenirmotrap.NUM_CLE=motcle.NUM_CLE ";


                if (!empty($_POST['inputIntitule']))
                {
                    $intitule=$_POST['inputIntitule'];
                    $req.=" AND rapport.INTITULE_RAP LIKE '%$intitule%' ";


                }

                if (!empty($_POST['inputMotcle']))
                {
                    $mot=$_POST['inputMotcle'];
                    $req.=" AND motcle.LIBELLE_CLE LIKE '%$mot%' ";
                    $index = array_search($mot,$mocles);
                    if($index !== FALSE){
                        $seletedCle=$mocles[$index];
                        unset($mocles[$index]);
                    }


                }

                if (!empty($_POST['inputNiveaux']))
                {
                    $niv=$_POST['inputNiveaux'];
                    $req.=" AND niveau.LIBELLE_NIV LIKE '%$niv%' ";

                    $index = array_search($niv,$niveaux);
                    if($index !== FALSE){
                        $seletedNiv=$niveaux[$index];
                        unset($niveaux[$index]);
                    }


                }
                if (!empty($_POST['inputTrier']))
                {
                    $tri=$_POST['inputTrier'];
                    if($tri=='ASC')
                        $req.=" ORDER BY stage.DATEFIN_STG ASC ";
                    else
                        $req.=" ORDER BY stage.DATEFIN_STG DESC ";


                }

                $All_rapport = $bdd->query($req);
                $fich_rapport = $All_rapport->fetchAll(2);



            }

            ?>

            <?php

            //var_dump(info_etu(1,@$etu,$bdd)[0]["NOM_ETU"]);
            if ( !isset($_POST['filterClicked']))
            {
                $req_rapport = "SELECT rap.* from Rapport rap,STAGE stg,NIVEAU niv,OFFREDESTAGE offr
                                    WHERE stg.NUM_STG = rap.NUM_STG
                                    AND offr.NUM_OFFR=stg.NUM_OFFR
                                    AND offr.NUM_NIV=niv.NUM_NIV
                            ;";
                $All_rapport = $bdd->query($req_rapport);
                $fich_rapport = $All_rapport->fetchAll(2);
            }







            ?>
        </div>
        <div class=" col-xl-9 col-sm-12">
            <div class="intro p-4 mt-3 d-flex align-items-center">
                <h3><b>Consulter Rapport</b></h3>

            </div>
            <div class="intro ps-4 ">
                <p>
                    chercher par mot cle ou intitule
                </p>
            </div>
            <div>


            <button class="ms-4 mb-3 btn btn-filtre"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                filtrer les données
                <i class=" ms-5 bi bi-filter-right"></i>
            </button>

            <!--------Filter bar ----->
                <div class="  collapse " id="collapseExample" >
                    <div class=" row filtre-bar ps-4  mt-5">
                        <form method="post" class="row g-3">
                            <div class="col-xl-2 col-sm-6">
                                <label for="inputIntitule" class="col-form-label">Intitule</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <input class="form-control" type="text"  value="<?php echo @$intitule; ?>" id="inputIntitule" name="inputIntitule" placeholder="Type to search...">
                            </div>
                            <div class="col-xl-2 col-sm-6">
                                <label for="inputMotcle" class="col-form-label">Mot cle</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <input class="form-control" list="motcle" value="<?php echo @$seletedCle ?>" name="inputMotcle" id="inputMotcle"
                                       placeholder="Type to search...">
                                <datalist id="motcle">

                                    <?php

                                    foreach ($mocles as $mot)
                                        echo '<option value="'.$mot.'">'
                                    ?>

                                </datalist>
                            </div>

                            <div class="col-xl-2 col-sm-6">
                                <label for="inputNiveaux" class="col-form-label">Niveaux</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <input class="form-control" value="<?php echo @$seletedNiv ?>" list="niveaux" name="inputNiveaux" id="inputNiveaux"
                                       placeholder="Type to search...">
                                <datalist id="niveaux">

                                    <?php
                                    foreach ($niveaux as $niv)
                                        echo '<option value="'.$niv.'">'
                                    ?>

                                </datalist>
                            </div>

                            <div class="col-xl-2 col-sm-6">
                                <label for="inputTrier2" class="col-form-label">Trier</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <select name="inputTrier"  id="inputTrier"  class="form-select" aria-label="Default select example">

                                    <option selected value="1">ASC</option>
                                    <option value="2">DESC</option>
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <button type="submit" name="filterClicked" class="btn btn-filtre btn-primary w-100 mb-3"> Chercher <i
                                            class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class=" list-rapport mt-3">

                <!---- card rapport--->
                <div class="container-card d-flex flex-row flex-wrap">
                    <?php foreach ($fich_rapport

                       as $V): ?>
                    <div class=" my-4 border card-rapport rounded-3  border-link col-xl-12 ms-2 ">
                        <div class="d-flex flex-row flex-wrap p-2">
                            <div>
                                <div class="row overflow-auto">
                                    <h3 style=" word-break: break-word; min-width: 375px;max-width: 375px;" class="headline-rapport  "><b><?php echo($V['INTITULE_RAP']); ?></b></h3>
                                </div>


                                <div class=" badges d-flex justify-content-start">
                                    <?php @$keyword = mot_clets($V['NUM_RAP'], $bdd); ?>
                                    <?php if(isset($keyword[0])){?>
                                    <div class="mt-3">
                                        <span class="badge   p-2 badge-key rounded-pill bg-primary"><?php echo($keyword[0]['LIBELLE_CLE']); ?></span>
                                    </div>
                                    <?php }?>
                                    <?php if(isset($keyword[1])){?>
                                    <div class="mt-3">
                                        <span class="badge  ms-3 p-2 badge-key rounded-pill bg-success"><?php echo($keyword[1]['LIBELLE_CLE']); ?></span>
                                    </div>
                                    <?php }?>
                                    <?php if(isset($keyword[2])){?>
                                    <div class="mt-3">
                                        <span class="badge ms-3 p-2 badge-key rounded-pill bg-danger"><?php echo($keyword[2]['LIBELLE_CLE']); ?></span>
                                    </div>
                                    <?php }?>
                                </div>
                                <div class="mt-3">
                                    <div class="headline">
                                        <b>Acions sur rapport</b>

                                    </div>
                                    <div class="row   mt-3 justify-content-start align-items-center border-top-0">
                                            <div class="col-xl-5 col-sm-10 mt-2">
                                                <a  id="" style="width: 100%"  class="btn-postuler btn px-xl-4  border border-1 "
                                                    href="<?php echo $V['PATH_RAP']; ?>" role="button"
                                                    download>Télechager</a>

                                            </div>
                                        <div class="col-xl-5 col-sm-10 mt-2">
                                            <a style="width: 100%"  id="" class="btn-voir-plus  btn px-xl-4  ms-xl-3   border border-1"
                                               href="<?php echo$V['PATH_RAP']; ?>" role="button" target="_blank">Voir
                                                plus</a>
                                        </div>

                                        <!-- <a href="'.$cvetu.'" style="color:#7B61FF " target="_blank"> visualiser </a> -->
                                    </div>

                                </div>
                            </div>
                            <div class="ms-2  mt-2 d-flex flex-xl-column flex-sm-row  justify-content-center flex-wrap align-items-center ">
                                <?php
                                @$stud = info_etu($V['NUM_RAP'], $bdd);
                                ?>
                                <img style="width: 55px;height: 55px;" class="mx-auto mb-2 ms-4 rounded-circle border-1 border" src="<?php echo($stud[0]['IMG_ETU']); ?>" alt="">
                                <p style="font-size: 12px; margin-top: 10px; text-align: center;"><?php
                                    echo($stud[0]['NOM_ETU']); ?> <br><?php echo($stud[0]['LIBELLE_NIV']); ?></p>

                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </div>



                </div>
            </div>
        </div>
    </div>



</body>

</html>