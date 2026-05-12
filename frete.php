<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// VALIDAR CEP
if (!isset($_GET['cep'])) {
    echo json_encode(["erro" => "CEP não enviado"]);
    exit;
}

$cep = preg_replace('/[^0-9]/', '', $_GET['cep']);

// TOKEN
$token = "jwCIv10ToI31EPyV60LlOprTteGx03jeTcwJzwTQ";

// URL CORRETA
$url = "https://api.melhorenvio.com.br/api/v2/me/shipment/calculate";

// JSON MANUAL (IMPORTANTE)
$json = '{
  "from": {"postal_code": "01001000"},
  "to": {"postal_code": "'.$cep.'"},
  "products": [{
    "id": "1",
    "width": 15,
    "height": 10,
    "length": 20,
    "weight": 1,
    "insurance_value": 50,
    "quantity": 1
  }]
}';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Content-Type: application/json",
    "Authorization: Bearer $token",
    "User-Agent: MinhaLoja (email@email.com)"
]);

// 🔴 CORREÇÃO SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

if(curl_errno($ch)){
    echo json_encode(["erro" => curl_error($ch)]);
    exit;
}

$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo json_encode([
    "http" => $http,
    "resposta" => json_decode($response)
]);