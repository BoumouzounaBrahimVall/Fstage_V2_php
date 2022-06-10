
<?php
require(  __DIR__.'../../phpQueries/mail.php');
require(  __DIR__.'../../phpQueries/uploads.php');
$cne=$_GET['cne'];

//print_r($_GET);
if(isset($_POST['filesUploaed'])){
    echo 'yes';
    $cne=$_POST['cne'];
    switch ($_POST['filesUploaed']){
        case 'modifyphoto':
            $file = $_FILES['file'];
            echo 'photo';
            uploadImagesOrCVEtudiant($cne, $file, $bdd, 1);
            break;
        case 'modifycv':
            $file = $_FILES['cv'];
            echo 'cv';
            uploadImagesOrCVEtudiant($cne,$file,$bdd,2);
            break;
    }
}

if (empty($cne)) header('location:gererEtudiant.php');
if(isset($_GET['send'])) {
    switch ($_GET['send']) {
        case 'modifydateNiv'://numniv cne datniv
            $numNiv = $_GET['numniv'];
            $dateNew = $_GET['datniv'];
            $req = "UPDATE ETUDIER set DATE_NIV='$dateNew' WHERE NUM_NIV='$numNiv' and CNE_ETU='$cne'";
            break;
        case 'modifyPERSONNE':
            $dataEtu=array(
                    $_GET['nom'],$_GET['prenom'] ,$_GET['email'], $_GET['tel'] ,$_GET['ville'], $_GET['pays'] ,$_GET['datenais']
            );
            $req = "UPDATE ETUDIANT set NOM_ETU='$dataEtu[0]',PRENOM_ETU='$dataEtu[1]',EMAIL_ENS_ETU='$dataEtu[2]',
                    TEL_ETU='$dataEtu[3]',VILLE_ETU='$dataEtu[4]',PAYS_ETU='$dataEtu[5]',DATENAISS_ETU='$dataEtu[6]' WHERE CNE_ETU='$cne'";
            break;
        case 'modifynew':// newniv datnew
            $newNiv=$_GET['newniv'];
            $dateNiv=$_GET['datnew'];
            $req = "insert into ETUDIER values ('$cne','$newNiv','$dateNiv')";
            break;

    }
    $bdd->exec($req);

}

$req1="SELECT * FROM ETUDIANT  where CNE_ETU='$cne';";

$Smt1=$bdd->query($req1);
$detaiEtu=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC
if( empty($detaiEtu['IMG_ETU'])){
    $detaiEtu['IMG_ETU']="../ressources/user.png";
}
$donnee=array(
    $detaiEtu['NOM_ETU'],
    $detaiEtu['PRENOM_ETU'],
    $detaiEtu['EMAIL_ENS_ETU'],
    $detaiEtu['TEL_ETU'],
    $detaiEtu['VILLE_ETU'],
    $detaiEtu['PAYS_ETU'],
    $detaiEtu['DATENAISS_ETU'],
    $detaiEtu['CV_ETU'],
    $detaiEtu['MOTDEPASSE_ETU'],
    $detaiEtu['IMG_ETU']
);
if(isset($_GET['passOublier'])) {

    $pass=generateRandomString();
    passForgotten("$donnee[2]",$pass,$donnee[0],$donnee[1]);
    $pass=password_hash($pass,PASSWORD_DEFAULT);
    $req = "  UPDATE `ETUDIANT` SET `MOTDEPASSE_ETU` = '$pass' WHERE `ETUDIANT`.`CNE_ETU` = '$cne';";
    $bdd->exec($req);
   // header("location:resposable-details-etudiant.php?cne='$cne'");
}

?>


