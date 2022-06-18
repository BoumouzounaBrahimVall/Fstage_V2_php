<?php

//heroku db mysql
//mysql://b847878388960a:cec449ca@us-cdbr-east-05.cleardb.net/heroku_93aab640ed42c57?reconnect=true
try {


    //$bdd= new PDO("mysql:host=localhost;dbname=fstage","root","root");

   // $bdd = new PDO("mysql:host=localhost;port=3307;dbname=fstage", "root", "");

      $host = 'us-cdbr-east-05.cleardb.net';
        $dbname = 'heroku_93aab640ed42c57';
        $username = 'b847878388960a';
        $password = 'cec449ca';
        $bdd = new PDO("mysql:host=" . $host . "; dbname=" . $dbname, $username, $password);




} catch (PDOException $e) {
    echo "votre connection n'est pas reussi " . $e->getMessage();
    exit();
}

require( __DIR__.'./../phpQueries/synchro.php');
Synchronisation_offre_date($bdd);
Synchronisation_offre_effectif($bdd);
Synchronisation_post_expirer($bdd);

?>