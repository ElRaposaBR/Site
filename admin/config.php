<?php

$host = "sql10.freesqldatabase.com";
$user = "sql10826736";
$pass = "mvww2twiVW";
$db   = "sql10826736";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}
?>