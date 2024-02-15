<?php

// Import des fonctions
require_once 'functions.php';

// Pour éviter de dupliquer le code, ce formulaire sera utiliser pour créer ou modifier un membre. Si l'url est appelée avec id= alors nous l'utiliserons pour éditer le membre avec l'id spécifié. 
if (isset($_GET['id'])) {
    // récupérer $id dans les paramètres d'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations du membre depuis la BDD pour remplir le formulaire
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $memberQuery pour récupérer les informations du membre
        $memberQuery = $db->prepare('SELECT * FROM members WHERE id= :id');
        // Exécuter la requête
        $memberQuery->execute(['id' => $id]);
        // Récupérer les données et les assigner à $member
        $member = $memberQuery->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
    // Fermer la connection à la BDD
    $memberQuery=null;
    $db=null;
}

// Récupérer les abos 
$abos = getAbos();

?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='abos.php' class='btn btn-secondary m-2 active' role='button'>Abos</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Member Form</h1>
</div>
<div class='row'>
    <form method='post' action='add-edit-member.php'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id' value='<?= $member['id'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='firstName'>Prénom</label>
            <input type='text' name='prenom' class='form-control' id='firstName' placeholder='Enter prénom' required autofocus value='<?= isset($member['prenom']) ? htmlentities($member['prenom']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='lastName'>Nom</label>
            <input type='text' name='nom' class='form-control' id='lastName' placeholder='Enter nom' required value='<?= isset($member['nom']) ? htmlentities($member['nom'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='adresse'>Adresse</label>
            <input type='text' name='adresse' class='form-control' id='adresse' placeholder='Enter adresse' required value='<?= isset($member['adresse']) ? htmlentities($member['adresse']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='adresse'>Type d'abo:</label>
            <!--  Générer une liste déroulante avec tous les abos disponibles -->
            <select class='custom-select' name='abo_id'>
                <?php foreach ($abos as $abo) : ?>
                    <option <?= (!empty($member['abo_id']) && $member['abo_id'] == $abo['id']) ? 'selected' : '' ?> value='<?= $abo['id'] ?>'>
                        <?= htmlentities($abo['titre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>

<?php require_once 'footer.php' ?>