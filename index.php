<?php
session_start();

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name ='DbSW';

$con = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die('Erreur de connexion à la base de donnée');

$req = "SELECT * FROM utilisateur WHERE IdUser = '{$_SESSION['IdUser']}'";
$User = mysqli_query($con,$req);


echo "<table>";
echo "<tr>";
echo "<th>Nom</th>";
echo "<th>Prénom</th>";
echo "<th>Statut</th>";
echo "</tr>";

while($row = mysqli_fetch_assoc($User))
{

    echo "<tr>";
    echo "<td>" . $row['Nom'] . "</td>";
    echo "<td>" . $row['Prenom'] . "</td>";
    echo "<td>" . $row['Statut'] . "</td>";
    echo "</tr>";

    $IdAuto = $row['IdAutorisation'];

}

$Autorisation = Recup_Droit($IdAuto,$con);

/*if (){include('request.html');}*/

function Recup_Droit($IdAuto,$con)
{

    $req = "SELECT * FROM autorisation WHERE IdAutorisation = $IdAuto";
    $Autorisation = mysqli_query($con,$req);

    return $Autorisation;

}

while($row = mysqli_fetch_assoc($Autorisation))
{
        if($row['Ecriture'] == 1)
        {
            include('Ecriture.html');
        }

}


?>