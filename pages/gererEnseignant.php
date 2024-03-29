<?php
    require( __DIR__.'/../phpQueries/respoRequiries.php');
    //modification

if(isset($_GET['modif'])){
    $donnee=array(
        $_GET['numens'],
        $_GET['prenom'],
        $_GET['nom'],
        $_GET['datnes'],
        $_GET['email'],
        $_GET['tel']
    );

    $req="update  ENSEIGNANT set PRENOM_ENS='$donnee[1]',NOM_ENS='$donnee[2]',
                       DATEDENAISSANCE_ENS='$donnee[3]',EMAIL_ENS_ETU='$donnee[4]',
                       TEL_ENS='$donnee[5]' where NUM_ENS='$donnee[0]';";
    //execution de la requette
    $bdd->exec($req);
    header('location:../pages/gererEnseignant.php');

}
           if($_SERVER['REQUEST_METHOD']=='POST'){
             $donnee=array(
              $_POST['numens'],
              $_POST['prenom'],
              $_POST['nom'],
              $_POST['datnes'],
              $_POST['email'],
              $_POST['tel']
             );
             $verif=0;
             //enseignat existe dans la table enseignant
             $req_test="SELECT ENSEIGNANT.NUM_ENS FROM `ENSEIGNANT`;";

               if (!empty($bdd)) {
                   $Smt_test=$bdd->query($req_test);
                   $ens=$Smt_test->fetchAll(2);
               }

             foreach($ens as $en){
               if($en['NUM_ENS']==$donnee[0]) 
               {
                 $verif=1; break;
               }
             }
             if($verif==0){
                  //la requette d'insertion
              $req="INSERT INTO ENSEIGNANT (NUM_ENS,PRENOM_ENS,NOM_ENS,DATEDENAISSANCE_ENS,EMAIL_ENS_ETU,TEL_ENS)
              VALUES ('$donnee[0]','$donnee[1]','$donnee[2]','$donnee[3]','$donnee[4]','$donnee[5]');";
             //execution de la requette
             $bdd->exec($req);
             }


           $req_test2="SELECT ENSEIGNER.NUM_ENS num from ENSEIGNER where ENSEIGNER.NUM_FORM='$formation';";

            $Smt_test2=$bdd->query($req_test2); 
            $ensenies=$Smt_test2->fetchAll(2);
            foreach($ensenies as $ensenie){
              if($ensenie['num']==$donnee[0]) 
              {
                  $verif=2; break;
              }
            }

            if($verif!=2){
              $req="INSERT INTO ENSEIGNER (NUM_ENS,NUM_FORM)
              VALUES ('$donnee[0]','$formation')";
             //execution de la requette
             $bdd->exec($req); 
            }
            
             header('location:../pages/gererEnseignant.php');
   
           }
          ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
      <?php
      require_once "./meta-tag.php"
      ?>
     
    <title>Gerer Enseignants</title>
  </head>
