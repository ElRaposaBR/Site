<?php
session_start();

$conn = new mysqli("sql10.freesqldatabase.com", "sql10826736", "mvww2twiVW", "sql10826736");

if ($conn->connect_error) {
  die("Erro conexão");
}
?>
