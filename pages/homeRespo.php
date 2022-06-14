<?php
require(__DIR__ . './../phpQueries/respoRequiries.php');
?>


<!DOCTYPE html>
<html lang="fr">
<head>

    <?php
    require_once "./meta-tag.php"
    ?>
    <title>Home respo</title>
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
                            <li><a href="#" class="actuel-page"><i class=" active  bi bi-house-fill"></i>Acceuil</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class=" col-xl-8 p-4   col-sm-12 mt-0">
                    <div class="row  px-4">
                        <h4>Bonjour Resp. <?php
                            $req_respoName = "SELECT e.NOM_ENS nomRep from `RESPONSABLE` r, `ENSEIGNANT` e where r.NUM_ENS=e.NUM_ENS 
                    and r.USERNAME_RES='$respon_username';";
                            $Smt_respoName = $bdd->query($req_respoName);
                            $respo = $Smt_respoName->fetch(2); // arg: PDO::FETCH_ASSOC
                            echo $respo['nomRep'];
                            ?> 👋🏻</h4><br>
                        <p class="text-secondary">Decouvrir quelque statistique sur la platform</p>
                    </div>
                    <div class="row  px-4 mt-2">
                        <div class="col  p-4 mr-2 ">

                            <div class="row mx-1 p-xl-4 statis-div-1">

                                <div class="col-3 col-sm-5  p-4">
                                    <img src="../assets/icon/bag_purple.png" alt="offres">
                                </div>
                                <div class="col p-4">
                                    <h1 class=" text-center"><?php
                                        $req = "SELECT COUNT(distinct(NUM_OFFR)) nbr_offre_total from 
                    `OFFREDESTAGE` ofr, `NIVEAU` niv where ofr.NUM_NIV=niv.NUM_NIV 
                    and niv.NUM_FORM='$formation'";
                                        $Smt = $bdd->query($req);
                                        $nbr_of_tt = $Smt->fetch(2); // arg: PDO::FETCH_ASSOC
                                        echo $nbr_of_tt['nbr_offre_total'];
                                        ?></h1>
                                    <p class=" text-center">Nombre des offres</p>

                                </div>
                            </div>
                        </div>
                        <!-- the other one-->
                        <div class="col p-4 mr-2 ">

                            <div class="row mx-1 p-xl-4 statis-div-2">

                                <div class="col-3 col-sm-5  p-4">
                                    <img src="../assets/icon/student.png" alt="offres">
                                </div>
                                <div class="col p-4">
                                    <h1 class=" text-center"><?php
                                        $numFormation = $formation;
                                        $req = "SELECT COUNT(distinct (E.CNE_ETU)) nbr_etudiant from `ETUDIANT` E,`ETUDIER` ETU, `NIVEAU` niv
                     where E.CNE_ETU=ETU.CNE_ETU and ETU.NUM_NIV=niv.NUM_NIV and niv.NUM_FORM='$formation'";
                                        $Smt = $bdd->query($req);
                                        $nbr_of_tt = $Smt->fetch(2); // arg: PDO::FETCH_ASSOC
                                        echo $nbr_of_tt['nbr_etudiant'];
                                        ?></h1>
                                    <input id="formationId" type="text" class="d-none"
                                           value="<?php echo $numFormation; ?>">
                                    <p class=" text-center">Nombre des Etudiants</p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  p-4 mt-2">
                        <div class="col-xl-6 col-sm-12 mx-auto">
                            <select id="selectedOption" onchange="showGraph()" class="form-select"
                                    aria-label="Default select example">

                                <option selected value="1">Tous</option>
                                <option value="2">Offres</option>
                                <option value="3">Etudiants</option>
                                <option value="4">Enseignant</option>
                            </select>
                            <div class="mt-3" id="chart-container">
                                <canvas style="max-width:400px;max-height:400px" id="myChart"></canvas>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        showGraph();
    });

    function showGraph() {


        {
            let selected = document.getElementById('selectedOption').value;
            console.log(selected);

            let num = document.getElementById('formationId').value;
            var dataX = {
                formation: num,
                option: selected
            };

            //let formation=document.getElementById('formationId').value;
            console.log(dataX);
            $.post("./statiqueRespo.php",
                dataX,
                function (data) {
                    console.log(data);


                    //get the doughnut chart canvas
                    var ctx1 = $("#myChart");
                    console.log(dataX)
                    var column = [];
                    var chartRep = {
                        column: [],
                        data: [],
                        backgroundColor: [],
                        borderColor: [],
                        borderWidth: []

                    };
                    switch (dataX.option) {
                        case '1': {
                            chartRep.backgroundColor = [
                                "#DC143C",
                                "#2E8B57",
                                "#2e3a8b"
                            ], chartRep.borderColor = [
                                "#CB252B",
                                "#1D7A46",
                                "#2e3a8b"
                            ],
                                chartRep.borderWidth = [1, 1, 1],
                                chartRep.column = ["Offres", "Etudiants", "Enseignant"];
                            break;
                        }
                        case '2': {
                            chartRep.backgroundColor = [

                                "#2E8B57",
                                "#2e3a8b"
                            ], chartRep.borderColor = [

                                "#1D7A46",
                                "#2e3a8b"
                            ],
                                chartRep.borderWidth = [1, 1],
                                chartRep.column = ["Nouveaux", "Complété"];
                            break;
                        }
                        case '3': {
                            chartRep.backgroundColor = [

                                "#2E8B57",
                                "#2e3a8b"
                            ], chartRep.borderColor = [

                                "#1D7A46",
                                "#2e3a8b"
                            ],
                                chartRep.borderWidth = [1, 1],
                                chartRep.column = ["Compte Activé", "Compte Desactivé"];
                            break;
                        }
                        case '4': {
                            chartRep.backgroundColor = [

                                "#2E8B57",
                                "#2e3a8b"
                            ], chartRep.borderColor = [

                                "#1D7A46",
                                "#2e3a8b"
                            ],
                                chartRep.borderWidth = [1, 1],
                                chartRep.column = ["Compte Activé", "Compte Desactivé"];
                            break;
                        }

                    }

                    //doughnut chart data
                    console.log(column)
                    var data1 = {
                        labels: [...chartRep.column],
                        datasets: [
                            {
                                label: "Nombre total",
                                data: [...Object.values(data)],
                                backgroundColor: chartRep.backgroundColor,
                                borderColor: chartRep.borderColor,
                                borderWidth: chartRep.borderWidth
                            }
                        ]
                    };


                    //options
                    var options = {
                        responsive: true,
                        title: {
                            display: true,
                            position: "top",
                            text: "Doughnut Chart",
                            fontSize: 18,
                            fontColor: "#111"
                        },
                        legend: {
                            display: true,
                            position: "bottom",
                            labels: {
                                fontColor: "#333",
                                fontSize: 16
                            }
                        }
                    };
                    let chartStatus = Chart.getChart("myChart"); // <canvas> id
                    if (chartStatus != undefined) {
                        chartStatus.destroy();
                    }
                    //create Chart class object
                    var chart1 = new Chart(ctx1, {
                        type: "doughnut",
                        data: data1,
                        options: options
                    });
                }, "json");

        }
    }


</script>


<!-- Main Content Area -->

<!-- Pills content -->

<!-- JavaScript Bundle with Popper-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>

</body>
</html>