<?php
require(__DIR__ . './../phpQueries/uploads.php');
$stage_num = $_GET['numStage'];

if (isset($_POST['filesUpload']) || (isset($_POST['contratUpload']))) {
    $stage_num = $_POST['numStage'];
    print_r($_POST);
}
//ANNULER STAGE
if(isset($_GET["annulerStg"])){
    $requpdate = "UPDATE stage set ACTIVE_STG='1' WHERE NUM_STG='$stage_num'";
    $bdd->exec($requpdate);
}
if (!isset($stage_num)) header('location:gererStage.php');

//jury note
$reqNot = "SELECT NUM_STG, sum(juger.NOTE) somme,COUNT(juger.NUM_ENS) effe FROM juger  WHERE NUM_STG='$stage_num' GROUP by NUM_STG;";
$SmtNot = $bdd->query($reqNot);
$Note = $SmtNot->fetch(2);
if(!empty($Note)) $notGenerale=((float)($Note['somme']/$Note['effe']));
else $notGenerale=0;
//RAPPORT STAGE REQUETTE
$reqRap = "SELECT NUM_RAP nrp, INTITULE_RAP intirp, PATH_RAP pthrp FROM rapport rap WHERE rap.NUM_STG='$stage_num';";
$Smtrap = $bdd->query($reqRap);
$Rapport = $Smtrap->fetch(2);
$action = ' ';
if (empty($Rapport)) {
    $Rapport['nrp'] = 'vide';
    $Rapport['intirp'] = '';
    $Rapport['pthrp'] = 'vide';
    $action = 'disabled';
} else {
    if (!isset($Rapport['pthrp'])) $action = 'disabled';
}
$numRapp = $Rapport['nrp'];
//REQUETTE DES MOTS CLES DE CE RAP
$reqMotCleRAP = "SELECT NUM_CLE numCle FROM contenirmotrap where NUM_RAP='$numRapp';";
$SmtmcleRAP = $bdd->query($reqMotCleRAP);
$MotClesRAP = $SmtmcleRAP->fetchAll(2);
if (!empty($MotClesRAP)) {
    foreach ($MotClesRAP as $mclRap) {
        $listMotCleRap[] = $mclRap['numCle'];
    }
} else $listMotCleRap[] = '-1';
if (isset($_POST['contratUpload'])) {

    $file = $_FILES['fileContrat'];
    if (!empty($file['name'])) {
        //importer le fichier au firebase stockage a distance
        $file = $_POST['contratPath'];
        if (!empty($file)) {
            uploadImagesOrCVFirebase($stage_num, $file, $bdd, 6);
            header('location:resposable-details-stage.php?numStage=' . $stage_num);
        }


    }
}
if (isset($_POST['filesUpload'])) {
    echo 'ouui';
    $intit = addslashes($_POST['intituler']);
    $file = $_FILES['file'];
    if ($Rapport['nrp'] == 'vide') {//creer rapport
        $reqrapadd = "  insert into `rapport`(num_stg, intitule_rap)values ('$stage_num','$intit');";
        $bdd->exec($reqrapadd);
        //recuperer le cle du nouveau rapport just crée
        $reqRap = "SELECT NUM_RAP nrp, INTITULE_RAP intirp, PATH_RAP pthrp FROM rapport rap WHERE rap.NUM_STG='$stage_num';";
        $Smtrap = $bdd->query($reqRap);
        $Rapport = $Smtrap->fetch(2);
        $numRapp = $Rapport['nrp'];
    } else {
        $reqrapadd = "UPDATE `rapport` SET `intitule_rap`= '$intit' WHERE `NUM_STG` = '$stage_num';";
        $bdd->exec($reqrapadd);
    }
    if (!empty($file['name'])) {
        //importer le fichier au firebase stockage a distance
        $file = $_POST['rapportPath'];
        uploadImagesOrCVFirebase($stage_num, $file, $bdd, 5);
        //importer local
        //uploadImagesOrCVEtudiant($stage_num, $file, $bdd, 5);
    }


    if (isset($_POST["mcl"])) {
        $reqmcldel = "DELETE FROM contenirmotrap WHERE NUM_RAP='$numRapp';";
        $bdd->exec($reqmcldel);
        foreach ($_POST["mcl"] as $newMotCle) {
            $reqmcldel = "insert into `contenirmotrap`(NUM_RAP, NUM_CLE)values ('$numRapp','$newMotCle');";
            $bdd->exec($reqmcldel);
        }

    }
    header('location:resposable-details-stage.php?numStage=' . $stage_num);
}

