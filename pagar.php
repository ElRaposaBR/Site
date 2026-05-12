<?php

$access_token = "APP_USR-5976581828685437-042918-b60791b47818e7c3c9fdc21ce5e12b0c-3369359340";

$dados = json_decode(file_get_contents("php://input"), true);

$items = [];

foreach($dados['carrinho'] as $item){
  $items[] = [
    "title" => $item['nome'],
    "quantity" => $item['qtd'],
    "currency_id" => "BRL",
    "unit_price" => (float)$item['preco']
  ];
}

$payment = [
  "items" => $items
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer " . $access_token
]);

$response = curl_exec($ch);

curl_close($ch);

echo $response;