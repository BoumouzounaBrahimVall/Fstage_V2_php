<?php
    require( __DIR__.'../../phpQueries/respoRequiries.php'); 
?>



<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        
    </style>
     
    <title>Home respo</title>
  </head>
<body>
  
    <!-- Navbar  -->  
    <nav class="navbar navbar-expand-lg navbar-light m-0">
      <div class="container-fluid px-5">
        <a class="navbar-brand" href="#">
          <img id="logo" src="../assets/icon/logo.png" alt="logo" />
        </a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active">
              <a class="nav-link " aria-current="page" href="#">Acceuil</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gererOffre.php">Gérer les offres</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gererEtudiant.php">Gérer les comptes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gererStage.php">Gérer stage</a>
            </li>
          </ul>
          <div class="d-flex">
          <a  href="../pages/respoProfil.php">
              <img class="profile_icon rounded-circle border" src="<?php echo $respon_img;?>" alt="">
            </a>            <a
              name=""
              id="seDeconnecter"
              class="btn btn-outline-primary  btn-selector pt-3"
              href="../pages/login.php?logout"
              role="button"
              >Se deconnecter 
              <i class="fa-solid fa-right-from-bracket"></i>
              </a>
          </div>
        </div>
      </div>
    </nav>
    
    <div class="container ">
      
      <div class="row pt-0">

        <div class="container ">
          <div class="row">
            <div class="col-xl-3   col-sm-12">
              <div class="sidebar  ps-2 pe-2 pt-2 pb-2  mt-4">
                <ul type="none">
                  <li > <a href="#" class="actuel-page"><i class=" active  bi bi-house-fill"></i>Acceuil</a></li>  
                  
                </ul>
              </div>
            </div>
            <div class=" col p-4  mt-0">
              <div class="row  p-4">
                 <h4>Bonjour Resp. <?php
                    $req_respoName="SELECT e.NOM_ENS nomRep from `RESPONSABLE` r, `ENSEIGNANT` e where r.NUM_ENS=e.NUM_ENS 
                    and r.USERNAME_RES='$respon_username';";
                    $Smt_respoName=$bdd->query($req_respoName); 
                    $respo=$Smt_respoName->fetch(2); // arg: PDO::FETCH_ASSOC 
                    echo $respo['nomRep'];
                 ?> 👋🏻</h4><br>
                 <p class="text-secondary">Decouvrir quelque statistique sur la platform</p>
              </div>
              <div class="row  p-4 mt-2">
                <div class="col  p-4 mr-2 ">
                
                  <div class="row  p-4 statis-div-1">
                      
                    <div class="col-3 col-sm-5  p-4">
                      <img  src="../assets/icon/bag_purple.png" alt="offres">
                    </div>
                    <div class="col p-4">
                      <h1 class=" text-center"><?php
                    $req="SELECT COUNT(distinct(NUM_OFFR)) nbr_offre_total from 
                    `OFFREDESTAGE` ofr, `NIVEAU` niv where ofr.NUM_NIV=niv.NUM_NIV 
                    and niv.NUM_FORM='$formation'";
                    $Smt=$bdd->query($req); 
                    $nbr_of_tt=$Smt->fetch(2); // arg: PDO::FETCH_ASSOC 
                    echo $nbr_of_tt['nbr_offre_total'];
                 ?></h1>
                        <p class=" text-center">Nombre des offres</p>
                        
                    </div>
                    </div>
                </div>
                <!-- the other one-->
                <div class="col p-4 mr-2 ">
                
                  <div class="row  p-4 statis-div-2">
                      
                    <div class="col-3 col-sm-5  p-4">
                      <img  src="../assets/icon/student.png" alt="offres">
                    </div>
                    <div class="col p-4">
                      <h1 class=" text-center"><?php
                    $req="SELECT COUNT(distinct (E.CNE_ETU)) nbr_etudiant from `ETUDIANT` E,`ETUDIER` ETU, `NIVEAU` niv
                     where E.CNE_ETU=ETU.CNE_ETU and ETU.NUM_NIV=niv.NUM_NIV and niv.NUM_FORM='$formation'";
                    $Smt=$bdd->query($req); 
                    $nbr_of_tt=$Smt->fetch(2); // arg: PDO::FETCH_ASSOC 
                    echo $nbr_of_tt['nbr_etudiant'];
                 ?></h1>
                        <p class=" text-center">Nombre des Etudiants</p>
                        
                    </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
        
      </div>
      </div>
    </div>
    
    

    <!-- Main Content Area -->
 
  <!-- Pills content -->
  <footer>
    <div class="container mt-5">
      <div class="row">
        <div class="col-12">
          <div class="d-flex  justify-content-around align-items-center p-5">

         
          <div>
            <img id="logo-light" src="../assets/icon/logo-light.png" alt="" />
          </div>
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
          </a> </div>
        </div>
      </div>
      <div class="row">
        <div class="d-flex justify-content-center">

        <div class="col-3.5">
          <p class="copyright" >Copyright © Stage FSTM 2022. Tous droits réservés.</p>
        </div>
      </div>
      </div>
    </div>
  </footer>
  <!-- JavaScript Bundle with Popper-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/script.js"></script>
  </body>
</html>