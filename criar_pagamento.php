<?php

include "config.php";

$access_token = "SEU_ACCESS_TOKEN_AQUI";

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

// cria pedido no banco como pendente
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

// pagamento MP
$payment = [
  "items" => $items,
  "external_reference" => $pedido_id,
  "notification_url" => "https://SEUSITE.com/webhook.php"
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
