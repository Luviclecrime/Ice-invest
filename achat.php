<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Veuillez vous connecter.']);
    exit;
}

// Connexion à la base de données
$con = mysqli_connect("localhost", "root", "", "ice_invst");
if (!$con) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
    exit;
}

// Récupérer les données envoyées par la requête AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Vérification si 'pack_id' existe dans $data
if (!isset($data['pack_id']) || empty($data['pack_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de pack manquant.']);
    exit;
}

$pack_id = $data['pack_id'];
$user_id = $_SESSION['user_id'];

// Vérifier si le pack existe
$query = "SELECT * FROM packs WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $pack_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Pack introuvable.']);
    exit;
}

$pack = $result->fetch_assoc();
$prix_pack = $pack['prix'];

// Vérifier le solde de l'utilisateur
$query = "SELECT * FROM accounts WHERE id_utilisateur = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Compte introuvable.']);
    exit;
}

$account = $result->fetch_assoc();
$solde_actuel = $account['solde'];

if ($solde_actuel < $prix_pack) {
    echo json_encode(['success' => false, 'message' => 'Solde insuffisant.']);
    exit;
}

// Déduire le prix du pack et mettre à jour le solde
$nouveau_solde = $solde_actuel - $prix_pack;
$query = "UPDATE accounts SET solde = ? WHERE id_utilisateur = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("di", $nouveau_solde, $user_id);
$stmt->execute();

// Enregistrer l'investissement (achat du pack)
$query = "INSERT INTO investissement (id_projet, id_compte, montant_investi) VALUES (?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("iid", $pack_id, $account['id'], $prix_pack);
$stmt->execute();

// Retourner une réponse JSON
echo json_encode(['success' => true, 'message' => 'Achat effectué avec succès.']);
?>
