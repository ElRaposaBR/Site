<?php
include "config.php";

$dados = json_decode(file_get_contents("php://input"), true);

$nome = $conn->real_escape_string($dados['nome']);
$email = $conn->real_escape_string($dados['email']);
$endereco = $conn->real_escape_string($dados['endereco']);
$total = floatval($dados['total']);

$sql = "INSERT INTO pedidos (nome, email, endereco, total)
        VALUES ('$nome','$email','$endereco','$total')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status"=>"ok"]);
} else {
    echo json_encode(["erro"=>$conn->error]);
}
?>
