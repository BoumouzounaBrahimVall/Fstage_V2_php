
<!-- Navbar  -->  
<nav class="navbar navbar-expand-lg navbar-light ">
      <div class="container-fluid ">
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
              <a class="nav-link " aria-current="page" href="etudiant-dashboard.php">Offre de stage</a
              >
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="./../pages/etudiant-rapport.php">Consulter Rapport</a>
            </li>
            
          </ul>
          
        </div>
          <?php if (isset($_SESSION['auth']))
              echo '
              <div class="d-flex">
              <a  href="../pages/respoProfil.php">
                  <img src="../assets/img/comment-section/user.png" class="rounded d-block profile_icon" alt="...">
              </a>            <a

                      id="seDeconnecter"
                      class="btn btn-outline-primary  btn-selector pt-3"
                      href="../pages/login.php?logout"
                      role="button"
              >Se deconnecter
                  <i class="fa-solid fa-right-from-bracket"></i>
              </a>
          </div>
              
              '
              ?>

      </div>
    </nav>
