<?php
session_start();
if(!isset($_SESSION['admin'])) exit("Acesso negado");

include "../config.php";

// DASHBOARD
$totalPedidos = $conn->query("SELECT COUNT(*) as t FROM pedidos")->fetch_assoc()['t'];
$pendentes = $conn->query("SELECT COUNT(*) as t FROM pedidos WHERE status='pendente'")->fetch_assoc()['t'];
$totalVendas = $conn->query("SELECT SUM(total) as t FROM pedidos")->fetch_assoc()['t'];

$res = $conn->query("SELECT * FROM pedidos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Painel Admin</title>

<style>

body {
  font-family: Arial;
  background: #f4f6f9;
  margin: 0;
}

/* TOPO */
.topo {
  background: #111;
  color: #fff;
  padding: 20px;
  text-align: center;
}

/* DASHBOARD */
.dashboard {
  display: flex;
  gap: 20px;
  padding: 20px;
}

.card {
  flex: 1;
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card h2 {
  margin: 0;
}

/* PEDIDOS */
.pedidos {
  padding: 20px;
}

.pedido {
  background: #fff;
  margin-bottom: 15px;
  padding: 15px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* STATUS */
.status {
  padding: 5px 10px;
  border-radius: 6px;
  color: #fff;
  font-size: 12px;
}

.pendente { background: orange; }
.aprovado { background: green; }
.enviado { background: blue; }

/* BOTÕES */
.btn {
  padding: 8px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 5px;
}

.btn-pago { background: green; color: #fff; }
.btn-enviar { background: blue; color: #fff; }

input {
  padding: 6px;
  width: 100%;
  margin-top: 5px;
}

</style>
</head>

<body>

<div class="topo">
  <h1>📊 Painel Admin</h1>
</div>

<!-- DASHBOARD -->
<div class="dashboard">

  <div class="card">
    <h2><?= $totalPedidos ?></h2>
    <p>Pedidos</p>
  </div>

  <div class="card">
    <h2><?= $pendentes ?></h2>
    <p>Pendentes</p>
  </div>

  <div class="card">
    <h2>R$ <?= number_format($totalVendas,2) ?></h2>
    <p>Total Vendido</p>
  </div>

</div>

<!-- PEDIDOS -->
<div class="pedidos">

<?php while($p = $res->fetch_assoc()){ ?>

<div class="pedido">

<b>Cliente:</b> <?= $p['nome'] ?><br>
<b>Email:</b> <?= $p['email'] ?><br>
<b>Total:</b> R$ <?= $p['total'] ?><br>

<b>Status:</b> 
<span class="status <?= $p['status'] ?>">
  <?= $p['status'] ?>
</span>

<br><br>

<b>Rastreio:</b> <?= $p['rastreio'] ?? '---' ?><br><br>

<!-- MARCAR PAGO -->
<a href="mudar_status.php?id=<?= $p['id'] ?>&s=aprovado">
  <button class="btn btn-pago">✅ Pago</button>
</a>

<!-- ENVIO -->
<form action="enviar.php" method="POST">
  <input type="hidden" name="id" value="<?= $p['id'] ?>">

  <input name="rastreio" placeholder="Código de rastreio" required>

  <button class="btn btn-enviar">📦 Enviar</button>
</form>

</div>

<?php } ?>

</div>

</body>
</html>
