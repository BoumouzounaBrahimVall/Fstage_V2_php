<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $who = $_POST['who'];


    if ($user != "" && $pass != "") {
        require(__DIR__ . '/../phpQueries/conxnBDD.php');
        if ($who == 'responsable')
            $query = "SELECT RESPONSABLE.MOTDEPASSE_RES FROM RESPONSABLE where RESPONSABLE.USERNAME_RES='$user';";
        else
            $query = "SELECT * FROM ETUDIANT where `CNE_ETU`='$user';";
        try {
            $smt = $bdd->query($query);
            $row = $smt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            echo "error : " . $e->getMessage();
            exit();
        }

        if (!empty($row)) {
            if ($who === 'responsable') {
                if (password_verify($pass, $row['MOTDEPASSE_RES'])) {

                    $_SESSION['auth'] = $user;
                    if (!isset($_SESSION['vers']))
                        header("Location:./../pages/homeRespo.php");
                    else header('Location:' . $_SESSION['vers']);
                } else {
                    $_SESSION['error'] = 'login ou mot de passe incorrect';

                }
            } else {
                if (password_verify($pass, $row['MOTDEPASSE_ETU'])) {//
                    $_SESSION['auth'] = $row['CNE_ETU'];
                    echo $row['CNE_ETU'];
                    if (!isset($_SESSION['vers']))
                        header("Location:./../pages/etudiant-dashboard.php");
                    else header('Location:' . $_SESSION['vers']);
                } else {
                    $_SESSION['error'] = 'login ou mot de passe incorrect';

                }

            }
        } else {
            $_SESSION['error'] = 'login ou mot de passe incorrect';
        }
    } else {
        $_SESSION['error'] = 'login ou mot de passe incorrect';
        header("Location:../pages/login.php");
    }


}
//deconnexion
if (isset($_GET['logout'])) {
    require_once(__DIR__ . '../../phpQueries/deconnecter.php');
    header("Location:../pages/login.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Bootstrap CSS -->
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
            crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&family=Reem+Kufi&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>

    </style>

    <title>Login</title>
</head>
<body>
<style>

</style>
<!-- Navbar  -->
<nav class="navbar navbar m-0 px-5  py-3 navbar-expand-lg navbar-light ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img id="logo" src="../assets/icon/logo.png" alt=""/>
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
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="#"
                    >Offre de stage</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">A propos</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<h4 class="pb-5 text-center " style="margin-top: 50px">Acceder a mon compte</h4>


<!-- Main Content Area -->
<div class=" container-fluid d-flex justify-content-center align-items-center">
    <div class="row col-xl-4 col-lg-5 col-md-6 col-sm-7 my-auto  d-flex">
        <!-- Pills navs pills-login pills-register-->
        <div class="nav nav-pills mb-3 ">

            <button class="btn btn-selector  mx-auto btn-seconnecter" id="tab-etudiant">Espace Etudiant</button>


            <button class="btn btn-selector mt-sm-2 mx-auto " id="tab-responsible">Espace Responsable</button>
        </div>
        <!-- Pills navs  fade show active-->

        <!-- Pills content -->
        <div class="tab-content">
            <div class="tab-pane  active" id="pills-etudiant" role="tabpanel" aria-labelledby="tab-login">
                <form class="col-md-auto mb-3" method="post">
                    <!-- username input -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="loginName" name="username" placeholder="username">
                    </div>
                    <div class=""></div>
                    <!-- Password input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="loginPassword" name="password"
                               placeholder="Mot de passe">
                    </div>
                    <!-- used to check who is the user input -->
                    <div style="display: none;">
                        <input type="text" class="form-control" id="who" name="who" value="etudiant">
                    </div>
                    <!-- 2 column grid layout -->
                    <div class="row mb-4">
                        <div class="col-md-6 d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-3 mb-md-0">
                                <input class="form-check-input" type="checkbox" value="" id="loginCheck" checked/>
                                <label class="form-check-label" for="loginCheck"> Remember me </label>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex justify-content-center">
                            <!-- Simple link -->
                            <a href="#!">Forgot password?</a>
                        </div>
                    </div>
                    <!-- Submit button -->
                    <div class="btn-login-parent">
                        <button type="submit" class="btn btn-primary btn-login " id="btn-seconnecter-body">Se
                            connecter
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Pills content -->
<footer  style="height: fit-content">
    <div style="margin-top: 120px" class="container">
        <div class="">
            <div >
                <div class="row justify-content-around align-items-center p-5">


                    <div class="col-xl-auto col-sm-12 mt-sm-2">
                        <img id="logo-light" src="./../assets/icon/logo-light.png" alt="" />
                    </div>
                    <a class="col-xl-auto col-sm-12  mt-sm-2" href="#">
                        Offre de stage
                    </a>

                    <a class="col-xl-auto col-sm-12  mt-sm-2" href="#">
                        Contact
                    </a>
                    <a  class="col-xl-auto col-sm-12  mt-sm-2" href="#">
                        A propos
                    </a>
                    <a class="col-xl-auto col-sm-12  mt-sm-2" href="#">
                        Espace Responsable
                    </a>
                    <a class="col-xl-auto col-sm-12  mt-sm-2" href="#">
                        Espace Etudiant
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="justify-content-center">

                <p class="copyright" style="text-align: center">Copyright © Stage FSTM 2022. Tous droits réservés.</p>

            </div>
        </div>
    </div>
</footer>
<!-- JavaScript Bundle with Popper-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/script.js"></script>
</body>
</html>





