<?php

require_once 'functions.php';

if (!empty($_POST)) {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $abo_id = filter_input(INPUT_POST, 'abo_id', FILTER_SANITIZE_NUMBER_INT);

    // Connection à la BDD avec la fonction connect() dans functions.php
    $db = connect();

    // Un membre n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il  le membre a un ID.
    if (empty($_POST['id'])) {
         // S'il n'y a pas d'ID, le membre n'existe pas dans la BDD donc on l'ajoute.
         try {
            // Préparation de la requête d'insertion.
            $createMemberStmt = $db->prepare('INSERT INTO members (prenom, nom, adresse, abo_id) VALUES (:prenom, :nom, :adresse, :abo_id)');
            // Exécution de la requête
            $createMemberStmt->execute(['prenom'=>$prenom, 'nom'=>$nom, 'adresse'=>$adresse, 'abo_id'=>$abo_id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createMemberStmt->rowCount()) {
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'Membre ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'Membre non ajouté';
            }
        } catch (Exception $e) {
            // Le membre n'a pas été ajouté, récupération du message de l'exception
            $type = 'error';
            $message = 'Membre non ajouté: ' . $e->getMessage();
        }
    } else {
        // Le membre existe, on met à jour ses informations

        // Récupération de l'ID du membre
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        // Mise à jour des informations du membre
        try {
            // Préparation de la requête de mis à jour
            $updateMemberStmt = $db->prepare('UPDATE members SET prenom=:prenom, nom=:nom, adresse=:adresse, abo_id=:abo_id WHERE id=:id');
            // Exécution de la requête
           $updateMemberStmt->execute(['prenom'=>$prenom, 'nom'=>$nom, 'adresse'=>$adresse, 'abo_id'=>$abo_id, 'id'=>$id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateMemberStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Membre mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Membre non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Membre non mis à jour: ' . $e->getMessage();
        }
    }

    // Fermeture des connexions à la BDD
    $createMemberStmt = null;
    $updateMemberStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'members.php?type=' . $type . '&message=' . $message);
}