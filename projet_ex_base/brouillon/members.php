<?php

require_once 'functions.php';

// Création d'un bloc try/catch pour gérer les exceptions de la BDD
try {
    // Connection à la BDD
    $db = connect();

    // Création de $membersQuery. On utilise inner join pour récupérer les titres d'abo
    $membersQuery = $db->query('SELECT members.*, abos.titre FROM members INNER JOIN abos ON members.abo_id = abos.id');
    // Récupération de tous les membres et assignation à $members
    $members = $membersQuery->fetchAll(PDO::FETCH_ASSOC);;

} catch (Exception $e) {
    // Affiche le message en cas d'exception
    echo $e->getMessage();
}

// Fermeture de la connexion à la BDD
$db=null;
?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='abos.php' class='btn btn-secondary m-2 active' role='button'>Abos</a>

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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Membres</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Prénom</th>
                <th scope='col'>Nom</th>
                <th scope='col'>Adresse</th>
                <th scope='col'>Abo</th>
                <th scope='col'>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member) : ?>
                <tr>
                    <td><?= $member['id'] ?></td>
                    <td><?= htmlentities($member['prenom']) ?></td>
                    <td><?= htmlentities($member['nom']) ?></td>
                    <td><?= htmlentities($member['adresse']) ?></td>
                    <td><?= htmlentities($member['titre']) ?></td>
                    <td>
                        <a class='btn btn-primary' href='member-form.php?id=<?= $member['id'] ?>' role='button'>Modifier</a>
                        <a class='btn btn-danger' href='delete-member.php?id=<?= $member['id'] ?>' role='button'>Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='member-form.php' role='button'>Ajouter membre</a>
    </div>
</div>

<?php require_once 'footer.php' ?>