<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css">


  <title>g_stage</title>
</head>

<body>


  <?php
  require_once "./pages/nav-acceuil.php"
  ?>

  <div  class="container header-section">
    <div class="row">
      <div class="d-flex justify-content-between align-items-center">
        <div class="col-lg-6">
          <div>
            <h3 id="headline-title">Etes vous a la recherche du stage ?</h3>
            <p id="body-text">
              connectez vous pour explorer les offres de stages publié sur la
              plateforme.
            </p>
            <a  id="btn-seconnecter-body" class="btn btn-primary mt-3" href="#" role="button">Se Connecter</a>
          </div>
        </div>
        <div class="col-lg-6">
          <div>
            <img class="img-etud-header" src="./assets/img/img_lp.png" alt="" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="margin-top: 50px" class="container  main-stat-section">
    <div class="row">
      <div class="d-flex justify-content-start">
        <div class="col-lg-6 d-flex justify-content-around border border-1 border-primary rounded-3 p-4">
          <div class="statistique-section">
            <span class="d-block stat-chiffre"> <b>65</b> </span>
            <span class="d-block">Offres Publié</span>
          </div>
          <div class="statistique-section">
            <span class="d-block stat-chiffre"> <b>205</b> </span>
            <span class="d-block">Etudiant inscrits</span>
          </div>
          <div class="statistique-section">
            <span class="d-block stat-chiffre"> <b>105</b> </span>
            <span class="d-block">Rapport Publié</span>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div style="margin-top: 200px" id="Comment" class="container  comment-section">
    <div class="row mt-5">
      <div class="col-12">
        <h4 style="
                text-align: center;
                font-weight: 600;
                font-size: 36px;
                line-height: 23px;
              ">
          Comment ça marche
        </h4>
      </div>
    </div>
    <div class="row mt-5">
      <div class="d-flex   justify-content-around ">
        <div class="col-3 mt-5 d-flex flex-column  align-items-center d-block justify-content-center alignit">
          <img id="user-comment" src="./assets/img/comment-section/user.png" alt="">
          <h5 class="mt-5">Je connecte a mon compte</h5>
          <p class="p-comment" style="text-align: center;">J'entre toutes les informations me concernant pour améliorer ma visibilité.</p>

        </div>
        <div class="col-3 mt-5 d-flex flex-column  align-items-center d-block justify-content-center alignit">
          <img id="user-comment" src="./assets/img/comment-section/cv.png" alt="">
          <h5 class="mt-5">Je joins mon CV</h5>
          <p class="p-comment" style="text-align: center;">Je joins mon CV à mon profil et je remplis tous les champs du CV .</p>

        </div>
        <div class="col-3 mt-5 d-flex flex-column  align-items-center d-block justify-content-center alignit">
          <img id="user-comment" src="./assets/img/comment-section/loopsearch.png" alt="">
          <h5 class="mt-5 ">Je choisis l'offre de stage qui me correspond</h5>
          <p class="p-comment" style="text-align: center;">Je postule et j'envoie ma candidature </p>

        </div>
      </div>
    </div>
  </div>

  <div style="margin-top: 200px" class="container   offer-section">
    <div class="row">
      <div class="col-12">
        <h4 style="
                text-align: center;
                font-weight: 600;
                font-size: 36px;
                line-height: 23px;
              ">
          Offres de stage à la Une
        </h4>
      </div>
    </div>
    <div class="row mt-5 ">
      <div class="d-flex   justify-content-center ">

        <div class="">
          <div class="card border-link ">
            <div class="row">
              <div class="col">
                <span class="  m-3 badge-status  w-25  p-2  "> Nouveau </span>

              </div>
            </div>
            <div>

            </div>
            <div class="row">
              <div class="col">
                <img class=" m-4 company-logo" src="./ressources/company/images/atos.png" alt="">

              </div>
            </div>

            <div class="card-body">
              <h4 class="card-title"> <b>Developpeur Front-end</b> </h4>
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
                  <img class="place-svg" src="./assets/icon/card/place.svg" alt="">
                  <span class="place-location">
                    Mohammedia,Maroc
                  </span>
                </div>
                <div class="ms-5">
                  <img class="place-svg" src="./assets/icon/card/time.svg" alt="">
                  <span class="place-location">
                    6 mois
                  </span>
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
            <div class="card-footer-p p-3  d-flex justify-content-around border-top-0">

              <a name="" id="" class="btn ps-5 pe-5 btn-postuler" href="#" role="button">Postuler</a>
              <a name="" id="" class="btn ps-5 pe-5 btn-voir-plus" href="#" role="button">Voir plus</a>

            </div>
          </div>


        </div>
        <div class="ms-5">
          <div class="card border-link ">
            <div class="row">
              <div class="col">
                <span class="  m-3 badge-status  w-25  p-2  "> Nouveau </span>

              </div>
            </div>
            <div>

            </div>
            <div class="row">
              <div class="col">
                <img class=" m-4 company-logo" src="./ressources/company/images/atos.png" alt="">

              </div>
            </div>

            <div class="card-body">
              <h4 class="card-title"> <b>Developpeur Front-end</b> </h4>
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
                  <img class="place-svg" src="./assets/icon/card/place.svg" alt="">
                  <span class="place-location">
                    Mohammedia,Maroc
                  </span>
                </div>
                <div class="ms-5">
                  <img class="place-svg" src="./assets/icon/card/time.svg" alt="">
                  <span class="place-location">
                    6 mois
                  </span>
                </div>
              </div>
              <div class="mt-3">
                <div class="headline">
                  <b>Details</b>
                </div>
                <p class="card-text mt-2">

                  – Missions principales : <br> Etude, conception et réalisation d’une application mobile <br> – Mode travail : à distance 100% <br> – Ville : Rabat<br>

                </p>
              </div>

            </div>
            <div class="card-footer-p p-3  d-flex justify-content-around border-top-0">

              <a name="" id="" class="btn ps-5 pe-5 btn-postuler" href="#" role="button">Postuler</a>
              <a name="" id="" class="btn ps-5 pe-5 btn-voir-plus" href="#" role="button">Voir plus</a>

            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
  <div style="margin-top: 200px" id="apropos" class="container  apropos-section">
    <div class="row">
      <div class="col-12">
        <h4 style="
                text-align: center;
                font-weight: 600;
                font-size: 36px;
                line-height: 23px;
              ">
          A propos
        </h4>
        <div class="row mt-5">
          <div class=" ">
            <div class="d-flex mt-5 justify-content-center">
              <div class="col-3">
                <img class="logo-apropos" src="assets/icon/logo-apropos.png" alt="">
              </div>
              <div class="col-6">
                <p class=" project-desc">
                  Stage FSTM est une plateforme digitale a pour le but aider les etudiants de la fstm de trouver les stages facilement qui le convient et aussi de partager les rapports de stage entre eux

                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="margin-top: 200px" id="contact" class="container  contact-section">
    <div class="row">
      <div class="col-12">
        <h4 style="
                text-align: center;
                font-weight: 600;
                font-size: 36px;
                line-height: 23px;
              ">
          Contactez Nous
        </h4>

      </div>
    </div>
    <div class="row mt-5 d-flex justify-content-center">
      <div class="col-4">
        <form>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email </label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="saisie votre email" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="exampleInputObjet1" class="form-label">Objet</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="saisie l'objet " aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Description</label>
            <textarea class="form-control" name="" id="" rows="3"></textarea>
          </div>

          <a type="button " class=" mt-2 btn btn-envoyer btn-lg ">Envoyer</a>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

  <footer>
    <div style="margin-top: 120px" class="container">
      <div class="row">
        <div class="col-12">
          <div class="d-flex  justify-content-around align-items-center p-5">


            <div>
              <img id="logo-light" src="/assets/icon/logo-light.png" alt="" />
            </div>
            <a href="#">
              Offre de stage
            </a>

            <a href="#">
              Contact
            </a>
            <a href="#">
              A propos
            </a>
            <a href="#">
              Espace Responsable
            </a>
            <a href="#">
              Espace Etudiant
            </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="d-flex justify-content-center">

          <div class="col-3.5">
            <p class="copyright">Copyright © Stage FSTM 2022. Tous droits réservés.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>