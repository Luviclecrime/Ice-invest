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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recharge Tarifs</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .button button {
            margin: 5px;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 8px;
        }

        .button button:hover {
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }

        .button .popular {
            background-color: red;
            color: white;
        }

        .solde h4 {
            color: green;
            font-weight: bold;
        }

        .recuperer input {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
        }

        .paye button {
            margin-top: 20px;
            padding: 15px 25px;
            font-size: 20px;
            border-radius: 8px;
            background-color: #28a745;
            color: white;
            border: none;
        }

        .paye button:hover {
            background-color: #218838;
            cursor: pointer;
        }

        .paye button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        ul {
            color: red;
            font-size: 16px;
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        /* Modal styles */
        .modal-content {
            text-align: center;
        }

        .modal-body img {
            width: 100px;
            height: 100px;
            margin: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">
        <h4 class="text-center">Tarifs de Recharge</h4>
        <div class="button text-center">
            <button onclick="setAmount(4000)">4 000 XAF</button>
            <button onclick="setAmount(5000)">5 000 XAF</button>
            <button onclick="setAmount(15000)">15 000 XAF</button><br>
            <button onclick="setAmount(20000)">20 000 XAF</button>
            <button onclick="setAmount(50000)" class="popular">50 000 XAF</button>
            <button onclick="setAmount(100000)">100 000 XAF</button><br>
            <button onclick="setAmount(7000)">7 000 XAF</button>
            <button onclick="setAmount(10000)">10 000 XAF</button><br>
        </div>

        <div class="solde text-center">
            <h5>Solde disponible: <h4 id="balance"><?php echo $solde; ?></h4> </h5>
        </div>

        <div class="recuperer">
            <input type="number" id="customAmount" placeholder="Personnalisez votre montant" oninput="setCustomAmount()">
        </div>

        <div class="paye text-center">
            <button id="pay-button" disabled data-toggle="modal" data-target="#paymentModal">Payer 0 XAF <i class="bi bi-credit-card"></i></button>
        </div>

        <div>
            <ul>Le montant minimum de recharge est de 4000 XAF</ul>
            <ul>soyez parmi les 40 premiers à effectuer une recharge et recevez 3% de bénéfice de la somme</ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Choisir la méthode de paiement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="mtn.png" alt="MTN" onclick="selectPayment('mtn')" style="cursor: pointer;">
                    <img src="orange-money-withdrawal-and-transfer-charges-update-.jpg" alt="Orange" onclick="selectPayment('orange')" style="cursor: pointer;">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let currentAmount = 0;

        // Set amount based on button click
        function setAmount(amount) {
            currentAmount = amount;
            document.getElementById("pay-button").disabled = false;
            document.getElementById("pay-button").innerText = `Payer ${currentAmount} XAF`;
        }

        // Set amount from custom input
        function setCustomAmount() {
            let customAmount = document.getElementById("customAmount").value;
            if (customAmount >= 4000) {
                currentAmount = customAmount;
                document.getElementById("pay-button").disabled = false;
                document.getElementById("pay-button").innerText = `Payer ${currentAmount} XAF`;
            } else {
                currentAmount = 0;
                document.getElementById("pay-button").disabled = true;
                document.getElementById("pay-button").innerText = `Payer 0 XAF`;
            }
        }

        // Redirect based on payment method selection
        function selectPayment(method) {
            if (method === 'mtn') {
                window.location.href = "mtn.php?amount=" + currentAmount;
            } else if (method === 'orange') {
                window.location.href = "orange.php?amount=" + currentAmount;
            }
        }
    </script>

</body>

</html>
