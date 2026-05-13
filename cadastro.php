<?php
include("config.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$cep = $_POST['cep'];

$sql = $conn->prepare("INSERT INTO usuarios (nome,email,senha,cep) VALUES (?,?,?,?)");
$sql->bind_param("ssss",$nome,$email,$senha,$cep);

if($sql->execute()){
  echo "ok";
}else{
  echo "erro";
}
?>
