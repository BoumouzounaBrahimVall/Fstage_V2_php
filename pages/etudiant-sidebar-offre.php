<?php
require( __DIR__.'./../phpQueries/etudiant/dash.php');
$nbr_retenu = 0;//variable pour compter le nombre d offre postuler avec l etat retenu
$etat_retenu= " SELECT POSTULER.ETATS_POST from POSTULER,ETUDIANT where ETUDIANT.CNE_ETU=POSTULER.CNE_ETU and POSTULER.ETATS_POST='RETENU' and ETUDIANT.CNE_ETU='$etudiant_cne' ;";
$All_etats = $bdd->query($etat_retenu);
$fich_etat = $All_etats->fetchAll(2);
if(!empty($fich_etat))
$nbr_retenu = 1;
else $nbr_retenu = 0;
?>



<div class="sidebar ps-2 pe-2 pt-2 pb-2  mt-4">
    <ul type="none">
        <li> <a href="./etudiant-dashboard.php"><i class=" active  bi bi-house-fill"></i>Offre disponible</a></li>

        <li> <a href="./etudiant-mes-offre.php"><i class="bi bi-briefcase-fill"></i>Mes Offres<i class="bi bi-bell-fill" style="color:red;" id="notification"></i></a></li>
        <li> <a href="./etudiant-mes-stage.php"><i class="bi bi-briefcase-fill"></i>Mes stage</a></li>
        <li> <a href="./etudiant-profil.php"><i class="bi bi-person-lines-fill"></i>Mon Profil</a></li>

    </ul>
</div>

<?php
echo "
<script>
    
          if( $nbr_retenu ==0 ){
          document.getElementById('notification').style.display = 'none'; }
          else document.getElementById('notification').style.display = 'block';
</script>
";
?>