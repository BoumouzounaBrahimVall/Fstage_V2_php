
<?php
require_once(__DIR__.'./../phpQueries/etudiant/detailoffr.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <?php
      require_once "./meta-tag.php"
      ?>
    <title>Offre Détails</title>
  </head>

  <body>
  <?php
  require_once "nav-etudiant.php";
  ?>
    <div class="container">
      <div class="row">
        <div class="col-xl-3 col-sm-12">
            <?php
            require_once "./etudiant-sidebar-offre.php";
            ?>
        </div>
        <div class="col-xl-9 col-sm-12">
          <div class="intro p-4 mt-3 d-flex align-items-center">
            <h3><b>Détails de l'offre</b></h3>
          </div>
          <div class="intro ps-4">
            <p>
              exploiter les differentes informations concernant l'offre du stage
            </p>
          </div>
          <div class="row ms-xl-4 mt-xl-4 p-xl-4 border-link border rounded-3">
              <?php
              if(empty($offre_stage["IMAGE_ENT"] )) $offre_stage["IMAGE_ENT"]= "./../ressources/company/images/atos.png";

              echo '
              
              <div class="col-xl-3">
              <img
                class="m-4 company-logo" style="max-width: 150px;"
                src='.$offre_stage["IMAGE_ENT"] .'
                alt=""
              />
            </div>
            <div class="col-xl-9">
              <div class="card-body">
                <h4 class="card-title" style="text-transform: capitalize"><b>'.$offre_stage["POSTE_OFFR"] .'</b></h4>
                
                <div class="sujet mt-3">
                  <span class="title-specification">Sujet </span> <br />
                  <span class="detail-specification"
                    >'.$offre_stage["SUJET_OFFR"] .'
                  </span>
                </div>
                <div class="durre mt-3">
                  <span class="title-specification">Durré : </span>
                  <span class="detail-specification">'.$offre_stage["DURE_OFFR"] .' mois</span>
                </div>
                <div class="lieux mt-3">
                  <span class="title-specification">Lieux : </span>
                  <span class="detail-specification" style="text-transform: capitalize">'.$offre_stage["VILLE_OFFR"] .','.$offre_stage["PAYS_OFFR"] .'</span>
                </div>
                <div class="societe mt-3">
                  <span class="title-specification">Societé : </span>
                  <span class="detail-specification"> '.$offre_stage["LIBELLE_ENT"] .'</span>
                </div>
                <div class="niveaux mt-3">
                  <span class="title-specification">Niveaux : </span>
                  <span class="detail-specification"> '.$offre_stage["LIBELLE_NIV"] .'</span>
                </div>
                <div class="societe mt-3">
                  <span class="title-specification">Effectif : </span>
                  <span class="detail-specification"> '.$offre_stage["EFFECTIF_OFFRE"] .' poste</span>
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
            
             
            </div>
              '
              ?>

          </div>
        </div>

        
      </div>
    </div>
    

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
