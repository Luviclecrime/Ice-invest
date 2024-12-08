<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php");
    exit;
}

// Connexion à la base de données
$con = mysqli_connect("localhost", "root", "", "ice_invst");
if (!$con) {
    die("Erreur de connexion à la base de données.");
}

$user_id = $_SESSION['user_id'];

// Récupérer les projets en cours
$query = "SELECT p.nom, p.description, i.montant_investi, i.date_investissement
          FROM investissement i
          JOIN projets p ON i.id_projet = p.id
          JOIN accounts a ON i.id_compte = a.id
          WHERE a.id_utilisateur = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets en cours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: ivory;
        }
        .project-card {
            border: 1px solid #ddd;
            margin: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .no-project {
            text-align: center;
            font-size: 1.5rem;
            color: gray;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <h2>Vos Projets en cours</h2>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($projet = $result->fetch_assoc()): ?>
            <div class="project-card">
                <h3><?php echo htmlspecialchars($projet['nom']); ?></h3>
                <p><?php echo htmlspecialchars($projet['description']); ?></p>
                <p>Montant investi : <?php echo htmlspecialchars($projet['montant_investi']); ?> XAF</p>
                <p>Investi le : <?php echo htmlspecialchars($projet['date_investissement']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-project">
            Vous n'avez aucun projet en cours.
        </div>
    <?php endif; ?>
</body>
</html>
