<?php
    require( __DIR__.'../../phpQueries/respoRequiries.php'); 


           if($_SERVER['REQUEST_METHOD']=='POST'){
            $pass=password_hash($_POST['password'],PASSWORD_DEFAULT);
             $donnee=array(
              $_POST['cne'],
              $_POST['prenom'],
              $_POST['nom'],
              $_POST['datnes'],
              $_POST['email'],
              $pass,
              $_POST['tel'],
              $_POST['ville'],
              $_POST['pays'],
              $_POST['niveau']
             );
              //recuperer les donnees 
              $nnn=$_POST['nom'];
              $ppp=$_POST['prenom'];
              //la requette d'insertion
              $req="INSERT INTO Etudiant (CNE_ETU,PRENOM_ETU,NOM_ETU,DATENAISS_ETU,EMAIL_ENS_ETU,MOTDEPASSE_ETU,TEL_ETU,VILLE_ETU,PAYS_ETU)
               VALUES ('$donnee[0]','$donnee[1]','$donnee[2]','$donnee[3]','$donnee[4]','$donnee[5]','$donnee[6]','$donnee[7]','$donnee[8]');";
              //execution de la requette
              $bdd->exec($req); 
              $DT= date("Y-m-d");
              $req="INSERT INTO ETUDIER (CNE_ETU,NUM_NIV,DATE_NIV)
               VALUES ('$donnee[0]','$donnee[9]','$DT')";
              //execution de la requette
              $bdd->exec($req); 
             header('location:../pages/gererEtudiant.php');

           }
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

     
    <title>Publier offre</title>
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
              <a class="nav-link " aria-current="page" href="homeRespo.php">Acceuil</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gererOffre.php">Gérer les offres</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Gérer les comptes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Gérer stage</a>
            </li>
          </ul>
          <div class="d-flex">
          <a  href="../pages/respoProfil.php">
              <img class="profile_icon rounded-circle border" src="<?php echo $respon_img;?>" alt="">
            </a>
            <a
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
                            <li > <a href="#" class="actuel-page"><i class=" active  bi bi-person-fill"></i>Gérer Etudiants</a></li>  
                            <li > <a href="gererEnseignant.php" ><i class=" active  bi bi-person-fill"></i>Gérer Enseignant</a></li>  
                            </ul>
                        </div>
                    </div>
                    <div class=" col p-4  mt-0">
                        <div class="row  px-4 py-0">
                            <h4>Gerer comptes des etudiants</h4>
                        </div>
                        <div class="row  p-0 mt-0 mb-5">
                            <div class="col  p-4 mr-2 ">
                            
                            <div class="row  p-4 statis-div-2">
                                    <div class="col-3 col-sm-5  p-4">
                                        <img  src="../assets/icon/student.png" alt="offres">
                                    </div>
                                    <div class="col p-4">
                                    <?php
                                     $req1="SELECT COUNT(ETUDIANT.CNE_ETU)FROM `ETUDIANT`,`NIVEAU`,`ETUDIER` 
                                     WHERE ETUDIANT.CNE_ETU=ETUDIER.CNE_ETU and NIVEAU.NUM_NIV=ETUDIER.NUM_NIV 
                                     and NIVEAU.NUM_FORM='$formation';";
                                     $Smt1=$bdd->query($req1); 
                                     $nbr=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC 
                                     
                                     echo '<h1 class=" text-center">'.$nbr['COUNT(ETUDIANT.CNE_ETU)'].'</h1>';//<h1 class=" text-center">250</h1>
                                     ?>
                                        <p class=" text-center">Nombre des Etudiants</p>
                                    </div>
                                </div>
                            </div>
                            <!-- the other one-->
                            <div class="col p-4 mr-2 ">
                            
                            <div class="row  p-4  addOffre-div">
                                
                                    <div class="col-12 p-3 d-flex align-items-center  justify-content-center">
                                        <img  src="../assets/icon/plus-btn.png" alt="offres">

                                    </div>
                                      <!-- Button trigger modal -->
                                    <div class="col-12 p-0 d-flex align-items-center  justify-content-center">
                                        <button type="button" class="btn btn-seconnecter"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                                          Ajouter Etudiant</button>
                                       


                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-filtre" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                filtrer les données
                            </button>
                           
                            <div class="collapse " id="collapseExample">
                                <div class="row">
                                    <div class="filtre-bar ps-4  mt-5" >
                                        <form class="row g-3">
                                            <div class="col-xl-2 col-sm-6">
                                                <label for="inputIntitule2" class="col-form-label">CNE</label>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <input class="form-control" type="text" id="inputIntitule2" placeholder="CNE...">
                                            </div>
                                            <div class="col-xl-2 col-sm-6">
                                                <label for="inputNiveaux" class="col-form-label">Niveaux</label>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <select id="inputNiveaux" class="form-select" aria-label="Default select example">
                                                        <option selected>Trier par </option>
                                                        <option value="ILISI1">ILISI1</option>
                                                        <option value="ILISI2">ILISI2</option>
                                                        <option value="ILISI3">ILISI3</option>
                                                    </select>
                                                </div>
                                                        <div class="col-xl-2 col-sm-6">
                                                        <label for="inputTrier2" class="col-form-label">Trier</label>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                        <select id="inputTrier2" class="form-select" aria-label="Default select example">
                                                            <option selected>Trier par </option>
                                                            <option value="date">Date</option>
                                                            <option value="Alpha">Ordre Alphabetique</option>
                                                            </select></div>
                                                <div class="col-xl-6">
                                                <button type="submit" class="btn btn-filtre  w-100 mb-3">    Chercher <i class="bi bi-search"></i></button>
                                            </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row overflow-auto">
                                <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">CNE</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Nº stages</th>
                                    <th scope="col">Nº Offres</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                     $req="SELECT  ETUDIANT.CNE_ETU cne, ETUDIANT.NOM_ETU nom,ETUDIANT.PRENOM_ETU prenom,NIVEAU.LIBELLE_NIV niv
                                            FROM `ETUDIANT`,`NIVEAU`,`ETUDIER` WHERE ETUDIANT.CNE_ETU=ETUDIER.CNE_ETU and NIVEAU.NUM_NIV=ETUDIER.NUM_NIV
                                            and  NIVEAU.NUM_FORM='$formation' and ((ETUDIER.NUM_NIV in (SELECT ET1.NUM_NIV from ETUDIER ET1,ETUDIER ET2 
                                                 where ET1.CNE_ETU=ET2.CNE_ETU and ET1.NUM_NIV!=ET2.NUM_NIV  and ET1.DATE_NIV>=ET2.DATE_NIV)) or ETUDIER.CNE_ETU in
                                                  (SELECT ET3.CNE_ETU from ETUDIER ET3 GROUP by ET3.CNE_ETU HAVING COUNT(ET3.CNE_ETU)=1)) ;";
                                     $Smt=$bdd->query($req); 
                                     $rows=$Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC 
                                     //afficher le tableau
                                     foreach($rows as $V): 
                                      $cneEtudiant=$V['cne'];
                                      $req_nbr=" SELECT COUNT(POSTULER.CNE_ETU) nbr_post,COUNT(STAGE.CNE_ETU) nbr_stage 
                                      FROM `ETUDIANT`,`NIVEAU`,`ETUDIER`,`POSTULER`,`STAGE` WHERE ETUDIANT.CNE_ETU=ETUDIER.CNE_ETU 
                                      and ETUDIANT.CNE_ETU=POSTULER.CNE_ETU and ETUDIANT.CNE_ETU=STAGE.CNE_ETU and
                                       NIVEAU.NUM_NIV=ETUDIER.NUM_NIV and NIVEAU.NUM_FORM='$formation' and ETUDIANT.CNE_ETU=' $cneEtudiant';";
                                       $Smt_nbr=$bdd->query($req_nbr); 
                                       $nbr=$Smt_nbr->fetch(PDO::FETCH_ASSOC);
                                      echo' <tr>
                                      <th scope="row">'.$V['cne'].'</th>
                                    
                                            <td>'.$V['nom'].'</td>
                                            <td>'.$V['prenom'].'</td> 
                                            <td>'.$V['niv'].'</td>
                                            <td>'.$nbr['nbr_stage'].'</td>
                                            <td>'.$nbr['nbr_post'].'</td>
                                            <td>  
                                         <a class="ms-3" href="../pages/resposable-details-etudiant.php?cne='.$V['cne'].'"><i class=" active  bi bi-pencil-fill"></i></a>
                                        </td></tr>
                                        
                                    <tr>';
                                     endforeach;
                                    
                                    ?>
                                    
                                    
                                    
                                    
                
                                </tbody>
                                </table>
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
  <!--MODEL FORM-->
