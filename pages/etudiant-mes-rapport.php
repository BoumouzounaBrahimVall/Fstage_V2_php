<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "./meta-tag.php"
    ?>
    <title>Mes Rapport</title>
</head>

<body>


<?php
require(__DIR__ . './../phpQueries/etudiant/dash.php');
require_once "nav-etudiant.php";
?>

<div class="container ">
    <div class="row">
        <div class="col-xl-3   col-sm-12">
            <?php
            require_once "./etudiant-sidebar-rapport.php";


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

            ?>

            <?php

            //var_dump(info_etu(1,@$etu,$bdd)[0]["NOM_ETU"]);

            $req_rapport = "SELECT Rapport.* from Rapport,stage where stage.NUM_STG=rapport.NUM_STG and stage.CNE_ETU='$etudiant_cne';";
            $All_rapport = $bdd->query($req_rapport);
            $fich_rapport = $All_rapport->fetchAll(2);


            ?>
        </div>
        <div class=" col-xl-9 col-sm-12">
            <div class="intro p-4 mt-3 d-flex align-items-center">
                <h3><b>Consulter Mes Rapport</b></h3>

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
                        <form class="row g-3">
                            <div class="col-xl-2 col-sm-6">
                                <label for="inputIntitule2" class="col-form-label">Intitule</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <input class="form-control" type="text" id="inputIntitule2" placeholder="Type to search...">
                            </div>
                            <div class="col-xl-2 col-sm-6">
                                <label for="inputMotcle" class="col-form-label">Mot cle</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <input class="form-control" list="datalistOptions" id="inputMotcle"
                                       placeholder="Type to search...">
                                <datalist id="datalistOptions">
                                    <option value="Reseau">
                                    <option value="Informatique">
                                    <option value="BDD">

                                </datalist>
                            </div>

                            <div class="col-xl-2 col-sm-6">
                                <label for="inputNiveaux" class="col-form-label">Niveaux</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <select id="inputNiveaux" class="form-select" aria-label="Default select example">
                                    <option selected>Trier par</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>

                            <div class="col-xl-2 col-sm-6">
                                <label for="inputTrier2" class="col-form-label">Trier</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <select id="inputTrier2" class="form-select" aria-label="Default select example">
                                    <option selected>Trier par</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <button type="submit" class="btn btn-filtre btn-primary w-100 mb-3"> Chercher <i
                                            class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class=" list-rapport mt-3">
                <?php foreach ($fich_rapport

                as $V): ?>
                <!---- card rapport--->
                <div class="container-card d-flex flex-column flex-wrap">
                    <div class="border card-rapport rounded-3  border-link col-xl-12 m-xl-3 p-xl-4 ">
                        <div class="d-flex flex-row flex-wrap p-2">
                            <div>
                                <h4><b><?php echo($V['INTITULE_RAP']); ?></b></h4>

                                <div class="badges d-flex justify-content-start">
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
                            <div class="ms-xl-5 ms-sm-2 mt-2 d-flex flex-xl-column flex-sm-row  justify-content-center flex-wrap align-items-center ">
                                <?php
                                @$stud = info_etu($V['NUM_RAP'], $bdd);
                                ?>
                                <img style="width: 75px;height: 75px;" class="mx-auto mb-2 ms-4 rounded-circle border-1 border" src="<?php echo($stud[0]['IMG_ETU']); ?>" alt="">
                                <p style="font-size: 14px; margin-top: 10px; text-align: center;"><?php
                                    echo($stud[0]['NOM_ETU']); ?> <br><?php echo($stud[0]['LIBELLE_NIV']); ?></p>

                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>


                </div>
            </div>
        </div>
    </div>



</body>

</html>