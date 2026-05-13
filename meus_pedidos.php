<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Meus Pedidos</title>

<style>
body{
  font-family: Arial;
  background:#0f172a;
  color:white;
  text-align:center;
}

.container{
  margin-top:50px;
}

input{
  padding:10px;
  width:250px;
  border-radius:8px;
  border:none;
}

button{
  padding:10px 20px;
  border:none;
  border-radius:8px;
  background:#22c55e;
  color:white;
  cursor:pointer;
}

.card{
  background:#1e293b;
  padding:20px;
  margin:20px auto;
  width:350px;
  border-radius:12px;
  text-align:left;
}

.status{
  font-weight:bold;
}

.aprovado{ color: #22c55e; }
.pendente{ color: #facc15; }
.enviado{ color: #38bdf8; }
</style>

</head>

<body>

<div class="container">
  <h1>📦 Meus Pedidos</h1>

  <form method="GET">
    <input type="text" name="busca" placeholder="Digite seu email ou ID">
    <button type="submit">Buscar</button>
  </form>

<?php

if(isset($_GET['busca'])){
  $busca = $_GET['busca'];

  $sql = $conn->query("SELECT * FROM pedidos WHERE email='$busca' OR id='$busca' ORDER BY id DESC");

  if($sql->num_rows > 0){

    while($p = $sql->fetch_assoc()){

      $statusClass = strtolower($p['status']);

      echo "
      <div class='card'>
        <p><b>ID:</b> {$p['id']}</p>
        <p><b>Cliente:</b> {$p['nome']}</p>
        <p><b>Email:</b> {$p['email']}</p>
        <p><b>Total:</b> R$ {$p['total']}</p>

        <p class='status {$statusClass}'>
          Status: {$p['status']}
        </p>

        <p>
          <b>Rastreio:</b><br>
          ".($p['rastreio'] ? $p['rastreio'] : 'Aguardando envio')."
        </p>
      </div>
      ";
    }

  } else {
    echo "<p>Nenhum pedido encontrado</p>";
  }
}
?>

</div>

</body>
</html>
