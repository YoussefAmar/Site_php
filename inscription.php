<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Formulaire d'inscription</title>

  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="col">
                </div>
                <div class="Site_Final">
                    <h1>Formulaire d'inscription</h1>
                    <form method="post" action="<?php $_SERVER['PHP_SELF'];?>"> <!-- Remplacer par bdd  -->
                        <div class="form-group">
                            <label>Designation</label>
                            <label>
                                <select class="form-control" name="Statut" required>
                                    <option name="Statut">Client</option>
                                    <option name="Statut">Travailleur</option>
                                    <option name="Statut">Personnel</option>
                                </select>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Nom</label>
                            <label>
                                <input type="text" class="form-control" name="Nom" placeholder="Entrer votre nom" required>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Prénom</label>
                            <label>
                                <input type="text" class="form-control" name="Prenom" placeholder="Entrer votre prénom" required>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <label>
                                <input type="email" class="form-control" name="Email" placeholder="Entrer votre email" required>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Date de naissance</label>
                            <label>
                                <input type="date" class="form-control" name="Naissance" required>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Téléphone</label>
                            <label>
                                <input type="number" class="form-control" name="Gsm" placeholder="Numéro de téléphone" required>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Mot de passe</label>
                            <label>
                                <input type="password" class="form-control" name="Password" placeholder="Mot de passe" maxlength="15" required>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Confirmation</label>
                            <label>
                                <input type="password" class="form-control" name="ConfirmPassword" placeholder="Confirmer mot de passe" maxlength="15" required>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="Envoyer">Envoyer</button>
                    </form>
                    <form action = connexion.php>
                        <button type="submit" class="btn btn-primary" name="Connecter">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php

    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name ='DbSW';

    $con = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die('Erreur de connexion à la base de donnée');

    if(isset($_POST['Envoyer']))
    {
        $Nom = mysqli_real_escape_string($con,$_POST['Nom']);
        $Prenom = mysqli_real_escape_string($con,$_POST['Prenom']);
        $Email = mysqli_real_escape_string($con,$_POST['Email']);
        $Naissance = mysqli_real_escape_string($con,$_POST['Naissance']);
        $Gsm= mysqli_real_escape_string($con,$_POST['Gsm']);
        $Password = mysqli_real_escape_string($con,$_POST['Password']);
        $ConfirmPassword = mysqli_real_escape_string($con,$_POST['ConfirmPassword']);
        $Statut = mysqli_real_escape_string($con,$_POST['Statut']);
        $IdAutorisation = 3;

        switch ($Statut)
        {
            case "Client" : $IdAutorisation = 2; break;

            case "Travailleur" : $IdAutorisation = 3; break;

            case "Personnel" : $IdAutorisation = 1; break;
        }

        $insertion ="INSERT INTO utilisateur (Nom, Prenom, Email, Naissance, Gsm, Password, Statut, IdAutorisation)
        VALUE('$Nom','$Prenom','$Email','$Naissance','$Gsm','$Password','$Statut','$IdAutorisation')";

        $req = "SELECT Email FROM utilisateur WHERE Email = '$Email'";
        $resultat = mysqli_query($con,$req);

        if($Password == $ConfirmPassword)
        {
            if (mysqli_num_rows($resultat) > 0)
            {
              echo $message = '<div class="alerte" id="notification">
                          <strong>Echec</strong> Email déjà utilisée<br>
                        </div>';
            }
            else
                {
                if (mysqli_query($con, $insertion))
                {
                   echo $message = '<div class="succes" id="notification">
                                 <strong>Opération réussie</strong> Utilisateur enregistré<br>
                                 </div>';
                }
                else
                    {
                  echo $message = '<div class="alerte" id="notification">
                                <strong>Echec</strong> Utilisateur non-enregistré <br>
                                </div>';
                    }
            }
        }
        else
            {
              echo $message = '<div class="alerte" id="notification">
                               <strong>Echec</strong> Les mots de passes sont différents <br>
                               </div>';
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