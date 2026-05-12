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
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmJmZTc2N2NlZmE5ZTA5YjJlOGRmYTA0ODdjZTY4MjhiZGYyMDE4MWI2M2E0MWQxZjNiYWVmNTBjZGViOThlYjJmNzU1NWY0YWZkMzk4OTAiLCJpYXQiOjE3Nzg2MjQzOTEuNzA1OTU1LCJuYmYiOjE3Nzg2MjQzOTEuNzA1OTU3LCJleHAiOjE4MTAxNjAzOTEuNjkzNDM1LCJzdWIiOiJhMWE5YmNlOC0wOTdlLTRkNjMtYTc5Ni03NjI1ZTljMTgzNzkiLCJzY29wZXMiOlsiY2FydC1yZWFkIiwiY2FydC13cml0ZSIsImNvbXBhbmllcy1yZWFkIiwiY29tcGFuaWVzLXdyaXRlIiwiY291cG9ucy1yZWFkIiwiY291cG9ucy13cml0ZSIsIm5vdGlmaWNhdGlvbnMtcmVhZCIsIm9yZGVycy1yZWFkIiwicHJvZHVjdHMtcmVhZCIsInByb2R1Y3RzLWRlc3Ryb3kiLCJwcm9kdWN0cy13cml0ZSIsInB1cmNoYXNlcy1yZWFkIiwic2hpcHBpbmctY2FsY3VsYXRlIiwic2hpcHBpbmctY2FuY2VsIiwic2hpcHBpbmctY2hlY2tvdXQiLCJzaGlwcGluZy1jb21wYW5pZXMiLCJzaGlwcGluZy1nZW5lcmF0ZSIsInNoaXBwaW5nLXByZXZpZXciLCJzaGlwcGluZy1wcmludCIsInNoaXBwaW5nLXNoYXJlIiwic2hpcHBpbmctdHJhY2tpbmciLCJlY29tbWVyY2Utc2hpcHBpbmciLCJ0cmFuc2FjdGlvbnMtcmVhZCIsInVzZXJzLXJlYWQiLCJ1c2Vycy13cml0ZSIsIndlYmhvb2tzLXJlYWQiLCJ3ZWJob29rcy13cml0ZSIsIndlYmhvb2tzLWRlbGV0ZSIsInRkZWFsZXItd2ViaG9vayJdfQ.W5rGmAaof_Re-vgpH8nc4igGee4W72D9V74xZE-VVntl6mamKsHMe4Pfc4IHU6aHN3hej0sIq-uG8KwRHSIq_IbjJ5umGQcLStKcbRsPMKWMdp6rYBjE1xPa_6EzfcXfeKkgQat0QE-GRqfLaDz48EJOanSvXpJcWNxzBZEAqGvNQL5eFR-kT0F2OJyO8KU6vJkLkoNmHtzNZ7G-mQ2k6lYmJrHAdngWOLionWLL_8R6_xmpKGJYMWYjCeaF4YGXH4uDBm0_eMYNXY_HwfBlc0GvXHKh8pI1TV817dopKvUQKMTtUTrEfVwXR_dktVMflSUrP1FMAgo_yryHLDDppyToIMDIlQTxhUCcFbjboHsC3qCcIOrxjV7k5O2wPqnOrunKOc2NNfTn3YMl16Mu9NEQSYi_zcLwsWwZrWgoAJpjbk6OZKE2D0cdu2aQFX-qYpZ9aWK9zT07LwjlbIzsmL9s4GhmvMvStF_pkMYp9D3JaWzdD73Q5WsELD-T4pnGyzmcSOIBUMrUxb80j5-auG5yO2Q5fHRkK2OVOQrcJpkqagRuq2ohqPIaiFIQGdmDrCIaXEr2BY08hIPPRvlrgc3joTGXzKU4ji6mDgHpUCxC4j4B7aIAbgIO7fIs_8OcEuukabRsl73WK3G2BNZk5330HCOCH4odWjzu1Ca7PYA";

// URL CORRETA
$url = "https://melhorenvio.com.br/api/v2/me/shipment/calculate";

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
