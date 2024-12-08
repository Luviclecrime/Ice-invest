<?php
// Connexion à la base de données (assurez-vous de remplacer les informations de connexion)
$pdo = new PDO('mysql:host=localhost;dbname=ice_invst', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer le nom de l'utilisateur connecté (exemple ici, ajustez selon votre logique)
$user_name = 'LUVIC'; // Exemple de nom d'utilisateur, à remplacer par la session ou l'input utilisateur

// Récupérer la liste des utilisateurs invités
$stmt = $pdo->prepare("SELECT u.nom, u.numero FROM users u JOIN parrainages p ON u.id = p.id_invite WHERE p.id_parrain = (SELECT id FROM users WHERE nom = :user_name)");
$stmt->execute(['user_name' => $user_name]);
$invites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Équipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
    <style>
        .container {
            margin-top: 50px;
            height:300px;
        }
        .invite-card {
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .highlight {
            color: #42a5f5;
            font-weight: bold;
        }
        .btn-copy {
            background-color: #42a5f5;
            color: white;
        }
        .btn-copy:hover {
            background-color: #1e88e5;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Vos Invités</h2>

    <?php if ($invites): ?>
        <div class="row">
            <?php foreach ($invites as $invite): ?>
                <div class="col-md-4">
                    <div class="card invite-card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($invite['nom']); ?></h5>
                            <p class="card-text">Numéro: <?php echo htmlspecialchars($invite['numero']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Vous n'avez pas encore invité d'utilisateur.</p>
    <?php endif; ?>

    <!-- Lien de parrainage -->
    <div class="text-center mt-4">
        <button class="btn btn-copy" onclick="copierLien()">Copier le Lien de Parrainage</button>
    </div>

    <p id="parrainageLien" class="text-center mt-2">
        <strong>https://monsite.com/<?php echo $user_name; ?></strong>
    </p>
</div>
<footer class='foot'>
    <a href="accueil.php" class="nav-link">accueil</a>
        <a href="projet.php" class="nav-link">revenu</a>
        <a href="roue_chanceux.php" class="nav-link">roue chanceux</a>
        <a href="equipe.php" class="nav-link">equipe</a>
        <a href="compte.php" class="nav-link">compte</a>
    </footer>

<script>
    // Copier le lien dans le presse-papiers
    function copierLien() {
        const lien = document.getElementById('parrainageLien').textContent;
        navigator.clipboard.writeText(lien).then(() => {
            alert("Lien copié avec succès !");
        }).catch(err => {
            alert("Erreur lors de la copie du lien : " + err);
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
