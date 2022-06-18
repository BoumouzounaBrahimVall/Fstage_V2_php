<?php
require(__DIR__ . '../../phpQueries/respoRequiries.php');
require(__DIR__ . './../phpQueries/etudiant/uploadfile.php');

@$cne_courant= $_GET['cnee'];
if(!is_null($cne_courant)){
$req_infoEtud="SELECT * from ETUDIANT where ETUDIANT.CNE_ETU='$cne_courant';";
$smt_infoEtud=$bdd->query($req_infoEtud);
$infoEtud=$smt_infoEtud->fetch(2);

    //selectionner dernier niveau
$req_lastNiv = "SELECT ETUDIER.NUM_NIV from ETUDIER where ETUDIER.CNE_ETU='$cne_courant' and ETUDIER.NUM_NIV>=All(SELECT NUM_NIV from NIVEAU where CNE_ETU='$cne_courant');";
$smt_lastNiv=$bdd->query($req_lastNiv);
$lastNiv=$smt_lastNiv->fetch(2);
$dernierNv= $lastNiv['NUM_NIV'];
if($infoEtud['ACTIVE_ETU']==0){
//desactiver l etudiant
$req_annulerEtud = "UPDATE ETUDIANT set ETUDIANT.ACTIVE_ETU='1'where ETUDIANT.CNE_ETU='$cne_courant'; ";
$bdd->exec($req_annulerEtud);
}
else
{
    //activer Etudiant
    $req_annulerEtud = "UPDATE ETUDIANT set ETUDIANT.ACTIVE_ETU='0'where ETUDIANT.CNE_ETU='$cne_courant'; ";
    $bdd->exec($req_annulerEtud); 
}
//annuler le stage le stage actuel de l etudiant
// $req_annulerstg_Etud = "UPDATE stage set stage.ACTIVE_STG='1' where  stage.CNE_ETU='$cne_courant' and stage.NUM_OFFR in (SELECT offredestage.NUM_OFFR from offredestage where   offredestage.NUM_NIV='$dernierNv'); ";
// $bdd->exec($req_annulerstg_Etud);





} 



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $donnee = array(
        $_POST['cne'],
        $_POST['prenom'],
        $_POST['nom'],
        $_POST['datnes'],
        $_POST['email'],
        $pass,
        $_POST['tel'],
        $_POST['ville'],
        $_POST['pays'],
        $_POST['niveau']
    );
    //recuperer les donnees
    $nnn = $_POST['nom'];
    $ppp = $_POST['prenom'];
    //la requette d'insertion
    $req = "INSERT INTO Etudiant (CNE_ETU,PRENOM_ETU,NOM_ETU,DATENAISS_ETU,EMAIL_ENS_ETU,MOTDEPASSE_ETU,TEL_ETU,VILLE_ETU,PAYS_ETU)
               VALUES ('$donnee[0]','$donnee[1]','$donnee[2]','$donnee[3]','$donnee[4]','$donnee[5]','$donnee[6]','$donnee[7]','$donnee[8]');";
    //execution de la requette
    $bdd->exec($req);
    $DT = date("Y-m-d");
    $req = "INSERT INTO ETUDIER (CNE_ETU,NUM_NIV,DATE_NIV)
               VALUES ('$donnee[0]','$donnee[9]','$DT')";
    //execution de la requette
    $bdd->exec($req);
    if (isset($_POST['cvPath'])) {

        $file = $_POST['cvPath'];
        uploadImagesOrCVFirebase($donnee[0], $file, $bdd, 1);
    }

    header('location:../pages/gererEtudiant.php');

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require_once "./meta-tag.php"
    ?>
    <title>Gerer etudiants</title>


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
                            <li><a href="#" class="actuel-page"><i class=" active  bi bi-person-fill"></i>Gérer
                                    Etudiants</a></li>
                            <li><a href="gererEnseignant.php"><i class=" active  bi bi-person-fill"></i>Gérer Enseignant</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class=" col p-4  mt-0">
                    <div class="row  px-4 py-0">
                        <h4>Gerer comptes des etudiants</h4>
                    </div>
                    <div class="row  p-0 mt-0 mb-5">
                        <div class="col  p-4 mr-2 ">

                            <div class="row  p-4 statis-div-2">
                                <div class="col-3 col-sm-5  p-4">
                                    <img src="../assets/icon/student.png" alt="offres">
                                </div>
                                <div class="col p-4">
                                    <?php
                                    $req1 = "SELECT COUNT(distinct( ETUDIANT.CNE_ETU)) nbr FROM `ETUDIANT`,`NIVEAU`,`ETUDIER` 
                                     WHERE ETUDIANT.CNE_ETU=ETUDIER.CNE_ETU and NIVEAU.NUM_NIV=ETUDIER.NUM_NIV 
                                     and NIVEAU.NUM_FORM='$formation';";
                                    $Smt1 = $bdd->query($req1);
                                    $nbr = $Smt1->fetch(2); // arg: PDO::FETCH_ASSOC

                                    echo '<h1 class=" text-center">' . $nbr['nbr'] . '</h1>';//<h1 class=" text-center">250</h1>
                                    ?>
                                    <p class=" text-center">Nombre des Etudiants</p>
                                </div>
                            </div>
                        </div>
                        <!-- the other one-->
                        <div class="col p-4 mr-2 ">

                            <div class="row  p-4  addOffre-div">

                                <div class="col-12 p-3 d-flex align-items-center  justify-content-center">
                                    <img src="../assets/icon/plus-btn.png" alt="offres">

                                </div>
                                <!-- Button trigger modal -->
                                <div class="col-12 p-0 d-flex align-items-center  justify-content-center">
                                    <div class="row">
                                        <button type="button" class="btn btn-seconnecter" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                            Ajouter Etudiant
                                        </button>
                                    </div>

                                    <div class="row mt-1">
                                        <button type="button" class="btn btn-seconnecter" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                            Ajouter liste
                                        </button>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="row  mt-2 border p-3 border-1 rounded  rounded-5  ">
                            <table id="table_id2" style="width:100%" class=" nowrap display"
                            >
                                <thead>
                                <tr>
                                    <th scope="col">CNE</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Nº stages</th>
                                    <th scope="col">Nº Offres</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $req = "SELECT  ETUDIANT.CNE_ETU cne, ETUDIANT.NOM_ETU nom,ETUDIANT.ACTIVE_ETU,ETUDIANT.PRENOM_ETU prenom,NIVEAU.LIBELLE_NIV niv 
                                            FROM `ETUDIANT`,`NIVEAU`,`ETUDIER` WHERE ETUDIANT.CNE_ETU=ETUDIER.CNE_ETU and NIVEAU.NUM_NIV=ETUDIER.NUM_NIV
                                            and  NIVEAU.NUM_FORM='$formation' and ((ETUDIER.NUM_NIV in (SELECT ET1.NUM_NIV from ETUDIER ET1,ETUDIER ET2 
                                                 where ET1.CNE_ETU=ET2.CNE_ETU and ET1.NUM_NIV!=ET2.NUM_NIV  and ET1.DATE_NIV>=ET2.DATE_NIV)) or ETUDIER.CNE_ETU in
                                                  (SELECT ET3.CNE_ETU from ETUDIER ET3 GROUP by ET3.CNE_ETU HAVING COUNT(ET3.CNE_ETU)=1)) ;";
                                $Smt = $bdd->query($req);
                                $rows = $Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC
                                //afficher le tableau
                                $lastNum = 0;
                                foreach ($rows as $V):
                                    $lastNum++;
                                    $cneEtudiant = $V['cne'];
                                    $req_nbrpst = " SELECT COUNT(POSTULER.CNE_ETU) nbr_post FROM `POSTULER` WHERE POSTULER.CNE_ETU='$cneEtudiant';";
                                    $Smt_nbrpst = $bdd->query($req_nbrpst);
                                    $nbrpst = $Smt_nbrpst->fetch(PDO::FETCH_ASSOC);
                                    $req_nbr = " SELECT COUNT(stage.CNE_ETU) nbr_stg FROM `stage` WHERE stage.CNE_ETU='$cneEtudiant';";
                                    $Smt_nbr = $bdd->query($req_nbr);
                                    $nbr = $Smt_nbr->fetch(PDO::FETCH_ASSOC);
                                    if($V['ACTIVE_ETU']==0) {$person='bi bi-person-x';$color='red';}
                                   else {$person='bi bi-person-check';$color='green';}
                                    echo ' <tr>
                                      <td>' . $V['cne'] . '</td>
                                    
                                            <td>' . $V['nom'] . '</td>
                                            <td>' . $V['prenom'] . '</td> 
                                            <td>' . $V['niv'] . '</td>
                                            <td>' . $nbr['nbr_stg'] . '</td>
                                            <td>' . $nbrpst['nbr_post'] . '</td>
                                            <td>  
                                                            <a class="ms-3" href="../pages/resposable-details-etudiant.php?cne='.$V['cne'].'"><i class=" active  bi bi-pencil-fill"></i></a>
                                                            <a class="ms-3"  id="btn-tgl" href="../pages/gererEtudiant.php?cnee='.$V['cne'].'"><i class="'.@$person.'" style="color:'.$color.';"></i></i></a>
                                        </td>
                                        
                                    </tr>';

                                endforeach;
                                $lastNum++;
                                ?>


                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Main Content Area -->

