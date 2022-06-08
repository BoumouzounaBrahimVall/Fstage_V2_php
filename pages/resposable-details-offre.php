<?php
require(  __DIR__.'../../phpQueries/uploads.php');
$offre_num=$_GET['numOffre'];


if(isset($_POST['filesUpload'])) {
    echo 'yes';
    $ent = $_POST['numEnt'];
    $offre_num = $_POST['numOffre'];
    $file = $_FILES['file'];
    echo 'logo';
    uploadImagesOrCVEtudiant($ent, $file, $bdd, 3);
}

if (empty($offre_num)) header('location:gererOffre.php');
//print_r($_GET);
if(isset($_GET['send'])) {
    switch ($_GET['send']) {
        case 'modifySociete':
            $idEnt = $_GET['inputSociete'];
            $req = "UPDATE OFFREDESTAGE set NUM_ENT='$idEnt' WHERE NUM_OFFR='$offre_num'";
            break;
        case 'modifyEtat':
            $etat = $_GET['inputEtat'];
            $req = "UPDATE OFFREDESTAGE set ETATPUB_OFFR='$etat' WHERE NUM_OFFR='$offre_num'";
            break;
        case 'modifyDate':
            $datDeb=$_GET['datedebut'];
            $dateFin=$_GET['datefin'];
            $req = "UPDATE OFFREDESTAGE set DATEDEB_OFFR='$datDeb',DATEFIN_OFFR='$dateFin' WHERE NUM_OFFR='$offre_num'";
            break;
        case 'modifyEffDl':
            $Effectif=$_GET['Effectif'];
            $delai=$_GET['delai'];
            $req = "UPDATE OFFREDESTAGE set EFFECTIF_OFFRE='$Effectif',DELAI_JOFFR='$delai' WHERE NUM_OFFR='$offre_num'";
            break;
        case 'modifyAdr':// villeOffre paysOffre lieuOffre
            $ville=$_GET['villeOffre'];
            $pays=$_GET['paysOffre'];
            $lieu=$_GET['lieuOffre'];
            $req = "UPDATE OFFREDESTAGE set VILLE_OFFR='$ville',LIEUX_OFFR='$lieu',PAYS_OFFR='$pays' WHERE NUM_OFFR='$offre_num'";
            break;
        case 'modifyDetail':// Poste sujet detail
            $poste=$_GET['Poste'];
            $sujet=$_GET['sujet'];
            $detail=$_GET['detail'];
            $req = "UPDATE OFFREDESTAGE set POSTE_OFFR='$poste',SUJET_OFFR='$sujet',DETAILS_OFFR='$detail' WHERE NUM_OFFR='$offre_num'";
            break;
    }
    $bdd->exec($req);
}

$req1="SELECT offr.*,ent.IMAGE_ENT,ent.NUM_ENT FROM OFFREDESTAGE offr,ENTREPRISE ent,NIVEAU niv 
                                               WHERE offr.NUM_ENT=ent.NUM_ENT and offr.NUM_OFFR='$offre_num';";
