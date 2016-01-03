<?php

// -----------------------------------------------------------------
// Chargement des configurations
// -----------------------------------------------------------------
// Chargement des principaux fichier de l'application
// -----------------------------------------------------------------

require dirname(__DIR__) . "/vendor/autoload.php";
$config = require dirname(__DIR__) . "/configuration/bootstrap.php";

// Creation de l'application
$app = \Snoop\Core\Application::loader($config->init);

require "Http/Router/index.php";

// Lancement de l'application
$app->run();

return $app;