<!-- Pills content -->

<!--MODEL FORM-->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 370px;;max-width: 800px">
        <div class="modal-content d-flex justify-content-center "
             style="min-width: 370px;max-width: 800px;margin:auto;">
            <div class="modal-header border-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <span class="headline-form"> Ajouter un etudiant </span>

                    </div>
                    <div class="row">
                        <form class=" g-3 mt-2" method="post">
                            <div class="d-flex align-items-center ">
                                <img class="me-2" src="../assets/icon/step1.svg" alt="">
                                <span class="subheadline-form">information sur l'etudiant</span>
                            </div>

                            <div>
                                <div class="mt-4 p-2 border border-1 rounded-3">
                                    <label for="files" class="col-form-label mt-2 btn btn-import-img">
                                        Importer logo <i class="bi bi-image-fill"></i>
                                    </label>
                                    <input class="form-control d-none"
                                           onchange="uploadFileToFirebase('files','btnSubmit','pathStorageFile',1,'<?php echo $lastNum; ?>')"
                                           accept="image/*" type="file" id="files">


                                    <div>
                                        <input class="form-control d-none" name="cvPath" id="pathStorageFile">

                                        <div class="row">
                                            <div class="col-xl-6 col-sm-6">
                                                <label for="inputNom2" class="col-form-label">Nom</label>

                                                <input class="form-control" type="text" id="inputNom2" name="nom"
                                                       placeholder="Type to search...">
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <label for="inputPrenom2" class="col-form-label">Prenom</label>

                                                <input class="form-control" type="text" id="inputPrenom2" name="prenom"
                                                       placeholder="Type to search...">
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="mt-2 col-xl-6 col-sm-6">
                                                <label for="inputEmail" class="col-form-label">Email</label>

                                                <input class="form-control" name="email" type="email" id="inputEmail"
                                                       placeholder="Type to search...">
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <label for="inputtel" class="col-form-label">Telephone</label>

                                                <input class="form-control" type="tel" id="inputtel" name="tel"
                                                       placeholder="Type to search...">
                                            </div>

                                        </div>

                                        <div class="row mt-2 ">
                                            <div class="col-xl-6 col-sm-12">
                                                <label for="CNE" class="col-form-label">CNE</label>

                                                <input class="form-control" type="text" id="CNE" name="cne"
                                                       placeholder="Type to search...">
                                            </div>
                                            <div class="col-xl-6 col-sm-12">
                                                <label for="inputVille" class="col-form-label">Ville</label>

                                                <input class="form-control" type="text" id="inputVille" name="ville"
                                                       placeholder="Type to search...">
                                            </div>
                                            <div class="col-xl-6  col-sm-12">
                                                <label for="inputPays" class="col-form-label">Pays</label>

                                                <input class="form-control" type="tel" id="inputPays" name="pays"
                                                       placeholder="Type to search...">
                                            </div>
                                            <div class="col-xl-6  col-sm-12">
                                                <label for="dateNaiss" class="col-form-label">Date Naissance</label>

                                                <input class="form-control" type="date" id="dateNaiss" name="datnes"
                                                       placeholder="Type to search...">
                                            </div>

                                        </div>

                                        <div class="row">


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="d-flex align-items-center ">
                                    <img class="me-2" src="../assets/icon/step2.svg" alt="">
                                    <span class="subheadline-form">information sur niveau d'etude</span>
                                </div>
                                <div>
                                    <div class="mt-4 p-2 border border-1 rounded-3">

                                        <div>

                                            <div class="row">
                                                <div class="col-xl-6 col-sm-12">
                                                    <label for="inputNiveaux" class="col-form-label">Niveaux</label>

                                                    <select id="inputNiveaux" class="form-select" name="niveau"
                                                            aria-label="Default select example">
                                                        <?php
                                                        //requette de selection
                                                        $req = "SELECT NIVEAU.NUM_NIV,NIVEAU.LIBELLE_NIV FROM `Responsable`, `niveau` WHERE Responsable.NUM_FORM=niveau.NUM_FORM and Responsable.USERNAME_RES='$respon_username';";
                                                        $Smt = $bdd->query($req);
                                                        $rows = $Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC
                                                        //afficher le tableau

                                                        foreach ($rows as $V):

                                                            echo " <option value=\"" . $V['NUM_NIV'] . "\">" . $V['LIBELLE_NIV'] . "</option>";

                                                        endforeach;

                                                        ?>

                                                    </select></div>

                                                <div class="col-xl-6  col-sm-12">
                                                    <label for="inputpass" class="col-form-label">mot de passe</label>

                                                    <input class="form-control" type="tel" id="inputpass"
                                                           name="password" placeholder="Type to search...">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 mt-4">
                                            <button type="submit" id="btnSubmit"
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
<div id="modal-progress-upload">

</div>
<script>
    $(document).ready(function () {
        $('#table_id2').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json'
            },
            scrollY: 200,
            scrollX: true,
        });

   


    });
</script>
<script type="text/javascript" src="/js/script.js"></script>
<script src="./../js/script-upload.js"></script>


</body>
</html>