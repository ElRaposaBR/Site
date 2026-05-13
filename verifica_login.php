<?php
session_start();

if(!isset($_SESSION['user_id'])){
  echo "nao_logado";
}else{
  echo json_encode([
    "nome" => $_SESSION['nome'],
    "email" => $_SESSION['email']
  ]);
}
?>
