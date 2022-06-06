<?php
    require('conxnBDD.php');
    require('authen.php');

$respon_username=$_SESSION['auth'];
$req_formation_respo="SELECT RESPONSABLE.NUM_FORM num from RESPONSABLE 
                where RESPONSABLE.USERNAME_RES='$respon_username';";
$Smt_formation_respo=$bdd->query($req_formation_respo);
$formation_respo=$Smt_formation_respo->fetch(2);
$formation=$formation_respo['num'];
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-.,;!@#$%&*()';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$req="SELECT RESPONSABLE.IMAGE_RESP
  from RESPONSABLE
   where  RESPONSABLE.USERNAME_RES='$respon_username';";
$Smt_im=$bdd->query($req);
$rspim=$Smt_im->fetch(2);
$respon_img=$rspim['IMAGE_RESP'];

?>
