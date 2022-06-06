
<?php
require(  __DIR__.'../../phpQueries/uploads.php');?>
<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="../css/style.css" />

    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <title>Profile</title>
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
                    <a class="nav-link" href="../pages/gererEtudiant.php">Gérer les comptes</a>
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
    <div class="row">
        <div class="col-xl-3   col-sm-12">
            <div class="sidebar ps-2 pe-2 pt-2 pb-2  mt-4">
                <ul type="none">
                    <li > <a href="homeRespo.php"><i class=" active  bi bi-house-fill"></i>Acceuil</a></li>
                </ul>
            </div>
        </div>
<div class="p-4 col-xl-9 col-sm-12">
    <div class="intro  mt-3">
        <h3> <b>Stage N°12546</b> </h3>

    </div>
    <div class="intro ">
        <p>
            Consulter l'ensemble des information sur le stage

        </p>
    </div>
    <div class="row  border border-link rounded-3 py-4 px-2">

        <div class="col-xl-2 col-sm-12 me-4 ">
            <img class="mx-auto mb-2" style="max-width: 150px;" src="./../../ressources/company/images/atos.png" alt="">
        </div>
        <div class="col-xl-9 col-sm-12 me-4">
            <div class="row mt-2">
                <div class="col-xl-4 col-sm-12 m-0 mt-sm-2 d-flex justify-content-start ">

                    <div class="col-auto prop-name me-3  p-0">Société :</div>
                    <div class="col-auto prop-value">Atos</div>

                </div>

                <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                    <div class="col-auto me-3 p-0 prop-name ">N° stage :</div>
                    <div class="col-auto prop-value">19658</div>


                </div>
                <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                    <div class="col-auto m-0 p-0  prop-name me-3">Note Général :</div>
                    <div class="col-auto prop-value">0</div>


                </div>

            </div>
            <div class="row mt-4 m-0">
                <div class="col-xl-6 col-sm-12  mt-sm-2  ">
                    <form id="formDateDeb" class="row align-items-center  justify-content-start" action="" method="get">
                        <div class="col-4 m-0 p-0 prop-name ">
                            <label for="" class="form-label">Date debut </label>
                        </div>
                        <div class="col-6 m-0 p-0 prop-value">
                            <input id="inputDateDeb" type="date" class="form-control" disabled value="2022-09-20" name="date" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="col-2 ">
                            <a onclick="modifySubmitdate('inputDateDeb','modifyDateDeb','formDateDeb')" id="modifyDateDeb" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                    </form>
                </div>
                <div class="col-xl-6 col-sm-12 mt-sm-2 d-flex ">
                    <form id="formDateFin" class="row align-items-center  justify-content-start" action="" method="get">
                        <div class="col-4 m-0 p-0 prop-name ">
                            <label for="" class="form-label">Date fin </label>
                        </div>
                        <div class="col-6 m-0 p-0 prop-value">
                            <input id="inputDateFin" type="date" class="form-control" disabled value="2022-09-20" name="date" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="col-2 ">
                            <a onclick="modifySubmitdate('inputDateFin','modifyDateFin','formDateFin')" id="modifyDateFin" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-4 m-0">
                <div class="col-xl-5 col-sm-12  mt-sm-2  ">
                    <form id="formEncadrant" class="row align-items-center  justify-content-start" action="" method="get">
                        <div class="col-4 m-0 p-0 prop-name ">
                            <label for="" class="form-label">Encadrant </label>
                        </div>
                        <div class="col-6 m-0 p-0 prop-value">
                            <input id="inputEncadrant" list="datalistEncadrant" class="form-control" disabled name="encadrant" id="" aria-describedby="helpId" placeholder="">
                            <datalist id="datalistEncadrant">
                                <option value="Mr Bakkoucha">
                                <option value="Mr Kissi">
                                <option value="Mme Letrach">

                            </datalist>
                        </div>
                        <div class="col-1 ">
                            <a onclick="modifySubmitdate('inputEncadrant','modifyEncadrant','formEncadrant')" id="modifyEncadrant" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                    </form>
                </div>
                <div class="col-xl-7 col-sm-12 mt-sm-2 ">
                    <form id="formDateFin" class="row align-items-center  justify-content-start" action="" method="get">
                        <div class="col-2 m-0 p-0 prop-name ">
                            <label for="" class="form-label">Lieux</label>
                        </div>
                        <div class="col-8 m-0 p-0 prop-value">
                            <input id="inputLieux" type="text" class="form-control" disabled value="Hay FAllah,Mohammedia , Maroc" name="lieux" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="col-1 ">
                            <a onclick="modifySubmitdate('inputLieux','modifyDateFin','formDateFin')" id="modifyDateFin" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-4 m-0">
                <div class="col-xl-6 col-sm-12  mt-sm-2 d-flex ">
                    <div class="row align-items-center  justify-content-start">
                        <div class="col-auto m-0 p-0 prop-name ">
                            <span>Rapport </span>
                        </div>
                        <div class="col-auto m-0 p-0 prop-value">
                            <div class="ms-4">
                                <a class=" btn px-5 " style="border: 1px solid #7B61FF;color: #7B61FF;" role="button" data-bs-toggle="modal" data-bs-target="#ModalRapport">Editer </a
                                >
                            </div>
                        </div>

                    </div>

                </div> <div class="col-xl-6 col-sm-12  mt-sm-2 d-flex ">
                <div class="row align-items-center  justify-content-start">
                    <div class="col-auto m-0 p-0 prop-name ">
                        <span>Contrat </span>
                    </div>
                    <div class="col-auto m-0 p-0 prop-value">
                        <div class="ms-4">
                            <a name="" id="" class=" btn px-5 " style="border: 1px solid #7B61FF;color: #7B61FF;" href="#" role="button" data-bs-toggle="modal" data-bs-target="#ModalContrat">Editer </a
                            >
                        </div>
                    </div>

                </div>
            </div>
            </div>

            <div class="row mt-4 m-0">
                <div class="col-xl-12 col-sm-12  mt-sm-2 ">



                    <form id="formJury" class="row align-items-center  justify-content-start" action="" method="get">
                        <div class="col-4 m-0 p-0 prop-name ">
                            <label for="" class="form-label">Affecter jury de stage  </label>
                        </div>
                        <div class="col-6 m-0 p-0 prop-value">
                            <input id="inputJury" list="datalistJury" class="form-control " disabled name="jury" id="" aria-describedby="helpId" placeholder="">
                            <datalist id="datalistJury">
                                <option value="Mr Bakkoucha">
                                <option value="Mr Kissi">
                                <option value="Mme Letrach">

                            </datalist>
                        </div>
                        <div class="col-2 ">
                            <a onclick="modifySubmitdate('inputJury','modifyJury','formJury')" id="modifyJury" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                    </form>

                </div>

            </div>
            <div class="row mt-4 m-0">
                <div class="col-xl-12 col-sm-12  mt-sm-2 ">



                    <form id="formNoteJury" class="row align-items-center  justify-content-start" action="" method="get">
                        <div class="col-3 m-0 p-0 prop-name ">
                            <label for="" class="form-label">Note Jury  </label>
                        </div>
                        <div class="col-2 m-0 p-0 prop-value">
                            <input id="inputNoteJury1" type="number" value="0" class="form-control " disabled name="jury" id="" aria-describedby="helpId" placeholder="">

                        </div>
                        <div class="col-1 ">
                            <a onclick="modifySubmitdate('inputNoteJury','modifyNoteJury','formNoteJury')" id="modifyNoteJury" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                        <div class="col-2 m-0 p-0 prop-value">
                            <input id="inputNoteJury" type="number" value="0" class="form-control " disabled name="jury" id="" aria-describedby="helpId" placeholder="">

                        </div>
                        <div class="col-1 ">
                            <a onclick="modifySubmitdate('inputNoteJury','modifyNoteJury','formNoteJury')" id="modifyNoteJury" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                        <div class="col-2 m-0 p-0 prop-value">
                            <input id="inputNoteJury" type="number" value="0" class="form-control " disabled name="jury"  aria-describedby="helpId" placeholder="">

                        </div>
                        <div class="col-1 ">
                            <a onclick="modifySubmitdate('inputNoteJury','modifyNoteJury','formNoteJury')" id="modifyNoteJury" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                    </form>

                </div>

            </div>
            <div class="row mt-4 m-0">
                <div class="col-xl-12 col-sm-12  mt-sm-2 ">



                    <form id="formSujet" class="row align-items-center  justify-content-start" action="" method="get">
                        <div class="col-3 m-0 p-0 prop-name ">
                            <label for="" class="form-label">Sujet  </label>
                        </div>
                        <div class="col-8 m-0 p-0 prop-value">
                            <input id="inputSujet" type="text" class="form-control " value="developper une application mobile" disabled name="Sujet" id="" aria-describedby="helpId" placeholder="">

                        </div>
                        <div class="col-1 ">
                            <a onclick="modifySubmitdate('inputSujet','modifySujet','formSujet')" id="modifySujet" type="btn"><i name="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                        </div>
                    </form>

                </div>

            </div>

            <div class="row mt-4">
                <div class="col-xl-4 col-sm-12 m-0 mt-sm-2 d-flex justify-content-start ">

                    <div class="col-auto prop-name me-3  p-0">Offre de stage N°:</div>
                    <div class="col-auto prop-value " style="color: #7B61FF;"><a href="">123568</a> </div>

                </div>

                <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                    <div class="col-auto me-3 p-0 prop-name ">Etudiant N° :</div>
                    <div class="col-auto prop-value" style="color: #7B61FF;"><a href="">C14258967</a> </div>


                </div>


            </div>


        </div>


    </div>

    <div class="intro  mt-5">
        <h3> <b>Détails offres postulé</b> </h3>

    </div>
    <div class="mt-4">
        <button class="btn btn-filtre" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            filtrer les données
        </button>

        <div class="collapse " id="collapseExample">
            <div class="row">
                <div class="filtre-bar ps-4  mt-5">
                    <form class="row g-3">
                        <div class="col-xl-2 col-sm-6">
                            <label for="inputIntitule2" class="col-form-label">CNE</label>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <input class="form-control" type="text" id="inputIntitule2" placeholder="CNE...">
                        </div>g
                        <div class="col-xl-2 col-sm-6">
                            <label for="inputNiveaux" class="col-form-label">Niveaux</label>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <select id="inputNiveaux" class="form-select" aria-label="Default select example">
                                <option selected>Trier par </option>
                                <option value="ILISI1">ILISI1</option>
                                <option value="ILISI2">ILISI2</option>
                                <option value="ILISI3">ILISI3</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-sm-6">
                            <label for="inputTrier2" class="col-form-label">Trier</label>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <select id="inputTrier2" class="form-select" aria-label="Default select example">
                                <option selected>Trier par </option>
                                <option value="date">Date</option>
                                <option value="Alpha">Ordre Alphabetique</option>
                            </select></div>
                        <div class="col-xl-6">
                            <button type="submit" class="btn btn-filtre  w-100 mb-3">    Chercher <i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row overflow-auto">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Entreprise</th>
                    <th scope="col">Poste</th>

                    <th scope="col">Date Postuler</th>
                    <th scope="col">Retenu</th>
                    <th scope="col">Accepter</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>

                    <td>Atos</td>
                    <td>Developpeur back-end</td>
                    <td>20-06-2022</td>
                    <td>Oui</td>
                    <td>Non</td>
                    <td>
                        <a href="#" class="me-3"><i class=" active  bi bi-info-circle-fill"></i></a>
                        <a href="#"><i class=" active  bi bi-pencil-fill"></i></a>
                    </td>
                </tr>
                <th scope="row">1</th>

                <td>Atos</td>
                <td>Developpeur back-end</td>
                <td>20-06-2022</td>
                <td>Oui</td>
                <td>Non</td>
                <td>
                    <a href="#" class="me-3"><i class=" active  bi bi-info-circle-fill"></i></a>
                    <a href="#"><i class=" active  bi bi-pencil-fill"></i></a>
                </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>





