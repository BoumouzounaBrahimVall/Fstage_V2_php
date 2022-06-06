



<?php
require( __DIR__.'./../phpQueries/etudiant/dash.php');
require( __DIR__.'./../phpQueries/etudiant/uploadfile.php');


if(isset($_POST['filesUploaed']))
{

    $file = $_FILES['cv'];
    echo 'cv';
    uploadImagesOrCVEtudiant($etudiant_cne,$file,$bdd,2);
}
if($_SERVER['REQUEST_METHOD']=='POST') {
    require(__DIR__ . './../phpQueries/conxnBDD.php');
    $noffr = $_POST['noffr'];
    $cne= $_POST['cne'];
    $date=date("Y-m-d");
    $query = "INSERT INTO POSTULER (NUM_OFFR,CNE_ETU,DATE_POST,ETATS_POST) VALUES ('$noffr','$cne','$date','POSTULE')";
    $row=$bdd->exec($query);

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
  require_once "nav-etudiant.php";
  ?>
  <div  class="container ">
    <div class="row">
      <div class="col-xl-3   col-sm-12">
        <?php
        require_once "./etudiant-sidebar-offre.php";
        ?>
      </div>
      <div class=" col-xl-9 col-sm-12">
        <div class="intro p-4 mt-3 d-flex align-items-center">
          <h3> <b>Bonjour

                  <?php

                  if (!empty($etudiant_info))
                     echo $etudiant_info['PRENOM_ETU'];
          ?>
              </b> </h3> <img style="margin-left: 15px; width:40px ;" src="./../assets/icon/salute-icon.png" alt="">

        </div>
        <div class="intro ps-4 ">
          <p>
            liste des offres disponible
          </p>
        </div>
        <div class="row">
          <div class="filtre-bar ps-4  mt-5">
            <form class="row g-3">

              <div class="col-auto">
                <label for="inputVille2" class="col-form-label">Ville</label>
              </div>
              <div class="col-auto">
                <input class="form-control" list="datalistVilles" id="inputVille2" placeholder="Type to search...">
                <datalist id="datalistVilles">
                    <?php
                    foreach ($villes as $ville)
                    {
                        echo '
                            <option value="'. $ville  .'">'. $ville  .'</option>
                            ';
                    }

                    ?>
                </datalist>
              </div>

              <div class="col-auto">
                <label for="inputTrier2" class="col-form-label">Trier</label>
              </div>
              <div class="col-auto">
                <select id="inputTrier2" class="form-select" aria-label="Default select example">

                  <option selected>Trier par </option>
                  <option value="1">Ascendant</option>
                  <option value="2">Descendant </option>
                </select>
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-filtre btn-primary mb-3"> Chercher <i class="bi bi-search"></i></button>
              </div>
            </form>
          </div>
        </div>

          <div class="cv" hidden>
              <input type="text" name="" value="<?php
              if (!empty($etudiant_info['CV_ETU']))
              echo 1;
              else
                  echo 2;?>
"id="cv">
          </div>
        <div class=" list-offre mt-3">
          <div  class="container-card d-flex flex-row flex-wrap">
              <?php foreach ($etudiant_offres as $offre_stage):
                  if(empty($offre_stage["IMAGE_ENT"] )) $offre_stage["IMAGE_ENT"]= "./../ressources/company/images/atos.png";

                  echo '
                  <div class="m-3 ">
              <div class="card border-link " style="min-width: 450px;min-height: 480px;">
                <div class="row">
                  <div class="col">
                    <span class="  m-3 badge-status  w-25  p-2  "> '.$offre_stage["ETATPUB_OFFR"] .'</span>

                  </div>
                </div>
                <div>

                </div>
                <div class="row">
                  <div class="col">
                    <img class=" m-4 company-logo" src='.$offre_stage["IMAGE_ENT"] .' alt="">

                  </div>
                </div>

                <div class="card-body">
                  <h4 class="card-title" style="text-transform: capitalize"> <b>'.$offre_stage["POSTE_OFFR"] .'</b> </h4>
                  <div class="badges d-flex justify-content-start">

                    <div class="mt-3">
                      <span class="badge   p-2 badge-key rounded-pill bg-primary">info</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge  ms-3 p-2 badge-key rounded-pill bg-success">Stage PFA</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge ms-3 p-2 badge-key rounded-pill bg-danger">Front-end</span>
                    </div>
                  </div>
                  <div class="loc-time mt-3 d-flex ">
                    <div>
                      <img class="place-svg" src="./../assets/icon/card/place.svg" alt="">
                      <span class="place-location">
                       '.$offre_stage["VILLE_OFFR"] .','.$offre_stage["PAYS_OFFR"] .' 
                      </span>
                    </div>
                    <div class="ms-5">
                      <img class="place-svg" src="./../assets/icon/card/time.svg" alt="">
                      <span class="place-location">
                        '.$offre_stage["DURE_OFFR"] .' mois
                      </span>
                    </div>
                  </div>
                  <div class="mt-3">
                    <div class="headline">
                      <b>Sujet </b>
                    </div>
                    <p class="card-text mt-2">

                      '.$offre_stage["SUJET_OFFR"].'

                    </p>
                  </div>
                  <div class="mt-3">
                    <div class="headline">
                      <b>Details</b>
                    </div>
                    <p class="card-text mt-2">

                      '.html_entity_decode($offre_stage["DETAILS_OFFR"]).'

                    </p>
                  </div>

                </div>
                
      
                <div class=" p-3  d-flex justify-content-around border-top-0">

                  <button  id="" class="btn ps-5 pe-5  me-2 btn-postuler"  onclick="verifyCvUploaded('. $offre_stage["NUM_OFFR"] .')" role="button">Postuler</button>
                  <a  id="" class="btn ps-5 pe-5 btn-voir-plus" target="_blank" href="offre-details.php?noffr='. $offre_stage["NUM_OFFR"] .'&niv='. $offre_stage["NUM_NIV"] .'" role="button">Voir plus</a>

                </div>
              </div>


            </div>
                  ';

              endforeach;

                  ?>


          </div>
        </div>
      </div>
    </div>


      <!-- Modal Cv upload -->
      <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="min-width: 500px;max-width: 700px">
              <div class="modal-content d-flex justify-content-center " style="max-width: 800px;margin:auto;">
                  <div class="modal-header border-0">

                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="container-fluid">
                          <div class="row">
                              <span class="headline-form"> Completer ma condidature</span>
                              <span>pour déposer a aux offre de stage veuillez importer votre CV ,c'est obligatoire</span>

                          </div>
                          <div class="row">
                                  <div class="d-flex mt-4 align-items-center ">
                                      <img class="me-2" src="./../assets/icon/step2.svg" alt="">
                                      <span class="subheadline-form">Importer Mon CV</span>
                                  </div>
                                  <div class="row">
                                      <form action="" method="post"  enctype="multipart/form-data">
                                          <div class="col-10 ms-5   align-items-start ">

                                              <div class="mt-2 p-2 border border-1 rounded-3 ">
                                                  <div>
                                                      <div class=" p-3 ">

                                                          <div>
                                                              <input type="text" name="cne" value="<?php echo $_SESSION['auth'] ?>" hidden id="">
                                                              <input type="text" id="noffre" name="noffr"  hidden >

                                                              <div class="row mt-2 d-flex justify-content-around ">
                                                                  <div style="width: fit-content" class="mt-2 ms-3 col-6 px-5 py-4  d-flex flex-column rounded-4 justify-content-center ">
                                                                      <img style="margin: auto; max-width: 64px" src="./../assets/img/comment-section/cv.png" alt="" />
                                                                      <label for="inputfile" class="col-form-label mt-2 btn py-2 px-5 mt-3 btn-voir-plus">
                                                                          Importer  <i class="bi bi-file-arrow-up-fill"></i>
                                                                      </label>
                                                                      <input class="form-control d-none" name="cv" accept="application/pdf" type="file" id="inputfile">

<!--                                                                      <a class="mt-3 btn-voir-plus py-2 px-4" style="width: fit-content; font-size: 16px" href="">Importer  <i class="bi bi-file-arrow-up-fill"></i-->
<!--                                                                          ></a>-->
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
                                                  <button type="submit" name="filesUploaed"  value="uploadCvPostuler" class="btn btn-filtre btn-primary w-100 mb-3">    Enregistrer <i class="bi bi-plus-circle-fill"></i></button>
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
      <!-- Modal Confirmation postuler -->
      <div class="modal fade" id="myModalPostuler" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="min-width: 500px;max-width: 700px">
              <div class="modal-content d-flex justify-content-center " style="max-width: 800px;margin:auto;">
                  <div class="modal-header border-0">

                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="container-fluid">
                          <div class="row">
                              <span class="headline-form"> Confirmer ma condidature</span>
                              <span>pour déposer a cette offre de stage veuillez confimer votre postulation</span>

                          </div>
                          <div class="row">
                              <form action="etudiant-dashboard.php" name="cvupload" method="post" enctype="multipart/form-data" class=" g-3">


                                  <div class="d-flex mt-4 align-items-center ">
                                      <img class="me-2" src="./../assets/icon/step2.svg" alt="">
                                      <span class="subheadline-form">Confirmer Candidature</span>
                                  </div>
                                  <div class="row">
                                      <form action="" method="post">
                                          <div class="col-10 ms-5   align-items-start ">

                                              <div class="mt-2 p-2 border border-1 rounded-3 ">
                                                  <div>
                                                      <div class=" p-3 ">

                                                          <div>
                                                              <input type="text" name="cne" value="<?php echo $_SESSION['auth'] ?>" hidden id="">
                                                              <input type="text" id="noffrePos" name="noffr"  hidden >

                                                              <div class="row mt-2 d-flex justify-content-around ">
                                                                  <div style="width: fit-content" class="mt-2 ms-3 col-12 px-5 py-4  d-flex flex-column rounded-4 justify-content-center border border-link">
                                                                      <button type="submit" name="submit"  value="uploadCvPostuler" class="btn btn-filtre btn-primary w-100 mb-3">    Postuler <i class="bi bi-plus-circle-fill"></i></button>



                                                                      <!--                                                                      <a class="mt-3 btn-voir-plus py-2 px-4" style="width: fit-content; font-size: 16px" href="">Importer  <i class="bi bi-file-arrow-up-fill"></i-->
                                                                      <!--                                                                          ></a>-->
                                                                  </div>


                                                              </div>


                                                          </div>
                                                      </div>
                                                  </div>



                                              </div>

                                              <div>

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
      <div class="container offre-section-user">
      <div class="row">

      </div>
    </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

      <script src="./../js/script2.js">

          document.onload =verifyCvOnLoad();
      </script>
</body>

</html>