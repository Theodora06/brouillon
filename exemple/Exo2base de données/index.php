<?php
$nom = "ap_nom";


//inclures les données des personnes
require_once "personnes.php";
//inclure le haut de page + afficher le titre de la page dans la balise <title>
include_once "includes/ap_header.php";
//inclure le corps de la page d'accueil
include_once "pages/ap_function.php";
//inclure le pied de page
include "includes/ap_footer.php";
?>