<?php
require(  __DIR__.'../../phpQueries/uploads.php');
$verification=0;//variable global pour la verification du mot de passe
//selectionner les informations du responsable
// traitement du formulaire
if(isset($_POST['filesUpload'])){
    $file = $_FILES['file'];

    uploadImagesOrCVEtudiant($respon_username, $file, $bdd, 4);
}
if(isset($_GET['btnsend'])){
    echo 'good';

    $donnee=array(
        $_GET['inputNom2'], //nom d responsable
        $_GET['inputPrenom2'], //prenom d responsable
        $_GET['inputEmail'], //email d responsable
        $_GET['inputtel'], //Tel d responsable
        $_GET['dateNaiss'], //Date naiss d responsable
        $_GET['numEns']
    );
    print_r($donnee);
    //modifier les informations du responsable
    $modifier_ens="UPDATE ENSEIGNANT set NOM_ENS='$donnee[0]',
              PRENOM_ENS='$donnee[1]',EMAIL_ENS_ETU='$donnee[2]',TEL_ENS='$donnee[3]',
        DATEDENAISSANCE_ENS='$donnee[4]' where NUM_ENS='$donnee[5]' ; ";
    $bdd->exec($modifier_ens);
    header('location:respoProfil.php');

}
$req="SELECT ENSEIGNANT.*,RESPONSABLE.IMAGE_RESP
  from ENSEIGNANT,RESPONSABLE
   where ENSEIGNANT.NUM_ENS=RESPONSABLE.NUM_ENS and RESPONSABLE.USERNAME_RES='$respon_username';";
$Smt=$bdd->query($req);
$rows=$Smt->fetch(2);
//traitement du deuxieme formulaire
if(isset($_POST['btn-modifier_mdp_respo'])){

    //recuperer le mot de passe
     $mdp=$_POST['inputmotdepasse']; //password d responsable

    //selectionner le mot de passe du responsable courant
    $password_respo="SELECT RESPONSABLE.MOTDEPASSE_RES from RESPONSABLE where RESPONSABLE.USERNAME_RES='$respon_username';";
    $Smt_password=$bdd->query($password_respo);
  
    $rows_password=$Smt_password->fetch(PDO::FETCH_ASSOC); // arg: PDO::FETCH_ASSOC
      
    //si le mot de passe est correcte afficher les inputs de nouveau mot de passe

    if(password_verify($mdp,$rows_password['MOTDEPASSE_RES']))
     {
       $verification=1;

     }
     else
     {
       $verification=0;
     }

  }