<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />

    <link rel="stylesheet" href="../css/style.css" />

    <title>Infos etudiant</title>
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
              </a>            <a
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
      <div class="row">
      <div class="col-xl-3   col-sm-12">
                        <div class="sidebar  ps-2 pe-2 pt-2 pb-2  mt-4">
                            <ul type="none">
                            <li > <a href="gererEtudiant.php" ><i class=" active  bi bi-person-fill"></i>Gérer Etudiants</a></li>  
                            </ul>
                        </div>
                    </div>
        <div class="p-4 col-xl-9 col-sm-12">
            <div class="intro  mt-3">
                <h3> <b>Détails étudiant</b>  </h3> 
    
            </div>
            <div class="intro ">
               <p>
                Consulter l'ensemble des information sur l'etudiant
            </p> 
            </div>



            <div class="row  border border-link rounded-3 p-2">

                <div class="col-xl-2 col-sm-12 me-4 " >
                    <img style="width: 96px;height: 96px;" class="mx-auto mb-2 ms-4 rounded-circle" src="<?php echo $donnee[9];?>" alt="">
                    <div class="row border rounded-3 py-2">
                        <form   action="" class="m-0 pe-0" method="POST" enctype="multipart/form-data">
                            <input type="text" class="d-none "  value="<?php echo $cne;?>" name="cne" >
                            <label for="imgEtu" class="p-1 btn-import-img" ><i class="bi bi-image-fill"></i> import</label>
                            <input type="file" disabled class="d-none inputImg" name="file" id="imgEtu">
                            <button type="submit" name="filesUploaed" class="btn d-none"  id="subbtnimg" >
                                <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                            <a onclick="modifySubmitdate('inputImg','modifyphoto','subbtnimg')" id="modifyphoto" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>

                        </form>
                    </div>
                    <div class="row  mt-2 p-0 ">
                        <form   action="" method="get">
                            <input type="text" class="d-none "  value="<?php echo $cne;?>" name="cne" >
                            <button type="submit" name="passOublier" class="btn btn-filtre m-0"  id="subbtn" ><small>Reinisialiser Mot de passe</small></button>
                        </form>
                    </div>
                </div>
                <div class="col-xl-9 col-sm-12 " >
                    <div class="row ">
                        <div class="col mt-2">
                            <div class="row border rounded-3 mb-2 p-1 pb-2">
                                <form   action="" method="get" >
                                    <input type="text" class="d-none "  value="<?php echo $cne;?>" name="cne" >
                                    <div class="row">
                                        <div class="col">

                                            <label for="inputNOM" >Nom </label>
                                            <input id="inputNOM" type="text"  class="form-control  inputPERSONE" disabled value="<?php echo $donnee[0];?>" name="nom" >

                                        </div>
                                        <div class="col">

                                            <label for="inputPRENOM" >Prenom </label>
                                            <input id="inputPRENOMN" type="text"  class="form-control  inputPERSONE" disabled value="<?php echo $donnee[1];?>" name="prenom" >

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">

                                            <label for="inputEMAIL" >E-mail </label>
                                            <input id="inputEMAIL" type="email"  class="form-control  inputPERSONE" disabled value="<?php echo $donnee[2];?>" name="email" >

                                        </div>
                                        <div class="col">

                                            <label for="inputTEL" >TEL </label>
                                            <input id="inputTEL" type="text"  class="form-control  inputPERSONE" disabled value="<?php echo $donnee[3];?>" name="tel" >

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">

                                            <label  >Ville </label>
                                            <input type="text" class="form-control inputPERSONE" disabled value="<?php echo $donnee[4];?>" name="ville" >

                                        </div>
                                        <div class="col">

                                            <label >Pays </label>
                                            <input type="text" class="form-control inputPERSONE" disabled  value="<?php echo $donnee[5];?>" name="pays" >

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputDatnais">Date Naissance</label>
                                            <input id="inputDatnais" type="date" class="form-control inputPERSONE" disabled value="<?php echo $donnee[6];?>" name="datenais" >
                                        </div>
                                        <div class="col ">
                                            <label class="mt-4 ms-5 ps-5">Modifier</label>
                                            <button type="submit" name="send" class="btn d-none"  id="subbtnPERSONNE" >
                                                <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                            <a onclick="modifySubmitdate('inputPERSONE','modifyPERSONNE','subbtnPERSONNE')" id="modifyPERSONNE" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </div>


                                <div class="row  border rounded-3">
                                    <div class="col d-flex align-items-center justify-content-center">
                                        <a href="<?php echo $donnee[7];?>" target="_blank">visualiser CV?</a>
                                    </div>
                                    <div class="col d-flex align-items-center justify-content-center">
                                        <form   action="" class="m-0 pe-0" method="POST" enctype="multipart/form-data">
                                            <input type="text" class="d-none "  value="<?php echo $cne;?>" name="cne" >
                                            <label for="cvEtu" style="color: #7B61FF;" class="p-1" ><i class="bi bi-file-earmark-person"></i>changer CV ?</label>
                                            <input type="file" disabled class="d-none inputCV" name="cv" id="cvEtu">
                                            <button type="submit" name="filesUploaed" class="btn d-none"  id="subbtncv" >
                                                <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                            <a onclick="modifySubmitdate('inputCV','modifycv','subbtncv')" id="modifycv" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>

                                        </form>
                                    </div>
                                </div>


                        </div>

                    </div>

                    <div class="row border rounded-3 mt-2 p-1 pb-2 ">
                       <?php

                       $req1="SELECT etud.DATE_NIV,niv.LIBELLE_NIV,etud.NUM_NIV FROM ETUDIER etud,NIVEAU niv
                                     where etud.NUM_NIV=niv.NUM_NIV and etud.CNE_ETU='$cne' and niv.NUM_FORM='$formation'  ORDER by etud.DATE_NIV DESC;";

                       $Smt1=$bdd->query($req1);
                       $niveauEtu=$Smt1->fetchAll(2);//
                       foreach ($niveauEtu as $nv):
                           $lb=$nv['LIBELLE_NIV'];
                            $dt=$nv['DATE_NIV'];
                           echo "<div class='col mt-2'>
                                    <form   action='' method='get' >
                                        <input type='text' class='d-none'  value='". $cne."' name='cne' >
                                        <input type='text' class='d-none'  value='". $nv['NUM_NIV']."' name='numniv' >
                                         Niveau:<strong>  ".$lb."</strong>
                                     
                                        <div class='col'>
                                            <label>Dans la date</label>
                                            <input id='".$lb."' type='date' class='form-control input".$lb."' disabled value='".$dt."' name='datniv' >
                                            <button type='submit' name='send' class='btn d-none'  id='subbtn".$lb."' >
                                                <i  style='font-size: 20px;color: #7B61FF;cursor: pointer;' class='m-0 p-0 bi bi-check-square'></i></button>
                                            <a onclick=\"modifySubmitdate('input".$lb."','modifydateNiv','subbtn".$lb."')\" id='modifydateNiv' type='btn'><i id='modifier' style='font-size: 20px;color: #7B61FF;cursor: pointer;' class='bi bi-pencil-square'></i></a>
                                        </div>
                                    </form>
                                </div>";
                       endforeach;
                        ?>
                    </div>

                </div>


            </div>


    <?php


    $req3="SELECT niv.LIBELLE_NIV,niv.NUM_NIV FROM NIVEAU niv where niv.NUM_NIV not in (
                                           select etu.NUM_NIV from ETUDIER etu where etu.CNE_ETU='$cne');";
    $Smt3=$bdd->query($req3);
    $nivs=$Smt3->fetchAll(2);
    if(!empty($nivs)){
        echo "<div class='row  border border-link rounded-3 p-2 mt-2'>
                                    <form   action='' method='get' >
                                        <input type='text' class='d-none'  value='". $cne."' name='cne' >
                                      
                                       <div class='intro  mt-5'> <h3> <b> Ajouter un nouveau Niveau</b></h3></div>
                                      ";
        echo " <select id='inputSociete' class='form-select inputnew' disabled name='newniv' aria-label='Default select example'>";
        foreach($nivs as $V):
            echo" <option  value=\"".$V['NUM_NIV']."\">".$V['LIBELLE_NIV']."</option>";
        endforeach;
        echo "  </select> <div class='col'>
                                            <label>Date</label>
                                            <input id='inputdtnew' required type='date' class='form-control inputnew' disabled  name='datnew' >
                                            <button type='submit' name='send' class='btn d-none'  id='subbtnajouter' >
                                                <i  style='font-size: 20px;color: #7B61FF;cursor: pointer;' class='m-0 p-0 bi bi-check-square'></i></button>
                                            <a onclick=\"modifySubmitdate('inputnew','modifynew','subbtnajouter')\" id='modifynew' type='btn'><i id='modifier' style='font-size: 20px;color: #7B61FF;cursor: pointer;' class='bi bi-pencil-square'></i></a>
                                        </div>
                                    </form>
                                </div>";
    }


    ?>








            <div class="intro  mt-5">
                <h3> <b>Détails offres postulé</b>  </h3> 
                
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
                          <th scope="col">#</th>
                          <th scope="col">Entreprise</th>
                          <th scope="col">Poste</th>
                          
                          <th scope="col">Date Postuler</th>
                          <th scope="col">Retenu</th>
                          <th scope="col">Accepter</th>
                          <th scope="col">Annuler</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $reqoffr=" SELECT pst.*,ent.LIBELLE_ENT,offr.POSTE_OFFR ,offr.NUM_OFFR
                                FROM `postuler` pst ,offredestage offr,entreprise ent 
                                WHERE pst.NUM_OFFR=offr.NUM_OFFR and offr.NUM_ENT=ent.NUM_ENT and pst.CNE_ETU='$cne'";
                      $Smt_offr=$bdd->query($reqoffr);
                      $offres=$Smt_offr->fetchAll(PDO::FETCH_ASSOC);
                      //afficher le tableau
                      if(!empty($offres))
                      {
                          foreach($offres as $V):

                              if( strcmp($V['ETATS_POST'],'RETENU')==0)  $retenu=$V['date_reponse'];
                              else if(strcmp($V['ETATS_POST'],'REFUSER')==0) $retenu='Non';
                              else $retenu='--';

                              if(strcmp($V['ETATS_POST'],'ACCEPTER')==0){
                                  $retenu=$V['date_reponse'];
                                  $accpt='Oui';
                              }
                              else if(strcmp($V['ETATS_POST'],'No accepte')==0){
                                  $accpt="Non";
                                  $retenu=$V['date_reponse'];
                              }
                              else $accpt='--';
                              if(strcmp($V['ETATS_POST'],'ANNULER')==0) $anul='Oui';
                              else $anul='--';
                              echo' <tr>
                              <th scope="row"><a href="../pages/resposable-details-offre.php?numOffre='.$V['NUM_OFFR'].'">'.$V['NUM_OFFR'].'</a></th>
                              <td>'.$V['LIBELLE_ENT'].'</td>
                              <td>'.$V['POSTE_OFFR'].'</td>
                              <td>'.$V['DATE_POST'].'</td>
                                <td>'.$retenu.'</td>
                                <td>'.$accpt.'</td>
                                 <td>'.$anul.'</td>
                              <td>  
                                <a href="#" class="me-3"><i class=" active  bi bi-info-circle-fill"></i></a>
                                <a href="#"><i class=" active  bi bi-pencil-fill"></i></a>
                               </td>
                        </tr>';
                          endforeach;
                      }
                      ?>
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
     <script>
         const modifySubmitdate = (inputId, btnId,subbtn) => {
             console.log('pass');
             let subBtn=document.getElementById(subbtn);
             let input = document.getElementsByClassName(inputId);
             let i;
             let btn = document.getElementById(btnId);
             subBtn.setAttribute("class","btn bt");
             btn.setAttribute("class","d-none");
             for(i = 0; i < input.length; i++)
             {
                 input[i].disabled = false;
             }
             subBtn.setAttribute('value',btnId);
             subBtn.setAttribute('type','submit');
         }
     </script>
  </body>
</html>
