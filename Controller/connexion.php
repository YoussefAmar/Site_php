<?php session_start();

include '../Views/connexion.html';
include '../Models/Bdd.php';

                $con = $_SESSION['con'];

                if(isset($_POST['Connexion']))
                {
                    $Email = mysqli_real_escape_string($con,$_POST['Email']);
                    $Password = mysqli_real_escape_string($con,$_POST['Password']);

                    $req = "SELECT * FROM utilisateur WHERE Email = '$Email' AND Password ='$Password'";
                    $resultat = mysqli_query($con,$req);

                       if(mysqli_num_rows($resultat) > 0)
                       {

                           while($row = mysqli_fetch_assoc($resultat))
                           {
                               $_SESSION['IdUser'] = $row['IdUser'];
                               $_SESSION['Statut'] = $row['Statut'];
                           }

                           switch($_SESSION['Statut'])
                           {

                               case "Client" : header('location:../Controller/Client.php'); exit();

                               case "Travailleur" : header('location:../Controller/Travailleur.php'); exit();

                               case "Personnel" : header('location:../Controller/Personnel.php'); exit();

                               default : header('location : ../Views/Error.html'); exit();

                           }

                       }
                       else
                       {
                         echo $message = '<div class="alerte" id="notification">
                                       <strong>Opération échouée</strong> Email ou mot de passe incorrect<br>
                                       </div>';
                       }
                }

                ?>