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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

    $errors = [];

    // Validation du numéro de téléphone
    if (!preg_match("/^[0-9]{9}$/", $number)) {
        $errors[] = "Le numéro de téléphone doit être composé de 9 chiffres.";
    }

    // Validation du mot de passe
    if ($password !== $password2) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($nom)) {
        $errors[] = "Le nom d'utilisateur est requis.";
    }

    // Si pas d'erreurs, procéder à l'enregistrement
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Vérifier si l'utilisateur existe déjà
        $query = "SELECT * FROM users WHERE numero = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Cet utilisateur existe déjà.";
        } else {
            // Insérer l'utilisateur dans la base de données
            $query = "INSERT INTO users (numero, nom, mots_de_pass) VALUES (?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("sss", $number, $nom, $hashed_password);

            if ($stmt->execute()) {
                echo "Inscription réussie!";
                header("Location: connexion.html");
                exit;
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
