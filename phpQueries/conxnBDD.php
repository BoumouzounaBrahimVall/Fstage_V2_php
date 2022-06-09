<?php
try{
    $bdd= new PDO("mysql:host=localhost;dbname=fstage","root","");
}
    catch(PDOException $e)
    {
        echo "votre connection n'est pas reussi ". $e->getMessage();
        exit();
    }
?>