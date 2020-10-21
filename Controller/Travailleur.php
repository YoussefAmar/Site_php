<?php
session_start();

include '../Views/Travailleur.html';
include '../Models/Bdd.php';

$con = $_SESSION['con'];

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

    foreach ($IdTaches as $IdTache)
    {
        $updateTache = "UPDATE tache SET Finis = 1  WHERE IdTache = '$IdTache'";

        if (mysqli_query($con, $updateTache))
        {
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
