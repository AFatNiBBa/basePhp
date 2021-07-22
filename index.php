
<?php

/*
    v41

    [Contesto]
    1) Su "assemble()" se chiedi un percorso non esistente ti da il default e ti mette il resto del percorso su "$_PATH"
    2) Se chiedi la root del sito ti da il default principale ed il resto del percorso (Una stringa vuota singola) è messo su "$_PATH"

    [Risoluzione]
    E' stato necessario modificare la root perchè dava errore se il "$_PATH" non era vuoto, cosa che non poteva accadere (*Punto 2)
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