</div>








</div>
</div>
<!-- Modal Rapport-->
<div class="modal fade" id="ModalRapport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 500px;max-width: 800px">
        <div class="modal-content d-flex justify-content-center " style="max-width: 800px;margin:auto;">
            <div class="modal-header border-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <span class="headline-form"> Editer Rapport</span>

                    </div>
                    <div class="row">
                        <form class=" g-3">
                            <div class="mt-4">
                                <div class="d-flex align-items-center ">
                                    <img class="me-2" src="./../../assets/icon/step1.svg" alt="">
                                    <span class="subheadline-form">Action sur Rapport</span>
                                </div>

                                <div class="row mt-4 ms-5   py-2 border border-1 rounded-3" style="width: 50%;">

                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-4 col-sm-6">
                                                <label for="inputRapport" class="col-form-label">Action</label>

                                            </div>
                                            <div class="col-8 col-sm-6">
                                                <select id="inputRapport" class="form-select" aria-label="Default select example">

                                                    <option selected value="1">importer</option>
                                                    <option value="2">télecharger</option>
                                                </select></div>

                                        </div>


                                    </div>
                                </div>
                            </div>



                            <div class="d-flex mt-4 align-items-center ">
                                <img class="me-2" src="./../../assets/icon/step2.svg" alt="">
                                <span class="subheadline-form">Information sur Rapport</span>
                            </div>
                            <div class="row">
                                <form action="" method="post">
                                    <div class="col-10 ms-5   align-items-start ">

                                        <div class="mt-2 p-2 border border-1 rounded-3 ">
                                            <div>
                                                <div class=" p-3 ">

                                                    <div>
                                                        <div class="row mt-2 ">
                                                            <div class="col-xl-12 col-sm-12">
                                                                <label for="inputIntitule" class="col-form-label">Intitule</label>

                                                                <input class="form-control" type="text" id="inputIntitule" placeholder="Type to search...">
                                                            </div>


                                                        </div>

                                                        <div class="row mt-2">
                                                            <div class="col-xl-12 col-sm-12">
                                                                <label for="inputMotCle" class="col-form-label">Mot clé</label>

                                                                <input multiple id="inputMotCle" list="datalistMotcle" class="form-control" name="motclé" id="" aria-describedby="helpId" placeholder="">
                                                                <datalist id="datalistMotcle">
                                                                    <option value="Informatique">
                                                                    <option value="Reseaux">
                                                                    <option value="PHP">

                                                                </datalist></div>

                                                        </div>

                                                        <div class="row mt-2 d-flex justify-content-around ">
                                                            <div style="width: fit-content" class="mt-2 ms-3 col-6 px-5 py-4  d-flex flex-column rounded-4 justify-content-center border border-link">
                                                                <img style="margin: auto; max-width: 64px" src="./../../assets/icon/rapport-icon.svg" alt="" />
                                                                <a class="mt-3 btn-voir-plus py-2 px-4" style="width: fit-content; font-size: 16px" href="">Importer  <i class="bi bi-file-arrow-up-fill"></i
                                                                ></a>
                                                            </div>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <div>

                                        </div>

                                    </div>
                                    <div class="row ms-4">
                                        <div class="col-xl-6 mt-4">
                                            <button type="submit" class="btn btn-filtre btn-primary w-100 mb-3">    Ajouter <i class="bi bi-plus-circle-fill"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
