<?php
 require( __DIR__.'./../phpQueries/respoRequiries.php');
require( __DIR__.'./../phpQueries/etudiant/uploadfile.php');
 if($_SERVER['REQUEST_METHOD']=='POST'){

    $donnee=array(
      @$_POST['inputEntreprise'], //ent existe
        @$_POST['inputIntitule'], // ent intit crée
        @$_POST['inputEmail'], //ent mail crée
        @$_POST['inputAdresse'],//ent adr crée
        @$_POST['inputtel'], //ent tel crée
        @$_POST['inputVille'],//ent ville crée
        @$_POST['inputPays'],//ent pays crée

        @$_POST['inputpost'],//offre post crée
        @$_POST['dateDeb'],//offre  dateDeb
        @$_POST['dateFin'],//offre  datefin
        @$_POST['inputvilleoffre'], //offre  ville
        @$_POST['delai'],          //offre  delai
        @$_POST['inputeffectif'],  //offre  effectif
        @$_POST['inputpaysoffre'], //offre  pays
        @$_POST['inputNiveaux'], //offre  niveau
        @$_POST['detailoffre'],  //offre  detais

        @$_POST['CNE'], //stage CNE 16
        @$_POST['inputSujet'], //stage sujet 17
        @$_POST['dtDebStg'], //stage debut 18
        @$_POST['dtFinStg'], //stage fin 19

     );
  if(!empty($donnee[1]))//entreprise n'existe pas. on l'ajoute
  {

    $req="INSERT INTO entreprise (LIBELLE_ENT,ADRESSE_ENT,EMAIL_ENT,TEL_ENT,VILLE_ENT,PAYS_ENT)
    VALUES ('$donnee[1]','$donnee[3]','$donnee[2]','$donnee[4]','$donnee[5]','$donnee[6]');";
   //execution de la requette
   $bdd->exec($req);
   //recuperer l'entreprise
   $reqEntlast="select entreprise.NUM_ENT from entreprise where entreprise.NUM_ENT>=ALL(select ent.NUM_ENT from entreprise ent);";
    $smtentlast=$bdd->query($reqEntlast);
    $lastent=$smtentlast->fetch(2);

    $donnee[0]=$lastent['NUM_ENT'];

    //add image entreprise
      if(isset($_POST['cvPath']))
      {

          $file = $_POST['cvPath'];
          uploadImagesOrCVFirebase($donnee[17],$file,$bdd,3);
      }
  }
if(!empty($donnee[17]))//stage ext
{
    $req_etudiant_niveau = "SELECT NUM_NIV from ETUDIER WHERE CNE_ETU='$donnee[16]'ORDER BY DATE_NIV DESC";
    $Smt_etudiant_niveau = $bdd->query($req_etudiant_niveau);
    $etudiant_niveaux = $Smt_etudiant_niveau->fetchAll(PDO::FETCH_ASSOC);
    $etudiant_niveau =$etudiant_niveaux[0]['NUM_NIV'];
    $dt=date("Y-m-d");
    //inserer offre

    $req2 = "INSERT INTO offredestage (NUM_NIV,NUM_ENT,POSTE_OFFR,EFFECTIF_OFFRE,DETAILS_OFFR,DATEDEB_OFFR,DATEFIN_OFFR,VILLE_OFFR,ETATPUB_OFFR,PAYS_OFFR,TYPE_OFFR)
    VALUES ('$etudiant_niveau','$donnee[0]','$donnee[7]','1','$donnee[15]','$dt','$dt','$donnee[10]','CLOSE','$donnee[13]','2');";
    //execution de la requette
    $bdd->exec($req2);

    //recuperer l'offre
    $reqOfflast="select offredestage.NUM_OFFR from offredestage where offredestage.NUM_OFFR>=ALL(select offr.NUM_OFFR from offredestage offr);";
    $smtOfflast=$bdd->query($reqOfflast);
    $lastOff=$smtOfflast->fetch(2);
    $numOffre=$lastOff['NUM_OFFR'];

    //inserer postulation
    $req2 = "INSERT INTO postuler (NUM_OFFR, CNE_ETU, DATE_POST, ETATS_POST, date_reponse)
    VALUES ('$numOffre','$donnee[16]','$dt','ACCEPTER','$dt');";
    //execution de la requette
    $bdd->exec($req2);
    //inserer le stage
    $req2 = "INSERT INTO stage (NUM_OFFR, CNE_ETU, DATEDEB_STG, DATEFIN_STG, SUJET_STG, ACTIVE_STG)
    VALUES ('$numOffre','$donnee[16]','$donnee[18]','$donnee[19]','$donnee[17]','0');";
    //execution de la requette
    $bdd->exec($req2);

}
else {// offre publique
    $req2 = "INSERT INTO offredestage (NUM_NIV,NUM_ENT,POSTE_OFFR,EFFECTIF_OFFRE,DETAILS_OFFR,DATEDEB_OFFR,DATEFIN_OFFR,VILLE_OFFR,ETATPUB_OFFR,PAYS_OFFR,DELAI_JOFFR,TYPE_OFFR)
    VALUES ('$donnee[14]','$donnee[0]','$donnee[7]','$donnee[12]','$donnee[15]','$donnee[8]','$donnee[9]','$donnee[10]','NOUVEAU','$donnee[13]','$donnee[11]','1');";
    //execution de la requette
    $bdd->exec($req2);
}
     header('location:../pages/publierOffre.php');
 }