//traitement du troisieme formulaire
  if(isset($_POST['btn-modifier_mdp_responv'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      //recuperer les deux valeurs du mot de passe
      $nouveau_pass2=$_POST['inputmotdepassenv2'];
      $nouveau_pass1=$_POST['inputmotdepassenv'];
      //premiere test: si les deux passwords ne sont pas egaux
      if($nouveau_pass1==$nouveau_pass2){
          $nouveau_pass1= password_hash($nouveau_pass1,PASSWORD_DEFAULT);
            //etape2 : changer le mot de passe
          $modifier_mdp="UPDATE RESPONSABLE 
          set RESPONSABLE.MOTDEPASSE_RES='$nouveau_pass1'where RESPONSABLE.USERNAME_RES='$respon_username'; ";
          $bdd->exec($modifier_mdp);
      }
  }
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

      <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <title>Profile</title>
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
              <a class="nav-link" href="../pages/gererEtudiant.php">Gérer les comptes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/gererStage.php">Gérer stage</a>
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
          <div class="sidebar ps-2 pe-2 pt-2 pb-2  mt-4">
            <ul type="none">
              <li > <a href="homeRespo.php"><i class=" active  bi bi-house-fill"></i>Acceuil</a></li> 
            </ul>
          </div>
        </div>
        <div class=" col-xl-9 col-sm-12">
            <div class="intro p-4 mt-3 d-flex align-items-center">
                <h3> <b>Personaliser mon profil</b>  </h3>
            </div>

            <div class="row ps-4 my-4 ">
                  <span class="modifier-info-headline" >visualiser mes informations</span>
                   <div class="mt-4 p-5 border border-1 rounded-3">
                       <div class="row" >
                           <div class="col-2 ">
                               <img style="width: 96px;height: 96px;" class="mx-auto mb-2 ms-4 rounded-circle" src="<?php echo $rows['IMAGE_RESP'];?>" alt="">
                           </div>
                           <div class="col mt-3">
                               <form   action="" class="m-0 pe-0" method="POST" enctype="multipart/form-data">
                                   <label for="imgEnt" class="mt-2 ms-2 btn btn-import-img" >Importer image <i class="bi bi-image-fill"></i></label>
                                   <input type="file"  class="d-none inputEnt" name="file" id="imgEnt">
                                   <button type="submit" name="filesUpload" class="btn"  id="subbtnEnt" >
                                       <svg style="color: #7B61FF;cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send-plus-fill" viewBox="0 0 16 16">
                                           <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47L15.964.686Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                           <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z"/>
                                       </svg>
                                   </button>
                               </form>
                           </div>
                       </div>
            <form action="" method="get">

                        <div class="row mt-5">
                          <div class="col-xl-6 col-sm-6">
                             <label for="inputNom2" class="col-form-label">Nom</label>
                             <input class="form-control" type="text" id="inputNom2" name="inputNom2" value=' <?php echo $rows['NOM_ENS'] ?>'>
                          </div>
                       <div class="col-xl-6 col-sm-6">
                          <label for="inputPrenom2" class="col-form-label">Prenom</label>
                      
                          <input class="form-control" type="text" id="inputPrenom2" name="inputPrenom2" value='<?php echo $rows['PRENOM_ENS']  ?>'>
                      </div>
    
                    </div>
                   
                  <div class="row mt-5">
                    <div class=" col-xl-6 col-sm-6">
                        <label for="inputEmail" class="col-form-label">Email</label>
                    
                        <input class="form-control" type="email" id="inputEmail" name="inputEmail"  value='<?php echo $rows['EMAIL_ENS_ETU']  ?>'>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                      <label for="inputtel" class="col-form-label">Telephone</label>
                  
                      <input class="form-control" type="tel" id="inputtel" name="inputtel" value='<?php echo $rows['TEL_ENS']  ?>'>
                  </div>
    
                </div>
    
                <div class="row mt-5 ">
                  <div class="col-xl-6 col-sm-12">
                      <label for="inputId" class="col-form-label">№</label>
                      <input class="form-control"  type="text" id="inputId"  disabled name="numEns" value="<?php echo $rows['NUM_ENS']  ?>">
                  </div>
                
                <div class="col-xl-6  col-sm-12 ">
                     <label for="dateNaiss" class="col-form-label" >Date Naissance</label>
              
                     <input class="form-control" type="date" id="dateNaiss" name="dateNaiss" value='<?php echo $rows['DATEDENAISSANCE_ENS']  ?>'>
                </div>
    
            </div>
                    
              <div class="row  mt-5">
                    <div class="col-xl-6 col-sm-12 mt-6">
                       <button onclick="document.getElementById('inputId').disabled=false;" type="submit" class="btn  btn-login text-white " id="btn-modifier_info_respo"  name="btnsend" value="btn_modifier_info_respo"> Modifier </button>
                  </div>
            </div>
        </form>
        <HR SIZE="4">
        <div class="row border">
            <div class="row ">
                <form action="" method="post">


                            <label for="inputmotdepasse" class="col-form-label"><b>Changer le Mot de Passe</b></label><br>
                            <label for="inputmotdepasse" class="col-form-label">Mot de passe</label>
                            <input class="form-control " type="password" id="inputmotdepasse" name="inputmotdepasse" ><br>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-login " id="btn-modifier_mdp_respo" name="btn-modifier_mdp_respo"> Valider </button>

                            </div>

                    <HR SIZE="4">
                </form>
            </div>

            <form action="" method="post" class="row" id="hdpss">
                <div class="col ">
                    <label for="inputmotdepassenv" class="col-form-label" id="label_mdp">Nouveau mot de passe</label>
                    <input class="form-control " type="password" id="inputmotdepassenv" name="inputmotdepassenv" >
                </div>

                <div class="col mb-2">
                        <label for="inputmotdepassenv2" class="col-form-label" id="label_mdp2">Resaisir Mot de Passe</label>
                        <input class="form-control " type="password" id="inputmotdepassenv2" name="inputmotdepassenv2" >
                </div>
                <div class="col mt-3 mb-2">
                        <button type="submit" class="btn btn-selector" id="btn-modifier_mdp_responv" name="btn-modifier_mdp_responv"> Changer </button>
                </div>
            </form>

        </div>


          </div>
        </div>
    
            

            
      </div>
    </div>



<?php
  //si le mot de passe est incorrecte
  if($verification==0)
  {
echo"
<script>
  
    $(document).ready(function(){
           $('#hdpss').hide(); 
  });
    
</script>
";
  }else{
      echo
      "
        <script>
      
        $(document).ready(function(){
            $('#hdpss').show(); 
      });
        </script>
      ";
  }
    ?>


     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/script.js">

</script>
  </body>
</html>