<!-- Modal Contrat-->
<div class="modal fade" id="ModalContrat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 500px;max-width: 800px">
        <div class="modal-content d-flex justify-content-center " style="max-width: 800px;margin:auto;">
            <div class="modal-header border-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <span class="headline-form"> Editer Contrat</span>

                    </div>
                    <div class="row">
                        <form class=" g-3">
                            <div class="mt-4">
                                <div class="d-flex align-items-center ">
                                    <img class="me-2" src="./../../assets/icon/step1.svg" alt="">
                                    <span class="subheadline-form">Action sur Rapport</span>
                                </div>

                                <div class="row mt-4 ms-5   py-2 border border-1 rounded-3" style="width: 50%;">

                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-4 col-sm-6">
                                                <label for="inputRapport" class="col-form-label">Action</label>

                                            </div>
                                            <div class="col-8 col-sm-6">
                                                <select id="inputRapport" class="form-select" aria-label="Default select example">

                                                    <option selected value="1">importer</option>
                                                    <option value="2">generer</option>
                                                </select></div>

                                        </div>


                                    </div>
                                </div>
                            </div>



                            <div class="d-flex mt-4 align-items-center ">
                                <img class="me-2" src="./../../assets/icon/step2.svg" alt="">
                                <span class="subheadline-form">Importer Contrat</span>
                            </div>
                            <div class="row">
                                <form action="" method="post">
                                    <div class="col-10 ms-5   align-items-start ">

                                        <div class="mt-2 p-2 border border-1 rounded-3 ">
                                            <div>
                                                <div class=" p-3 ">

                                                    <div>


                                                        <div class="row mt-2 d-flex justify-content-around ">
                                                            <div style="width: fit-content" class="mt-2 ms-3 col-6 px-5 py-4  d-flex flex-column rounded-4 justify-content-center border border-link">
                                                                <img style="margin: auto; max-width: 64px" src="./../../assets/icon/contrat-icon.svg" alt="" />
                                                                <a class="mt-3 btn-voir-plus py-2 px-4" style="width: fit-content; font-size: 16px" href="">Importer  <i class="bi bi-file-arrow-up-fill"></i
                                                                ></a>
                                                            </div>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <div>

                                        </div>

                                    </div>
                                    <div class="row ms-4">
                                        <div class="col-xl-6  mt-4">
                                            <button type="submit" class="btn btn-filtre btn-primary w-100 mb-3">    Ajouter <i class="bi bi-plus-circle-fill"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="../js/script.js"></script>
</body>

</html>