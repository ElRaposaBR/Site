<?php

include "config.php";

// 🔴 SEU TOKEN REAL
$access_token = "APP_USR-5270068585960318-042918-da723df4fc1d99ce42bc0f6cca62345b-1245082322";

$dados = json_decode(file_get_contents("php://input"), true);

// 🔥 VALOR FIXO PRA TESTE
$total = 1.00;

// 🔥 ITEM FIXO (IGNORA CARRINHO)
$items = [
  [
    "title" => "Teste Loja",
    "quantity" => 1,
    "currency_id" => "BRL",
    "unit_price" => 1.00
  ]
];

// 🔥 SALVA NO BANCO
$conn->query("
  INSERT INTO pedidos (nome,email,endereco,total)
  VALUES (
    '".$dados['nome']."',
    '".$dados['email']."',
    '".$dados['endereco']."',
    '$total'
  )
");

$pedido_id = $conn->insert_id;

// 🔥 CRIA PAGAMENTO
$payment = [
  "items" => $items,
  "external_reference" => $pedido_id,
  "notification_url" => "https://SEUSITE.onrender.com/webhook.php"
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer ".$access_token
]);

$response = curl_exec($ch);

curl_close($ch);

echo $response;
