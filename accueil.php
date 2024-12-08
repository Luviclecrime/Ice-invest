<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php"); // Rediriger vers la page de connexion si non connecté
    exit;
}

// Récupérer le nom de l'utilisateur depuis la session
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec barre de navigation</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
    <style>
        /* Style pour le modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            text-align: center;
        }
        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover, .close:focus {
            color: darkred;
            text-decoration: none;
            cursor: pointer;
        }
        .go{
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar">
        <a href="recharge.php" class="nav-link">Recharger</a>
        <a href="retrait.php" class="nav-link">Retirer</a>
        <a href="patage.php" class="nav-link">Partager</a>
        <a href="https://t.me/iceinvestcom" class="nav-link">Canal</a>
    </nav>

    <!-- Section d'accueil -->
    <div class="bienvenu">
        <h3>Bienvenue <?php echo $user_name; ?> !</h3>
    </div>
    <div class="annonce">
       <marquee behavior="" direction=""> lencer-vous dans ice_invest <br>
         avec un capitale de 1000XAF offert par l'entreprise </marquee>
    </div>
    <!-- Packs -->
    <div class="paquet1" name="pack1">
        <img src="ice1.jpeg">
        <div class="detaille">
            <h5>ice A</h5>
            <h6>prix : <h7>7000Xaf</h7></h6>
            <h6>duree :<h7> 20 jours</h7></h6>
            <h6>revenu :<h7> 650Xaf/j</h7></h6>
            <h6>revenu total : <h7>13000Xaf</h7></h6>
        </div>
    </div>
    <div class="achat">
        <button onclick="showModal()"  class="go">Acheter le pack gratuit</button>
    </div>

    <!-- Modal -->
    <div id="modalSoldeInsuffisant" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Solde Insuffisant</h3>
            <p>Vous n'avez pas assez de solde pour acheter ce pack. Veuillez recharger votre compte pour continuer.</p>
            <button onclick="closeModal()">Fermer</button>
        </div>
    </div>
    <div class="paquet1" name="pack2">
        <img src="ice7.jpeg">
        <div class="detaille">
            <h5>ice D</h5>
            <h6>prix : <h7>5000Xaf<h4></h4></h7>
            </h6>
            <h6>duree : <h7>20days</h7>
            </h6>
            <h6>revenu : <h7>500Xaf/j</h7>
            </h6>
            <h6>revenu totale : <h7>10 000Xaf/j</h7>
            </h6>
        </div>

    </div>
    <div class="achat">
        <button onclick="showModal()"  class="go"><i>acheter le pack</i></button>
    </div>
    <div class="paquet1" name="pack3">
        <img src="ice2.jpeg">
        <div class="detaille">
            <h5>ice CF</h5>
            <h6>prix : <h7>10 000Xaf<h4></h4></h7>
            </h6>
            <h6>duree : <h7>20days</h7>
            </h6>
            <h6>revenu : <h7>900Xaf/j</h7>
            </h6>
            <h6>revenu totale : <h7>19 000Xaf/j</h7>
            </h6>
        </div>

    </div>
    <div class="achat">
        <button onclick="showModal()"  class="go"><i>acheter le pack</i></button>
    </div>
    <div class="paquet1" name="pack4">
        <img src="ice3.jpeg">
        <div class="detaille">
            <h5>ice H</h5>
            <h6>prix : <h7>15 000Xaf<h4></h4></h7>
            </h6>
            <h6>duree : <h7>20days</h7>
            </h6>
            <h6>revenu : <h7>1 200Xaf/j</h7>
            </h6>
            <h6>revenu totale : <h7>24 000Xaf/j</h7>
            </h6>
        </div>

    </div>
    <div class="achat">
        <button onclick="showModal()"  class="go"><i>acheter le pack</i></button>
    </div>
    <div class="paquet1" name="pack5">
        <img src="ice1.jpeg">
        <div class="detaille">
            <h5>ice G</h5>
            <h6>prix : <h7>40 000Xaf<h4></h4></h7>
            </h6>
            <h6>duree : <h7>20days</h7>
            </h6>
            <h6>revenu : <h7>3 500Xaf/j</h7>
            </h6>
            <h6>revenu totale : <h7>70 000Xaf/j</h7>
            </h6>
        </div>

    </div>
    <div class="achat">
        <button onclick="showModal()"  class="go"><i>acheter le pack</i></button>
    </div>
    <div class="paquet1" name="pack6">
        <img src="ice4.jpeg">
        <div class="detaille">
            <h5>ice V</h5>
            <h6>prix : <h7>50 000Xaf<h4></h4></h7>
            </h6>
            <h6>duree : <h7>20days</h7>
            </h6>
            <h6>revenu : <h7>4 000Xaf/j</h7>
            </h6>
            <h6>revenu totale : <h7>80 000Xaf/j</h7>
            </h6>
        </div>

    </div>
    <div class="achat">
        <button onclick="showModal()"  class="go"><i>acheter le pack</i></button>
    </div>
    <div class="paquet1" name="pack7">
        <img src="ice12.jpeg">
        <div class="detaille">
            <h5>ice V+</h5>
            <h6>prix : <h7>80 000Xaf<h4></h4></h7>
            </h6>
            <h6>duree : <h7>20days</h7>
            </h6>
            <h6>revenu : <h7>5 000Xaf/j</h7>
            </h6>
            <h6>revenu totale : <h7>100 000Xaf/j</h7>
            </h6>
        </div>

    </div>
    <div class="achat">
        <button onclick="showModal()"  class="go"><i>acheter le pack</i></button>
    </div>
    <div class="paquet1" name="pack9">
        <img src="ice8.jpeg">
        <div class="detaille">
            <h5>ice A</h5>
            <h6>prix : <h7>120 000Xaf<h4></h4></h7>
            </h6>
            <h6>duree : <h7>20days</h7>
            </h6>
            <h6>revenu : <h7>10 000Xaf/j</h7>
            </h6>
            <h6>revenu totale : <h7>200 000Xaf/j</h7>
            </h6>
        </div>

    </div>
    <div class="achat">
        <button onclick="showModal()" class="go"><i>acheter le pack</i></button>
    </div>
    <footer class='foot'>
    <a href="accueil.php" class="nav-link">accueil</a>
        <a href="projet.php" class="nav-link">revenu</a>
        <a href="roue_chanceux.php" class="nav-link">roue chanceux</a>
        <a href="equipe.php" class="nav-link">equipe</a>
        <a href="compte.php" class="nav-link">compte</a>
    </footer>
    <!-- Scripts -->
    <script>
        // Fonction pour afficher le modal
        function showModal() {
            document.getElementById('modalSoldeInsuffisant').style.display = 'block';
        }

        // Fonction pour fermer le modal
        function closeModal() {
            document.getElementById('modalSoldeInsuffisant').style.display = 'none';
        }
    </script>
</body>
</html>