$Smt1=$bdd->query($req1);
$detaiOff=$Smt1->fetch(2); // arg: PDO::FETCH_ASSOC
$donnee=array(
    $detaiOff['NUM_ENT'],
    $detaiOff['ETATPUB_OFFR'],
    $detaiOff['DATEDEB_OFFR'],
    $detaiOff['DATEFIN_OFFR'],
    $detaiOff['EFFECTIF_OFFRE'],
    $detaiOff['DELAI_JOFFR'],
    $detaiOff['VILLE_OFFR'],
    $detaiOff['PAYS_OFFR'],
    $detaiOff['LIEUX_OFFR'],
    $detaiOff['POSTE_OFFR'],
    $detaiOff['SUJET_OFFR'],
    $detaiOff['DETAILS_OFFR'],
    $detaiOff['IMAGE_ENT'],
    $detaiOff['NUM_ENT'],
);

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
    <title>Details offre </title>
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
                  <li > <a href="gererOffre.php" class="actuel-page"><i class=" active  bi bi-briefcase-fill "></i>Gerer Offres</a></li>                    
                </ul>
              </div>
            </div>
        <div class="p-4 col-xl-9 col-sm-12">
            <div class="intro  mt-3">
                <h3> <b>Détails offre</b>  </h3> 
    
            </div>
            <div class="intro ">
               <p>
                Consulter l'ensemble des information sur l'offre

            </p> 
            </div>
            <div class="row  border border-link rounded-3 p-4">

                <div class="col-xl-2 col-sm-12 me-4 " >
                    <img style="width: 96px;height: 96px;" class="mx-auto mb-2 ms-4 " src="<?php echo $donnee[12];?>" alt="">
                    <div class="row border rounded-3 py-2">
                        <form   action="" class="m-0 pe-0" method="POST" enctype="multipart/form-data">
                            <input type="text" class="d-none "  value="<?php echo $offre_num;?>" name="numOffre" >
                            <input type="text" class="d-none "  value="<?php echo $donnee[13];?>" name="numEnt" >
                            <label for="imgEnt" class="p-1 btn-import-img" ><i class="bi bi-image-fill"></i> import</label>
                            <input type="file" disabled class="d-none inputEnt" name="file" id="imgEnt">
                            <button type="submit" name="filesUpload" class="btn d-none"  id="subbtnEnt" >
                                <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                            <a onclick="modifySubmitdate('inputEnt','modifyEnt','subbtnEnt')" id="modifyEnt" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>

                        </form>
                    </div>
                </div>
                    <div class="col-xl-9 col-sm-12 me-4" >
                        <div class="row mt-2">
                            <div class="col-6">
                                <form  action="" method="get" class="col border rounded p-1">
                                    <input type="text" class="d-none "  value="<?php echo $offre_num;?>" name="numOffre" >
                                    <label for="inputSociete" >Société </label>
                                    <select id="inputSociete" class="form-select inputSociete" disabled name="inputSociete" aria-label="Default select example">
                                    <?php
                                    $req2="SELECT NUM_ENT,LIBELLE_ENT FROM ENTREPRISE ;";
                                    $Smt2=$bdd->query($req2);
                                    $ent=$Smt2->fetchAll(2);

                                    foreach($ent as $V):

                                        if($V['NUM_ENT']==$donnee[0])
                                            echo" <option selected value=\"".$V['NUM_ENT']."\">".$V['LIBELLE_ENT']."</option>";
                                        else
                                            echo" <option  value=\"".$V['NUM_ENT']."\">".$V['LIBELLE_ENT']."</option>";
                                    endforeach;
                                    ?>

                                    </select>

                                    <button type="submit" name="send" class=" d-none"  id="subbtnSociete" >
                                        <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bt bi bi-check-square"></i></button>
                                        <a onclick="modifySubmitdate('inputSociete','modifySociete','subbtnSociete')" id="modifySociete" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class=" bi bi-pencil-square"></i></a>
                                </form>
                            </div>
                            <div class="col-6">

                                <form   action="" method="get" class="col border rounded p-1">
                                    <label for="inputEtat">Etat</label>
                                    <input id="inputEtat" type="text" class="form-control inputEtat" disabled value="<?php echo $donnee[1];?>" name="inputEtat">
                                    <input type="text" class="d-none"  value="<?php echo $offre_num;?>" name="numOffre" >
                                    <button type="submit" name="send" class="btn d-none"  id="subbtnEtat" >
                                        <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                    <a onclick="modifySubmitdate('inputEtat','modifyEtat','subbtnEtat')"  id="modifyEtat" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>

                                </form>
                            </div>
                           </div>


                        <div class="row">
                            <div class="col mt-2">
                                <form   action="" method="get" class="border rounded p-1">
                                    <input type="text" class="d-none "  value="<?php echo $offre_num;?>" name="numOffre" >
                                    <div class="col">

                                        <label for="inputDatdeb" >Date debut </label>
                                        <input id="inputDatdeb" type="date"  class="form-control  inputDate" disabled value="<?php echo $donnee[2];?>" name="datedebut" >

                                    </div>
                                    <div class="col">
                                        <label for="inputDatfin">Date Fin</label>
                                        <input id="inputDatfin" type="date" class="form-control inputDate" disabled value="<?php echo $donnee[3];?>" name="datefin" >
                                        <button type="submit" name="send" class="btn d-none"  id="subbtnDate" >
                                            <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                        <a onclick="modifySubmitdate('inputDate','modifyDate','subbtnDate')" id="modifyDate" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                    </div>
                                </form>

                            </div>
                            <div class="col mt-2">
                                <form  action="" method="get" class="border rounded p-1" >
                                    <input type="text" class="d-none "  value="<?php echo $offre_num;?>" name="numOffre" >
                                    <div class="col">

                                            <label for="inputEff" >Effectif </label>
                                            <input id="inputEff" type="number" class="form-control  inputEffDl" disabled value="<?php echo $donnee[4];?>" name="Effectif" >

                                    </div>
                                    <div class="col">
                                            <label for="inputEtat">Delai (jours)</label>
                                            <input id="inputEtat" type="number" class="form-control inputEffDl" disabled value="<?php echo $donnee[5];?>" name="delai">
                                        <button type="submit" name="send" class="btn d-none"  id="subbtnEffDl" >
                                            <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                        <a onclick="modifySubmitdate('inputEffDl','modifyEffDl','subbtnEffDl')" id="modifyEffDl" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>

                                    </div>
                                </form>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col mt-2">
                                <form   action="" method="get" class="border rounded p-1">
                                    <input type="text" class="d-none "  value="<?php echo $offre_num;?>" name="numOffre" >
                                    <div class="col">

                                        <label  >Ville </label>
                                        <input type="text" class="form-control inputAdr" disabled value="<?php echo $donnee[6];?>" name="villeOffre" >

                                    </div>
                                    <div class="col">

                                        <label >Pays </label>
                                        <input type="text" class="form-control inputAdr" disabled value="<?php echo $donnee[7];?>" name="paysOffre" >

                                    </div>
                                    <div class="col">
                                        <label >Rue</label>
                                        <input type="text" class="form-control inputAdr" disabled value="<?php echo $donnee[8];?>" name="lieuOffre" >
                                        <button type="submit" name="send" class="btn d-none"  id="subbtnAdr" >
                                            <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                        <a onclick="modifySubmitdate('inputAdr','modifyAdr','subbtnAdr')" id="modifyAdr" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                    </div>
                                </form>

                            </div>
                            <div class="col mt-2">
                                <form  action="resposable-details-offre.php" method="get" class="border rounded p-1" >
                                    <input type="text" class="d-none "  value="<?php echo $offre_num;?>" name="numOffre" >
                                    <div class="col">

                                        <label  >Poste </label>
                                        <input type="text" class="form-control inputDetail" disabled value="<?php echo $donnee[9];?>" name="Poste" >
                                    </div>
                                    <div class="col">
                                        <label  >Sujet </label>
                                        <input type="text" class="form-control inputDetail" disabled value="<?php echo $donnee[10];?>" name="sujet" >
                                    </div>
                                    <div class="col">
                                        <label >Detail</label>
                                        <textarea   class="form-control inputDetail " disabled name="detail" rows="3" cols="21"><?php echo $donnee[11];?></textarea>
                                        <button type="submit" name="send" class="btn d-none"  id="subbtnDetail" >
                                            <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                        <a onclick="modifySubmitdate('inputDetail','modifyDetail','subbtnDetail')" id="modifyDetail" type="submit"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                    </div>
                                </form>

                            </div>

                        </div>


                    </div>
                            
                            
                        </div>
                        
                       

            
            
             <div class="intro  mt-5">
                <h3> <b>Etudiants postulés</b>  </h3> 
                
             </div>
             <div class="mt-4">
                <button class="btn btn-filtre" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    filtrer les données
                </button>
               
                <div class="collapse " id="collapseExample">
                    <div class="row">
                        <div class="filtre-bar ps-4  mt-5" >
                            <form class="row g-3">
                                <div class="col-xl-2 col-sm-6 ">
                                    <label for="inputIntitule2" class="col-form-label ">CNE</label>
                                </div>
                                <div class="col-xl-4 col-sm-6 ">
                                    <input class="form-control " type="text" id="inputIntitule2" placeholder="CNE...">
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
                          
                          <th scope="col">Date Postuler</th>
                          <th scope="col">Retenu</th>
                          <th scope="col">Accepter</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          
                          <td>Atos</td>
                          <td>Developpeur back-end</td>
                          <td>20-06-2022</td>
                          <td>Oui</td>
                          <td>Non</td>
                          <td>  
                            <a href="#" class="me-3"><i class=" active  bi bi-info-circle-fill"></i></a>
                            <a href="#"><i class=" active  bi bi-pencil-fill"></i></a>
                           </td>
                        </tr>
                        <th scope="row">1</th>
                          
                          <td>Atos</td>
                          <td>Developpeur back-end</td>
                          <td>20-06-2022</td>
                          <td>Oui</td>
                          <td>Non</td>
                          <td>  
                            <a href="#" class="me-3"><i class=" active  bi bi-info-circle-fill"></i></a>
                            <a href="#"><i class=" active  bi bi-pencil-fill"></i></a>
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
    <script>
      const modifySubmitdate = (inputId, btnId,subbtn) => {
        console.log('pass');
          let subBtn=document.getElementById(subbtn);
        let input = document.getElementsByClassName(inputId);
        let i;
        let btn = document.getElementById(btnId);
        let icon = btn.firstChild;
        if (icon.getAttribute("id") === "modifier") {

            subBtn.setAttribute("class","btn bt");

            btn.setAttribute("class","d-none");
            for(i = 0; i < input.length; i++)
                {
                  input[i].disabled = false;
                }
            subBtn.setAttribute('value',btnId);
            subBtn.setAttribute('type','submit');
          //  icon.setAttribute("id", "sut");
        }

}
    </script>
  </body>
</html>