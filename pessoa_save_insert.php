<?php
$dados = $_POST;

$conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$result = $conn->query('SELECT MAX(id) as next FROM pessoas');
$row = $result->fetch_assoc();
$next = (int) $row['next'] + 1;

$sql = "INSERT INTO pessoas(id, nome, endereco, bairro, telefone, email,id_cidade)
VALUES ('{$next}',  '{$dados['nome']}', '{$dados['endereco']}', '{$dados['bairro']}', '{$dados['telefone']}', '{$dados['email']}', '{$dados['id_cidade']}')";

$result = mysqli_query($conn, $sql);

if ($result) {
    print "Registro inserido com sucesso!";
} else {
    print "Erro ao inserir: " . mysqli_error($conn);
}
$conn->close();

