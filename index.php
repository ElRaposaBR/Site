<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Minha Loja Geek</title>

<style>

body{
  margin:0;
  font-family:Arial;
  background:#0f172a;
  color:white;
}

header{
  background:#020617;
  padding:15px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.logo{
  font-size:22px;
  font-weight:bold;
}

nav a{
  color:white;
  margin:0 10px;
  text-decoration:none;
}

.user{
  font-size:14px;
}

.botao{
  background:#22c55e;
  padding:8px 15px;
  border-radius:8px;
  text-decoration:none;
  color:white;
}

.container{
  padding:20px;
  text-align:center;
}

.produtos{
  display:flex;
  justify-content:center;
  gap:20px;
  flex-wrap:wrap;
}

.card{
  background:#1e293b;
  padding:15px;
  border-radius:12px;
  width:220px;
}

.card img{
  width:100%;
  border-radius:10px;
}

.preco{
  color:#22c55e;
  font-size:18px;
}

button{
  background:#22c55e;
  border:none;
  padding:10px;
  width:100%;
  border-radius:8px;
  cursor:pointer;
  color:white;
}

.carrinho{
  margin-top:30px;
  background:#1e293b;
  padding:20px;
  border-radius:12px;
  max-width:400px;
  margin-left:auto;
  margin-right:auto;
}

</style>

</head>

<body>

<header>

<div class="logo">🛒 Loja Geek</div>

<nav>
<a href="#">Início</a>
<a href="meus_pedidos.php">Pedidos</a>
</nav>

<div class="user">

<?php if(isset($_SESSION['user_id'])): ?>

👤 <?php echo $_SESSION['nome']; ?> |
<a href="logout.php" class="botao">Sair</a>

<?php else: ?>

<a href="login.html" class="botao">Entrar</a>

<?php endif; ?>

</div>

</header>

<div class="container">

<h1>🔥 Produtos em Destaque</h1>

<div class="produtos">

<!-- PRODUTO TESTE 1 REAL -->
<div class="card">
<img src="https://via.placeholder.com/200">
<h3>Produto Teste</h3>
<p class="preco">R$ 1,00</p>
<button onclick="comprar('Produto Teste',1)">Comprar</button>
</div>

<div class="card">
<img src="https://via.placeholder.com/200">
<h3>Boneco Naruto</h3>
<p class="preco">R$ 59,90</p>
<button onclick="comprar('Boneco Naruto',59.90)">Comprar</button>
</div>

<div class="card">
<img src="https://via.placeholder.com/200">
<h3>Goku Action Figure</h3>
<p class="preco">R$ 89,90</p>
<button onclick="comprar('Goku',89.90)">Comprar</button>
</div>

</div>

<!-- CARRINHO -->
<div class="carrinho">

<h2>🛒 Carrinho</h2>

<ul id="lista"></ul>

<p>Total: R$ <span id="total">0.00</span></p>

<button onclick="finalizar()">Finalizar Compra</button>

</div>

</div>

<script>

let carrinho = [];

function comprar(nome, preco){

  fetch("verifica_login.php")
  .then(r=>r.text())
  .then(res=>{

    if(res === "nao_logado"){
      alert("⚠️ Faça login primeiro!");
      window.location.href = "login.html";
      return;
    }

    let item = carrinho.find(i => i.nome === nome);

    if(item) item.qtd++;
    else carrinho.push({nome,preco,qtd:1});

    atualizar();
  });

}

function atualizar(){

  let lista = document.getElementById("lista");
  let total = document.getElementById("total");

  lista.innerHTML = "";
  let soma = 0;

  carrinho.forEach((i,index)=>{
    soma += i.preco * i.qtd;

    lista.innerHTML += `
      <li>
        ${i.nome} x${i.qtd}
        <button onclick="remover(${index})">❌</button>
      </li>
    `;
  });

  total.innerText = soma.toFixed(2);
}

function remover(i){
  carrinho.splice(i,1);
  atualizar();
}

function finalizar(){

  if(carrinho.length === 0){
    alert("Carrinho vazio");
    return;
  }

  fetch("criar_pagamento.php",{
    method:"POST",
    headers:{"Content-Type":"application/json"},
    body: JSON.stringify({carrinho})
  })
  .then(r=>r.json())
  .then(data=>{
    window.location.href = data.link;
  });

}

</script>

</body>
</html>
