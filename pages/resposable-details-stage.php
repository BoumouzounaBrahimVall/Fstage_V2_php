
<?php
require(  __DIR__.'../../phpQueries/uploads.php');
$stage_num=$_GET['numStage'];
 if(!isset($stage_num)) header('location:gererStage.php');

if(isset($_GET['send'])) {
    switch ($_GET['send']) {
        case 'modifystg1':
            $idEns = $_GET['encadrant'];
            $numoff=$_GET['numOffre'];
            $datDeb=$_GET['dateDeb'];
            $datFin=$_GET['dateFin'];
            $ville=$_GET['ville'];
            $pays=$_GET['pays'];
            $lieu=$_GET['lieu'];

            $requpdate = "UPDATE OFFREDESTAGE set VILLE_OFFR='$ville',PAYS_OFFR='$pays',LIEUX_OFFR='$lieu' WHERE NUM_OFFR='$numoff'";
            $bdd->exec($requpdate);
            $requpdate = "UPDATE stage set DATEDEB_STG='$datDeb',DATEFIN_STG='$datFin' WHERE NUM_STG='$stage_num'";
            $bdd->exec($requpdate);
            //initialiser le jurie ( personne n'est un 'encadrant') pour ne pas avoir plus q'un encadrent
            foreach($ens as $V):
                $requpdate = "UPDATE juger set EST_ENCADRER='0' WHERE NUM_STG='$stage_num'";
                $bdd->exec($requpdate);
            endforeach;
            //affecter le nouveau encadrant parmit le jurie
            $requpdate = "UPDATE juger set EST_ENCADRER='1' WHERE NUM_STG='$stage_num' and NUM_ENS='$idEns'";
            $bdd->exec($requpdate);
            break;
        case 'wallo':
            $etat = $_GET['inputEtat'];
            $req = "UPDATE OFFREDESTAGE set ETATPUB_OFFR='$etat' WHERE NUM_OFFR='$stage_num'";
            break;

    }
   // $bdd->exec($req);
    header('location:resposable-details-stage.php?numStage='.$stage_num);

}

if(isset($_GET['ajouter'])){
    $idEnsNew=$_GET['juryAjou'];
    if(!empty($_GET['NoteAjou'])){
        $note=$_GET['NoteAjou'];
        $reqajou="INSERT INTO juger (NUM_STG,NUM_ENS,NOTE,EST_ENCADRER)
              VALUES ('$stage_num','$idEnsNew','$note','0');";
        //execution de la requette

    }else$reqajou="INSERT INTO juger (NUM_STG,NUM_ENS,EST_ENCADRER)VALUES ('$stage_num','$idEnsNew','0');";
    $bdd->exec($reqajou);
}
if(isset($_GET['supprimer'])){
        $jurysupp= $_GET['jury'];
        echo $jurysupp;
        if(isset($_GET['jury'])) {
            //requette de suppression
            $reqSup="DELETE FROM juger WHERE NUM_ENS='$jurysupp' and NUM_STG='$stage_num';";
            //executer la requette de suppression
            $bdd->exec($reqSup);
        }
}
if(isset($_GET['modif'])){

    $jurymodif= $_GET['jury'];
    $note=$_GET['Note'];
    echo $jurymodif;
    $requpdate = "UPDATE juger set NOTE='$note' WHERE NUM_STG='$stage_num' and NUM_ENS='$jurymodif'";
    $bdd->exec($requpdate);
}

$req2=" SELECT ens.NUM_ENS,ens.NOM_ENS,ens.PRENOM_ENS,ju.NOTE,ju.EST_ENCADRER
                                                FROM juger ju ,`ENSEIGNANT` ens,`ENSEIGNER` ensg WHERE ensg.NUM_ENS=ens.NUM_ENS 
                                                and ens.NUM_ENS=ju.NUM_ENS and  ju.NUM_STG='$stage_num' and ensg.NUM_FORM='$formation';";
