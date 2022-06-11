<?php
require( __DIR__.'../../phpQueries/respoRequiries.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
            crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>

    </style>

    <title>Gerer Stages</title>
</head>
<body>

<!-- Navbar  -->
<nav class="navbar navbar-expand-lg navbar-light m-0">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="#">
            <img id="logo" src="../assets/icon/logo.png" alt="logo" />
        </a>

        <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link " aria-current="page" href="homeRespo.php">Acceuil</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gererOffre.php">Gérer les offres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gererEtudiant.php">Gérer les comptes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Gérer stage</a>
                </li>
            </ul>
            <div class="d-flex">
                <a  href="../pages/respoProfil.php">
                    <img class="profile_icon rounded-circle border" src="<?php echo $respon_img;?>" alt="">
                </a>
                <a
                        name=""
                        id="seDeconnecter"
                        class="btn btn-outline-primary  btn-selector pt-3"
                        href="login.php"
                        role="button"
                >Se deconnecter
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

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
                        <div class="col-lg-6 col-md-12 p-4 mr-2 ">

                            <div class="row  pt-3 pb-3 statis-div-2">

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
                        <div class="col-lg-6 col-md-12 p-4 mr-2 ">

                            <div class="row   pt-3 pb-3  statis-div-3">

                                <div class="col-2 col-sm-5  p-4">
                                    <img  src="../assets/icon/bag_red.png" alt="offres">
                                </div>
                                <div class="col p-4">
                                    <h1 class=" text-center"><?php
                                        $req1="SELECT COUNT(off.NUM_OFFR) nbr_off_cmp FROM `OFFREDESTAGE` off,NIVEAU niv WHERE niv.NUM_NIV=off.NUM_NIV and off.ETATPUB_OFFR='complete' and niv.NUM_FORM='$formation';";
                                        $Smt1=$bdd->query($req1);
                                        $nbr=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

                                        echo '<h1 class=" text-center">'.$nbr['nbr_off_cmp'].'</h1>';//<h1 class=" text-center">250</h1>
                                        ?></h1>
                                    <p class=" text-center">offres complétés</p>

                                </div>
                            </div>
                        </div>
                        <button class="btn btn-filtre" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            filtrer les données
                        </button>
                        </p>
                        <div class="collapse " id="collapseExample">

                            <div class="row">
                                <div class="filtre-bar ps-4  mt-5" >
                                    <form class="row g-3">
                                        <div class="col-xl-2 col-sm-6">
                                            <label for="inputIntitule2" class="col-form-label">Entreprise</label>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <input class="form-control" type="text" id="inputIntitule2" placeholder="Type to search...">
                                        </div>
                                        <div class="col-xl-2 col-sm-6">
                                            <label for="inputMotcle" class="col-form-label">Ville</label>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <input class="form-control" list="datalistOptions" id="inputMotcle" placeholder="Type to search...">
                                            <datalist id="datalistOptions">
                                                <option value="Casablanca">
                                                <option value="Rabat">
                                                <option value="Mohammedia">
                                            </datalist> </div>

                                        <div class="col-xl-2 col-sm-6">
                                            <label for="inputNiveaux" class="col-form-label">Niveaux</label>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <select id="inputNiveaux" class="form-select" aria-label="Default select example">
                                                <option selected>Trier par </option>
                                                <option value="ILISI1">ILISI1</option>
                                                <option value="ILISI2">ILISI2</option>
                                                <option value="ILISI3">ILISI3</option>
                                            </select></div>

                                        <div class="col-xl-2 col-sm-6">
                                            <label for="inputTrier2" class="col-form-label">Trier</label>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <select id="inputTrier2" class="form-select" aria-label="Default select example">
                                                <option selected>Trier par </option>
                                                <option value="date">Date</option>
                                                <option value="2">Nombre effectif</option>
                                                <option value="3">Nombre candidats</option>
                                            </select></div>
                                        <div class="col-xl-6">
                                            <button type="submit" class="btn btn-filtre  w-100 mb-3">    Chercher <i class="bi bi-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--------Filter bar ----->

                        <div class="row overflow-auto">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">№ stage</th>
                                    <th scope="col">№ offre</th>
                                    <th scope="col">CNE etudiant</th>
                                    <th scope="col">Sujet</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Date Deb</th>
                                    <th scope="col">Date Fin</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $req="SELECT ofr.*,ent.LIBELLE_ENT,niv.LIBELLE_NIV FROM `OFFREDESTAGE` ofr,NIVEAU niv ,ENTREPRISE ent 
                      WHERE niv.NUM_NIV=ofr.NUM_NIV and ent.NUM_ENT=ofr.NUM_ENT and niv.NUM_FORM='$formation';";
                                $Smt=$bdd->query($req);
                                $rows=$Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC
                                //afficher le tableau
                                foreach($rows as $V):
                                    $postul=$V['NUM_OFFR'];
                                    $nbr="SELECT count(POSTULER.CNE_ETU) nbrpost FROM `POSTULER` WHERE POSTULER.NUM_OFFR='$postul';";
                                    $Smt2=$bdd->query($nbr);
                                    $nbrCnd=$Smt2->fetch(PDO::FETCH_ASSOC);
                                    echo' <tr>
                      <th scope="row">'.$V['NUM_OFFR'].'</th>
                    
                            <td>'.$V['LIBELLE_ENT'].'</td>
                            <td>'.$V['POSTE_OFFR'].'</td> 
                            <td>'.$V['LIBELLE_NIV'].'</td> 
                            <td>'.$V['EFFECTIF_OFFRE'].'</td>
                            <td>'.$nbrCnd['nbrpost'].'</td>
                            <td>  
                          <a class="ms-3" href="../pages/resposable-details-offre.php?numOffre='.$V['NUM_OFFR'].'"><i class=" active  bi bi-pencil-fill"></i></a>
                        </td></tr>
                        
                    <tr>';
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



<!-- Main Content Area -->

<!-- Pills content -->
<footer>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex  justify-content-around align-items-center p-5">


                    <div>
                        <img id="logo-light" src="../assets/icon/logo-light.png" alt="" />
                    </div>
                    <a href="#">
                        Contact
                    </a>
                    <a href="#">
                        A propos
                    </a>
                    <a href="#">
                        Espace Responsable
                    </a>
                    <a href="#">
                        Espace Etudiant
                    </a> </div>
            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-center">

                <div class="col-3.5">
                    <p class="copyright" >Copyright © Stage FSTM 2022. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- JavaScript Bundle with Popper-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/script.js"></script>
</body>
</html>