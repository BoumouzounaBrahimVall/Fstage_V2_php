<?php

function uploadImagesOrCVFirebase($id,$fileDestination,$bdd,$typ){
    if (!empty($fileDestination))
    {
        switch ($typ) {
            case 1://photo etudiant
                $req = "  UPDATE `ETUDIANT` SET `IMG_ETU` = '$fileDestination' WHERE `ETUDIANT`.`CNE_ETU` = '$id';";
                break;
            case 2: //cv etudiant
                $req = "  UPDATE `ETUDIANT` SET `CV_ETU`= '$fileDestination' WHERE `ETUDIANT`.`CNE_ETU` = '$id';";
                break;
            case 3://logo ent
                $req = "  UPDATE `ENTREPRISE` SET `IMAGE_ENT`= '$fileDestination' WHERE `ENTREPRISE`.`NUM_ENT` = '$id';";
                break;
            case 4: // photo responsable
                $req = "  UPDATE `RESPONSABLE` SET `IMAGE_RESP`= '$fileDestination' WHERE `RESPONSABLE`.`USERNAME_RES` = '$id';";
                break;

        }

        $bdd->exec($req);
    }


}
function uploadImagesOrCVEtudiant($id,$file,$bdd,$typ){
    $fileName = $file['name'];
    $fileTmpName =$file['tmp_name'];
    $filesize =$file['size'];
    $fileError=$file['error'];
    $fileType = $file['type'];
    $fileExt = explode ('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed=array('jpg','jpeg','png','pdf');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($filesize< 20000000){ // max 20mb
                switch ($typ) {
                    case 1://photo etudiant
                        $fileNameNew = $id . "profile." . $fileActualExt;
                        $fileDestination = "../ressources/EtudiantPhoto/" . $fileNameNew;
                        $req = "  UPDATE `ETUDIANT` SET `IMG_ETU` = '$fileDestination' WHERE `ETUDIANT`.`CNE_ETU` = '$id';";
                        break;
                    case 2: //cv etudiant
                        $fileNameNew=$id."CV.". $fileActualExt;
                        $fileDestination="../ressources/EtudiantCV/". $fileNameNew;
                        $req = "  UPDATE `ETUDIANT` SET `CV_ETU`= '$fileDestination' WHERE `ETUDIANT`.`CNE_ETU` = '$id';";
                        break;
                    case 3://logo ent
                        $fileNameNew=$id."entlogo.". $fileActualExt;
                        $fileDestination="../ressources/company/images/". $fileNameNew;
                        $req = "  UPDATE `ENTREPRISE` SET `IMAGE_ENT`= '$fileDestination' WHERE `ENTREPRISE`.`NUM_ENT` = '$id';";
                        break;
                    case 4: // photo responsable
                        $fileNameNew=$id."_Respo.". $fileActualExt;
                        $fileDestination="../ressources/ResposablesPhoto/". $fileNameNew;
                        $req = "  UPDATE `RESPONSABLE` SET `IMAGE_RESP`= '$fileDestination' WHERE `RESPONSABLE`.`USERNAME_RES` = '$id';";
                        break;

                }

                $bdd->exec($req);
                move_uploaded_file($fileTmpName, $fileDestination);
            }else{
                echo "size error";
            }

        }else {
            echo "there was a prob uploading";
        }
    }else {
        echo
        "You cannot upload files of this type!";
    }
}
?>