$Smt2=$bdd->query($req2);
$ens=$Smt2->fetchAll(2);
$req1="SELECT offr.*,stg.*,ent.IMAGE_ENT,ent.LIBELLE_ENT FROM OFFREDESTAGE offr,ENTREPRISE ent,NIVEAU niv,stage stg 
                                               WHERE offr.NUM_ENT=ent.NUM_ENT and stg.NUM_OFFR=offr.NUM_OFFR and stg.NUM_STG='$stage_num';";
$Smt1=$bdd->query($req1);
$detaiOff=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC
$donnee=array(
    $detaiOff['NUM_STG'],
    $detaiOff['NUM_OFFR'],
    $detaiOff['CNE_ETU'],
    $detaiOff['DATEDEB_STG'],
    $detaiOff['DATEFIN_STG'],
    $detaiOff['NOTE_ENEX'],
    $detaiOff['SUJET_STG'],

    $detaiOff['VILLE_OFFR'],//7
    $detaiOff['PAYS_OFFR'],
    $detaiOff['LIEUX_OFFR'],

    $detaiOff['IMAGE_ENT'], //10
    $detaiOff['LIBELLE_ENT'],
    $detaiOff['CONTRAT_STG'],
);
?>
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
    <title>Details Stage</title>
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
                    <li > <a href="gererStage.php"><i class=" active  bi bi-briefcase-fill"></i>Gerer Stage</a></li>
                </ul>
            </div>
        </div>
        <div class="p-4 col-xl-9 col-sm-12">
            <div class="intro  mt-3">
                <h3> <b>Stage N°<?php echo $donnee[0];?></b> </h3>

            </div>
            <div class="intro ">
                <p>
                    Consulter l'ensemble des information sur le stage

                </p>
            </div>
            <div class="row  border border-link rounded-3 py-4 px-2">

                <div class="col-xl-2 col-sm-12 me-4 ">
                    <img class="mx-auto mb-2" style="max-width: 150px; border-radius:10%; " src="<?php echo $donnee[10];?>" alt="">
                </div>
                <div class="col-xl-9 col-sm-12 me-4">
                    <div class="row mt-2">
                        <div class="col-xl-4 col-sm-12 m-0 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3  p-0">Société :</div>
                            <div class="col-auto prop-value"><?php echo $donnee[11];?></div>

                        </div>

                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto me-3 p-0 prop-name ">N° stage :</div>
                            <div class="col-auto prop-value"><?php echo $donnee[0];?></div>


                        </div>
                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto m-0 p-0  prop-name me-3">Note Général :</div>
                            <div class="col-auto prop-value">0</div>


                        </div>

                    </div>


                    <div class="row border rounded-3 mt-3 mb-2 p-1 pb-2">
                        <form   action="" method="get" >
                            <input type="text" class="d-none "  value="<?php echo $stage_num;?>" name="numStage" >
                            <input type="text" class="d-none "  value="<?php echo $donnee[1];?>" name="numOffre" >
                            <div class="row">
                                <div class="col-xl-6 col-sm-12 ">

                                    <label class="prop-name mt-2" for="inputdatDeb" >Date Debut </label>
                                    <input id="inputdatDeb" type="date"  class="form-control  inputstg1" disabled value="<?php echo $donnee[3];?>" name="dateDeb" >

                                </div>
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputdatFin" >Date Fin </label>
                                    <input id="inputdatFin" type="date"  class="form-control  inputstg1" disabled value="<?php echo $donnee[4];?>" name="dateFin" >

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputEMAIL" >Encadrant </label>
                                    <select id="inputEMAIL" class="form-select inputstg1" disabled name="encadrant" aria-label="Default select example">
                                        <?php
                                        foreach($ens as $V):
                                            if($V['EST_ENCADRER']=='1')
                                                echo" <option selected value=\"".$V['NUM_ENS']."\">".$V['NOM_ENS']." ".$V['PRENOM_ENS']."</option>";
                                            else
                                                echo" <option value=\"".$V['NUM_ENS']."\">".$V['NOM_ENS']." ".$V['PRENOM_ENS']."</option>";
                                        endforeach;
                                        ?>

                                    </select>
                                </div>
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputVille" >Ville </label>
                                    <input id="inputVille" type="text"  class="form-control  inputstg1" disabled value="<?php echo $donnee[7];?>" name="ville" >
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-xl-6 col-sm-12  ">
                                    <label class="prop-name mt-2" for="inputPays" >Pays </label>
                                    <input id="inputTEL" type="text"  class="form-control  inputstg1" disabled value="<?php echo $donnee[8];?>" name="pays" >
                                </div>
                                <div class="col-1 mt-4 ms-1">
                                    <button type="submit" name="send" class="btn d-none"  id="subbtnstg1" >
                                        <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                    <a onclick="modifySubmitdate('inputstg1','modifystg1','subbtnstg1')" id="modifystg1" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                </div>
                                <div class="col-xl-6 col-sm-12">
                                    <label class="prop-name mt-2" for="inputTEL" >Lieu </label>
                                    <input id="inputTEL" type="text"  class="form-control  inputstg1" disabled value="<?php echo $donnee[9];?>" name="lieu" >
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="row border rounded-3 mb-2 p-1 pb-2">
                        <form   action="" method="get" >
                            <input type="text" class="d-none "  value="<?php echo $stage_num;?>" name="numStage" >
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputdatNotext" >Note encadrant externe</label>
                                    <input id="inputdatNotext" type="number"  class="form-control  inputext" disabled value="<?php echo $donnee[5];?>" name="noteext" >

                                </div>
                                <div class="col-1 mt-4">
                                    <button type="submit" name="send" class="btn d-none"  id="subbtnext" >
                                        <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                    <a onclick="modifySubmitdate('inputext','modifyext','subbtnext')" id="modifyext" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                </div>
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputSujet" >Sujet Stage </label>
                                    <input id="inputSujet" type="text"  class="form-control  inputext" disabled value="<?php echo $donnee[6];?>" name="Sujet" >

                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="row mt-4 m-0">
                        <div class="col-xl-6 col-sm-12   d-flex ">
                            <div class="row mt-3 align-items-center   justify-content-start">
                                <div class="col-auto m-0 p-0 prop-name  ">
                                    <span>Rapport </span>
                                </div>
                                <div class="col-auto m-0 p-0 prop-value">
                                    <div class="ms-4">
                                        <a class=" btn px-5 " style="border: 1px solid #7B61FF;color: #7B61FF;" role="button" data-bs-toggle="modal" data-bs-target="#ModalRapport">Editer </a
                                        >
                                    </div>
                                </div>

                            </div>

                        </div> <div class="col-xl-6 col-sm-12 mt-3  d-flex ">
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
                    <div class="row mt-4 m-0" id="divMere">

                                        <?php
                                        foreach($ens as $V):
                                            $jur=$V["NUM_ENS"]; //les autre ens du formation
                                            $req3=" SELECT ens.NUM_ENS,ens.NOM_ENS,ens.PRENOM_ENS from `ENSEIGNANT` ens,`ENSEIGNER` ensg WHERE ensg.NUM_ENS=ens.NUM_ENS 
                                                and ens.NUM_ENS!='$jur' and ensg.NUM_FORM='$formation';";
                                            $Smt3=$bdd->query($req3);
                                            $ens2=$Smt3->fetchAll(2);

                                           echo'<div style="max-width: 220px; min-width: 220px" class="col p-1 m-1  border rounded-3" id="divFils"><!--Affecter  <button type="submit" name="supprimer" class="btn bt "  > jury de stage-->
                                                <form method="get"> 
                                                    <input type="text" class="d-none "  value="'.$stage_num.'" name="numStage" >
                                                    <label for="inputJury" class="form-label">jury </label>
                                                    <select id="inputJury'.$V['NUM_ENS'].'"  class="form-control " disabled name="jury" >
                                                    ';
                                                        foreach ($ens2 as $en):
                                                        echo'<option  value="'.$en['NUM_ENS'].'">'.$en['NOM_ENS'].' '.$en['PRENOM_ENS'].'</option>';
                                                        endforeach;

                                                        echo '<option selected value="'.$V['NUM_ENS'].'">'.$V['NOM_ENS'].' '.$V['PRENOM_ENS'].'</option>';
                                                    echo'</select>
                                                    <label for="" class="form-label">Note</label>
                                                    <input id="inputJury" type="number" class="form-control inputJury'.$V['NUM_ENS'].'" value="'.$V['NOTE'].'" disabled name="Note" >
                                                    
                                                    <a href="../pages/resposable-details-stage.php?numStage='.$stage_num.'&supprimer=1&jury='.$V['NUM_ENS'].'"><i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-x-square"></i></a>
                                                    <button onclick="document.getElementById(\'inputJury'.$V['NUM_ENS'].'\').disabled=false;"  type="submit" name="modif" class="btn d-none"  id="subbtnJury'.$V['NUM_ENS'].'" >
                                                            <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                                    <a  onclick="modifySubmitdate(\'inputJury'.$V['NUM_ENS'].'\',\'modifyJury'.$V['NUM_ENS'].'\',\'subbtnJury'.$V['NUM_ENS'].'\')" id="modifyJury'.$V['NUM_ENS'].'" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                                    
                                                </form>
                                             </div>'
                                                ;
                                       endforeach; ?>

                        <div class="col-4 mt-5" align="center" id="ajoutJury">
                            <a onclick="AddJury('#divMere','#ajoutJury')"  type="btn"><i id="ajouter" style="font-size: 50px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-plus-square"></i></a>
                        </div>
                                    </div>




                    <div class="row mt-4">
                        <div class="col-xl-4 col-sm-12 m-0 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3  p-0">Offre de stage N°:</div>
                            <div class="col-auto prop-value " style="color: #7B61FF;"><a href="../pages/resposable-details-offre.php?numOffre=<?php echo $donnee[1];?>"><?php echo $donnee[1];?></a> </div>

                        </div>

                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto me-3 p-0 prop-name ">Etudiant N° :</div>
                            <div class="col-auto prop-value" style="color: #7B61FF;"><a href="../pages/resposable-details-etudiant.php?cne=<?php echo $donnee[2];?>"><?php echo $donnee[2];?></a> </div>


                        </div>


                    </div>


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
                                    <img class="me-2" src="/assets/icon/step1.svg" alt="">
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


