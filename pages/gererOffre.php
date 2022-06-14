<?php
 require( __DIR__.'../../phpQueries/respoRequiries.php'); 
 ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
      <?php
      require_once "./meta-tag.php"
      ?>
     <title>Gerer offres</title>
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
              <a class="nav-link" href="#">Gérer les offres</a>
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
            </a>
            <a
              name=""
              id="seDeconnecter"
              class="btn btn-outline-primary  btn-selector pt-3"
              href="login.php"
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
                  <li > <a href="#" class="actuel-page"><i class=" active  bi bi-briefcase-fill "></i>Gerer Offres</a></li> 
                  <li > <a href="publierOffre.php"><i class=" active  bi bi-briefcase-fill"></i>Publier Offre</a></li>  
                   
                </ul>
              </div>
            </div>
            <div class=" col p-4  mt-0">
              <div class="row px-xl-4  ">
                 <h4>Mettre à jour listes des offres</h4>
              </div>
              
              <div class="container-fluid d-flex justify-content-center align-items-center row mt-2">
                <div class="col-lg-6 col-md-12 p-xl-4 mr-2 my-sm-2 ">
                
                  <div class="row  pt-3 pb-3 statis-div-2 mt-2">
                      
                    <div class="col-2 col-sm-5  p-4">
                      <img  src="../assets/icon/bag_green.png" alt="offres">
                    </div>
                    <div class="col p-4">
                      <h1 class=" text-center">
                      <?php
                                     $req1="SELECT COUNT(off.NUM_OFFR) nbr_nv_off FROM `OFFREDESTAGE` off,NIVEAU niv WHERE niv.NUM_NIV=off.NUM_NIV and off.ETATPUB_OFFR='nouveau' and niv.NUM_FORM='$formation';";
                                     $Smt1=$bdd->query($req1); 
                                     $nbr=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC 
                                     
                                     echo '<h1 class=" text-center">'.$nbr['nbr_nv_off'].'</h1>';//<h1 class=" text-center">250</h1>
                                     ?></h1>
                      
                        <p class=" text-center">nouveaux offres</p>
                        
                    </div>
                    </div>
                </div>
                <!-- the other one-->
                <div class="col-lg-6 col-md-12  p-xl-4 mr-2 my-sm-2 ">
                
                  <div class="row   pt-3 pb-3  statis-div-3 mt-2">
                      
                    <div class="col-2 col-sm-5  p-4">
                      <img  src="../assets/icon/bag_red.png" alt="offres">
                    </div>
                    <div class="col p-4">
                      <h1 class=" text-center"><?php
                                     $req1="SELECT COUNT(off.NUM_OFFR) nbr_off_cmp FROM `OFFREDESTAGE` off,NIVEAU niv WHERE niv.NUM_NIV=off.NUM_NIV and off.ETATPUB_OFFR='complete' and niv.NUM_FORM='$formation';";
                                     $Smt1=$bdd->query($req1); 
                                     $nbr=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC 
                                     
                                     echo '<h1 class=" text-center">'.$nbr['nbr_off_cmp'].'</h1>';//<h1 class=" text-center">250</h1>
                                     ?></h1>
                        <p class=" text-center">offres complétés</p>
                        
                    </div>
                    </div>
                </div>



                  <!--------Filter bar ----->

                  <div class="mt-2 border p-3 rounded-5 rounded border-1 ">
                      <table id="table_id"  style="width:100%" class=" nowrap display">
                          <thead>
                          <tr>
                              <th scope="col">id</th>
                              <th scope="col">Entreprise</th>
                              <th scope="col">Poste</th>
                              <th scope="col">Niveau</th>
                              <th scope="col">Effectif</th>
                              <th scope="col">Nbr candidats</th>
                              <th scope="col">Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          $req="SELECT ofr.*,ent.LIBELLE_ENT,niv.LIBELLE_NIV FROM `OFFREDESTAGE` ofr,NIVEAU niv ,ENTREPRISE ent 
                      WHERE niv.NUM_NIV=ofr.NUM_NIV and ent.NUM_ENT=ofr.NUM_ENT and niv.NUM_FORM='$formation';";
                          $Smt=$bdd->query($req);
                          $rows=$Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC
                          //afficher le tableau
                          foreach($rows as $V):
                              $postul=$V['NUM_OFFR'];
                              $nbr="SELECT count(POSTULER.CNE_ETU) nbrpost FROM `POSTULER` WHERE POSTULER.NUM_OFFR='$postul';";
                              $Smt2=$bdd->query($nbr);
                              $nbrCnd=$Smt2->fetch(PDO::FETCH_ASSOC);
                              echo' <tr>
                            <td>'.$V['NUM_OFFR'].'</td>
                    
                            <td>'.$V['LIBELLE_ENT'].'</td>
                            <td>'.$V['POSTE_OFFR'].'</td> 
                            <td>'.$V['LIBELLE_NIV'].'</td> 
                            <td>'.$V['EFFECTIF_OFFRE'].'</td>
                            <td>'.$nbrCnd['nbrpost'].'</td>
                            <td>  
                                <a class="ms-3" href="../pages/resposable-details-offre.php?numOffre='.$V['NUM_OFFR'].'"><i class=" active  bi bi-pencil-fill"></i></a>
                                </td>
                            </tr>
                        
                    ';
                          endforeach;

                          ?>


                          </tbody>
                          <tfoot>

                          </tfoot>
                      </table>
                  </div>


              </div>
              </div>
            </div>
        </div>
        
      </div>
      </div>
    </div>
    
    

    <!-- Main Content Area -->

    <script>
        $(document).ready( function () {
            $('#table_id').DataTable({
                scrollY: 200,
                scrollX: true,
            });
        } );
    </script>
  </body>
</html>