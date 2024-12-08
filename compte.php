<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php"); // Rediriger vers la page de connexion si non connecté
    exit;
}

// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$password = "";
$database = "ice_invst";
$con = mysqli_connect($serveur, $utilisateur, $password, $database);

if (!$con) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupérer l'ID de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];

// Vérifier si un compte existe pour cet utilisateur
$query = "SELECT * FROM accounts WHERE id_utilisateur = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Si un compte existe, récupérer le solde
if ($result->num_rows > 0) {
    $account = $result->fetch_assoc();
    $solde = $account['solde'];
} else {
    // Si aucun compte n'existe, créer un compte avec un solde de 1000 XAF
    $solde = 1000;
    $insert_query = "INSERT INTO accounts (id_utilisateur, solde) VALUES (?, ?)";
    $insert_stmt = $con->prepare($insert_query);
    $insert_stmt->bind_param("id", $user_id, $solde);
    $insert_stmt->execute();
}

// Récupérer le numéro de l'utilisateur depuis la session
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page du compte</title>
    <!-- Intégration de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: ivory;
        }
        .image-container {
            width: 100px;
            height: 100px;
            background-color: #ddd;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }
        .image-container img {
            width: 100%;
            height: auto;
        }
        .card {
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .icon {
            font-size: 1.5rem;
            color: #007bff;
        }
        .custom-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }
        .custom-btn:hover {
            background-color: #f8f9fa;
        }
        .modal-content {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex align-items-center mb-4">
            <!-- Image de l'utilisateur -->
            <div class="image-container">
                <img src="icone.jpg" alt="Photo de profil">
            </div>
            <!-- Message de bienvenue -->
            <h3 class="mb-0">Salut, <?php echo $user_name; ?> !</h3>
        </div>

        <!-- Solde -->
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title">Solde</h4>
                <p class="card-text fw-bold text-success"><?php echo $solde; ?> XAF</p>
            </div>
        </div>

        <!-- Dossier de retrait -->
        <div class="card mt-4">
            <div class="card-body custom-btn" data-bs-toggle="modal" data-bs-target="#retraitModal">
                <span><i class="bi bi-folder icon"></i> Dossier de Retrait</span>
                <i class="bi bi-arrow-right-circle"></i>
            </div>
        </div>

        <!-- Dossier de recharge -->
        <div class="card mt-3">
            <div class="card-body custom-btn" data-bs-toggle="modal" data-bs-target="#rechargeModal">
                <span><i class="bi bi-folder-plus icon"></i> Dossier de Recharge</span>
                <i class="bi bi-arrow-right-circle"></i>
            </div>
        </div>

        <!-- Service client -->
        <div class="card mt-3">
    <div class="card-body">
        <a href="https://t.me/Lyla9999999" class="text-decoration-none d-flex align-items-center" target="_blank" rel="noopener noreferrer">
            <span><i class="bi bi-headset icon"></i> Service Client</span>
            <i class="bi bi-arrow-right-circle ms-auto"></i>
        </a>
       
    </div>
</div>

    <!-- Modals -->
    <div class="modal fade" id="retraitModal" tabindex="-1" aria-labelledby="retraitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="retraitModalLabel">Dossier de Retrait</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Aucun retrait effectué pour le moment.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rechargeModal" tabindex="-1" aria-labelledby="rechargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rechargeModalLabel">Dossier de Recharge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Aucune recharge effectuée pour le moment.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
