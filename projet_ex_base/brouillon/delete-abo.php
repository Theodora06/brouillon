<?php
require_once 'functions.php';

// L'ID est-il dans les paramètres d'URL?
if (isset($_GET['id'])) {

    // Récupérer $id depuis l'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {

        // Connection à la BDD avec la fonction connect() dans functions.php
        $db = connect();

        // Avant de supprimer un abo, on vérifie qu'aucun membre ne l'utilise
        $aboQuery = $db->prepare('SELECT * FROM members WHERE abo_id = :id');
        // Execution de la requête
        $aboQuery->execute(['id' => $id]);
        // Assignation de l'information à $abo
        $abo = $aboQuery->fetch(PDO::FETCH_ASSOC);
        // Si un membre utilise l'abo, création d'une erreur et redirection sur la page des abos
        if ($abo) {
            $type = 'error';
            $message = 'L\'abo ne peut pas être supprimé car un membre l\'utilise';
        } else {
            // Aucun membre n'utilise l'abo, on peut le supprimer

            // Préparation de la requête pour supprimer l'abo correspondant à l'id
            $deleteAboStmt = $db->prepare('DELETE FROM abos WHERE id=:id');
            // Execution de la requête
            $deleteAboStmt->execute(['id' => $id]);
            // Vérification qu'une ligne a été impactée avec rowCount()
            if ($deleteAboStmt->rowCount()) {
                // La ligne a été détruite, on envoie un message de succès
                $type = 'success';
                $message = 'Abo supprimé';
            } else {
                // Aucune ligne n'a été impactée, on envoie un message d'erreur
                $type = 'error';
                $message = 'Abo non supprimé';
            }
        }
    } catch (Exception $e) {
        // Une exception a été levée, on affiche le message d'erreur
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Fermeture de la connexion à la BDD
    $aboQuery = null;
    $deleteAboStmt = null;
    $db = null;

    // Redirection vers la page principale des abos en passant le message et son type en variables GET
    header('location:' . 'abos.php?type=' . $type . '&message=' . $message);
} else {
    //Redirection vers l'Accueil
    header('location:' . 'index.php');
}