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
                    href="../pages/login.php?logout"
                    role="button"
                >Se deconnecter
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </div>
</nav>