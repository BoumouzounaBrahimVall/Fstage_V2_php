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
  require_once "./etudiant-sidebar-rapport.php";
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
          <!---- card rapport--->
          <div class="container-card d-flex flex-column flex-wrap">
            <div class="border card-rapport rounded-3  border-link col-xl-12 m-xl-3 p-xl-4 ">
              <div class="d-flex p-2">
                <div>
                  <h4> <b>Conception et Realisation d’une application Web</b> </h4>

                  <div class="badges d-flex justify-content-start">

                    <div class="mt-3">
                      <span class="badge   p-2 badge-key rounded-pill bg-primary">Conception</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge  ms-3 p-2 badge-key rounded-pill bg-success">Stage PFA</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge ms-3 p-2 badge-key rounded-pill bg-danger">Rapport</span>
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
                  <p style="font-size: 14px; margin-top: 10px; text-align: center;">Vall Brahim <br>ILISI </p>
                  <div class="  d-flex  flex-column justify-content-around border-top-0">

                    <a name="" id="" class="btn-postuler btn px-xl-4  border border-1 " href="#" role="button">Télechager</a>
                    <a name="" id="" class="btn-voir-plus btn px-xl-4 mt-2  border border-1" href="#" role="button">Voir plus</a>

                  </div>
                </div>
              </div>

            </div>
            <div class="border card-rapport rounded-3  border-link col-xl-12 m-xl-3 p-xl-4 ">
              <div class="d-flex p-2">
                <div>
                  <h4> <b>Conception et Realisation d’une application Web</b> </h4>

                  <div class="badges d-flex justify-content-start">

                    <div class="mt-3">
                      <span class="badge   p-2 badge-key rounded-pill bg-primary">Conception</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge  ms-3 p-2 badge-key rounded-pill bg-success">Stage PFA</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge ms-3 p-2 badge-key rounded-pill bg-danger">Rapport</span>
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
                  <p style="font-size: 14px; margin-top: 10px; text-align: center;">Vall Brahim <br>ILISI </p>
                  <div class="  d-flex  flex-column justify-content-around border-top-0">

                    <a name="" id="" class="btn-postuler btn px-xl-4  border border-1 " href="#" role="button">Télechager</a>
                    <a name="" id="" class="btn-voir-plus btn px-xl-4 mt-2  border border-1" href="#" role="button">Voir plus</a>

                  </div>
                </div>
              </div>

            </div>
            <div class="border card-rapport rounded-3  border-link col-xl-12 m-xl-3 p-xl-4 ">
              <div class="d-flex p-2">
                <div>
                  <h4> <b>Conception et Realisation d’une application Web</b> </h4>

                  <div class="badges d-flex justify-content-start">

                    <div class="mt-3">
                      <span class="badge   p-2 badge-key rounded-pill bg-primary">Conception</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge  ms-3 p-2 badge-key rounded-pill bg-success">Stage PFA</span>
                    </div>
                    <div class="mt-3">
                      <span class="badge ms-3 p-2 badge-key rounded-pill bg-danger">Rapport</span>
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
                  <p style="font-size: 14px; margin-top: 10px; text-align: center;">Vall Brahim <br>ILISI </p>
                  <div class="  d-flex  flex-column justify-content-around border-top-0">

                    <a name="" id="" class="btn-postuler btn px-xl-4  border border-1 " href="#" role="button">Télechager</a>
                    <a name="" id="" class="btn-voir-plus btn px-xl-4 mt-2  border border-1" href="#" role="button">Voir plus</a>

                  </div>
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