?>


<!DOCTYPE html>
<html lang="fr">
  <head>

      <?php
      require_once "./meta-tag.php"
      ?>

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
                  <li > <a href="gererOffre.php"><i class=" active  bi bi-briefcase-fill"></i>Gerer Offres</a></li>  
                 <li > <a href="#" class="actuel-page"><i class=" active  bi bi-briefcase-fill"></i>Publier Offre</a></li>  
                </ul>
              </div>
            </div>
            <div class=" col p-4  mt-0">
              <div class="row  px-4 py-0">
                 <h4 >Publier une offre de stage</4>
              </div>
              <div class="row  p-0 mt-0 mb-5">
                <div class="col  p-4 mr-2 ">
                
                  <div class="row  p-4 statis-div-1">
                      
                    <div class="col-3 col-sm-5  p-4">
                      <img  src="../assets/icon/bag_purple.png" alt="offres">
                    </div>
                    <div class="col p-4">
                      <h1 class=" text-center"><?php
                                     $req1="SELECT COUNT(DISTINCT(off.NUM_OFFR)) nbr_ffr FROM `OFFREDESTAGE` off,NIVEAU niv 
                                     WHERE niv.NUM_NIV=off.NUM_NIV and niv.NUM_FORM='$formation';";
                                     $Smt1=$bdd->query($req1); 
                                     $nbr=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC 
                                     
                                     echo '<h1 class=" text-center">'.$nbr['nbr_ffr'].'</h1>';//<h1 class=" text-center">250</h1>
                                     ?></h1>
                        <p class=" text-center">offres de stage</p>
                        
                    </div>
                    </div>
                </div>
                <!-- the other one-->
                <div class="col p-4 mr-2 ">
                
                  <div class="row  p-4  addOffre-div">
                      
                        <div class="col-12 p-3 d-flex align-items-center  justify-content-center">
                            <img  src="../assets/icon/plus-btn.png" alt="offres">

                        </div>
                        <div class="col-12 p-0 d-flex align-items-center  justify-content-center">
                            <button class="btn btn-seconnecter" data-bs-toggle="modal" data-bs-target="#exampleModal">
                              Publier Offre</button>
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






  <!-- Modal -->
