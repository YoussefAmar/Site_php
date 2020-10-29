<?php
session_start();
include '../Models/Bdd.php';

ob_start();

$con = $_SESSION['con'];

$req = "SELECT * FROM utilisateur WHERE IdUser = '{$_SESSION['IdUser']}'";
$User = mysqli_query($con,$req);

$reqTache = "SELECT * FROM tache";
$Tache = mysqli_query($con,$reqTache);

$Nom = "";
$Prenom = "";
$Statut = "";
$Mail = "";
$Nai ="";
$Gsm = "";

echo "
            <div class='input-group form-group'>";

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
                    <div class='d-flex flex-column'> <span class='articles' id='headcolor'>Email</span> <span class='number1'>$Mail</span> </div>
                    <div class='d-flex flex-column'> <span class='followers' id='headcolor'>Né le</span> <span class='number2'>$Nai</span> </div>
                    <div class='d-flex flex-column'> <span class='rating' id='headcolor'>Numéro</span> <span class='number3'>$Gsm</span> </div>
                </div>
            </div>
        </div></div></ul></div>";

include '../Views/Travailleur.html';

echo "<form method='post' action=" .$_SERVER['PHP_SELF'].">";

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
    <p><div class='d-flex flex-column'>Etat : $Fait</div></p>
    <div class='d-flex flex-column'><label id='check' for='checkbox_".$row['IdTache']."' for='todo'>Valider : 
        <input id='todo' value='todo' type='checkbox' name='checkbox_".$row['IdTache']."'></label></div>";

        while ($row = mysqli_fetch_assoc($MailClient))
        {
            echo "<p class='d-flex flex-column'>Demandée par ".$row['Email']."</p></div></div></li></div>";
        }

    }

}
else
{
    echo "<div class='containertodo centertodo'>
  <div class='cardtodo'>
    <h2><strong>Pas de tâches postées</strong></h2></div></div>";

}

echo"<button type='submit' id='work_btn' class='btn float-right login_btn' name='Effectuer'>Confirmer</button>";

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
            ob_clean();

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

