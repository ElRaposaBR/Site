<?php

include "config.php";

$access_token = "APP_USR-5270068585960318-042918-da723df4fc1d99ce42bc0f6cca62345b-1245082322";

$dados = json_decode(file_get_contents("php://input"), true);

$items = [];
$total = 0;

foreach($dados['carrinho'] as $item){

  $items[] = [
    "title" => $item['nome'],
    "quantity" => $item['qtd'],
    "currency_id" => "BRL",
    "unit_price" => (float)$item['preco']
  ];

  $total += $item['preco'] * $item['qtd'];
}

// cria pedido
$conn->query("
  INSERT INTO pedidos (nome,email,endereco,total,status)
  VALUES (
    '".$dados['nome']."',
    '".$dados['email']."',
    '".$dados['endereco']."',
    '$total',
    'pendente'
  )
");

$pedido_id = $conn->insert_id;

// cria pagamento Mercado Pago
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
