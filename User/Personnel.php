<?php
session_start();

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name ='DbSW';

$con = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die('Erreur de connexion à la base de donnée');

$reqUser = "SELECT * FROM utilisateur WHERE IdUser = '{$_SESSION['IdUser']}'";
$User = mysqli_query($con,$reqUser);

$reqTache = "SELECT * FROM tache";
$Tache = mysqli_query($con,$reqTache);

echo "<table>";
echo "<tr>";
echo "<th>Nom</th>";
echo "<th>Prénom</th>";
echo "<th>Statut</th>";
echo "<th>Date</th>";
echo "</tr>";

while($row = mysqli_fetch_assoc($User))
{

    echo "<tr>";
    echo "<td>" . $row['Nom'] . "</td>";
    echo "<td>" . $row['Prenom'] . "</td>";
    echo "<td>" . $row['Statut'] . "</td>";
    echo "<td>" . date('d-m-Y') . "</td>";
    echo "</tr>";

}

echo "<table>";
echo "<tr>";
echo "<th>Titre</th>";
echo "<th>Contenu</th>";
echo "<th>Finis</th>";
echo "<th>Date d'envoi</th>";
echo "<th>Client</th>";
echo "</tr>";


while ($row = mysqli_fetch_assoc($Tache))
{
    $reqMailClient = "SELECT Email FROM utilisateur WHERE IdUser = '{$row['IdUser']}'";
    $MailClient = mysqli_query($con,$reqMailClient);

    echo"<tr><form>";
    echo"<td>". $row['Titre'] ."</td>";
    echo"<td>". $row['Contenu'] ."</td>";
    echo"<td>". $row['Finis'] ."</td>";
    echo"<td>". $row['Date_Envoi'] ."</td>";

    while ($row = mysqli_fetch_assoc($MailClient))
    {
        echo"<td>". $row['Email'] ."</td>";
    }
    echo "</form></tr>";
}

if(isset($_POST['Envoyer'])) {
    $Date = date('Y-m-d');
    $IdUser = $_SESSION['IdUser'];
    $Finis = 0;
    $Titre = mysqli_real_escape_string($con, $_POST['Titre']);
    $Contenu = mysqli_real_escape_string($con, $_POST['Contenu']);

    $insertion = "INSERT INTO tache (Titre, Contenu, Finis, Date_Envoi, IdUser)
    VALUE('$Titre','$Contenu','$Finis','$Date','$IdUser')";

    $add = mysqli_query($con, $insertion);

    if ($add) {
        echo $message = '<div class="succes" id="notification">
                                <strong>Succès</strong> Tâche envoyée <br>
                                </div>';
        header("Refresh:0");
    } else {
        echo $message = '<div class="alerte" id="notification">
                                <strong>Echec</strong> Tâche non- envoyée <br>
                                </div>';
    }
}

    if(isset($_POST['Supprimer']))
    {
        $suppression ="DELETE FROM tache WHERE Finis = 1";

        if (mysqli_query($con, $suppression))
        {
            echo $message = '<div class="succes" id="notification">
                                <strong>Succès</strong> Suppression réussie <br>
                                </div>';
            header("Refresh:0");
        }
        else
        {
            echo $message = '<div class="alerte" id="notification">
                                <strong>Echec</strong> Suppression échouée <br>
                                </div>';
        }
    }

?>
<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Personnel</title>

</head>
<body>

<button onclick="myFunction()">+</button>

<div class="container" id="Formulaire">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="col">
            </div>
            <div class="Site_Final">
                <h1>To do</h1>
                <form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
                    <div class="form-group">
                        <label>Titre</label>
                        <label>
                            <input type="text" class="form-control" maxlength="30" name="Titre" placeholder="Titre de la requête" required>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Contenu</label>
                        <textarea class="form-control" rows="3" name="Contenu" placeholder="Contenu de la requête..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="Envoyer">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>
<form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
    <button type='submit'  class='btn btn-primary' name="Supprimer" value="Supprimer">Supprimer</button>
</form>

</body>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready( function() {
        $('#notification').delay(3000).fadeOut();
    });
</script>

<script>
    function myFunction() {
        var x = document.getElementById("Formulaire");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>