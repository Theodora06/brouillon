<?php
if (!empty($_POST["nom"])){
    if preg_match("/a-zA-Z]+$",$_POST["nom"]){
        $servername= 'locahost';
        $dbname= 'ap_nom';
        $username= 'root';
        $password= '';
        $dsn="mysql:host=$servername;dbname=$dbname;
        $conn= new PDO ($dsn; $username; $password);
        return $conn;


        $query = $conn->prepare["SELECT * FROM nom where nom = :nom"];
        $query->execute([" :nom" => $nom]);
        
    } else {
        echo 'nom incorrect, le nom doit comporter uniquement des lettres';
    }
    }
}
?>