<div  class="modal fade" id="exampleModal" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="min-width: 370px;max-width: 800px">
    <div class="modal-content d-flex justify-content-center "style="max-width: 800px;min-width: 370px;margin:auto;">
      <div class="modal-header border-0">
      
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <span class="headline-form"> Ajouter un offre </span>

          </div>
          <div class="row">
    
            
     
        <div class="d-flex align-items-center ">
          <img class="me-2" src="../assets/icon/step1.svg" alt="">
          <span class="subheadline-form" >information sur l'entreprise</span>
        </div>
      <div class="mt-4 p-2 border border-1 rounded-3">  
    <form class="row g-3" action="" method="post">
        <div class="form-check ms-3">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1" checked>
            <label class="form-check-label" for="flexRadioDefault1">
                 Entreprise existe dans la base de donnees
            </label>
        </div>
    
        <div class="form-check ms-3">
              <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="0" >
              <label class="form-check-label" for="flexRadioDefault2">
                    Nouvelle entreprise 
              </label>
        </div> 
       </div> 
        
          <div class="mt-4 p-2 border border-1 rounded-3" id="IDdiv_selectionner_entr">
          
          <div >
          
              <div class="row" >
       
              <div class="col-xl-6 col-sm-12">
                  <label for="inputEntreprise" class="col-form-label">Selectionné une entreprise</label>
    
              </div>
              
              <div class="col-xl-6 col-sm-12">
                <?php

                    $req="SELECT * FROM ENTREPRISE";
                    $Smt=$bdd->query($req);
                    $rows=$Smt->fetchAll(2);
                    
                    echo '<select id="inputEntreprise" name="inputEntreprise" class="form-select" aria-label="Default select example">';
                      
                    foreach($rows as $V):
                      echo '<option  value='.$V['NUM_ENT'].'>'.$V['LIBELLE_ENT'].' </option>';
                        $lastNum=$V['NUM_ENT'];
                    endforeach;

                $lastNum++;



                ?>
                 
                </select></div>
          
            </div>
              
    
          </div>
        </div>
        </div>
            <div class="row mt-2">               
               </div>
               
                <div class="col-12" id="div_nouvel_entre" >
                  <div class="mt-2 p-2 border border-1 rounded-3 " >
                    <div  >
                      <div class="">
                      <label for="files" class="col-form-label mt-2 btn btn-import-img">
                      Importer logo <i class="bi bi-image-fill"></i>
                      </label>
                      <input class="form-control d-none" onchange="uploadFileToFirebase('files','btnSubmit','pathStorageFile',3,'<?php echo $lastNum; ?>')" accept="image/*" type="file" id="files">
      
                      <div>
                          <input class="form-control d-none" name="cvPath" id="pathStorageFile" >

                          <div class="row mt-2 ">
                          <div class="col-xl-6 col-sm-12">
                              <label for="inputIntitule" class="col-form-label">Intitule</label>
                          
                              <input class="form-control" type="text" id="inputIntitule" name="inputIntitule" placeholder="Type to search...">
                          </div>
                          <div class="col-xl-6 col-sm-12">
                            <label for="inputEmail" class="col-form-label">Email</label>
                        
                            <input class="form-control"  type="email" id="inputEmail" name="inputEmail" placeholder="Type to search...">
                        </div>
      
                      </div>
                     
                    <div class="row">
                      <div class="col-xl-6 col-sm-12">
                        <label for="inputAdresse" class="col-form-label">Adresse</label>
                    
                        <input class="form-control"  type="text" id="inputAdresse" name="inputAdresse" placeholder="Type to search...">
                    </div>
    
    
                      <div class="col-xl-6 col-sm-12">
                        <label for="inputtel" class="col-form-label">Telephone</label>
                    
                        <input class="form-control" type="tel" id="inputtel" name="inputtel" placeholder="Type to search...">
                    </div>
      
                  </div>
      
                  <div class="row mt-2 ">
                    <div class="col-xl-6 col-sm-12">
                        <label for="inputVille" class="col-form-label">Ville</label>
                    
                        <input class="form-control"  type="text" id="inputVille" name="inputVille" placeholder="Type to search...">
                    </div>
                    <div class="col-xl-6 col-sm-12">
                      <label for="inputPays" class="col-form-label">Pays</label>
                  
                      <input class="form-control" type="tel" id="inputPays" name="inputPays" placeholder="Type to search...">
                  </div>

                  
      
                </div>
    
                      
                </div>
                </div>
              </div>
              
            </div>
             
              <div >
            
           
            
          
        
      
      </div>
              </div>
            </div>




                <div class="mt-4">
                  <div class="d-flex align-items-center ">
                    <img class="me-2" src="../assets/icon/step2.svg" alt="">
                    <span class="subheadline-form">information sur l'offre de stage</span>
                  </div>
                  <div >
                      <div class="mt-4 p-2 border border-1 rounded-3">
                          <div class="form-check ms-3">
                              <input class="form-check-input" type="radio" name="typeOffre" id="flexRadioDefault3" value="1" checked>
                              <label class="form-check-label" for="flexRadioDefault3">
                                 Offre publique
                              </label>
                          </div>

                          <div class="form-check ms-3">
                              <input class="form-check-input" type="radio" name="typeOffre" id="flexRadioDefault4" value="0" >
                              <label class="form-check-label" for="flexRadioDefault4">
                                  Offre de stage pour un etudiant (stage hors du platform)
                              </label>
                          </div>

                              <div class="col-12" id="div_nouvel_stg" >
                                  <div class="mt-2 p-2 border border-1 rounded-3 " >
                                          <div class="">

                                              <div>
                                                  <div class="row mt-2 ">
                                                      <div class="row d-flex align-items-center justify-content-center" >
                                                          <div align="center" class="subheadline-form"><b> Information Stage</b></div>
                                                          <HR class="ms-3">
                                                      </div>
                                                      <div class="col-xl-6 col-sm-12">
                                                          <label for="inputIntitule" class="col-form-label">Etudiant</label>
                                                          <select class="form-select" id="inputIntitule" title="Etudiant" name="CNE" >
                                                              <?php
                                                              //requette de selection
                                                              $reqet="SELECT distinct etudiant.CNE_ETU FROM etudiant,etudier,niveau where 
                                                                    etudier.CNE_ETU=etudiant.CNE_ETU and etudier.NUM_NIV=niveau.NUM_NIV 
                                                                    and niveau.NUM_FORM='$formation' and etudiant.ACTIVE_ETU='0';";
                                                              $Smtet=$bdd->query($reqet);
                                                              $ets=$Smtet->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC

                                                              echo "<option selected>CNE </option>";
                                                              foreach($ets as $V):
                                                                  echo" <option value=\"".$V['CNE_ETU']."\">".$V['CNE_ETU']."</option>";
                                                              endforeach;
                                                              ?>
                                                          </select>
                                                      </div>
                                                      <div class="col-xl-6 col-sm-12">
                                                          <label for="inputSujet" class="col-form-label">Sujet Stage</label>
                                                          <input class="form-control" type="text" id="inputSujet" name="inputSujet" placeholder="sujet..">
                                                      </div>

                                                  </div>

                                                  <div class="row">
                                                      <div class="col-xl-6 col-sm-12">
                                                          <label for="inputdtDebStg" class="col-form-label">Date debut stage</label>
                                                          <input class="form-control"  type="date" id="inputdtDebStg" name="dtDebStg">

                                                      </div>
                                                      <div class="col-xl-6 col-sm-12">
                                                          <label for="inputdtFinStg" class="col-form-label">Date Fin stage</label>
                                                          <input class="form-control"  type="date" id="inputdtFinStg" name="dtFinStg">
                                                      </div>



                                                  </div>
                                              </div>
                                          </div>


                                  </div>

                              </div>

                  </div>
                    <div class="mt-4 p-2 border border-1 rounded-3">
                      <div class="row">
                          <div class="row d-flex align-items-center justify-content-center" >
                              <div align="center" class="subheadline-form"><b> Information offre</b></div>
                              <HR class="ms-3">
                          </div>
                            <div class="col-xl-4 col-sm-12">
                                <label for="inputpost" class="col-form-label">Intitulé poste</label>
                                <input class="form-control" type="text" id="inputpost" name="inputpost" placeholder="intitulé...">
                            </div>
                          <div class="col-xl-4 col-sm-12">
                              <label for="inputville" class="col-form-label">Ville</label>
                              <input class="form-control" type="text" id="inputvilleoffre" pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"  title="ville ne contient pas des caractères speciaux"
                                     name="inputvilleoffre" placeholder="Ville...">
                          </div>

                          <div class="col-xl-4 col-sm-12">
                              <label for="inputpays" class="col-form-label">Pays</label>
                              <input class="form-control" type="text" id="inputpaysoffre" pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"  title="pays ne contient pas des caractères speciaux" name="inputpaysoffre" placeholder="Maroc...">
                          </div>
                          
                      </div>
                        <div id="stgExtr">
                            <div class="row">
                                <div class="col-xl-4 col-sm-12 ">
                                    <label for="dateDeb " class="col-form-label">Date debut Offre</label>
                                    <input class="form-control dis init1" required type="date" id="dateDeb" name="dateDeb">
                                </div>
                                <div class="col-xl-4 col-sm-12 ">
                                    <label for="delai" class="col-form-label">delai</label>
                                    <input class="form-control dis" required type="number" id="delai" pattern="([0-9]+)?"  title="Delai doit etre un entier" name="delai">
                                </div>
                                <div class="col-xl-4 col-sm-12 ">
                                    <label for="inputeffectif" class="col-form-label" >Effectife demandé</label>
                                    <input class="form-control dis" required type="number" id="inputeffectif" pattern="([0-9]+)?"  title="effectif doit etre un entier" name="inputeffectif">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xl-4 col-sm-12 ">
                                    <label for="dateFin" class="col-form-label">Date fin Offre</label>
                                    <input class="form-control dis init1" required type="date" id="dateFin" name="dateFin">
                                </div>
                                <div class="col-xl-4 col-sm-12 ">
                                    <label for="inputNiveaux" class="col-form-label">Niveaux</label>

                                    <select id="inputNiveaux" class="form-select dis" name="inputNiveaux" required aria-label="Default select example">
                                        <?php
                                        //requette de selection
                                        $req="SELECT NIVEAU.NUM_NIV,NIVEAU.LIBELLE_NIV FROM `Responsable`, `niveau` WHERE Responsable.NUM_FORM=niveau.NUM_FORM and Responsable.USERNAME_RES='$respon_username';";
                                        $Smt=$bdd->query($req);
                                        $rows=$Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC
                                        //afficher le tableau
                                        echo "<option selected>Niveaux </option>";
                                        foreach($rows as $V):

                                            echo" <option value=\"".$V['NUM_NIV']."\">".$V['LIBELLE_NIV']."</option>";

                                        endforeach;

                                        ?>

                                    </select></div>



                            </div>
                        </div>


                  <div class="row mt-3">
                   
                      <div class="col-xl-12 ">
                        <label for="" class="form-label">Description</label>
                        <textarea class="form-control " name="detailoffre" id="detailoffre" rows="7" cols="20"></textarea> 
                      </div>
                         
                    
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-xl-6 mt-4">
                    <button type="submit" id="btnSubmit" class="btn btn-filtre btn-primary w-100 mb-3">    Ajouter <i class="bi bi-plus-circle-fill"></i></button>
                  </div>       
                </div>

          </form>
          </div>
        </div>
      </div>
    
    </div>
  </div>
