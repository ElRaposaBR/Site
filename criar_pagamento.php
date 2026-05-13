<?php

include "config.php";

// 🔴 SEU TOKEN (use o real depois)
$access_token = "APP_USR-5976581828685437-042918-b60791b47818e7c3c9fdc21ce5e12b0c-3369359340";

// pega dados do site
$dados = json_decode(file_get_contents("php://input"), true);

// 🔥 VALOR FIXO PRA TESTE
$total = 1.00;

// 🔥 ITEM
$items = [
  [
    "title" => "Produto Teste",
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

// pega id do pedido
$pedido_id = $conn->insert_id;

// 🔥 CONFIGURAÇÃO COMPLETA
$payment = [
  "items" => $items,

  "payer" => [
    "email" => $dados['email']
  ],

  "payment_methods" => [
    "installments" => 1
  ],

  "back_urls" => [
    "success" => "https://site-v47l.onrender.com/sucesso.html",
    "failure" => "https://site-v47l.onrender.com/erro.html",
    "pending" => "https://site-v47l.onrender.com/pendente.html"
  ],

  "auto_return" => "approved",

  "external_reference" => $pedido_id,

  "notification_url" => "https://site-v47l.onrender.com/webhook.php"
];

// 🔥 ENVIA PARA MERCADO PAGO
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer " . $access_token
]);

$response = curl_exec($ch);

if(curl_errno($ch)){
  echo json_encode(["erro" => curl_error($ch)]);
  exit;
}

curl_close($ch);

// 🔥 RETORNA PARA O JS
echo $response;
