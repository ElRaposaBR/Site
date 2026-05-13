<form action="enviar.php" method="POST" style="border:1px solid #ccc; padding:10px; margin:10px">
  Cliente: <?= $p['nome'] ?><br>
  Total: R$ <?= $p['total'] ?><br>
  Status: <?= $p['status'] ?><br><br>

  <!-- PAGAMENTO -->
  <a href="mudar_status.php?id=<?= $p['id'] ?>&s=aprovado">✅ Marcar como Pago</a><br><br>

  <!-- ENVIO COM RASTREIO -->
  Código de rastreio:<br>
  <input name="rastreio" required><br><br>

  <input type="hidden" name="id" value="<?= $p['id'] ?>">

  <button type="submit">📦 Enviar Pedido</button>
</form>
