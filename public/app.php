<?php

/*-------------------------------------------------------
|
|	Chargement des configurations
|	Chargement des principaux fichier de l'application
|
*/
require dirname(__DIR__) . "/vendor/autoload.php";

require_once dirname(__DIR__) . "/vendor/bow/framework/src/BowAutoload.php";
\Bow\BowAutoload::register();

// Creation de l'application
$app = Bow\Core\Application::configure(configuration());

// Chargement des routeurs.
require dirname(__DIR__) . "/app/Router/routes.php";

// Lancement de l'application
$app->run();