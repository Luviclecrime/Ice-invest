<?php
session_start();
$_SERVER = "localhost";
$user = "root";
$pass = "";
$db = "ice_invst";
$con = new mysqli($_SERVER, $user, $pass, $db);

if ($con->connect_error) {
    die("Erreur de connexion à la BD: " . $con->connect_error);
}

if (isset($_SESSION['ice H']) && $_SESSION['ice H'] === "ice H") {
    $compte = $_SESSION['compte'] ?? null;
    $montant = $_SESSION['montant'] ?? null;
    
    // Vérifier si le montant est valide
    if (!$compte || !$montant || !is_numeric($montant)) {
        echo "Erreur : informations utilisateur invalides.";
        exit;
    }

    // Vérification si le compte existe
    $stm = $con->prepare("SELECT id FROM ice_ivst WHERE name=?");
    $stm->bind_param("s", $_SESSION['ice H']);
    $stm->execute();
    $result = $stm->get_result();

    if ($result->num_rows > 0) {
        // Vérifier si l'utilisateur a assez de chances pour jouer
        $stm = $con->prepare("SELECT chances FROM utilisateurs WHERE compte=?");
        $stm->bind_param("s", $compte);
        $stm->execute();
        $stm->bind_result($chances);
        $stm->fetch();

        if ($chances > 0) {
            // Insérer un projet (exemple d'insertion)
            $stm = $con->prepare("INSERT INTO projets (id, nom, description, montant_necessaire, date_debut, date_fin) VALUES (?, ?, ?, NOW(), NOW(), NOW())");
            $stm->bind_param("sd", $compte, $montant);

            if ($stm->execute()) {
                echo "Félicitations ! Vous avez déposé " . number_format($montant, 0, '', '') . " XAF sur votre compte ID : " . htmlspecialchars($compte);
                // Réduire les chances après un tirage
                $newChances = $chances - 1;
                $stm = $con->prepare("UPDATE utilisateurs SET chances=? WHERE compte=?");
                $stm->bind_param("is", $newChances, $compte);
                $stm->execute();
            } else {
                echo "Erreur lors de l'enregistrement du dépôt.";
            }
        } else {
            echo "Vous n'avez pas assez de chances pour jouer. Veuillez inviter plus de personnes.";
        }
        $stm->close();
    } else {
        echo "Erreur pour l'ICE H.";
    }
} else {
    echo "Vous n'avez pas acheté ou sélectionné ICE H.";
}

$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>roue de la fortune</title>
    <link rel="stylesheet" href="roue.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
</head>
<body>

<h1>Roue de la Chance</h1>
  <div class="wheel-container">
    <div class="pointer"></div>
    <div class="wheel" id="wheel">
      <div class="wheel-text">
        <div class="segment-1">10 000 XAF</div>
        <div class="segment-2">5 000 XAF</div>
        <div class="segment-3">20 000 XAF</div>
        <div class="segment-4">2 000 XAF</div>
        <div class="segment-5">15 000 XAF</div>
        <div class="segment-6">1 000 XAF</div>
        <div class="segment-7">50 000 XAF</div>
        <div class="segment-8">10 000 XAF</div>
      </div>
    </div>
  </div>
  <div class="regles">
    <h3>chances:0</h3>
    <h1>regles pour jouer a la lotterie:</h1> <br>
    <ul>
    <li>inviter 2personnes a investir dans le ice CF</li>
    <li>les personne inviter sont accumuler donc 4personne=>2tours de tirages</li>
    <li>achetez vous meme un ice H (si vous ne parrainr pas de personnes)</li>
    </ul>
 
  <button onclick="spinWheel()">Tourner la roue</button>
  <p id="result"></p>
  </div>
 
  <script>
     const wheel = document.getElementById('wheel');
    const result = document.getElementById('result');
    const segments = [
      '10 000 XAF', '5 000 XAF', '20 000 XAF',
      '2 000 XAF', '15 000 XAF', '1 000 XAF',
      '50 000 XAF', '10 000 XAF'
    ];

    let spinning = false;

    function spinWheel() {
      if(spinning) return; // Empêche le lancement multiple
      spinning = true;
      result.textContent = '';

      const randomIndex = Math.floor(Math.random() * segments.length);
      const randomDeg = 360 * 3 + randomIndex * (360 / segments.length);

      wheel.style.transform = `rotate(${randomDeg}deg)`;

      setTimeout(() =>LUVIC {
        const winningSegment = segments[randomIndex];
        result.textContent = `Félicitations ! Vous avez gagné ${winningSegment}`;
        spinning = false;
      }, 4000);
    }
  </script>
</body>
</html>