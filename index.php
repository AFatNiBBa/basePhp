
<?php

/*
    v40
    Fatto.
*/

session_start();
include __DIR__ . "/utils/global.php";

try
{
    //| Inizializzazione
    global $db, $page, $localhost, $altervista;
    $localhost = in_array($_SERVER["SERVER_ADDR"], [$cell = "0.0.0.0", "127.0.0.1", "::1"]);
    $localhost += $_SERVER["SERVER_ADDR"] == $cell;
    $page = rtrim(preg_replace("/\.\.\//", "", $_GET["page"] ?? ""), '/');
    $db = new Cacher([
        "host" => $localhost != 2
            ? "localhost"
            : $cell,
        "pass" => $localhost
            ? ($localhost == 2
                ? "root"
                : "")
            : "",
        "user" => $localhost
            ? "root"
            : $altervista,
        "db" => $localhost
            ? "a"
            : "my_$altervista"
    ]);
    
    //| Reindirizzamento
    assemble("/private/template/base", [ "page" => "/$page" ]);
}
catch (Exception $e)
{
    echo $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
    // throw $e;
}