<body>
  
    <!-- Navbar  -->
    <?php
    require_once "./nav-ens.php"
    ?>
    <div class="container ">
        <div class="row pt-0">
            <div class="container ">
                <div class="row">
                    <div class="col-xl-3   col-sm-12">
                        <div class="sidebar  ps-2 pe-2 pt-2 pb-2  mt-4">
                            <ul type="none">
                            <li > <a href="gererEtudiant.php" ><i class=" active  bi bi-person-fill"></i>Gérer Etudiants</a></li>  
                            <li > <a href="#" class="actuel-page" ><i class=" active  bi bi-person-fill"></i>Gérer Enseignant</a></li>  
                            </ul>
                        </div>
                    </div>
                    <div class=" col p-4  mt-0">
                        <div class="row  px-4 py-0">
                            <h4>Gerer les comptes des Enseignants</h4>
                        </div>
                        <div class="row  p-0 mt-0 mb-5">
                            <div class="col  p-4 mr-2 ">
                            
                            <div class="row  p-4 statis-div-2">
                                    <div class="col-3 col-sm-5  p-4">
                                        <img  src="../assets/icon/bag_green.png" alt="offres">
                                    </div>
                                    <div class="col p-4">
                                        <h1 class=" text-center">
                                        <?php
                                     $req1="SELECT COUNT(DISTINCT(NUM_ENS)) nbr_ens FROM `ENSEIGNER` WHERE NUM_FORM='$formation';";
                                     $Smt1=$bdd->query($req1); 
                                     $nbr=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC 
                                     
                                     echo '<h1 class=" text-center">'.$nbr['nbr_ens'].'</h1>';//<h1 class=" text-center">250</h1>
                                     ?>
                                        </h1>
                                        <p class=" text-center">Nombre des Enseignants</p>
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
                                        <button class="btn btn-seconnecter" data-bs-toggle="modal" data-bs-target="#exampleModal">Ajouter Enseignant</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 border p-3 rounded-5 rounded border-1 ">
                                <table id="table_id4"  style="width:100%" class=" nowrap display">
                                <thead>
                                    <tr>
                                    <th scope="col">CIN</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Date nais</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Nº tel</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                     $req="SELECT ens.*
                                     FROM `ENSEIGNANT` ens,`ENSEIGNER` ensg WHERE ensg.NUM_ENS=ens.NUM_ENS and ensg.NUM_FORM='$formation';";
                                     $Smt=$bdd->query($req); 
                                     $rows=$Smt->fetchAll(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC 
                                     //afficher le tableau
                                     foreach($rows as $V): 
                                    
                                      
                                      echo' <tr id="'.$V['NUM_ENS'].'">
                                      <td>'.$V['NUM_ENS'].'</td>
                                            <td>'.$V['NOM_ENS'].'</td>
                                            <td>'.$V['PRENOM_ENS'].'</td> 
                                            <td>'.$V['DATEDENAISSANCE_ENS'].'</td> 
                                            <td>'.$V['EMAIL_ENS_ETU'].'</td>
                                            <td>'.$V['TEL_ENS'].'</td>
                                            <td>  
                                         <button  class="ms-3 btn" onclick="recupEnsData(\''.$V['NUM_ENS'].'\')" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i style="color: #7b61ff" class=" active  bi bi-pencil-fill"></i></button>
                                        </td></tr>
                                        
                                    ';
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

  <!-- Ajouter enseignant-->
  <div  class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 370px;max-width: 800px">
      <div class="modal-content d-flex justify-content-center "style="min-width: 370px;max-width: 800px;margin:auto;">
        <div class="modal-header border-0">
        
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <span class="headline-form"> Ajouter un Enseignant </span>
  
            </div>
            <div class="row">
              <form class=" g-3 mt-2" method="post">
              <div class="d-flex align-items-center ">
                <img class="me-2" src="../assets/icon/step1.svg" alt="">
                <span class="subheadline-form" >information sur l'enseignant</span>
              </div>
              
            <div >
                <div class="mt-4 p-2 border border-1 rounded-3">
  
              <div>
                    <div class="row">
                    <div class="col-xl-6 col-sm-6">
                        <label for="inputNom2" class="col-form-label" >Nom</label>
                    
                        <input class="form-control" type="text" id="inputNom2" name="nom" placeholder="Type to search...">
                    </div>
                    <div class="col-xl-6 col-sm-6">
                      <label for="inputPrenom2" class="col-form-label">Prenom</label>
                  
                      <input class="form-control" type="text" id="inputPrenom2" name="prenom" placeholder="Type to search...">
                  </div>
  
                </div>
              
              <div class="row mt-2">
                <div class=" col-xl-6 col-sm-6">
                    <label for="inputEmail" class="col-form-label">Email</label>
                
                    <input class="form-control" type="email" name="email" id="inputEmail" placeholder="Type to search...">
                </div>
                <div class="col-xl-6 col-sm-6">
                  <label for="inputtel" class="col-form-label">Telephone</label>
              
                  <input class="form-control" type="tel" id="inputtel" name="tel" placeholder="Type to search...">
              </div>
  
            </div>
  
            <div class="row mt-2 ">
              <div class="col-xl-6 col-sm-6">
                <label for="numEnt" class="col-form-label">Nº enseignant</label>
            
                <input class="form-control" type="number" id="numEnt" name="numens" placeholder="Type to search...">
            </div>
            <div class="col-xl-6 col-sm-6">
              <label for="dateNaiss" class="col-form-label" >Date Naissance</label>
          
              <input class="form-control" type="date" id="dateNaiss" name="datnes" placeholder="Type to search...">
          </div>
  
          </div>
         
          </div>
        </div>
    </div>
                  <div class="mt-4">
                    
                  <div class="row">
                    <div class="col-xl-6 mt-4">
                      <button type="submit" class="btn btn-filtre btn-primary w-100 mb-3">    Ajouter <i class="bi bi-plus-circle-fill"></i></button>
                    </div>
                  </div>
                  </div>
                
              
            </form>
            </div>
          </div>
        </div>
      
      </div>
    </div>
  </div>

    <script>
        const recupEnsData=(idbtn)=>{
            if(idbtn){
                let children=document.getElementById(idbtn).children;
                let inptids=['numEntmodif','Nommodif','Prenommodif','dateNaissmodif','Emailmodif','telmodif'];
                console.log(children[0].textContent);
                for(let i=0;i<inptids.length;i++)
                    document.getElementById(inptids[i]).value=children[i].textContent;
        }}
    </script>



    <!-- Modifier enseignant-->
    <div  class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-width: 370px;max-width: 800px">
            <div class="modal-content d-flex justify-content-center "style="min-width: 370px;max-width: 800px;margin:auto;">
                <div class="modal-header border-0">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <span class="headline-form"> Modifier un Enseignant </span>

                        </div>
                        <div class="row">
                            <form class=" g-3 mt-2" method="get">
                                <div class="d-flex align-items-center ">
                                    <img class="me-2" src="../assets/icon/step1.svg" alt="">
                                    <span class="subheadline-form" >information sur l'enseignant</span>
                                </div>

                                <div >
                                    <div class="mt-4 p-2 border border-1 rounded-3">

                                        <div>
                                            <div class="row">
                                                <div class="col-xl-6 col-sm-6">
                                                    <label for="inputNom2" class="col-form-label" >Nom</label>

                                                    <input class="form-control" type="text" id="Nommodif" name="nom">
                                                </div>
                                                <div class="col-xl-6 col-sm-6">
                                                    <label for="inputPrenom2" class="col-form-label">Prenom</label>

                                                    <input class="form-control" type="text" id="Prenommodif" name="prenom">
                                                </div>

                                            </div>

                                            <div class="row mt-2">
                                                <div class=" col-xl-6 col-sm-6">
                                                    <label for="inputEmail" class="col-form-label">Email</label>

                                                    <input class="form-control" type="email" name="email" id="Emailmodif">
                                                </div>
                                                <div class="col-xl-6 col-sm-6">
                                                    <label for="inputtel" class="col-form-label">Telephone</label>

                                                    <input class="form-control" type="tel" id="telmodif" name="tel">
                                                </div>

                                            </div>

                                            <div class="row mt-2 ">
                                                <div class="col-xl-6 col-sm-6">
                                                    <label for="numEnt" class="col-form-label">Nº enseignant</label>

                                                    <input class="form-control" type="number" disabled id="numEntmodif" name="numens">
                                                </div>
                                                <div class="col-xl-6 col-sm-6">
                                                    <label for="dateNaiss" class="col-form-label" >Date Naissance</label>

                                                    <input class="form-control" type="date" id="dateNaissmodif" name="datnes" >
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">

                                    <div class="row">
                                        <div class="col-xl-6 mt-4">
                                            <button onclick="document.getElementById('numEntmodif').disabled=false;" type="submit" name="modif" class="btn btn-filtre btn-primary w-100 mb-3">    Modifier <i class="bi bi-pencil-fill"></i></button>
                                        </div>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('#table_id4').DataTable(
                {language: {
                    url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json'
                },
                scrollY: 200,
                scrollX: true,
            });
        } );
    </script>
<script type="text/javascript" src="/js/script.js"></script>
  </body>
</html>