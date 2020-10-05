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

    <title>Connexion</title>

</head>
<body>
<div class="container">
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
                            <input type="text" class="form-control" name="Titre" placeholder="Titre de la requête" required>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Contenu</label>
                        <textarea class="form-control" rows="3" name="Contenu" placeholder="Contenu de la requête..." required></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
