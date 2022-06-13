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
  require( __DIR__.'./../phpQueries/etudiant/dash.php');
  ?>

  <div class="container ">
    <div class="row">
      <div class="col-xl-3   col-sm-12">
      <?php
  require_once "./etudiant-sidebar-rapport.php";
  
  

function info_etu($rap,$etu,$bdd)
{
  $student = "SELECT ETUDIANT.NOM_ETU,ETUDIANT.PRENOM_ETU,ETUDIANT.CV_ETU,niveau.NUM_NIV,niveau.LIBELLE_NIV from STAGE,ETUDIANT,etudier,niveau,RAPPORT
  where STAGE.CNE_ETU=ETUDIANT.CNE_ETU and etudiant.CNE_ETU=etudier.CNE_ETU and etudier.NUM_NIV=niveau.NUM_NIV and RAPPORT.NUM_STG=STAGE.NUM_STG
  and RAPPORT.NUM_RAP='$rap' order by NUM_NIV desc ; ";
$info_etu=$bdd->query($student);

$etu=$info_etu->fetchAll(2);
return $etu;

}

function mot_clets($rap,$motcl,$bdd)
{
  $student = "SELECT MOTCLE.LIBELLE_CLE from MOTCLE,CONTENIRMOTRAP 
  where MOTCLE.NUM_CLE=CONTENIRMOTRAP.NUM_CLE and 
  CONTENIRMOTRAP.NUM_RAP='$rap'; ";
$info_motcle=$bdd->query($student);

$motcl=$info_motcle->fetchAll(2);
return $motcl;

}

  ?>

  <?php

//var_dump(info_etu(1,@$etu,$bdd)[0]["NOM_ETU"]);

  $req_rapport = "SELECT * from rapport where rapport.NUM_STG in (select NUM_STG from stage where stage.CNE_ETU='$etudiant_cne') ;";
$All_rapport = $bdd->query($req_rapport);
$fich_rapport = $All_rapport->fetchAll(2);
  
  ?>
      </div>
      <div class=" col-xl-9 col-sm-12">
        <div class="intro p-4 mt-3 d-flex align-items-center">
          <h3> <b>Consulter Rapport</b> </h3>

        </div>
        <div class="intro ps-4 ">
          <p>
            chercher par mot cle ou intitule
          </p>
        </div>

        <!--------Filter bar ----->
        <div class="row">
          <div class="filtre-bar ps-4  mt-5">
            <form class="row g-3">
              <div class="col-xl-2 col-sm-6">
                <label for="inputIntitule2" class="col-form-label">Intitule</label>
              </div>
              <div class="col-xl-4 col-sm-6">
                <input class="form-control" type="text" id="inputIntitule2" placeholder="Type to search...">
              </div>
              <div class="col-xl-2 col-sm-6">
                <label for="inputMotcle" class="col-form-label">Mot cle</label>
              </div>
              <div class="col-xl-4 col-sm-6">
                <input class="form-control" list="datalistOptions" id="inputMotcle" placeholder="Type to search...">
                <datalist id="datalistOptions">
                  <option value="Reseau">
                  <option value="Informatique">
                  <option value="BDD">

                </datalist>
              </div>

              <div class="col-xl-2 col-sm-6">
                <label for="inputNiveaux" class="col-form-label">Niveaux</label>
              </div>
              <div class="col-xl-4 col-sm-6">
                <select id="inputNiveaux" class="form-select" aria-label="Default select example">
                  <option selected>Trier par </option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </div>

              <div class="col-xl-2 col-sm-6">
                <label for="inputTrier2" class="col-form-label">Trier</label>
              </div>
              <div class="col-xl-4 col-sm-6">
                <select id="inputTrier2" class="form-select" aria-label="Default select example">
                  <option selected>Trier par </option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
              <div class="col-xl-6">
                <button type="submit" class="btn btn-filtre btn-primary w-100 mb-3"> Chercher <i class="bi bi-search"></i></button>
              </div>
            </form>
          </div>
        </div>


        <div class=" list-rapport mt-3">
          <?php foreach($fich_rapport as $V): ?>
          <!---- card rapport--->
          <div class="container-card d-flex flex-column flex-wrap">
            <div class="border card-rapport rounded-3  border-link col-xl-12 m-xl-3 p-xl-4 ">
              <div class="d-flex p-2">
                <div>
                  <h4> <b><?php echo($V['INTITULE_RAP']);?></b> </h4>

                  <div class="badges d-flex justify-content-start">
                       <?php  @$keyword=mot_clets($V['NUM_RAP'],$keyword,$bdd); ?>
                    <div class="mt-3">
                      <span class="badge   p-2 badge-key rounded-pill bg-primary"><?php echo($keyword[0]['LIBELLE_CLE']);?></span>
                    </div>
                    <div class="mt-3">
                      <span class="badge  ms-3 p-2 badge-key rounded-pill bg-success"><?php echo($keyword[1]['LIBELLE_CLE']);?></span>
                    </div>
                    <div class="mt-3">
                      <span class="badge ms-3 p-2 badge-key rounded-pill bg-danger"><?php echo($keyword[2]['LIBELLE_CLE']);?></span>
                    </div>
                  </div>
                  <div class="mt-3">
                    <div class="headline">
                      <b>Details</b>
                    </div>
                    <p class="card-text mt-2">

                      – Missions principales : <br>
                      Etude, conception et réalisation d’une application mobile <br>
                      – Mode travail : à distance 100% <br>
                      – Ville : Rabat<br>

                    </p>
                  </div>
                </div>
                <div class="ms-xl-5 ms-sm-2  d-flex flex-column flex-nowrap align-items-center ">
                  <img style="max-height: 60px;" src="../../assets/img/avatar.png" alt="">
                  <p style="font-size: 14px; margin-top: 10px; text-align: center;"><?php @$stud=info_etu($V['NUM_RAP'],$stud,$bdd);echo($stud[0]['NOM_ETU']);  ?> <br><?php echo($stud[0]['LIBELLE_NIV']);?></p>
                  <div class="  d-flex  flex-column justify-content-around border-top-0">

                    <a name="" id="" class="btn-postuler btn px-xl-4  border border-1 " href="<?php echo($stud[0]['CV_ETU']) ;?>" role="button"  download="Article_HTML5_download.pdf">Télechager</a>
                    <a name="" id="" class="btn-voir-plus btn px-xl-4 mt-2  border border-1" href="<?php echo($stud[0]['CV_ETU']) ;?>" role="button" target="_blank">Voir plus</a>
                    <!-- <a href="'.$cvetu.'" style="color:#7B61FF " target="_blank"> visualiser </a> -->
                  </div>
                </div>
              </div>

            </div>
            <?php endforeach; ?>

           



          </div>
        </div>
      </div>
    </div>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>