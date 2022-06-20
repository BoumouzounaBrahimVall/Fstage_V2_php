<?php
require(  __DIR__.'./../phpQueries/uploads.php');
$offre_num=$_GET['numOffre'];

/*
if(isset($_POST['filesUpload'])) {
    echo 'yes';
    $ent = $_POST['numEnt'];
    $offre_num = $_POST['numOffre'];
    $file = $_FILES['file'];
    echo 'logo';
    uploadImagesOrCVEtudiant($ent, $file, $bdd, 3);
}*/
if(isset($_POST['filesUpload']))
{

    $file = $_POST['cvPath'];
    $entNum=$_POST['numEnt'];
    $numOffre=$_POST['numOffre'];
    uploadImagesOrCVFirebase($entNum,$file,$bdd,3);
    header('location:resposable-details-offre.php?numOffre='.$numOffre);

}

if (empty($offre_num)) header('location:gererOffre.php');

if(isset($_GET['modifpost'])){
        $cneEtu=$_GET['cne'];
        $datReponse=$_GET['dateRep'];
      //reponse entreprise

    if(isset($_GET['responseEnt'])){
        $reponse = $_GET['responseEnt'];
        $reqP = "UPDATE postuler set ETATS_POST='$reponse',date_reponse='$datReponse' WHERE NUM_OFFR='$offre_num' and CNE_ETU='$cneEtu'";
        $bdd->exec($reqP);
    }
    else if($_GET['responseEnt']!='nothing'){

            $reqP = "UPDATE postuler set date_reponse='$datReponse' WHERE NUM_OFFR='$offre_num' and CNE_ETU='$cneEtu'";
            $bdd->exec($reqP);
        }
        $loca='location:resposable-details-offre.php?numOffre='.$offre_num;
    str_replace(' ', '', $loca);
    header($loca);

}

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
            $ville=addslashes($_GET['villeOffre']);
            $pays=addslashes($_GET['paysOffre']);
            $lieu=addslashes($_GET['lieuOffre']);
            $req = "UPDATE OFFREDESTAGE set VILLE_OFFR='$ville',LIEUX_OFFR='$lieu',PAYS_OFFR='$pays' WHERE NUM_OFFR='$offre_num'";
            break;
        case 'modifyDetail':// Poste sujet detail
            $poste=addslashes($_GET['Poste']);
            $sujet=addslashes($_GET['sujet']);
            $detail=addslashes($_GET['detail']);
            $req = "UPDATE OFFREDESTAGE set POSTE_OFFR='$poste',SUJET_OFFR='$sujet',DETAILS_OFFR='$detail' WHERE NUM_OFFR='$offre_num'";
            break;
    }
    $bdd->exec($req);
    header('location:resposable-details-offre.php?numOffre='.$offre_num);

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
      <?php
      require_once "./meta-tag.php"
      ?>
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
                <h3> <b>Détails offre № <?php echo  $detaiOff['NUM_OFFR']?></b>  </h3>
    
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

                            <input class="form-control d-none" name="cvPath" id="pathStorageFile" >
                            <label for="files" class="p-1 btn-import-img" ><i class="bi bi-image-fill"></i> import</label>
                            <input  disabled type="file"  class="d-none inputEnt"  name="file"  onchange="uploadFileToFirebase('files','btnSubmit','pathStorageFile',3,'<?php echo $donnee[13];?>')" id="files">
                            <button  type="submit" name="filesUpload" class="btn d-none"  id="subbtnEnt" >
                                <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                            <a onclick="modifySubmitdate('inputEnt','btnSubmit','subbtnEnt')" id="btnSubmit" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>

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
                                    <input id="inputEtat" type="text" pattern="(NOUVEAU|CLOSE|COMPLETÉ)"  title="L'etat soit :NOUVEAU,CLOSE ou COMPLETÉ" class="form-control inputEtat" disabled value="<?php echo $donnee[1];?>" name="inputEtat">
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
                                            <input id="inputEff" type="text" class="form-control  inputEffDl" pattern="([0-9]+)?"  title="effectif doit etre un entier" disabled value="<?php echo $donnee[4];?>" name="Effectif" >

                                    </div>
                                    <div class="col">
                                            <label for="inputEtat">Delai (jours)</label>
                                            <input id="inputEtat" type="text" class="form-control inputEffDl" pattern="([0-9]+)?"  title="Delai doit etre un entier" disabled value="<?php echo $donnee[5];?>" name="delai">
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
                                   <div class="row">
                                       <div class="col">

                                           <label  >Ville </label><!--^[a-zA-Z\u0080-\u024F]+(?:. |-| |')*([1-9a-zA-Z\u0080-\u024F]+(?:. |-| |'))[a-zA-Z\u0080-\u024F]*$ -->
                                           <input type="text" class="form-control inputAdr" pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"  title="ville ne contient pas des caractères speciaux" disabled value="<?php echo $donnee[6];?>" name="villeOffre" >

                                       </div>
                                       <div class="col">

                                           <label >Pays </label>
                                           <input type="text" class="form-control inputAdr" pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"  title="ville ne contient pas des caractères speciaux" disabled value="<?php echo $donnee[7];?>" name="paysOffre" >

                                       </div>
                                   </div>
                                    <div class="row">
                                        <div class="col">
                                            <label >Rue</label>
                                            <input type="text" class="form-control inputAdr" disabled value="<?php echo $donnee[8];?>" name="lieuOffre" >
                                        </div>
                                        <div align="center" class="col mt-4">
                                            <button type="submit" name="send" class="btn d-none"  id="subbtnAdr" >
                                                <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                            <a onclick="modifySubmitdate('inputAdr','modifyAdr','subbtnAdr')" id="modifyAdr" type="btn"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                        </div>
                                    </div>

                                </form>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col mt-2">
                                <form  action="resposable-details-offre.php" method="get" class="border rounded p-1" >
                                    <input type="text" class="d-none "  value="<?php echo $offre_num;?>" name="numOffre" >
                                    <div class="row">
                                        <div class="col">

                                            <label  >Poste </label>
                                            <input type="text" class="form-control inputDetail" disabled value="<?php echo $donnee[9];?>" name="Poste" >
                                        </div>
                                        <div class="col">
                                            <label  >Sujet </label>
                                            <input type="text" class="form-control inputDetail" disabled value="<?php echo $donnee[10];?>" name="sujet" >
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label >Detail</label>
                                        <textarea  id="detailoffre"  class="form-control inputDetail " disabled name="detail" rows="3" cols="21"> <?php echo  $donnee[11];?></textarea>
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

               <div class="mt-2 border p-3 rounded-5 rounded border-1 ">
                    <table id="table_id"  style="width:100%" class=" nowrap display">
                      <thead>
                        <tr>
                          <th scope="col">CNE</th>
                          <th scope="col">Nom</th>
                          <th scope="col">Prenom</th>
                          
                          <th scope="col">Date Postuler</th>
                          <th scope="col">Retenu</th>
                          <th scope="col">Accepter</th>
                            <th scope="col">Annuler</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $reqEt=" SELECT pst.*,etu.* FROM `postuler` pst ,etudiant etu WHERE etu.CNE_ETU=pst.CNE_ETU and pst.NUM_OFFR='$offre_num'";
                      $Smt_nbr=$bdd->query($reqEt);
                      $etud=$Smt_nbr->fetchAll(PDO::FETCH_ASSOC);
                      $reqconuts="SELECT postuler.ETATS_POST, COUNT(postuler.ETATS_POST)  FROM `postuler`  
                                    WHERE NUM_OFFR='$offre_num' and ETATS_POST not in ('REFUSER','ANNULER')
                                    GROUP BY ETATS_POST;";
                      $Smt_counts=$bdd->query($reqconuts);
                      $counts=$Smt_counts->fetchAll(PDO::FETCH_ASSOC);
                      $countsAll=array(0,0,0,0,0);
                      foreach ($counts as $etatcnt){
                          if($etatcnt['ETATS_POST']=='ACCEPTER') $countsAll[0]+=$etatcnt['COUNT(postuler.ETATS_POST)'];
                          else $countsAll[0]+=0;
                          //attente 1 jusqu'a 3
                          if($etatcnt['ETATS_POST']=='1') $countsAll[1]+=$etatcnt['COUNT(postuler.ETATS_POST)'];
                          else $countsAll[1]+=0;
                          if($etatcnt['ETATS_POST']=='2') $countsAll[2]+=$etatcnt['COUNT(postuler.ETATS_POST)'];
                          else $countsAll[2]+=0;
                          if($etatcnt['ETATS_POST']=='3') $countsAll[3]+=$etatcnt['COUNT(postuler.ETATS_POST)'];
                          else $countsAll[3]+=0;
                          if($etatcnt['ETATS_POST']=='RETENU') $countsAll[4]+=$etatcnt['COUNT(postuler.ETATS_POST)'];
                          else $countsAll[4]+=0;
                      }

                      //afficher le tableau
                      if(!empty($etud))
                      {
                          foreach($etud as $V):

                              if( strcmp($V['ETATS_POST'],'RETENU')==0){
                                  $retenu='<p>oui</p>';
                              }
                              else if(strcmp($V['ETATS_POST'],'REFUSER')==0) $retenu='<p>non</p>';
                              else{
                                  if( $countsAll[4]==$donnee[4]){ //effectif saturee
                                      if($countsAll[1]!='1')// 1er liste att kayen
                                      $retenu=' <select name="responseEnt" disabled required class="form-select  form-select-sm '."input".$V['CNE_ETU'].'" aria-label=".form-select-sm example">
                                                 <option value="nothing">--</option>
                                                <option value="REFUSER">Non</option>
                                                <option value="1" selected>1eme attante</option>
                                                </select>';
                                      else if($countsAll[2]!='1')//2eme liste att kayen
                                          $retenu=' <select name="responseEnt" disabled required class="form-select  form-select-sm '."input".$V['CNE_ETU'].'" aria-label=".form-select-sm example">
                                                <option value="nothing">--</option>
                                                <option value="REFUSER">Non</option>
                                                <option value="2" >2eme attante</option></select>';
                                      else if($countsAll[3]!='1')
                                          $retenu=' <select name="responseEnt" disabled required class="form-select  form-select-sm '."input".$V['CNE_ETU'].'" aria-label=".form-select-sm example">
                                                <option value="nothing">--</option>
                                                <option value="REFUSER">Non</option>
                                                <option value="3" >3eme attante</option>
                                                </select>';
                                      else $retenu=' <select name="responseEnt" disabled required class="form-select  form-select-sm '."input".$V['CNE_ETU'].'" aria-label=".form-select-sm example">
                                               <option value="nothing">--</option>
                                                <option value="REFUSER">Non</option></select>';
                                  }else $retenu=' <select name="responseEnt" disabled required class="form-select  form-select-sm '."input".$V['CNE_ETU'].'" aria-label=".form-select-sm example">
                                                 <option value="nothing">--</option>
                                                 <option value="RETENU">oui</option>
                                                <option value="REFUSER">Non</option></select>';
                              }
                              if(strcmp($V['ETATS_POST'],'ACCEPTER')==0){
                                  $retenu='<p>oui</p>';
                                  $accpt='<p>Oui</p>';
                              }
                              else if(strcmp($V['ETATS_POST'],'NO_ACCEPTER')==0){
                                  $retenu='<p>oui</p>';
                                  $accpt='<p>Non</p>';
                              }
                              else $accpt='--';
                              if(strcmp($V['ETATS_POST'],'ANNULER')==0) $anul='Oui';
                              else $anul='--';

                              echo' <tr>
                              <td ><a href="../pages/resposable-details-etudiant.php?cne='.$V['CNE_ETU'].'">'.$V['CNE_ETU'].'</a></td>
                              <td>'.$V['NOM_ETU'].'</td>
                              <td>'.$V['PRENOM_ETU'].'</td>
                              <td>'.$V['DATE_POST'].'</td>
                                <form method="get">
                                <td>
                                <input type="text" class="d-none"  value="'.$V['CNE_ETU'].'" name="cne" >
                                <input type="text" class="d-none"  value="'.$offre_num.'" name="numOffre" >
                                <div class="col-10"><input type="date" required disabled class="form-control '."input".$V['CNE_ETU'].'"  value="'.$V['date_reponse'].'" name="dateRep" >
                                </div>
                                <div class="col-10">';
                              echo $retenu;
                              echo'</div>
                                    </td>
                                   <td>'.$accpt.'</td>
                                  <td>'.$anul.'</td>
                              <td>  
                                <button type="submit" name="modifpost" class="btn d-none"  id="'."subbtn".$V['CNE_ETU'].'" >
                                            <i  style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="m-0 p-0 bi bi-check-square"></i></button>
                                        <a onclick=\'modifySubmitdate("'."input".$V['CNE_ETU'].'","'."modify".$V['CNE_ETU'].'","'."subbtn".$V['CNE_ETU'].'")\' id="'."modify".$V['CNE_ETU'].'" type="submit"><i id="modifier" style="font-size: 20px;color: #7B61FF;cursor: pointer;" class="bi bi-pencil-square"></i></a>
                                    </form>
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
        <div id="modal-progress-upload">

        </div>
    </div>


   <script src="../js/script-upload.js"></script>
   <script src="../js/script2.js"></script>
   <script>
       $(document).ready( function () {
           $('#table_id').DataTable({

               language: {
                   url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json'
               },
               scrollY: 200,
               scrollX: true,
           });
       } );
   </script>
   <!-- Import jQuery -->
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