<?php

$req4="SELECT ens.NUM_ENS,ens.NOM_ENS,ens.PRENOM_ENS from `ENSEIGNANT` ens,`ENSEIGNER` ensg 
                                              WHERE ensg.NUM_ENS=ens.NUM_ENS and ensg.NUM_FORM='$formation' 
                                            and (ens.NUM_ENS not in ( SELECT ju.NUM_ENS FROM juger ju where ju.NUM_STG='$stage_num'));";
$Smt4=$bdd->query($req4);
$ens4=$Smt4->fetchAll(2);
$ful=0;
if (empty($ens4))  $ful=1;

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="/js/script2.js"></script>
<script>
   const AddJury=(divMere,divAjout)=>{
       let num ='<?php echo $stage_num?>';
       let plein='<?php echo $ful?>';
       if(plein==='0'){
           let nd='<div style="max-width: 220px; min-width: 220px" class="col p-1 m-1  border rounded-3">'+
               '  <form><input type="text" class="d-none "  value="'+num+'" name="numStage" >'+
               '    <label for="inputJury" class="form-label">jury </label>'+
               '  <select id="inputJuryAdd"  class="form-control "  name="juryAjou" >\';'+
               <?php foreach ($ens4 as $en3):
                   echo '\'<option  value="'.$en3['NUM_ENS'].'">'.$en3['NOM_ENS'].' '.$en3['PRENOM_ENS'].'</option>\'+';
               endforeach;?>
               '</select><label for="" class="form-label">Note</label>'+
               '<input  type="number" class="form-control "  name="NoteAjou" >'+
               '<button type="submit" name="ajouter" class="btn bt"  id="btnAjouter" >'+
               ' <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>'+
               '</form></div>';
           $(divMere).append(nd);
       }
       $(divAjout).hide();
   }

</script>
</body>

</html>