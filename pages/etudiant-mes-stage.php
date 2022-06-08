
<?php
require(__DIR__ . './../phpQueries/etudiant/stage.php');

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
        <div class="p-4 col-xl-9 col-sm-12">
            <div class="intro  mt-3">
                <h3> <b>Mon stage</b>  </h3> 
    
            </div>
            <div class="intro ">
               <p>
               Decouvrir mon stage actuelle

            </p> 
            </div>
            <div style=""  class="row  border border-link rounded-3 p-4">
              
                    <div class="col-xl-2 col-sm-12 me-4 " >
                        <img class="mx-auto mb-2" style="max-width: 150px;" src="<?php echo $stage_actulle['IMAGE_ENT'] ?>" alt="">
                    </div>
                    <div class="col-xl-9 col-sm-12 me-4" >
                        <div class="row mt-2">
                            <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                                <div class="col-auto prop-name me-3">Société :</div>
                                <div class="col-auto prop-value"><?php echo $stage_actulle['LIBELLE_ENT'] ?> </div>
                             
                            </div>
                           
                                <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                                    <div class="col-auto prop-name me-3">N° Stage :</div>
                                    <div class="col-auto prop-value"><?php echo $stage_actulle['NUM_STG'] ?></div>
                                 
                               
                            </div>
                            <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                                <div class="col-auto prop-name me-3">Encadrant :</div>
                                <div class="col-auto prop-value">Ahmed Bouzian</div>
                             
                           
                        </div>
                            
                        </div>
                        <div class="row mt-2 ">
                            <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                                <div class="col-auto prop-name me-3">Date debut :</div>
                                <div class="col-auto prop-value"><?php echo $stage_actulle['DATEDEB_STG'] ?></div>
                             
                            </div>
                           
                                <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                                    <div class="col-auto prop-name  me-3">Lieux :</div>
                                    <div class="col-auto prop-value"><?php echo $stage_actulle['LIEUX_OFFR'] ?></div>
                                 
                               
                            </div>
                            
                            
                        </div>
                        <div class="row mt-2 ">
                            <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start ">

                                <div class="col-auto prop-name me-3">Date fin :</div>
                                <div class="col-auto prop-value"><?php echo $stage_actulle['DATEFIN_STG'] ?></div>
                             
                            </div>
                           
                                <div class="col-xl-4 col-sm-12 mt-sm-2 d-flex justify-content-start align-items-center">

                                    <div class="col-auto prop-name me-3">Contrat :</div>
                                    <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" href="">voir plus</a></div>
                                 
                               
                                </div>
                                
                            
                            
                        </div>
                        <div class="row mt-2  ">
                           
                           
                                <div class="col-xl-6 col-sm-12 mt-sm-2 d-flex justify-content-start align-items-center">

                                    <div class="col-auto prop-name  me-3">Rapport :</div>
                                    <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" href="">voir plus </a></div>
                                 
                                    
                               
                                </div>
                            
                            
                        </div>
                        <div class="row mt-2 overflow-auto ">
                           
                           
                          <div class="col-xl-12 col-sm-12 mt-sm-2 d-flex justify-content-start align-items-center">

                              <div class="col-auto prop-name  me-3">Liste Jury :</div>
                              <div class="col-auto prop-value">
                                  <?php
                                  foreach ($stage_jury as $jury)
                                  {
                                      echo '
                                      <span class="me-2"> '. $jury['PRENOM_ENS'].' '. $jury['NOM_ENS'].'</span>
                                      
                                      ';
                                  }
                                  ?>

                              
                         
                          </div>
                      
                      
                  </div>
                    </div>

                
            </div>
            
             <div class="intro  mt-5">
                <h3> <b>Historique stages</b>  </h3> 
                
             </div>
             <div class="intro ">
              <p>
                Decouvrir mes information concernant mes ancien stages  

           </p> 
           </div>
             <div class="mt-4">
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
                        <th scope="col">N° Stage</th>
                        <th scope="col">Entreprise</th>
                        <th scope="col">Date Debut</th>
                        
                        <th scope="col">Date Fin</th>
                        <th scope="col">Note général</th>
                        
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td >1</td>
                        <td>Atos</td>
                        
                        <td>20-06-2022</td>
                        <td>20-06-2023</td>
                        <td>16/20</td>
                        <td>  
                          <a  class="me-3" data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1"><i class=" active  bi bi-info-circle-fill" ></i></a>
                          
                         </td>
                      </tr>
                      <tr>
                        <td colspan="7" class="p-0">
                          <div class="collapse" id="collapseExample1"> 
                            <div class="row mt-2">
                              <div class="col-auto prop-name  me-3">Liste Jury avec note:</div>
                            <div class="col-auto prop-value"><span class="me-2"> ahmed DAMI  6/20</span><span class="me-2"> ahmed DAMI  6/20</span><span class="me-2"> ahmed DAMI  6/20</span></div>
                         
                            </div>
                            <div class="row align-items-center">
                              <div class="col-auto prop-name  me-3">Rapport</div>
                              <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" href="">voir plus</a></div>
                              <div class="col-auto prop-name  me-3">Contrat</div>
                              <div class="col-auto prop-value"><a class="btn" style="color:#7B61FF ;" href="">voir plus</a></div>
                                 

                            </div>
                            
                          </div>
                        </td>
                      </tr>
                      
  
                    </tbody>
                  </table>
                </div>
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
