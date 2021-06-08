
<?php

$data = json_decode($_GET["data"] ?? "[]", true);
switch ($_PATH)
{
    case "ping":
        $out = "pong";
        break;
}

echo json_encode(@$out);