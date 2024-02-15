<?php

require_once 'functions.php';

if (!empty($_POST)) {
    // Récupération des champs du formulaire
    $titre = $_POST['titre'] ?? '';
    $prix = filter_input(INPUT_POST, 'prix', FILTER_SANITIZE_NUMBER_INT);

    // Création de l'objet BDD
    $db = connect();

    // Si un abo a un ID, il est déjà enregistré en BDD, donc on le met à jour, sinon on le crée.
    if (empty($_POST['id'])) {
        // L'abonnement n'est pas dans la BDD, on le crée
        try {
            // Préparation de la requête d'insertion
            $createAboStmt = $db->prepare('INSERT INTO abos (titre, prix) VALUES (:titre, :prix)');
            // Exécution de la requête
            $createAboStmt->execute(['titre'=>$titre, 'prix'=>$prix]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createAboStmt->rowCount()) {
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'Abo ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'Abo non ajouté';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Exception message: ' . $e->getMessage();
        }
    } else {
         // L'abonnement existe en BDD, on le met à jour
        // Récupération de l'ID de l'abo
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        try {
            // Préparation de la requête de mis à jour
            $updateAboStmt = $db->prepare('UPDATE abos SET titre=:titre, prix=:prix WHERE id=:id');
            // Exécution de la requête
           $updateAboStmt->execute(['titre'=>$titre, 'prix'=>$prix, 'id'=>$id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateAboStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Abo mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Abo non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Abo non mis à jour: ' . $e->getMessage();
        }
    }
    // Fermeture des connexions à la BDD
    $createAboStmt = null;
    $updateAboStmt = null;
    $db = null;

    // Redirection vers la page principale des abos en passant le message et son type en variables GET
    header('location:' . 'abos.php?type=' . $type . '&message=' . $message);
}