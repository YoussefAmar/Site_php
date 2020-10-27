<?php
include '../Views/inscription.html';
include '../Models/Bdd.php';

$con = $_SESSION['con'];

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

        $insertion ="INSERT INTO utilisateur (Nom, Prenom, Email, Naissance, Gsm, Password, Statut)
        VALUE('$Nom','$Prenom','$Email','$Naissance','$Gsm','$Password','$Statut')";

        $req = "SELECT * FROM utilisateur WHERE Email = '$Email'";
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
                    echo $message = '<div class="alerte" id="succes">
                                <strong>Succès : </strong> Utilisateur enregistré <br>
                                </div>';
                }
                else
                    {
                  echo $message = '<div class="alerte" id="notification">
                                <strong>Echec : </strong> Utilisateur non-enregistré <br>
                                </div>';
                    }
            }
        }
        else
            {
              echo $message = '<div class="alerte" id="notification">
                               <strong>Echec : </strong> Les mots de passes sont différents <br>
                               </div>';
            }
    }
    ?>