</div>
    <div id="modal-progress-upload">

    </div>
    <script>


        $(document).ready(function(){


            $('#div_nouvel_entre').hide();//entreprise
            $('#div_nouvel_stg').hide();//stage

            $('#flexRadioDefault3').click(function(){
                $('#div_nouvel_stg').hide(1000);

                $('.dis').prop('disabled', false);
                $('#inputSujet').val('');
                $('#stgExtr').show(1000);

            });
            $('#flexRadioDefault4').click(function(){
                $('#div_nouvel_stg').show(1000);
                $('.dis').prop('disabled', true);
                $('#stgExtr').hide(1000);
            });

            ///////////////
            $('#flexRadioDefault1').click(function(){
                $('#IDdiv_selectionner_entr').show(1000);
                $('#div_nouvel_entre').hide(1000);
                $('#inputIntitule').val('');

            });
            $('#flexRadioDefault2').click(function(){
                $('#IDdiv_selectionner_entr').hide(400);
                $('#div_nouvel_entre').show(1000);


            });
        });

    </script>
    <script src="./../js/script-upload.js"></script>
    <!-- JavaScript Bundle with Popper-->
    <!-- Import jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>


    <!--Import Trumbowyg -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>

    <!-- Init Trumbowyg -->
    <script>
        // Doing this in a loaded JS file is better, I put this here for simplicity
        $('#detailoffre').trumbowyg();
    </script>
  </body>
</html>