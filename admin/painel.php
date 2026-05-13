<?php
session_start();
if(!isset($_SESSION['admin'])) exit("Acesso negado");

include "../config.php";

// TOTAL PEDIDOS
$totalPedidos = $conn->query("SELECT COUNT(*) as total FROM pedidos")->fetch_assoc()['total'];

// PEDIDOS PENDENTES
$pendentes = $conn->query("SELECT COUNT(*) as total FROM pedidos WHERE status='pendente'")->fetch_assoc()['total'];

// TOTAL VENDIDO
$totalVendas = $conn->query("SELECT SUM(total) as soma FROM pedidos")->fetch_assoc()['soma'];
?>

<h1>📊 Dashboard</h1>

<p>🧾 Pedidos: <?= $totalPedidos ?></p>
<p>⏳ Pendentes: <?= $pendentes ?></p>
<p>💰 Total vendido: R$ <?= number_format($totalVendas,2) ?></p>

<hr>

<h2>📦 Pedidos</h2>

<?php
$res = $conn->query("SELECT * FROM pedidos ORDER BY id DESC");

while($p = $res->fetch_assoc()){
?>
<div style="border:1px solid #ccc; margin:10px; padding:10px">
  Cliente: <?= $p['nome'] ?><br>
  Total: R$ <?= $p['total'] ?><br>
  Status: <?= $p['status'] ?><br>

  <a href="mudar_status.php?id=<?= $p['id'] ?>&s=aprovado">✅ Pago</a> |
  <a href="mudar_status.php?id=<?= $p['id'] ?>&s=enviado">📦 Enviado</a>
</div>
<?php } ?>
