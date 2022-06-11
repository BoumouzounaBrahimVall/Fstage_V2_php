<?php

//heroku db mysql
//mysql://b847878388960a:cec449ca@us-cdbr-east-05.cleardb.net/heroku_93aab640ed42c57?reconnect=true
try{
    //$bdd= new PDO("mysql:host=localhost;dbname=fstage","root","");
    $bdd= new PDO("mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_93aab640ed42c57","b847878388960a","cec449ca");
}
    catch(PDOException $e)
    {
        echo "votre connection n'est pas reussi ". $e->getMessage();
        exit();
    }
?>