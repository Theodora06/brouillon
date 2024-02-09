<?php

// Import de functions.php
require_once("functions.php");
try {
    // Récupération des abos avec la fonction getAbos() définie dans functions.php
 $abos=getAbos();
} catch (Exception $e) {
    // Afficher le message en cas d'envoi d'exception
    echo $e->getMessage();
}

?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='members.php' class='btn btn-secondary m-2 active' role='button'>Members</a>

<?php if (!empty($_GET['type']) && ($_GET['type'] === 'success')) : ?>
    <div class='row'>
        <div class='alert alert-success'>
            Succès! <?= $_GET['message'] ?>
        </div>
    </div>
<?php elseif (!empty($_GET['type']) && ($_GET['type'] === 'error')) : ?>
    <div class='row'>
        <div class='alert alert-danger'>
            Erreur! <?= $_GET['message'] ?>
        </div>
    </div>
<?php endif; ?>
<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Abos</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Titre</th>
                <th scope='col'>Prix</th>
                <th scope='col'>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($abos as $abo) : ?>
                <tr>
                    <td><?= $abo['id'] ?></td>
                    <td><?= htmlentities($abo['titre']) ?></td>
                    <td><?= $abo['prix'] ?></td>
                    <td>
                        <a class='btn btn-primary' href='abo-form.php?id=<?= $abo['id'] ?>' role='button'>Modifier</a>
                        <a class='btn btn-danger' href='delete-abo.php?id=<?= $abo['id'] ?>' role='button'>Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='abo-form.php' role='button'>Ajouter abo</a>
    </div>
</div>

<?php require_once 'footer.php' ?>