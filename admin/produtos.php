<?php
include "../config.php";

if($_POST){
  $nome = $_POST['nome'];
  $preco = $_POST['preco'];
  $peso = $_POST['peso'];
  $largura = $_POST['largura'];
  $altura = $_POST['altura'];
  $comprimento = $_POST['comprimento'];

  $conn->query("INSERT INTO produtos 
  (nome,preco,peso,largura,altura,comprimento)
  VALUES ('$nome','$preco','$peso','$largura','$altura','$comprimento')");
}
?>

<h2>Novo Produto</h2>

<form method="POST">
Nome <input name="nome"><br>
Preço <input name="preco"><br>
Peso (kg) <input name="peso"><br>
Largura <input name="largura"><br>
Altura <input name="altura"><br>
Comprimento <input name="comprimento"><br>
<button>Salvar</button>
</form>
