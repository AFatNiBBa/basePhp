
<?php

/*
    v30
    [***]: Aggiungi supporto per i sottodomini, dato che viene lasciato se lo cerchi ed agisce come il sito normale
    [***]: Miglioramento percorso relativo lato client (£::hash e altri problemi con <base> (inplementa un PATH come sul cmd))
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
    
    //| Reindirizzamento; Mette il template se non è in "plain/" o c'è ma non esiste; Da errore se prova ad accedere a "private/"
    if (
        ($temp = preg_match("/^private\/.+/", $page)) ||
        !preg_match("/^plain\/.+/", $page) ||
        !assemble("/$page", [], "")
    ) assemble("/private/template/base", $temp ? [ "page" => "/private/error", "code" => 404 ] : [ "page" => "/$page" ]);
}
catch (Exception $e)
{
    echo $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
    // throw $e;
}