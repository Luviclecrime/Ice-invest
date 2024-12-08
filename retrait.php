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
    $user_name = $_SESSION['user_name'];
    $user_number = $_SESSION['user_number']; // Supposons que le numéro de l'utilisateur est stocké dans la session
} else {
    // Si aucun compte n'existe, créer un compte avec un solde de 1000 XAF
    $solde = 1000;
    $insert_query = "INSERT INTO accounts (id_utilisateur, solde) VALUES (?, ?)";
    $insert_stmt = $con->prepare($insert_query);
    $insert_stmt->bind_param("id", $user_id, $solde);
    $insert_stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Retrait</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 50px;
        }

        .account-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            font-size: 18px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .withdraw-btn {
            background-color: #28a745;
            color: white;
        }

        .withdraw-btn:hover {
            background-color: #218838;
        }

        .info {
            margin-top: 20px;
        }

        .info h4 {
            color: green;
            font-weight: bold;
        }

        .icon {
            margin-top: 20px;
        }

        .modal-content {
            background-color: #f8d7da;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
        }

        .message-container {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            display: none;
            margin-top: 20px;
        }
        a{
            color:white;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Bouton de vérification -->
        <button class="btn btn-custom btn-block" onclick="verifyAccount()">Vérifier votre compte</button>

        <!-- Div d'informations du compte -->
        <div id="accountInfo" class="account-info" style="display: none;">
            <h3>Informations sur votre compte</h3>
            <p><strong>ID Utilisateur:</strong> <span id="userId"></span></p>
            <p><strong>Numéro:</strong> <span id="userNumber"></span></p>
            <p><strong>Solde:</strong> <span id="userBalance"></span> XAF</p>
        </div>

        <!-- Formulaire de retrait -->
        <div class="account-info">
            <h4>Demander un retrait</h4>

            <!-- Champ de texte pour donner des informations supplémentaires -->
            <textarea class="form-control mb-3" placeholder="Donner quelques infos sur le compte du récepteur" rows="4" id="accountInfoInput"></textarea>

            <!-- Champ pour entrer la somme -->
            <input type="number" class="form-control mb-3" placeholder="Saisissez la somme à retirer" id="amountInput">

            <!-- Message d'erreur en cas de solde insuffisant -->
            <div id="errorMessage" class="alert-error" style="display: none;"></div>

            <!-- Bouton de retrait -->
            <button class="btn withdraw-btn btn-lg" onclick="showModal()">Retrait</button>
        </div>

        <!-- Modal de confirmation de retrait -->
        <div class="modal" tabindex="-1" role="dialog" id="confirmModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation de retrait</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Vous êtes sur le point de retirer <span id="withdrawAmount"></span> XAF. Voulez-vous confirmer ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                        <button type="button" class="btn btn-primary" onclick="processWithdrawal()">Oui</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Div pour afficher les annonces toutes les 15 secondes -->
        <div id="messageContainer" class="message-container">
            <p id="messageContent"></p>
        </div>

        <div class="info text-center">
            <h4>Numéro de téléphone: 654568728</h4>
            <button class="btn btn-info" onclick="copyNumber()"><a href="recharge.php">Copier le numéro</a></button>
        </div>

        <div class="icon text-center">
            <a href="accueil.php" class="btn btn-secondary">Retour</a>
        </div>
        <div>
            <ul>
                <li>les retrail ce fonts tout les jours</li>
                <li> pas de frais de retrait</li>
                <li>cretiter dans les 30min apres la demande</li>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Fonction pour afficher les informations du compte
        function verifyAccount() {
            document.getElementById('userId').textContent = "<?php echo $user_id; ?>";
            document.getElementById('userNumber').textContent = "<?php echo $user_number; ?>";
            document.getElementById('userBalance').textContent = "<?php echo $solde; ?>";
            document.getElementById('accountInfo').style.display = 'block';
        }

        // Fonction pour afficher le modal
        function showModal() {
            var amount = document.getElementById('amountInput').value;
            var solde = "<?php echo $solde; ?>"; // Solde de l'utilisateur

            // Réinitialiser le message d'erreur
            document.getElementById('errorMessage').style.display = 'none';
            
            if (amount === "" || amount <= 0) {
                alert("Veuillez entrer un montant valide.");
                return;
            }

            // Vérification du solde
            if (parseInt(amount) > parseInt(solde)) {
                // Affichage du message d'erreur si le solde est insuffisant
                document.getElementById('errorMessage').style.display = 'block';
                document.getElementById('errorMessage').innerHTML = "Votre solde est inférieur à la somme entrée.";
                return;
            }

            document.getElementById('withdrawAmount').textContent = amount;
            $('#confirmModal').modal('show');
        }

        // Fonction pour traiter le retrait
        function processWithdrawal() {
            var amount = document.getElementById('amountInput').value;
            var solde = "<?php echo $solde; ?>"; // Solde de l'utilisateur

            // Si le solde est insuffisant
            if (parseInt(amount) > parseInt(solde)) {
                alert("Désolé, vous devez effectuer un dépôt initial dans la plateforme avant d'effectuer toute transaction.");
            } else {
                alert("Désolé, vous devez effectuer un dépôt initial dans la plateforme avant d'effectuer toute transaction.");
                location.reload(); // Recharge la page après le retrait
            }

            $('#confirmModal').modal('hide'); // Ferme le modal
        }

        // Fonction pour copier le numéro de téléphone
        function copyNumber() {
            var copyText = document.createElement("textarea");
            copyText.value = "654568728"; // Numéro de téléphone à copier
            document.body.appendChild(copyText);
            copyText.select();
            document.execCommand("copy");
            document.body.removeChild(copyText);
            alert("Numéro copié: " + copyText.value);
        }

        // Messages à afficher dans la div message-container
        var messages = [
            "1: Le retrait minimal est de 1000XAF.",
            "2: Effectuez vos retraits 24h/24 et 7J/7.",
            "3: Effectuez vos retraits sans frais de retrait."
        ];

        var currentMessage = 0;

        // Fonction pour afficher un message dans la div
        function showMessages() {
            var message = messages[currentMessage];
            document.getElementById('messageContent').textContent = message;
            document.getElementById('messageContainer').style.display = 'block'; // Affiche la div
            currentMessage++;
            if (currentMessage >= messages.length) {
                currentMessage = 0; // Redémarre les messages
            }
        }

        // Affichage des messages toutes les 15 secondes
        setInterval(showMessages, 15000); // 15000 ms = 15 secondes
    </script>
</body>

</html>