<!-- Modal -->
<div  class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="min-width: 500px;max-width: 800px">
    <div class="modal-content d-flex justify-content-center "style="max-width: 800px;margin:auto;">
      <div class="modal-header border-0">
      
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <span class="headline-form"> Ajouter un etudiant </span>

          </div>
          <div class="row">
            <form class=" g-3 mt-2" method="post">
            <div class="d-flex align-items-center ">
              <img class="me-2" src="../assets/icon/step1.svg" alt="">
              <span class="subheadline-form" >information sur l'etudiant</span>
            </div>
            
            <div >
              <div class="mt-4 p-2 border border-1 rounded-3">
              <a  class="mt-2 btn btn-import-img" href="">Importer image <i class="bi bi-image-fill"></i></a>

              <div>
                  <div class="row">
                  <div class="col-xl-6 col-sm-6">
                      <label for="inputNom2" class="col-form-label">Nom</label>
                  
                      <input class="form-control" type="text" id="inputNom2" name="nom" placeholder="Type to search...">
                  </div>
                  <div class="col-xl-6 col-sm-6">
                    <label for="inputPrenom2" class="col-form-label">Prenom</label>
                
                    <input class="form-control" type="text" id="inputPrenom2" name="prenom" placeholder="Type to search...">
                </div>

              </div>
            
            <div class="row">
              <div class="mt-2 col-xl-6 col-sm-6">
                  <label for="inputEmail" class="col-form-label">Email</label>
              
                  <input class="form-control" name="email" type="email" id="inputEmail" placeholder="Type to search...">
              </div>
              <div class="col-xl-6 col-sm-6">
                <label for="inputtel" class="col-form-label">Telephone</label>
            
                <input class="form-control" type="tel" id="inputtel" name="tel" placeholder="Type to search...">
            </div>

          </div>

          <div class="row mt-2 ">
            <div class="col-xl-6 col-sm-12">
                <label for="CNE" class="col-form-label">CNE</label>
            
                <input class="form-control"  type="text" id="CNE"  name="cne" placeholder="Type to search...">
            </div>
            <div class="col-xl-6 col-sm-12">
                <label for="inputVille" class="col-form-label">Ville</label>
            
                <input class="form-control"  type="text" id="inputVille" name="ville" placeholder="Type to search...">
            </div>
            <div class="col-xl-6  col-sm-12">
              <label for="inputPays" class="col-form-label">Pays</label>
          
              <input class="form-control" type="tel" id="inputPays"  name="pays" placeholder="Type to search...">
          </div>
          <div class="col-xl-6  col-sm-12">
            <label for="dateNaiss" class="col-form-label">Date Naissance</label>
        
            <input class="form-control" type="date" id="dateNaiss" name="datnes" placeholder="Type to search...">
        </div>

        </div>
              
            <div class="row">

                  
              
          </div>
                </div></div></div>
                <div class="mt-4">
                  <div class="d-flex align-items-center ">
                    <img class="me-2" src="../assets/icon/step2.svg" alt="">
                    <span class="subheadline-form">information sur niveau d'etude</span>
                  </div>
                  <div >
                    <div class="mt-4 p-2 border border-1 rounded-3">
                  
                    <div>
                    
                      <div class="row">
                            <div class="col-xl-6 col-sm-12">
                                <label for="inputNiveaux" class="col-form-label">Niveaux</label>
                              
                                <select id="inputNiveaux" class="form-select" name="niveau" aria-label="Default select example">
                                <?php
                                    //requette de selection 
                                    $req="SELECT NIVEAU.NUM_NIV,NIVEAU.LIBELLE_NIV FROM `Responsable`, `niveau` WHERE Responsable.NUM_FORM=niveau.NUM_FORM and Responsable.USERNAME_RES='$respon_username';";
                                    $Smt=$bdd->query($req); 
                                    $rows=$Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC 
                                    //afficher le tableau
                                  
                                    foreach($rows as $V): 
                                    
                                      echo" <option value=\"".$V['NUM_NIV']."\">".$V['LIBELLE_NIV']."</option>";
                                        
                                    endforeach;
                                   
                                ?>
                                    
                                  </select></div>
    
                                  <div class="col-xl-6  col-sm-12">
              <label for="inputpass" class="col-form-label">mot de passe</label>
          
              <input class="form-control" type="tel" id="inputpass"  name="password" placeholder="Type to search...">
          </div>  
                          
                      </div>
                      
                      </div>
                </div>
                <div class="row">
                  <div class="col-xl-6 mt-4">
                    <button type="submit" class="btn btn-filtre btn-primary w-100 mb-3">    Ajouter <i class="bi bi-plus-circle-fill"></i></button>
                  </div>
                </div>
                
              
            
          </form>
         
          </div>
        </div>
      </div>
    
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/script.js"></script>
  </body>
</html>