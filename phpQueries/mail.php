<?php
// Import PHPMailer classes into the global namespace
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader


function passForgotten($mal,$newPass,$nom,$prenom) {

// Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer();

    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    // $mail->SMTPSecure='tls';
    $mail->Username   = 'fstmstage@gmail.com';                    // SMTP username
    $mail->Password   = 'oaonendaffjffbmq';                                 // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above  587

// Content
    $mail->isHTML(true);
    $mail->setFrom('fstmstage@gmail.com', 'Platform des Stages FSTM');
  $mail->addAddress($mal);
  $mail->Subject ="Recupperation de mot de passe";
  $mail->Body    ="<h3>Cher Etudiant(e) : ".$nom." ".$prenom."</h3><br>
  <p> Une demande a été reçue pour réinitialiser votre mot de passe pour le compte fstage, vous trouverez ci-dessous un mot de passe de réinitialisation.</p><br>
  <h4 >Mot de passe de réinitialisation: <b style='color: #7b61ff'>".$newPass."<b></h4><br>
  <p style='color: orangered'>Il est recommandé de le changer après la connexion à votre compte pour des raisons de sécurité. </p>";
    if( $mail->send()){
        echo "mail sent";
    }else        echo "error";
    $mail->smtpClose();
}



function mail_to_entreprise($ent_mail,Array $infos) {

// Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer();

    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    // $mail->SMTPSecure='tls';
    $mail->Username   = 'fstmstage@gmail.com';                    // SMTP username
    $mail->Password   = 'oaonendaffjffbmq';                                 // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above  587

// Content
    $mail->isHTML(true);//style='color: #7b61ff'
    $mail->setFrom('fstmstage@gmail.com', 'Platform des Stages FSTM');
    $mail->addAddress($ent_mail);
    $mail->Subject ="Candidature au stage";
    $mail->Body    ="<h4>Voici les informations de l'un de nos etudiants [".$infos[1]." ".$infos[2]."], après avoir postulé pour l'un de vos offres [Offre: ".$infos[7].$infos[9]."] sur notre platform  FSTAGE. </h4><br>
                    <Hr>
                    <h6> Informations sur l'etudiant:</h6>
                     <p>
                    <b>CNE:</b> ".$infos[0]."
                     <br><b>Nom:</b>".$infos[1]."
                      <br><b>Prenom:</b>".$infos[2]."
                       <br><b>Date de naissance:</b>".$infos[3]."
                        <br><b>E-mail:</b>".$infos[4]."
                         <br><b>Tel:</b>".$infos[5]."
                          <br><b>Date de Candidature:</b>".$infos[6]."
                          <br><b>CV:</b>".$infos[11]."
                          <br>
                          </p>
                          <Hr>
                          <h6> Informations sur l'offre:</h6>
                          <p>
                          <b>№:</b>".$infos[7]."
                     <br><b>Poste offre:</b>".$infos[8]."
                      <br><b>Sujet offre:</b>".$infos[9]."
                       <br><b>Date de publication:</b>".$infos[10]."
                            </p>";

    if( $mail->send()){
        echo "mail sent";
    }else        echo "error";
    $mail->smtpClose();
}

//fin

//fin
?>


