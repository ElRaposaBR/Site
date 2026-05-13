<?php
session_start();

// usuário fixo (depois podemos melhorar)
$admin_user = "admin";
$admin_pass = "123456";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $user = $_POST['user'];
  $pass = $_POST['pass'];

  if($user === $admin_user && $pass === $admin_pass){
    $_SESSION['admin'] = true;
    header("Location: painel.php");
    exit;
  } else {
    $erro = "Login inválido!";
  }
}
?>

<h2>Login Admin</h2>

<form method="POST">
<input name="user" placeholder="Usuário"><br><br>
<input type="password" name="pass" placeholder="Senha"><br><br>
<button>Entrar</button>
</form>

<?php if(isset($erro)) echo "<p style='color:red'>$erro</p>"; ?>