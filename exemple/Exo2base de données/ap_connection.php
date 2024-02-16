<?php

// Connection à la base de données et renvoie l'objet PDO
function connect() {
    // hôte
    $hostname = 'localhost';

    // nom de la base de données
    $dbname = 'ap_nom.sql';

    // identifiant et mot de passe de connexion à la BDD
    $username = 'root';
    $password = '';
    
    $dsn ="mysql:host=$hostaname;dbname=$dbname";
    
    try{
       return new PDO ($dsn, $username,$password];) 
     } catch (Exception $e) {
        // Afficher le message en cas d'envoi d'exception
        echo $e->getMessage();
    }

     
?>