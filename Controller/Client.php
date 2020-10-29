<?php
session_start();
include '../Models/Bdd.php';

ob_start();

$con = $_SESSION['con'];

$reqUser = "SELECT * FROM utilisateur WHERE IdUser = '{$_SESSION['IdUser']}'";
$User = mysqli_query($con,$reqUser);

$reqTache = "SELECT * FROM tache WHERE IdUser = '{$_SESSION['IdUser']}'";
$Tache = mysqli_query($con,$reqTache);

$Nom = "";
$Prenom = "";
$Statut = "";
$Mail = "";
$Nai ="";
$Gsm = "";

echo "<button id='hide' class='btn float-right login_btn' name='Toggle' onclick='myFunction()'>+</button>";

echo "<div class='input-group form-group'>";

while($row = mysqli_fetch_assoc($User))
{
    $Nom = $row['Nom'];
    $Prenom = $row['Prenom'];
    $Statut = $row['Statut'];
    $Mail = $row['Email'];
    $Nai =$row['Naissance'];
    $Gsm = $row['Gsm'];
}

$Nai = date("d-m-Y", strtotime($Nai));

echo "<div class='container'>
  <ul class='responsive-table'>
  <div class='table-row'>
        <div class='d-flex align-items-center'>
            <div class='image'> <img src='../Views/css/Profile.png' class='rounded' width='155'> </div>
            <div class='ml-3 w-100'>
                <h4 class='mb-0 mt-0' id='headwhite'>$Nom $Prenom</h4> <span id='headwhite'>$Statut</span>
                <div class='p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats'>
                    <div class='d-flex flex-column'> <span class='articles'>Email</span> <span class='number1'>$Mail</span> </div>
                    <div class='d-flex flex-column'> <span class='followers'>Né le</span> <span class='number2'>$Nai</span> </div>
                    <div class='d-flex flex-column'> <span class='rating'>Numéro</span> <span class='number3'>$Gsm</span> </div>
                </div>
            </div>
        </div></div></ul></div>";

include '../Views/Client.html';

echo"<form>";

if(mysqli_num_rows($Tache) > 0)
{

    while ($row = mysqli_fetch_assoc($Tache))
    {
        $reqMailClient = "SELECT Email FROM utilisateur WHERE IdUser = '{$row['IdUser']}'";
        $MailClient = mysqli_query($con,$reqMailClient);

        $Date_envoi = date("d-m-Y", strtotime($row['Date_Envoi']));

        if($row['Finis'] == 0)
        {
            $Fait = "En cours";
        }
        else
            $Fait = "Finie";

        echo "<div><li><div class='containertodo centertodo'>
  <div class='cardtodo'>
    <h2><strong>".$row['Titre']."</strong></h2>
    <hr/>
    <p>
    ".$row['Contenu']."
    </p>
    <p><div class='d-flex flex-column'>Envoyé le $Date_envoi</div></p>
    <p><div class='d-flex flex-column'>Etat : $Fait</div>";

        while ($row = mysqli_fetch_assoc($MailClient))
        {
            echo "<p><div class='d-flex flex-column'>Demandée par ".$row['Email']."</div></p></div></div></li></div>";
        }

    }

}
else
{
    echo "<div class='containertodo centertodo'>
  <div class='cardtodo'>
    <h2><strong>Pas de tâches postées</strong></h2></div></div>";
}

echo"</form>";

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
        ob_clean();

        header("Refresh:0");

    }
    else
        {
        echo $message = '<div class="alerte" id="notification">
                                <strong>Echec</strong> Tâche non- envoyée <br>
                                </div>';
    }
}
