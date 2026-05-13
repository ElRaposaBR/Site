<?php
include "../config.php";

$id = $_POST['id'];
$rastreio = $_POST['rastreio'];

// não deixa vazio
if(empty($rastreio)){
  die("Digite o código de rastreio!");
}

// atualiza pedido
$conn->query("
  UPDATE pedidos 
  SET status='enviado', rastreio='$rastreio' 
  WHERE id=$id
");

header("Location: painel.php");
