<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url("orange-money-withdrawal-and-transfer-charges-update-.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            height: 100vh;
        }

        .televersement {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-image: url("IMG-20241124-WA0080.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            height: 80vh;
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .televersement input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .televersement input[type="button"], .televersement input[type="file"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-top: 10px;
            border-radius: 8px;
            background-color: #007bff;
            color: white;
            border: none;
        }

        .televersement input[type="button"]:hover, .televersement input[type="file"]:hover {
            background-color: #0056b3;
            cursor: pointer;
        }

        .televersement input[type="button"]:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        #imagePreview {
            margin-top: 20px;
            width: 100%;
            height: auto;
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Flèche stylée pour revenir en arrière */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 30px;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .success-message {
            display: none;
            margin-top: 20px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-align: center;
        }

        /* Div en bas contenant les informations du compte */
        .account-info {
            margin-top: 50px;
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 10px;
        }

        .account-info .info-text {
            margin-bottom: 15px;
        }

        .account-info button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .account-info button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Flèche pour revenir en arrière avec Bootstrap -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="televersement">
        <h4 class="mb-4 text-white">Téléverser votre transaction</h4>

        <!-- Formulaire avec méthode POST -->
        <form id="transactionForm">
            <!-- Champ de saisie pour l'ID de la transaction -->
            <input type="text" class="form-control" placeholder="Saisissez l'ID de la transaction" name="transactionId" id="transactionId" required>

            <!-- Bouton pour soumettre -->
            <input type="button" value="Soumettre" id="submitBtn" onclick="submitTransaction()">

            <!-- Champ pour télécharger la capture d'écran -->
            <input type="file" name="fileInput" id="fileInput" accept="image/*" onchange="previewImage(event)">

            <!-- Div pour afficher l'image sélectionnée -->
            <div id="imageContainer">
                <img id="imagePreview" src="" alt="Aucune image sélectionnée">
            </div>
        </form>

        <!-- Message de succès -->
        <div class="success-message" id="successMessage">
            Soumission avec succès ! Veuillez patienter.
        </div>
    </div>

    <!-- Div contenant les informations du compte et bouton pour copier -->
    <div class="account-info">
        <p class="info-text">Numéro de téléphone: <strong>654568728</strong></p>
        <p class="info-text">Nom du compte: <strong>Christian Romain Kenfack</strong></p>
        <button id="copyButton" onclick="copyPhoneNumber()">Copier le numéro</button>
    </div>

    <!-- Bootstrap JS, Popper.js, jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- FontAwesome pour les icônes -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- EmailJS SDK -->
    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>

    <script>
        // Initialisation d'EmailJS avec votre user_id
        emailjs.init("user_your_user_id");  // Remplacez "user_your_user_id" par votre ID EmailJS

        // Fonction pour prévisualiser l'image
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Fonction pour soumettre la transaction et envoyer un email
        function submitTransaction() {
            var transactionId = document.getElementById('transactionId').value;
            var userName = "Nom d'utilisateur";  // Remplacer par une variable dynamique de session utilisateur

            if (transactionId.trim() === "") {
                alert("Veuillez entrer un ID de transaction valide.");
                return;
            }

            // Utiliser EmailJS pour envoyer l'email
            var templateParams = {
                transactionId: transactionId,
                userName: userName
            };

            emailjs.send("your_service_id", "your_template_id", templateParams)
                .then(function(response) {
                    console.log("Email envoyé avec succès", response);
                    document.getElementById("successMessage").style.display = "block";  // Affiche le message de succès
                    setTimeout(function() {
                        document.getElementById("successMessage").style.display = "none";  // Cache après 5 secondes
                        location.reload();  // Actualise la page
                    }, 3000);
                }, function(error) {
                    console.error("Erreur lors de l'envoi de l'email", error);
                    alert("Une erreur est survenue, veuillez réessayer.");
                });
        }

        // Fonction pour copier le numéro de téléphone
        function copyPhoneNumber() {
            var phoneNumber = "654568728";
            navigator.clipboard.writeText(phoneNumber).then(function() {
                alert("Numéro copié : " + phoneNumber);
            }, function(err) {
                alert("Erreur lors de la copie : " + err);
            });
        }
    </script>

</body>
</html>
