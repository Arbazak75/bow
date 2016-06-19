<?php
/*
|-------------------------------------------------------
|	CHARGEMENT DES CONFIGURATIONS
|	CHARGEMENT DES PRINCIPAUX FICHIERS DE L'APPLICATION BOW
*/
require_once __DIR__ . "/../vendor/autoload.php";

// Création de l'application
$app = Bow\Core\Application::configure(config());

// Chargement des routeurs.
require __DIR__ . "/../app/routes.php";

// Lancement de l'application
$app->run();