<?php
include "config.php";

$sql = "SELECT * FROM pedidos ORDER BY id DESC";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo "<p>";
    echo "Cliente: ".$row['nome']."<br>";
    echo "Email: ".$row['email']."<br>";
    echo "Endereço: ".$row['endereco']."<br>";
    echo "Total: R$ ".$row['total']."<br>";
    echo "------------------------";
    echo "</p>";
}
?>
