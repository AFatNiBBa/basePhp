
<?php

if ($_MSG["template"] = !@assemble($_PATH, [""], true)[0])
    return false; # Se c'è disattiva il template sennò dice alla pagina prima che non lo ha trovato e di conseguenza manda l'errore 404