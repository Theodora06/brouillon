<?php

// Import des fonctions
require_once 'functions.php';

// Pour éviter de dupliquer le code, ce formulaire sera utiliser pour créer ou modifier un abo. Si l'url est appelée avec id= alors nous l'utiliserons pour éditer l'abo avec l'id spécifié. 
if (isset($_GET['id'])) {
    // récupérer $id dans les paramètres d'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations de l'abo depuis la BDD pour remplir le formulaire
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $aboQuery pour récupérer les informations de l'abo
        $aboQuery = $db->prepare('SELECT * FROM abos WHERE id= :id');
        // Exécuter la requête
        $aboQuery->execute(['id' => $id]);
        // Récupérer les données et les assigner à $abo
        $abo = $aboQuery->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }

    // Fermer la connection à la BDD
    $aboQuery=null;
    $db=null;
}

// Récupérer les abos 
$abos = getAbos();

?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='abos.php' class='btn btn-secondary m-2 active' role='button'>Abos</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Abo Form</h1>
</div>
<div class='row'>
    <form method='post' action='add-edit-abo.php'>
        <!--  Ajouter un champs cacher avec l'ID (s'il existe) pour qu'il soit envoyé avec le formulaire -->
        <input type='hidden' name='id' value='<?= $abo['id'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='firstName'>Titre</label>
            <input type='text' name='titre' class='form-control' id='titre' placeholder='Enter titre' required autofocus value='<?= isset($abo['titre']) ? htmlentities($abo['titre']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='prix'>Prix</label>
            <input type='number' name='prix' class='form-control' id='prix' placeholder='Enter prix' required value='<?= isset($abo['prix']) ? htmlentities($abo['prix'])  : '' ?>'>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Envoyer</button>
    </form>
</div>

<?php require_once 'footer.php' ?>