if (isset($_GET['send'])) {
    switch ($_GET['send']) {
        case 'modifystg1':
            $idEns = $_GET['encadrant'];
            $numoff = $_GET['numOffre'];
            $datDeb = $_GET['dateDeb'];
            $datFin = $_GET['dateFin'];
            $ville = addslashes($_GET['ville']);
            $pays = addslashes($_GET['pays']);
            $lieu = addslashes($_GET['lieu']);

            $requpdate = "UPDATE OFFREDESTAGE set VILLE_OFFR='$ville',PAYS_OFFR='$pays',LIEUX_OFFR='$lieu' WHERE NUM_OFFR='$numoff'";
            $bdd->exec($requpdate);
            $requpdate = "UPDATE stage set DATEDEB_STG='$datDeb',DATEFIN_STG='$datFin' WHERE NUM_STG='$stage_num'";
            $bdd->exec($requpdate);
            //initialiser le jurie ( personne n'est un 'encadrant') pour ne pas avoir plus q'un encadrent
            foreach ($ens as $V):
                $requpdate = "UPDATE juger set EST_ENCADRER='0' WHERE NUM_STG='$stage_num'";
                $bdd->exec($requpdate);
            endforeach;
            //affecter le nouveau encadrant parmit le jurie
            $requpdate = "UPDATE juger set EST_ENCADRER='1' WHERE NUM_STG='$stage_num' and NUM_ENS='$idEns'";
            $bdd->exec($requpdate);
            break;
        case 'modifyext':
            $noteext = $_GET['noteext'];
            $sujet = addslashes($_GET['sujet']);
            $req = "UPDATE stage set NOTE_ENEX='$noteext',SUJET_STG='$sujet' WHERE NUM_STG='$stage_num'";
            $bdd->exec($req);
            break;
    }

    header('location:resposable-details-stage.php?numStage=' . $stage_num);

}
//ajouter jurie
if (isset($_GET['ajouter'])) {
    $idEnsNew = $_GET['juryAjou'];
    if (!empty($_GET['NoteAjou'])) {
        $note = $_GET['NoteAjou'];
        $reqajou = "INSERT INTO juger (NUM_STG,NUM_ENS,NOTE,EST_ENCADRER)
              VALUES ('$stage_num','$idEnsNew','$note','0');";
        //execution de la requette

    } else$reqajou = "INSERT INTO juger (NUM_STG,NUM_ENS,EST_ENCADRER)VALUES ('$stage_num','$idEnsNew','0');";
    $bdd->exec($reqajou);
    header('location:resposable-details-stage.php?numStage=' . $stage_num);
}
//supprimer jurie
if (isset($_GET['supprimer'])) {
    $jurysupp = $_GET['jury'];
    echo $jurysupp;
    if (isset($_GET['jury'])) {
        //requette de suppression
        $reqSup = "DELETE FROM juger WHERE NUM_ENS='$jurysupp' and NUM_STG='$stage_num';";
        //executer la requette de suppression
        $bdd->exec($reqSup);
    }
    header('location:resposable-details-stage.php?numStage=' . $stage_num);
}
//modifier jurie et leurs notes
if (isset($_GET['modif'])) {

    $jurymodif = $_GET['jury'];
    $note = $_GET['Note'];
    echo $jurymodif;
    $requpdate = "UPDATE juger set NOTE='$note' WHERE NUM_STG='$stage_num' and NUM_ENS='$jurymodif'";
    $bdd->exec($requpdate);
    header('location:resposable-details-stage.php?numStage=' . $stage_num);
}
//l'affichage
$req2 = " SELECT ens.NUM_ENS,ens.NOM_ENS,ens.PRENOM_ENS,ju.NOTE,ju.EST_ENCADRER
                                                FROM juger ju ,`ENSEIGNANT` ens,`ENSEIGNER` ensg WHERE ensg.NUM_ENS=ens.NUM_ENS 
                                                and ens.NUM_ENS=ju.NUM_ENS and  ju.NUM_STG='$stage_num' and ensg.NUM_FORM='$formation';";
