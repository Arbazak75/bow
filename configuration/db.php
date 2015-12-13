<?php

/*--------------------------------
| Configuration de la base donnee.
|---------------------------------
| On retourne la configuration
| des bases de donnees utilise par
| l'application.
*/
return (object) [
    // Fetch mode.
    "fetch" => PDO::FETCH_OBJ,
    // La base de donnee sur laquelle se connectera l'application
    // par defaut
    "connections" =>
    [
        "default" => [
            "scheme" => "mysql",
            "host" => "localhost",
            "user" => "test",
            "pass" => "papac1010",
            "dbname" => "test",
            "port" => "",
            "socket" => ""
        ],
        "other" => [
            "scheme" => "mysql",
            "host" => "localhost",
            "user" => "user name",
            "pass" => "passe word",
            "dbname" => "data base name",
            "port" => "sgbd port",
            "socket" => ""
        ]
    ]
];
