<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Connexion</title>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="col">
            </div>
            <div class="Site_Final">
                <h1>Connexion</h1>
                <form method="post" action="<?php $_SERVER['PHP_SELF'];?>"> <!-- Remplacer par bdd  -->
                    <div class="form-group">
                        <label>Email</label>
                        <label>
                            <input type="email" class="form-control" name="Email" placeholder="Entrer votre email" required>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Mot de passe</label>
                        <label>
                            <input type="password" class="form-control" name="Password" placeholder="Mot de passe" maxlength="15" required>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" name="Connexion">Connexion</button>
                </form>
                <?php

                $db_host = 'localhost';
                $db_username = 'root';
                $db_password = '';
                $db_name ='DbSW';

                $con = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die('Erreur de connexion à la base de donnée');

                if(isset($_POST['Connexion']))
                {
                    $Email = mysqli_real_escape_string($con,$_POST['Email']);
                    $Password = mysqli_real_escape_string($con,$_POST['Password']);

                    $req = "SELECT * FROM utilisateur WHERE Email = '$Email' AND Password ='$Password'";
                    $resultat = mysqli_query($con,$req);

                       if(mysqli_num_rows($resultat) > 0)
                       {
                           $message = '<div class="alerte" id="notification">
                                       <strong>Opération réussie</strong> Utilisateur connecté<br>
                                       </div>';
                           echo $message;
                       }
                       else
                       {
                           $message = '<div class="alerte" id="notification">
                                       <strong>Opération échouée</strong> Utilisateur non-connecté<br>
                                       </div>';
                           echo $message;
                       }
                }

                ?>
                <!-- Optional JavaScript -->
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                <script src="https://code.jquery.com/jquery-3.3.1.min.js"
                        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                        crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

                <script type="text/javascript">
                    $(document).ready( function() {
                        $('#notification').delay(5000).fadeOut();
                    });
                </script>
</body>
</html>