$Smt2 = $bdd->query($req2);
$ens = $Smt2->fetchAll(2);
$req1 = "SELECT offr.*,stg.*,ent.IMAGE_ENT,ent.LIBELLE_ENT FROM OFFREDESTAGE offr,ENTREPRISE ent,NIVEAU niv,stage stg 
                                               WHERE offr.NUM_ENT=ent.NUM_ENT and stg.NUM_OFFR=offr.NUM_OFFR and stg.NUM_STG='$stage_num';";
$Smt1 = $bdd->query($req1);
$detaiOff = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

//REQUETE DE TOUS MOTS CLES
$reqMotCle = "SELECT NUM_CLE numCle, LIBELLE_CLE libCle FROM motcle";
$Smtmcle = $bdd->query($reqMotCle);
$MotCles = $Smtmcle->fetchAll(2);
$donnee = array(
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
$actionCrt = ' ';
if (empty($donnee[12])) $actionCrt = 'disabled';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
          integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"/>


    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />

    <link rel="stylesheet" href="../css/style.css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>

    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-storage.js"></script>

    <title>Details Stage</title>
</head>

<body>

<!-- Navbar  -->
<?php
require_once "./nav-ens.php"
?>

<div class="container ">
    <div class="row">
        <div class="col-xl-3   col-sm-12">
            <div class="sidebar ps-2 pe-2 pt-2 pb-2  mt-4">
                <ul type="none">
                    <li><a href="gererStage.php"><i class=" active  bi bi-briefcase-fill"></i>Gerer Stage</a></li>
                </ul>
            </div>
        </div>
        <div class="p-4 col-xl-9 col-sm-12">
            <div class="intro  mt-3">
                <h3><b>Stage N°<?php echo $donnee[0]; ?></b></h3>

            </div>
            <div class="intro ">
                <p>
                    Consulter l'ensemble des information sur le stage

                </p>
            </div>
            <div class="row  border border-link rounded-3 py-4 px-2">

                <div class="col-xl-2 col-sm-12 me-4 ">
                    <img class="mx-auto mb-2" style="max-width: 150px; border-radius:10%; "
                         src="<?php echo $donnee[10]; ?>" alt="">
                </div>
                <div class="col-xl-9 col-sm-12 me-4">
                    <div class="row mt-2">
                        <div class="col-xl-3 col-sm-12 m-0 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3  p-0">Société :</div>
                            <div class="col-auto prop-value"><?php echo $donnee[11]; ?></div>

                        </div>

                        <div class="col-xl-3 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto me-3 p-0 prop-name ">N° stage :</div>
                            <div class="col-auto prop-value"><?php echo $donnee[0]; ?></div>


                        </div>
                        <div class="col-xl-3 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto m-0 p-0  prop-name me-3">Note Général :</div>
                            <div class="col-auto prop-value"><?php echo number_format($notGenerale,2); ?></div>


                        </div>
                        <div class="col-xl-3 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <button class="col-auto m-0 pt-0 pb-0 btn btn-danger  prop-name me-3" data-bs-toggle="modal" data-bs-target="#Annuler">Annuler</button>

                        </div>

                    </div>


                    <div class="row border rounded-3 mt-3 mb-2 p-1 pb-2">
                        <form action="" method="get">
                            <input type="text" class="d-none " value="<?php echo $stage_num; ?>" name="numStage">
                            <input type="text" class="d-none " value="<?php echo $donnee[1]; ?>" name="numOffre">
                            <div class="row">
                                <div class="col-xl-6 col-sm-12 ">

                                    <label class="prop-name mt-2" for="inputdatDeb">Date Debut </label>
                                    <input id="inputdatDeb" type="date" class="form-control  inputstg1" required disabled
                                           value="<?php echo $donnee[3]; ?>" name="dateDeb">

                                </div>
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputdatFin">Date Fin </label>
                                    <input id="inputdatFin" type="date" class="form-control  inputstg1" required disabled
                                           value="<?php echo $donnee[4]; ?>" name="dateFin">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputEMAIL">Encadrant </label>
                                    <select id="inputEMAIL" class="form-select inputstg1" disabled name="encadrant"
                                            aria-label="Default select example">
                                        <?php
                                        foreach ($ens as $V):
                                            if ($V['EST_ENCADRER'] == '1')
                                                echo " <option selected value=\"" . $V['NUM_ENS'] . "\">" . $V['NOM_ENS'] . " " . $V['PRENOM_ENS'] . "</option>";
                                            else
                                                echo " <option value=\"" . $V['NUM_ENS'] . "\">" . $V['NOM_ENS'] . " " . $V['PRENOM_ENS'] . "</option>";
                                        endforeach;
                                        ?>

                                    </select>
                                </div>
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputVille">Ville </label>
                                    <input id="inputVille" type="text" class="form-control  inputstg1" disabled
                                           value="<?php echo $donnee[7]; ?>"
                                           pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"
                                           title="ville ne contient pas des caractères speciaux" name="ville">
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-xl-6 col-sm-12  ">
                                    <label class="prop-name mt-2" for="inputPays">Pays </label>
                                    <input id="inputTEL" type="text" class="form-control  inputstg1" disabled
                                           value="<?php echo $donnee[8]; ?>"
                                           pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"
                                           title="pays ne contient pas des caractères speciaux" name="pays">
                                </div>
                                <div class="col-1 mt-4 ms-1">
                                    <button type="submit" name="send" class="btn d-none" id="subbtnstg1">
                                        <i style="font-size: 20px;color: #7B61FF;cursor: pointer;"
                                           class="m-0 p-0 bi bi-check-square"></i></button>
                                    <a onclick="modifySubmitdate('inputstg1','modifystg1','subbtnstg1')" id="modifystg1"
                                       type="btn"><i id="modifier"
                                                     style="font-size: 20px;color: #7B61FF;cursor: pointer;"
                                                     class="bi bi-pencil-square"></i></a>
                                </div>
                                <div class="col-xl-6 col-sm-12">
                                    <label class="prop-name mt-2" for="inputTEL">Lieu </label>
                                    <input id="inputTEL" type="text" class="form-control  inputstg1" disabled
                                           value="<?php echo $donnee[9]; ?>" name="lieu">
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="row border rounded-3 mb-2 p-1 pb-2">
                        <form action="" method="get">
                            <input type="text" class="d-none " value="<?php echo $stage_num; ?>" name="numStage">
                            <div class="row">
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputdatNotext">Note encadrant externe</label>
                                    <input id="inputdatNotext" type="number" class="form-control  inputext" disabled
                                           pattern="[0-9]+([\.][0-9]+)?" step="0.01"
                                           title="un reel, ex: 2.3" value="<?php echo $donnee[5]; ?>" name="noteext">

                                </div>
                                <div class="col-1 mt-4">
                                    <button type="submit" name="send" class="btn d-none" id="subbtnext">
                                        <i style="font-size: 20px;color: #7B61FF;cursor: pointer;"
                                           class="m-0 p-0 bi bi-check-square"></i></button>
                                    <a onclick="modifySubmitdate('inputext','modifyext','subbtnext')" id="modifyext"
                                       type="btn"><i id="modifier"
                                                     style="font-size: 20px;color: #7B61FF;cursor: pointer;"
                                                     class="bi bi-pencil-square"></i></a>
                                </div>
                                <div class="col-xl-6 col-sm-12">

                                    <label class="prop-name mt-2" for="inputSujet">Sujet Stage </label>
                                    <input id="inputSujet" type="text" class="form-control  inputext" disabled
                                           value="<?php echo $donnee[6]; ?>" name="sujet">

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
                                        <a class=" btn px-5 " style="border: 1px solid #7B61FF;color: #7B61FF;"
                                           role="button" data-bs-toggle="modal"
                                           data-bs-target="#ModalRapport">Editer </a
                                        >
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-xl-6 col-sm-12 mt-3  d-flex ">
                            <div class="row align-items-center  justify-content-start">
                                <div class="col-auto m-0 p-0 prop-name ">
                                    <span>Contrat </span>
                                </div>
                                <div class="col-auto m-0 p-0 prop-value">
                                    <div class="ms-4">
                                        <a  id="" class=" btn px-5 "
                                           style="border: 1px solid #7B61FF;color: #7B61FF;" href="#" role="button"
                                           data-bs-toggle="modal" data-bs-target="#ModalContrat">Editer </a
                                        >
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 m-0" id="divMere">

                        <?php
                        foreach ($ens as $V):
                            $jur = $V["NUM_ENS"]; //les autre ens du formation
                            $req3 = " SELECT ens.NUM_ENS,ens.NOM_ENS,ens.PRENOM_ENS from `ENSEIGNANT` ens,`ENSEIGNER` ensg WHERE ensg.NUM_ENS=ens.NUM_ENS 
                                                and ens.NUM_ENS!='$jur' and ensg.NUM_FORM='$formation';";
                            $Smt3 = $bdd->query($req3);
                            $ens2 = $Smt3->fetchAll(2);

                            echo '<div style="max-width: 220px; min-width: 220px" class="col p-1 m-1  border rounded-3" id="divFils"><!--Affecter  <button type="submit" name="supprimer" class="btn bt "  > jury de stage-->
                                                <form method="get"> 
                                                    <input type="text" class="d-none "  value="' . $stage_num . '" name="numStage" >
                                                    <label for="inputJury" class="form-label">jury </label>
                                                    <select id="inputJury' . $V['NUM_ENS'] . '"  class="form-control " disabled name="jury" >
                                                    ';
                            foreach ($ens2 as $en):
                                echo '<option  value="' . $en['NUM_ENS'] . '">' . $en['NOM_ENS'] . ' ' . $en['PRENOM_ENS'] . '</option>';
                            endforeach;

                            echo '<option selected value="' . $V['NUM_ENS'] . '">' . $V['NOM_ENS'] . ' ' . $V['PRENOM_ENS'] . '</option>';
                            echo '</select>
                                                    <label for="" class="form-label">Note</label>
                                                    <input id="inputJury" type="number" pattern="[0-9]+([\.][0-9]+)?" step="0.01" title="un reel, ex: 2.3"  class="form-control inputJury' . $V['NUM_ENS'] . '" value="' . $V['NOTE'] . '" disabled name="Note" >
                                                    
                                                    <a href="../pages/resposable-details-stage.php?numStage=' . $stage_num . '&supprimer=1&jury=' . $V['NUM_ENS'] . '"><i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-x-square"></i></a>
                                                    <button onclick="document.getElementById(\'inputJury' . $V['NUM_ENS'] . '\').disabled=false;"  type="submit" name="modif" class="btn d-none"  id="subbtnJury' . $V['NUM_ENS'] . '" >
                                                            <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                                    <a  onclick="modifySubmitdate(\'inputJury' . $V['NUM_ENS'] . '\',\'modifyJury' . $V['NUM_ENS'] . '\',\'subbtnJury' . $V['NUM_ENS'] . '\')" id="modifyJury' . $V['NUM_ENS'] . '" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                                    
                                                </form>
                                             </div>';
                        endforeach; ?>

                        <div class="col-4 mt-5" align="center" id="ajoutJury">
                            <a onclick="AddJury('#divMere','#ajoutJury')" type="btn"><i id="ajouter"
                                                                                        style="font-size: 50px;color: #7B61FF;cursor: pointer;"
                                                                                        class="m-0 p-0 bi bi-plus-square"></i></a>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-xl-4 col-sm-12 m-0 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3  p-0">Offre de stage N°:</div>
                            <div class="col-auto prop-value " style="color: #7B61FF;"><a
                                        href="../pages/resposable-details-offre.php?numOffre=<?php echo $donnee[1]; ?>"><?php echo $donnee[1]; ?></a>
                            </div>

                        </div>

                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto me-3 p-0 prop-name ">Etudiant N° :</div>
                            <div class="col-auto prop-value" style="color: #7B61FF;"><a
                                        href="../pages/resposable-details-etudiant.php?cne=<?php echo $donnee[2]; ?>"><?php echo $donnee[2]; ?></a>
                            </div>


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
                                            <select id="inputRapport" class="form-select"
                                                    aria-label="Default select example">
                                                <option selected value="1">importer</option>
                                                <option value="2">télecharger</option>
                                            </select></div>

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="ms-4 mt-2 row">
                            <a href="<?php echo $Rapport['pthrp'] ?>"
                               target="_blank"
                               class="ms-4 btn btn-selector d-none <?php echo $action ?>" id="btnDnL" download>Telecharger</a>
                        </div>

                        <div class="d-flex mt-4 align-items-center inforap">
                            <img class="me-2" src="./../../assets/icon/step2.svg" alt="">
                            <span class="subheadline-form">Information sur Rapport</span>
                        </div>
                        <div class="row inforap">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="text" class="d-none" value="<?php echo $stage_num ?>" name="numStage">
                                <div class="col-10 ms-5   align-items-start ">

                                    <div class="mt-2 p-2 border border-1 rounded-3 ">
                                        <div>
                                            <div class=" p-3 ">

                                                <div>
                                                    <div class="row mt-2 ">
                                                        <div class="col-xl-12 col-sm-12">
                                                            <label for="inputIntitule"
                                                                   class="col-form-label">Intitule</label>

                                                            <input class="form-control" type="text" id="inputIntitule"
                                                                   value="<?php echo $Rapport['intirp'] ?>"
                                                                   name="intituler">
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="row ms-1"> Mots clés</div>
                                                        <div class="col">
                                                            <select class="selectpicker form-control" id="mote" multiple
                                                                    title="max 3 mots"
                                                                    data-live-search="true" name="mcl[]"
                                                                    data-max-options="3">
                                                                <?php
                                                                //numCle libCle $MotCles

                                                                foreach ($MotCles as $mot):
                                                                    if (in_array($mot["numCle"], $listMotCleRap)) {
                                                                        echo '<option value="' . $mot['numCle'] . '" selected>' . $mot['libCle'] . '</option>';
                                                                    } else  echo '<option value="' . $mot['numCle'] . '">' . $mot['libCle'] . '</option>';

                                                                endforeach;
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row mt-2 d-flex justify-content-around ">
                                                        <div style="width: fit-content"
                                                             class="mt-2 ms-3 col-6 px-5 py-4  d-flex flex-column rounded-4 justify-content-center border border-link">
                                                            <img style="margin: auto; max-width: 64px"
                                                                 src="./../assets/icon/rapport-icon.svg" alt=""/>
                                                            <input class="form-control d-none" name="rapportPath"
                                                                   id="rapportPath">
                                                            <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
                                                            <input type="file" class="d-none" name="file" id="rap"
                                                                   onchange="uploadFileToFirebase('rap','btnSubmit','rapportPath',5,'<?php echo $donnee[2] . $donnee[1].$stage_num; ?>')">
                                                            <label class="mt-3 btn-voir-plus py-2 px-4"
                                                                   style="width: fit-content; font-size: 16px"
                                                                   for="rap">Importer <i
                                                                        class="bi bi-file-arrow-up-fill"></i
                                                                ></label>
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
                                        <button type="submit" name="filesUpload" id="btnSubmit"
                                                class="btn btn-filtre btn-primary w-100 mb-3"> Ajouter <i
                                                    class="bi bi-plus-circle-fill"></i></button>
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
                            <div class="mt-4">
                                <div class="d-flex align-items-center ">
                                    <img class="me-2" src="./../../assets/icon/step1.svg" alt="">
                                    <span class="subheadline-form">Action sur Contrat</span>
                                </div>

                                <div class="row mt-4 ms-5   py-2 border border-1 rounded-3" style="width: 50%;">

                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-4 col-sm-6">
                                                <label for="inputContrat" class="col-form-label">Action</label>

                                            </div>
                                            <div class="col-8 col-sm-6">
                                                <select id="inputContrat" class="form-select"
                                                        aria-label="Default select example">

                                                    <option selected value="1">importer</option>
                                                    <option value="2">telecharger</option>
                                                </select></div>

                                        </div>


                                    </div>
                                </div>
                            </div>


                            <div class="ms-4 mt-2 row">
                                <a href="<?php echo $donnee[12] ?>"
                                   target="_blank"
                                   class="ms-4 btn btn-selector d-none <?php echo $actionCrt ?>" id="btnDnLCrt"
                                   download>Telecharger</a>
                            </div>
                            <div class="d-flex mt-4 align-items-center infocrt">
                                <img class="me-2" src="./../../assets/icon/step2.svg" alt="">
                                <span class="subheadline-form">Importer Contrat</span>
                            </div>
                            <div class="row infocrt">
                                <form  method="POST" enctype="multipart/form-data">
                                    <input type="text" class="d-none " value="<?php echo $stage_num; ?>"
                                           name="numStage">
                                    <div class="col-10 ms-5   align-items-start ">

                                        <div class="mt-2 p-2 border border-1 rounded-3 ">
                                            <div>
                                                <div class=" p-3 ">

                                                    <div>


                                                        <div class="row mt-2 d-flex justify-content-around ">
                                                            <input class="form-control d-none" name="contratPath"
                                                                   id="contratPath">
                                                            <div style="width: fit-content"
                                                                 class="mt-2 ms-3 col-6 px-5 py-4  d-flex flex-column rounded-4 justify-content-center border border-link">
                                                                <img style="margin: auto; max-width: 64px"
                                                                     src="./../assets/icon/contrat-icon.svg" alt=""/>

                                                                <label for="fileContrat"
                                                                       class="col-form-label mt-2 btn py-2 px-5 mt-3 btn-voir-plus">
                                                                    Importer <i class="bi bi-file-arrow-up-fill"></i>
                                                                </label>
                                                                <input class="form-control d-none" name="fileContrat"
                                                                       onchange="uploadFileToFirebase('fileContrat','btnSubmitCrt','contratPath',6,'<?php echo $donnee[2] . $donnee[1] . $stage_num; ?>')"
                                                                       accept="application/pdf" type="file"
                                                                       id="fileContrat">

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
                                            <button type="submit" name="contratUpload" id="btnSubmitCrt"
                                                    class="btn btn-filtre btn-primary w-100 mb-3"> Ajouter
                                                <i class="bi bi-plus-circle-fill"></i></button>
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


<!-- Modal  Annuler Stage-->
<div class="modal fade" id="Annuler" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 500px;max-width: 800px">
        <div class="modal-content d-flex justify-content-center " style="max-width: 800px;margin:auto;">
            <div class="modal-header border-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" align="center">
                        <span class="headline-form text-danger">Voulez vous vraiment annuler ce stage !</span>
                        <i class="bi bi-exclamation-triangle" style="font-size: 50px; color: orangered"></i>
                    </div>
                    <div>
                        <form method="get">
                            <input type="text" class="d-none " value="<?php echo $stage_num; ?>" name="numStage">
                            <div class="row">
                                <button style="width: 100%; height: 30px;" class="col-auto m-0 pt-0 pb-0 btn btn-danger  prop-name me-3" name="annulerStg" type="submit">Annuler</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
<div id="modal-progress-upload">

</div>

<script>
    let activities = document.getElementById("inputRapport");
    let infoRap = document.getElementsByClassName('inforap');
    let btnDownload = document.getElementById('btnDnL');
    activities.addEventListener("change", function () {
        if (activities.value === "2") {
            for (let i = 0; i < infoRap.length; i++)
                infoRap[i].classList.add('d-none');

            btnDownload.classList.remove('d-none');
        } else {
            for (let i = 0; i < infoRap.length; i++)
                infoRap[i].classList.remove('d-none');
            btnDownload.classList.add('d-none');
        }
    });


    let activitiescrt = document.getElementById("inputContrat");
    let infoCrt = document.getElementsByClassName('infocrt');
    let btnDownloadCrt = document.getElementById('btnDnLCrt');
    activitiescrt.addEventListener("change", function () {
        if (activitiescrt.value === "2") {
            for (let i = 0; i < infoCrt.length; i++)
                infoCrt[i].classList.add('d-none');

            btnDownloadCrt.classList.remove('d-none');
        } else {
            for (let i = 0; i < infoCrt.length; i++)
                infoCrt[i].classList.remove('d-none');
            btnDownloadCrt.classList.add('d-none');
        }
    });

    function addActivityItem() {
        activities.addEventListener("click", function () {
            let options = activities.querySelectorAll("option");
            let count = options.length;

            if (typeof (count) === "undefined" || count < 2) {

            }
        });
    }
</script>
<?php

$req4 = "SELECT ens.NUM_ENS,ens.NOM_ENS,ens.PRENOM_ENS from `ENSEIGNANT` ens,`ENSEIGNER` ensg 
                                              WHERE ensg.NUM_ENS=ens.NUM_ENS and ensg.NUM_FORM='$formation' 
                                            and (ens.NUM_ENS not in ( SELECT ju.NUM_ENS FROM juger ju where ju.NUM_STG='$stage_num'));";
$Smt4 = $bdd->query($req4);
$ens4 = $Smt4->fetchAll(2);
$ful = 0;
if (empty($ens4)) $ful = 1;

?>
<script src="/js/script2.js"></script>
<script src="./../js/script-upload.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
        integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>-->

<script>
    const AddJury = (divMere, divAjout) => {
        let num = '<?php echo $stage_num?>';
        let plein = '<?php echo $ful?>';
        if (plein === '0') {
            let nd = '<div style="max-width: 220px; min-width: 220px" class="col p-1 m-1  border rounded-3">' +
                '  <form><input type="text" class="d-none "  value="' + num + '" name="numStage" >' +
                '    <label for="inputJury" class="form-label">jury </label>' +
                '  <select id="inputJuryAdd"  class="form-control "  name="juryAjou" >\';' +
                <?php foreach ($ens4 as $en3):
                    echo '\'<option  value="' . $en3['NUM_ENS'] . '">' . $en3['NOM_ENS'] . ' ' . $en3['PRENOM_ENS'] . '</option>\'+';
                endforeach;?>
                '</select><label for="" class="form-label">Note</label>' +
                '<input  type="number" pattern="[0-9]+([\.][0-9]+)?" step="0.01"' +
                'title="un reel, ex: 2.3"  class="form-control "  name="NoteAjou" >' +
                '<button type="submit" name="ajouter" class="btn bt"  id="btnAjouter" >' +
                ' <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>' +
                '</form></div>';
            $(divMere).append(nd);
        }
        $(divAjout).hide();
    }

</script>
</body>

</html>