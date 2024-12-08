<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <script src="verification.js"></script>
</head>
<body>
    <div class="wrapper">
        <form action="insciption.php" method="POST" class="form-container">
            <div class="image">
                <img src="icone.jpg" alt="Logo" class="logo">
            </div>

            <u><b><h3>ICE-INVEST CMR</h3></b></u>

            <div class="container">
                <input type="number" name="number" id="number" placeholder="Saisissez un numéro de portable" required><br>
                <input type="text" name="nom" id="nom" placeholder="Votre nom d'utilisateur" required><br>
                <input type="password" name="password" id="password" placeholder="Saisissez votre mot de passe" required><br>
                <input type="password" name="password2" id="password2" placeholder="Confirmer votre mot de passe" required><br>
                <input type="submit" value="S'inscrire"><br>
            </div>
        </form>

        <div class="other-buttons">
        <a href="connexion.html">
    <button type="button">Se connecter</button>
</a>


            <input type="button" value="Télécharger l'application">
        </div>
    </div>
</body>
</html>
