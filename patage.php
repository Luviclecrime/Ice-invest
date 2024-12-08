<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_name'])) {
    header("Location: connect.php"); // Rediriger si non connecté
    exit;
}

// Récupérer le nom d'utilisateur depuis la session
$user_name = $_SESSION['user_name'];

// Construire le lien de parrainage
$lien_parrainage = "https://monsite.com/" . $user_name;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lien de Parrainage</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .parrainage-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .qr-code {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
        .btn-copy {
            background-color: #42a5f5;
            color: white;
        }
        .btn-copy:hover {
            background-color: #1e88e5;
        }
        .highlight {
            color: #ff5722;
            font-weight: bold;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrious/dist/qrious.min.js"></script>
</head>
<body>
<div class="container">
    <div class="parrainage-container">
        <h2 class="center-align">🌟 Devenez un Ambassadeur ! 🌟</h2>
        <p class="flow-text center-align">
            Invitez vos amis et profitez de <span class="highlight">récompenses exclusives</span> pour chaque parrainage !
        </p>

        <!-- QR Code -->
        <div class="qr-code">
            <canvas id="qrCode"></canvas>
        </div>

        <!-- Lien et bouton copier -->
        <p id="parrainageLien" class="center-align teal-text text-darken-2">
            <strong><?php echo $lien_parrainage; ?></strong>
        </p>
        <div class="center-align">
            <button class="waves-effect waves-light btn btn-copy" onclick="copierLien()">
                Copier le Lien
            </button>
        </div>

        <!-- Message motivant -->
        <div class="center-align" style="margin-top: 30px;">
            <h5 class="indigo-text">Pourquoi parrainer ?</h5>
            <p class="grey-text text-darken-1">
                Plus d'amis = plus de gains 💰 <br>
                Rejoignez notre communauté et bâtissez ensemble un avenir prospère !
            </p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    // Générer le QR Code
    const qr = new QRious({
        element: document.getElementById('qrCode'),
        value: "<?php echo $lien_parrainage; ?>", // Lien de parrainage
        size: 200, // Taille du QR Code
        background: 'white',
        foreground: '#42a5f5',
    });

    // Copier le lien dans le presse-papiers
    function copierLien() {
        const lien = document.getElementById('parrainageLien').textContent;
        navigator.clipboard.writeText(lien).then(() => {
            M.toast({html: "Lien copié avec succès ! 🎉"});
        }).catch(err => {
            alert("Erreur lors de la copie du lien : " + err);
        });
    }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
