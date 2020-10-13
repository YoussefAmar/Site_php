<?php
session_start();

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name ='DbSW';

$con = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die('Erreur de connexion à la base de donnée');

$req = "SELECT * FROM utilisateur WHERE IdUser = '{$_SESSION['IdUser']}'";
$User = mysqli_query($con,$req);

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

?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <meta charset="UTF-8">
    <title>Travailleur</title>
</head>
<body>
<?php echo "<table>";
echo "<tr>";
echo "<th>Titre</th>";
echo "<th>Contenu</th>";
echo "<th>Finis</th>";
echo "<th>Date d'envoi</th>";
echo "<th>Client</th>";
echo "</tr>";

echo "<form method='post' action=" .$_SERVER['PHP_SELF'].">";

while ($row = mysqli_fetch_assoc($Tache))
{
    echo "<tr>";

    $reqMailClient = "SELECT Email FROM utilisateur WHERE IdUser = '{$row['IdUser']}'";
    $MailClient = mysqli_query($con,$reqMailClient);

    echo"<td>". $row['Titre'] ."</td>";
    echo"<td>". $row['Contenu'] ."</td>";
    echo"<td>". $row['Finis'] ."</td>";
    echo"<td>". $row['Date_Envoi'] ."</td>";

    while ($rowMail = mysqli_fetch_assoc($MailClient))
    {
        echo"<td>". $rowMail['Email'] ."</td>";
    }


    echo "<td><input type='checkbox' name='checkbox_".$row['IdTache']."'></td>";

    echo "</tr>";

}

echo"<button type='submit' class='btn btn-primary' name='Effectuer'>Effectuer</button>";

echo "</form>";

if(isset($_POST["Effectuer"]))
{
    $IdTaches = array();

    foreach($_POST as $key => $value)
    {
        if(strpos($key,'checkbox_') === 0)
        {
           array_push($IdTaches,explode("_",$key)[1]);
        }
    }

    var_dump($IdTaches);

    foreach ($IdTaches as $IdTache)
    {
        $updateTache = "UPDATE tache SET Finis = 1  WHERE IdTache = '$IdTache'";

        if (mysqli_query($con, $updateTache))
        {
            echo $message = '<div class="succes" id="notification">
                                <strong>Succès</strong> Mise à jour réussie <br>
                                </div>';
            header("Refresh:0");
        }
        else
        {
            echo $message = '<div class="alerte" id="notification">
                                <strong>Echec</strong> Mise à jour échouée <br>
                                </div>';
        }
    }

}

?>
</body>

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

</html>