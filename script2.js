function acheterPack(packId) {
    console.log("Pack ID envoyé :", packId); // Vérifie la valeur de packId
    if (!packId) {
        alert("Pack ID manquant.");
        return;
    }

    fetch("acheter_pack.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ pack_id: packId })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(error => console.error("Erreur :", error));
}
