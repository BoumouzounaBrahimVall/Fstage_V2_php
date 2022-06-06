
<?php
require(__DIR__ . './../phpQueries/etudiant/profil.php');
require( __DIR__.'./../phpQueries/etudiant/uploadfile.php');
if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['filesUploaed']))
    {

        $file = $_FILES['cv'];
        uploadImagesOrCVEtudiant($etudiant_cne,$file,$bdd,2);
    }

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
  <div class="container ">
    <div class="row">
      <div class="col-xl-3   col-sm-12">
        <?php
        require_once "./etudiant-sidebar-offre.php"
        ?>
      </div>
      <div class=" col-xl-9 col-sm-12">
        <div class="intro p-4 mt-3 d-flex align-items-center">
          <h3> <b>Personaliser mon profil</b> </h3>
        </div>
        <div class="intro ps-4 ">
          <p>
            consulter mes information personnel
          </p>
        </div>

        <div class="row ps-4 my-4 ">
          <span class="modifier-info-headline">visualiser mes informations</span>
          <div class="mt-4 p-5 border border-1 rounded-3"">
            <img style="max-width: 100px;" class="rounded-circle border " src="<?php echo $etudiant_info['IMG_ETU'];?>" alt="">
<!--              <a class="mt-2 ms-2 btn btn-import-img" href="">Importer image <i class="bi bi-image-fill"></i></a>-->

            <div>
              <div class="row mt-5">
                <div class="col-xl-6 col-sm-6">
                  <label for="inputNom2" class="col-form-label">Nom</label>

                  <input disabled class="form-control" value="<?php echo $etudiant_info['NOM_ETU'];?>" type="text" id="inputNom2" placeholder="Type to search...">
                </div>
                <div class="col-xl-6 col-sm-6">
                  <label for="inputPrenom2" class="col-form-label">Prenom</label>

                  <input disabled class="form-control" value="<?php echo $etudiant_info['PRENOM_ETU'];?>" type="text" id="inputPrenom2" placeholder="Type to search...">
                </div>

              </div>

              <div class="row mt-5">
                <div class=" col-xl-6 col-sm-6">
                  <label for="inputEmail" class="col-form-label">Email</label>

                  <input disabled class="form-control" value="<?php echo $etudiant_info['EMAIL_ENS_ETU'];?>" pattern="email" type="email" id="inputEmail" placeholder="Type to search...">
                </div>
                <div class="col-xl-6 col-sm-6">
                  <label for="inputtel" class="col-form-label">Telephone</label>

                  <input disabled class="form-control" value="<?php echo $etudiant_info['TEL_ETU'];?>" type="tel" id="inputtel" placeholder="Type to search...">
                </div>

              </div>

              <div class="row mt-5 ">
                <div class="col-xl-4 col-sm-12">
                  <label for="inputVille" class="col-form-label">Ville</label>

                  <input disabled class="form-control" value="<?php echo $etudiant_info['VILLE_ETU'];?>" type="text" id="inputVille" placeholder="Type to search...">
                </div>
                <div class="col-xl-4  col-sm-12">
                  <label for="inputPays" class="col-form-label">Pays</label>

                  <input disabled class="form-control" value="<?php echo $etudiant_info['PAYS_ETU'];?>" type="text" id="inputPays" placeholder="Type to search...">
                </div>
                <div class="col-xl-4  col-sm-12">
                  <label for="dateNaiss" class="col-form-label">Date Naissance</label>

                  <input disabled class="form-control" value="<?php echo $etudiant_info['DATENAISS_ETU'];?>" type="date" id="dateNaiss" placeholder="Type to search...">
                </div>

              </div>

              <div class="row  mt-5">


                <div class="col-xl-6 col-sm-12">
                  <label for="inputNiveaux" class="col-form-label">Niveaux</label>

                  <select disabled id="inputNiveaux" class="form-select" aria-label="Default select example">
                    <option selected><?php echo $formation_niveau[0]['LIBELLE_NIV'];?> </option>
                  </select>
                </div>

                <div class="col-xl-6 col-sm-12">
                  <label for="inputFormation2" class="col-form-label">Formation</label>

                  <select disabled id="inputFormation2" class="form-select" aria-label="Default select example">
                    <option style="text-transform: uppercase" selected><?php echo $formation_niveau[0]['LIBELLE_FORM'];?> </option>

                  </select>
                </div>

              </div>




              <div class="row mt-5">

              </div>
                <div class="row mt-1">
                    <div class="col-xl-6 col-sm-12 ms-1">
                        <div>
                            <span class="modifier-info-headline">Modifier Mon CV</span>
                        </div>
                        <p class="mt-2">
                            Obligatoir d’importer votre Cv avant de postuler aux offres
                        </p>
                        <form enctype="multipart/form-data" method="post" action="">
                            <div  style="width: fit-content" class="mt-2   px-5 py-4  d-flex flex-column rounded-4 justify-content-center border border-link">
                                <img style="margin: auto; max-width: 75px" src="./../assets/img/comment-section/cv.png" alt="" />
                                <label for="inputfile" class="col-form-label mt-2 btn py-2 px-4 mt-3 btn-voir-plus">
                                    Importer  <i class="bi bi-file-arrow-up-fill"></i>
                                </label>
                                <input class="form-control d-none" name="cv" accept="application/pdf" type="file" id="inputfile">

                                <!--                                                                      <a class="mt-3 btn-voir-plus py-2 px-4" style="width: fit-content; font-size: 16px" href="">Importer  <i class="bi bi-file-arrow-up-fill"></i-->
                                <!--                                                                          ></a>-->
                            </div>
                            <div class="row ">
                                <div class="col-xl-8  mt-5">
                                    <button type="submit" name="filesUploaed"  value="uploadCvPostuler" class="btn btn-filtre btn-primary w-100 mb-3">    Enregistrer <i class="bi bi-plus-circle-fill"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="col-xl-5 col-sm-12 ms-2">
                        <?php

                        if (!empty($etudiant_info['CV_ETU'])){
                            $cvetu=$etudiant_info['CV_ETU'];
                           // <object data="data:application/pdf;base64,'. base64_encode($cvetu).'" type="application/pdf" style="width:100%"></object>

                            echo '
               

                    <div >
                        <p class="modifier-info-headline">Dernier Cv Importer  </p>
   
                        <a href="'.$cvetu.'" style="color:#7B61FF " target="_blank"> visualiser </a> 
                                          
                        </a>

                       

                     </div>



               
                ' ;
                        };
                        echo " ";
                        ?>
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
</body>

</html>