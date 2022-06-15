<?php
require(__DIR__ . './../phpQueries/etudiant/stage.php');
$div_stage_verification = 0;
$etud_niv = $etudiant_niveau['NUM_NIV'];
$req_stg = "SELECT * from STAGE,OFFREDESTAGE where STAGE.NUM_OFFR=OFFREDESTAGE.NUM_OFFR and CNE_ETU='$etudiant_cne' and OFFREDESTAGE.NUM_NIV=$etud_niv;";
$info_stg = $bdd->query($req_stg);
$info_stg_etu = $info_stg->fetch();

if (!empty($info_stg_etu)) {
    $div_stage_verification = 1;
} else {
    $div_stage_verification = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once "./meta-tag.php"
    ?>
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>

<body>
<?php
require_once "nav-etudiant.php";
?>
<div class="container ">
    <div class="row">
        <div class="col-xl-3   col-sm-12">
            <?php
            require_once "./etudiant-sidebar-offre.php"
            ?>
        </div>
        <div class="p-4 col-xl-9 col-sm-12">
            <div class="intro  mt-3">
                <h3><b>Mon stage</b></h3>

            </div>
            <div class="intro ">
                <p>
                    Decouvrir mon stage actuelle

                </p>
            </div>
            <div style="" class="row  border border-link rounded-3 p-4" id="div_stgg">

                <div class="col-xl-2 col-sm-12 me-4 ">
                    <img class="mx-auto mb-2" style="max-width: 150px;" src="<?php echo $stage_actulle['IMAGE_ENT'] ?>"
                         alt="">
                </div>
                <div class="col-xl-9 col-sm-12 me-4">
                    <div class="row mt-2">
                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3">Société :</div>
                            <div class="col-auto prop-value"><?php echo $stage_actulle['LIBELLE_ENT'] ?> </div>

                        </div>

                        <div class="col-xl-3 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3">N° Stage :</div>
                            <div class="col-auto prop-value"><?php echo $stage_actulle['NUM_STG'] ?></div>


                        </div>
                        <div class="col-xl-5 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3">Encadrant :</div>
                            <div class="col-auto prop-value"><?php echo getJuryName($stage_jury) ?></div>


                        </div>

                    </div>
                    <div class="row mt-2 ">
                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3">Date debut :</div>
                            <div class="col-auto prop-value"><?php echo $stage_actulle['DATEDEB_STG'] ?></div>

                        </div>

                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name  me-3">Lieux :</div>
                            <div class="col-auto prop-value"><?php echo $stage_actulle['LIEUX_OFFR'] ?></div>


                        </div>


                    </div>
                    <div class="row mt-2">
                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                            <div class="col-auto prop-name me-3">Date fin :</div>
                            <div class="col-auto prop-value"><?php echo $stage_actulle['DATEFIN_STG'] ?></div>

                        </div>

                        <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start align-items-center">

                            <div class="col-auto prop-name me-3">Contrat :</div>
                            <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" target="_blank"
                                                                href='../PDF/contrat.php'>voir plus</a></div>


                            <a name="" id="" class="btn-postuler btn px-xl-4  border border-1 "
                               href="../PDF/contrat.php" role="button"
                               download="Article_HTML5_download.pdf">Télechager</a>


                        </div>


                    </div>
                    <div class="row mt-2  ">


                        <div class="col-xl-6 col-sm-12 mt-sm-2 d-flex justify-content-start align-items-center">

                            <div class="col-auto prop-name  me-3">Rapport :</div>
                            <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" href="">voir
                                    plus </a></div>


                        </div>

                    </div>
                    <div class="row mt-2 overflow-auto ">


                        <div class="col-xl-12 col-sm-12 mt-sm-2 d-flex justify-content-start align-items-center">

                            <div class="col-auto prop-name  me-3">Liste Jury :</div>
                            <div class="col-auto prop-value">
                                <?php
                                foreach ($stage_jury as $jury) {
                                    echo '
                                      <span class="me-2"> ' . $jury['PRENOM_ENS'] . ' ' . $jury['NOM_ENS'] . '</span>
                                      
                                      ';
                                }
                                ?>


                            </div>


                        </div>
                    </div>


                </div>
            </div>

            <div class="intro  mt-5">
                <h3><b>Historique stages</b></h3>

            </div>
            <div class="intro ">
                <p>
                    Decouvrir mes information concernant mes ancien stages

                </p>
            </div>


            <div class="mt-4">
                <div class="mt-2 border p-3 rounded-5 rounded border-1 ">
                    <table id="table_id" style="width:100%" class=" nowrap display">
                        <thead>
                        <tr>
                            <th scope="col">N° Stage</th>
                            <th scope="col">Entreprise</th>
                            <th scope="col">Date Debut</th>

                            <th scope="col">Date Fin</th>
                            <th scope="col">Note général</th>

                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($stage_preced as $stage) {
                            $num_stage1 = $stage['NUM_STG'];
                            $req_jury2 = "SELECT * from STAGE st,JUGER jr,ENSEIGNANT ens
                        WHERE   st.NUM_STG=jr.NUM_STG
                        and ens.NUM_ENS = jr.NUM_ENS 
                        and st.NUM_STG='$num_stage1' ";

                            $Smt_jury_info2 = $bdd->query($req_jury2);
                            $stage_jury2 = $Smt_jury_info2->fetchAll(PDO::FETCH_ASSOC);

                            $req_rapp_stage = "SELECT * from RAPPORT 
                        WHERE   NUM_STG='$num_stage1'  ";
                            $Smt_rapp_stage = $bdd->query($req_rapp_stage);
                            $rapp_stage = $Smt_rapp_stage->fetch(PDO::FETCH_ASSOC);
                            if (isset($rapp_stage['PATH_RAP']))
                                $path = $rapp_stage['PATH_RAP'];
                            else
                                $path = "#";


                            echo '
                                 <tr> 
                                   <td >' . $stage['NUM_STG'] . '</td>    
                                   <td >' . $stage['LIBELLE_ENT'] . '</td>
                                   <td >' . $stage['DATEDEB_STG'] . '</td> 
                                   <td >' . $stage['DATEFIN_STG'] . '</td>   
                                   <td >' . $stage['NOTE_ENEX'] . '</td>  
                                   <td>  
                          <a  class="me-3" data-bs-toggle="collapse" href="#collapseExample' . $stage['NUM_STG'] . '" role="button" aria-expanded="false" aria-controls="collapseExample1"><i class=" active  bi bi-info-circle-fill" ></i></a>
                          
                         </td>
                      </tr> 
                      <tr data-child-name="' . $stage['NUM_STG'] . '" data-child-value="' . $stage['NUM_STG'] . '">
                            <td>
                                 Liste Jury  
                            </td>
                            <td >
                                 ';foreach ($stage_jury2 as $jury2) {

                                        echo '  <span class="me-2"> ' . $jury2['PRENOM_ENS'] . ' ' . $jury2['NOM_ENS'] . '</span>';
                                    }' 
                                 </td>
                            </tr>';
                        }
                        ?>


                        </tbody>
                    </table>
                </div>
            </div>


        </div>


