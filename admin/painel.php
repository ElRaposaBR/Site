<?php
session_start();
if(!isset($_SESSION['admin'])) exit("Acesso negado");

include "../config.php";

$res = $conn->query("SELECT * FROM pedidos ORDER BY id DESC");
?>

<h2>Pedidos</h2>

<?php while($p = $res->fetch_assoc()){ ?>

<form action="enviar.php" method="POST" style="border:1px solid #ccc; padding:10px; margin:10px">

  Cliente: <?= $p['nome'] ?><br>
  Total: R$ <?= $p['total'] ?><br>
  Status: <?= $p['status'] ?><br>
  Rastreio: <?= $p['rastreio'] ?? '---' ?><br><br>

  <!-- botão pago -->
  <a href="mudar_status.php?id=<?= $p['id'] ?>&s=aprovado">
    ✅ Marcar como Pago
  </a><br><br>

  <!-- envio -->
  Código de rastreio:<br>
  <input name="rastreio" required><br><br>

  <input type="hidden" name="id" value="<?= $p['id'] ?>">

  <button type="submit">📦 Enviar Pedido</button>

</form>

<?php } ?>
