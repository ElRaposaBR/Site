<?php
include "../config.php";

$id = $_GET['id'];
$status = $_GET['s'];

$conn->query("UPDATE pedidos SET status='$status' WHERE id=$id");

header("Location: painel.php");
