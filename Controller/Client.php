<?php
session_start();
include '../Views/Client.html';
include '../Models/Bdd.php';

$con = $_SESSION['con'];
$reqUser = "SELECT * FROM utilisateur WHERE IdUser = '{$_SESSION['IdUser']}'";
$User = mysqli_query($con,$reqUser);

$reqTache = "SELECT * FROM tache WHERE IdUser = '{$_SESSION['IdUser']}'";
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

if(mysqli_num_rows($Tache) > 0)
{
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

        echo "<tr><form method='post' action=" .$_SERVER['PHP_SELF'].">";
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

}
else
    echo "Aucune tâche envoyée";

if(isset($_POST['Envoyer'])) {
    $Date = date('Y-m-d');
    $IdUser = $_SESSION['IdUser'];
    $Finis = 0;
    $Titre = mysqli_real_escape_string($con, $_POST['Titre']);
    $Contenu = mysqli_real_escape_string($con, $_POST['Contenu']);

    $insertion = "INSERT INTO tache (Titre, Contenu, Finis, Date_Envoi, IdUser)
    VALUE('$Titre','$Contenu','$Finis','$Date','$IdUser')";

    $add = mysqli_query($con, $insertion);

    if ($add)
    {
        header("Refresh:0");

        echo $message = '<div class="succes" id="notification">
                                <strong>Succès</strong> Tâche envoyée <br>
                                </div>';
    }
    else
        {
        echo $message = '<div class="alerte" id="notification">
                                <strong>Echec</strong> Tâche non- envoyée <br>
                                </div>';
    }
}

?>
