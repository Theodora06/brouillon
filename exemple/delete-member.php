<?php
require_once 'functions.php';

// L'ID est-il dans les paramètres d'URL?
if (isset($_GET['id'])) {

    // Récupérer $id depuis l'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Connection à la BDD avec la fonction connect() dans functions.php
        $db = connect();

        // Préparation de la requête pour supprimer le membre correspondant à l'id
        $deleteMemberStmt = $db->prepare('DELETE FROM members WHERE id=:id');
        // Execution de la requête
        $deleteMemberStmt->execute(['id' => $id]);
    
        // Vérification qu'une ligne a été impactée avec rowCount()
        if ($deleteMemberStmt->rowCount()) {
            // La ligne a été détruite, on envoie un message de succès
            $type = 'success';
            $message = 'Membre supprimé';
        } else {
            // Aucune ligne n'a été impactée, on envoie un message d'erreur
            $type = 'error';
            $message = 'Membre non supprimé';
        }

    } catch (Exception $e) {
        // Une exception a été levée, on affiche le message d'erreur
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Fermeture de la connexion à la BDD
    $deleteMemberStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'members.php?type=' . $type . '&message=' . $message);
} else {
    //Redirection vers l'Accueil s'il n'y a pas d'ID membre 
    header('location:'. 'index.php');
}