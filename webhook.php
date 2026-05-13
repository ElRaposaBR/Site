<?php

include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

// pega info pagamento
if(isset($data['data']['id'])){

  $payment_id = $data['data']['id'];

  $access_token = "SEU_ACCESS_TOKEN_AQUI";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/".$payment_id);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer ".$access_token
  ]);

  $response = json_decode(curl_exec($ch), true);
  curl_close($ch);

  if($response['status'] == "approved"){

    $pedido_id = $response['external_reference'];

    $conn->query("
      UPDATE pedidos 
      SET status='aprovado' 
      WHERE id='$pedido_id'
    );

  }
}
