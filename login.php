<?php
include("config.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
$sql->bind_param("s",$email);
$sql->execute();

$res = $sql->get_result();

if($res->num_rows > 0){
  $user = $res->fetch_assoc();

  if(password_verify($senha, $user['senha'])){
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nome'] = $user['nome'];
    $_SESSION['email'] = $user['email'];

    echo "ok";
  } else {
    echo "senha_errada";
  }

}else{
  echo "nao_existe";
}
?>
