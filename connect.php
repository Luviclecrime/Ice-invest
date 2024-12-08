<?php

// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$password = "";
$database = "ice_invst";
$con = mysqli_connect($serveur, $utilisateur, $password, $database);

if (!$con) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs envoyées par le formulaire
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $password_input = isset($_POST['password']) ? $_POST['password'] : '';

    // Vérifier si le numéro de téléphone et le mot de passe sont renseignés
    if (empty($number) || empty($password_input)) {
        echo "Tous les champs sont requis.";
    } else {
        // Sécuriser la requête SQL
        $query = "SELECT * FROM users WHERE numero = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $number); // Bind du paramètre
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // L'utilisateur existe, vérifier le mot de passe
            $user = $result->fetch_assoc();
            if (password_verify($password_input, $user['mots_de_pass'])) {
                // Connexion réussie, démarrer une session et enregistrer les données de l'utilisateur
                session_start();
                $_SESSION['user_id'] = $user['id'];  // ID de l'utilisateur
                $_SESSION['user_name'] = $user['nom'];  // Nom de l'utilisateur
                $_SESSION['user_number'] = $user['numero']; 
                // Redirection vers la page de bienvenue
                header("Location: accueil.php");
                exit;
            } else {
                // Mot de passe incorrect
                echo "Identifiants incorrects.";
            }
        } else {
            // L'utilisateur n'existe pas
            echo "Identifiants incorrects.";
        }
    }
}
?>
