<?php
require(__DIR__ . './../phpQueries/etudiant/dash.php');


$req_offre_postuler = "
                        SELECT * FROM POSTULER pos,OFFREDESTAGE offre,ENTREPRISE ent
                        WHERE pos.NUM_OFFR = offre.NUM_OFFR
                        AND offre.NUM_ENT = ent.NUM_ENT 
                        AND pos.CNE_ETU='$etudiant_cne'  
                        AND pos.ETATS_POST !='ANNULER'
                        
                        ORDER BY  pos.DATE_POST DESC
                
                ";
$Smt_offre_postuler = $bdd->query($req_offre_postuler);
$etudiant_offres_pos = $Smt_offre_postuler->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['btnSelection'])) {
    // get last NUM_STG

    $req_num_stg = 'SELECT NUM_STG FROM `stage`  ORDER BY NUM_STG DESC';
    $smt_num_stg = $bdd->query($req_num_stg);
    $last_num_stg = $smt_num_stg->fetch(2);
    $last_num = $last_num_stg['NUM_STG'];
    $last_num++;
    echo $last_num;
    $cne = $_POST['cne'];
    $noffr = $_POST['noffre'];
    $date = date("Y-m-d");
    if ($_POST['responseSelected'] == 'OUI')
        $response = 'ACCEPTER';
    else
        $response = 'NO ACCEPTER';


    $req_offre_response = "
                        UPDATE POSTULER 
                        SET ETATS_POST='$response'
                        WHERE NUM_OFFR = '$noffr' 
                        AND  CNE_ETU='$etudiant_cne' 
                ";
    $offre_response = $bdd->exec($req_offre_response);
    if ($response == 'ACCEPTER') {


        //etablir un stage
        $req_stage = "
                        INSERT INTO STAGE (NUM_STG,NUM_OFFR,CNE_ETU,ACTIVE_STG)
                        VALUES ('$last_num','$noffr','$etudiant_cne' ,'0')
                ";
        $stage_response = $bdd->exec($req_stage);

        $last_niv = $etudiant_niveau['NUM_NIV'];
        $req_update_offre = " update postuler set postuler.ETATS_POST='ANNULER' WHERE postuler.NUM_OFFR IN (SELECT NUM_OFFR FROM offredestage WHERE NUM_NIV='$last_niv'
        and offredestage.NUM_OFFR!='$noffr' and postuler.CNE_ETU='$etudiant_cne') and postuler.CNE_ETU='$etudiant_cne';";
        $modifier_etat_Offre = $bdd->exec($req_update_offre);
        header('Location:etudiant-mes-offre.php');
    } else {
        Synchronisation_offre_attente($bdd);
        header('Location:etudiant-mes-offre.php');
    }


}
if (isset($_GET['noffr']) && isset($_GET['cne'])) {
    $cne = $_GET['cne'];
    $noffr = $_GET['noffr'];
    $req_offre_response = "
                        UPDATE POSTULER 
                        SET ETATS_POST='ANNULER'
                        WHERE NUM_OFFR = '$noffr'
                        AND  CNE_ETU='$etudiant_cne' 
                ";
    $offre_response = $bdd->exec($req_offre_response);
    header('Location:etudiant-mes-offre.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "./meta-tag.php"
    ?>
    <title>Dashboard</title>
</head>

<body>
<?php
require_once "./nav-etudiant.php"
?>
<div class="container ">
    <div class="row">
        <div class="col-xl-3   col-sm-12">
            <?php
            require_once "./etudiant-sidebar-offre.php"
            ?>
        </div>
        <div class="p-4 col-xl-9 col-sm-12">
            <div style="margin-top: 50px">


                <div class="intro  mt-3">
                    <h3><b>Mes Offre postulé</b></h3>

                </div>
                <div class="intro ">
                    <p>
                        consulter et gérer mes offres de stages

                    </p>
                </div>


                <div class="mt-4">

                    <div class="mt-2 border p-3 rounded-5 rounded border-1 ">
                        <table id="table_id" style="width:100%" class=" nowrap display">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Entreprise</th>
                                <th scope="col">Poste</th>

                                <th scope="col">Date Postuler</th>
                                <th scope="col">Delai</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($etudiant_offres_pos as $offre) {
                                if ($offre['ETATS_POST'] == 'POSTULER') {
                                    echo '
                                <tr>
                                        <td >' . $offre['NUM_OFFR'] . '</td>

                                        <td>' . $offre['LIBELLE_ENT'] . '</td>
                                        <td>' . $offre['POSTE_OFFR'] . '</td>
                                        <td>' . $offre['DATE_POST'] . '</td>
                                        <td>' . $offre['DELAI_JOFFR'] . ' jours</td>
                                        <td>
                                            <a href="etudiant-mes-offre.php?noffr=' . $offre["NUM_OFFR"] . '&cne=' . $offre["CNE_ETU"] . '" class="me-3"><i class=" active  bi bi-trash-fill"></i></a>
                                            <a target="_blank" href="offre-details.php?noffr=' . $offre["NUM_OFFR"] . '&niv=' . $offre["NUM_NIV"] . '" class="me-3"><i class=" active  bi bi-info-circle-fill"></i></a>
                                        </td>
                                    </tr>
                                ';
                                }

                            }


                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div style="margin-top: 75px">


                <div class="intro  mt-3">
                    <h3><b>Mes Offre retenu</b></h3>

                </div>
                <div class="intro ">
                    <p>
                        Accepter ou refuser un stage

                    </p>
                </div>


                <div class="mt-4">

                    <div class="mt-5 border p-3 rounded-5 rounded border-1 ">
                        <table id="table_id1" style="width:100%" class=" nowrap display">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Entreprise</th>
                                <th scope="col">Poste</th>

                                <th scope="col">Date Postuler</th>

                                <th scope="col">Accepter</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($etudiant_offres_pos as $offre) {
                                if ($offre['ETATS_POST'] == 'RETENU') {
                                    echo '
                                <tr>
                                        <td >' . $offre['NUM_OFFR'] . '</td>

                                        <td>' . $offre['LIBELLE_ENT'] . '</td>
                                        <td>' . $offre['POSTE_OFFR'] . '</td>
                                        <td>' . $offre['DATE_POST'] . '</td>
                                        
                                        <td>
                                        <form action="" method="post">
                                                        <div class="col-auto">
                                                        <input type="text" name="cne" hidden value="' . $offre['CNE_ETU'] . '" id="">
                                                     <input type="text" name="noffre" hidden value="' . $offre['NUM_OFFR'] . '" id="">
                                                     
                                                            <select name="responseSelected" class="form-select  form-select-sm" aria-label=".form-select-sm example">
                                                                <option value="OUI" selected>Oui</option>
                                                                <option value="NON">Non</option>

                                                            </select>
                                                        </div>
                                                        <div class="col-auto mt-2">
                                                            <div class=" col-auto prop-value">
                                                            <button
                                                             class="btn" name="btnSelection" style="border-radius: 20px; background-color:#7B61FF ;color: white;" href=""> Validate </button></div>

                                                        </div>

                                                    </form>
                                         </td>
                                    </tr>
                                ';
                                }

                            }


                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table_id').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json'
            },
            scrollY: 200,
            scrollX: true,
        });
    });
    $(document).ready(function () {
        $('#table_id1').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json'
            },
            scrollY: 200,
            scrollX: true,
        });
    });
</script>

</body>

</html>