<?php
session_start();

if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit;
}

include "../config.php";

$sql = "SELECT * FROM pedidos ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h2>Painel Admin</h2>

<a href="logout.php">Sair</a>

<hr>

<?php
while($row = $result->fetch_assoc()){
  echo "<div style='border:1px solid #ccc; padding:10px; margin:10px'>";
  echo "<b>Cliente:</b> ".$row['nome']."<br>";
  echo "<b>Email:</b> ".$row['email']."<br>";
  echo "<b>Endereço:</b> ".$row['endereco']."<br>";
  echo "<b>Total:</b> R$ ".$row['total']."<br>";
  echo "<b>Data:</b> ".$row['data']."<br>";
  echo "</div>";
}
?>