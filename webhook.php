<?php

include "config.php";

// LOG (debug)
file_put_contents("log.txt", file_get_contents("php://input") . "\n", FILE_APPEND);

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['data']['id'])){

    $payment_id = $data['data']['id'];

    $access_token = "APP_USR-5976581828685437-042918-b60791b47818e7c3c9fdc21ce5e12b0c-3369359340";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/".$payment_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer ".$access_token
    ]);

    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    file_put_contents("log.txt", json_encode($response) . "\n", FILE_APPEND);

    if(isset($response['status']) && $response['status'] == "approved"){

        $pedido_id = $response['external_reference'];

        $conn->query("
            UPDATE pedidos 
            SET status='aprovado' 
            WHERE id='$pedido_id'
        ");

        file_put_contents("log.txt", "APROVADO ID: $pedido_id\n", FILE_APPEND);
    }
}

echo "OK";
