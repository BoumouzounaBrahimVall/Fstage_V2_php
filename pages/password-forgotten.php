<?php
$errors=array('hi ','you');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
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

</head>
<body>
<div class="container ">
    <div class="row">
        <div class="col-md-4 offset-md-4 form">
            <form action="" method="POST" autocomplete="" >
                <h2 class="text-center">Forgot Password</h2>
                <p class="text-center">Entrer Votre Adresse E-mail</p>
                <?php
                if(count($errors) > 0){
                    ?>
                    <div class="alert alert-danger text-center">
                        <?php
                        foreach($errors as $error){
                            echo $error;
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group mb-3">
                    <input class="form-control" type="email" name="email" placeholder="Enter email address" required >
                </div>
                <div class="form-group">
                    <input class="btn btn-primary btn-login " id="btn-seconnecter-body" type="submit" name="check-email" value="Continue">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>