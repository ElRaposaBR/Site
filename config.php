<?php

$host = "sql10.freesqldatabase.com";
$user = "sql10826736";
$pass = "mvww2twiVW";
$db   = "sql10826736";

$conn = new mysqli($host, $user, $pass, $db);

// erro
if ($conn->connect_error) {
    die("Erro conexão: " . $conn->connect_error);
}

?>