<!--        </tr>-->
<!--        <tr data-child-name="' . $stage['NUM_STG'] . '" data-child-value="10">-->
<!--            <td colspan="7" class="p-0">-->
<!---->
<!--                <div class="col-auto prop-name  me-3">Liste Jury :</div>-->
<!--                <div class="col-auto prop-value">';-->
<!--                    foreach ($stage_jury2 as $jury2) {-->
<!---->
<!--                    echo '  <span class="me-2"> ' . $jury2['PRENOM_ENS'] . ' ' . $jury2['NOM_ENS'] . '</span>';-->
<!--                    }-->
<!--                    echo '-->
<!--                </div>-->
<!---->
<!--    </div>-->
<!--    <div class="row align-items-center">-->
<!--        <div class="col-auto prop-name  me-3">Rapport</div>-->
<!--        <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" href="' . $path . '">voir plus</a></div>-->
<!--        <div class="col-auto prop-name  me-3">Contrat</div>-->
<!--        <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" href="' . $stage['CONTRAT_STG'] . '">voir plus</a></div>-->
<!---->
<!---->
<!--        </td>-->
<!--        </tr>-->

        <?php
        echo "
       <script>

 
       $(document).ready(function(){
       
        if($div_stage_verification==0) {  
         $('#div_stgg').hide();  
        }
     else  $('#div_stgg').show();  
        
       });
     
     </script>
       
       "

        ?>


    </div>
</div>

<script>
    function format (name, value) {
        return '<div>Name: ' + name + '<br />Value: ' + value + '</div>';
    }
    $(document).ready(function () {
        $('#table_id').DataTable(
            {
                select: {
                    selector: 'td:not(:first-child)',
                    style: 'os'
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json'
                },
                scrollY: 200,
                scrollX: true,
            });




        $('#table_id tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
                tr.addClass('shown');
            }
        });

    });
</script>
</body>
</html>
